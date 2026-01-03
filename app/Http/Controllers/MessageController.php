<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use App\Models\Connection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MessageController extends Controller
{
    /**
     * Display the main inbox page with conversation list
     */
    public function index()
    {
        $userId = Auth::id();
        
        // Get all conversations for current user, ordered by most recent
        $conversations = Conversation::forUser($userId)
            ->with(['userOne', 'userTwo', 'lastMessage'])
            ->orderBy('last_message_at', 'desc')
            ->get();
        
        // Get the first conversation to display (if exists)
        $selectedConversation = $conversations->first();
        
        // Initialize as empty collection (not array)
        $messages = collect([]);
        
        if ($selectedConversation) {
            $messages = $selectedConversation->messages()
                ->with('sender')
                ->orderBy('created_at', 'asc')
                ->get();
            
            // Mark messages as read
            $this->markConversationAsRead($selectedConversation, $userId);
        }
        
        return view('messages.index', compact('conversations', 'selectedConversation', 'messages'));
    }

    /**
     * Show a specific conversation
     */
    public function show(Conversation $conversation)
    {
        $userId = Auth::id();
        
        // Verify user is part of this conversation
        if (!$this->userInConversation($conversation, $userId)) {
            abort(403, 'Unauthorized access to this conversation');
        }
        
        // Get all conversations for sidebar
        $conversations = Conversation::forUser($userId)
            ->with(['userOne', 'userTwo', 'lastMessage'])
            ->orderBy('last_message_at', 'desc')
            ->get();
        
        // Get messages for selected conversation (as collection, not array)
        $messages = $conversation->messages()
            ->with('sender')
            ->orderBy('created_at', 'asc')
            ->get();
        
        // Mark messages as read
        $this->markConversationAsRead($conversation, $userId);
        
        $selectedConversation = $conversation;
        
        return view('messages.index', compact('conversations', 'selectedConversation', 'messages'));
    }

    /**
     * Send a message in a conversation
     */
    public function store(Request $request, Conversation $conversation)
    {
        $userId = Auth::id();
        
        // Verify user is part of this conversation
        if (!$this->userInConversation($conversation, $userId)) {
            abort(403, 'Unauthorized access to this conversation');
        }
        
        // Get the other user
        $otherUser = $conversation->getOtherUser($userId);
        
        // Check if users are still connected
        if (!$this->areUsersConnected($userId, $otherUser->id)) {
            return back()->with('error', 'You can only message connected study partners');
        }
        
        // Validate request
        $request->validate([
            'message' => 'nullable|string|max:5000',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp,pdf|max:10240', // 10MB max
        ], [
            'attachment.mimes' => 'Only images (jpg, jpeg, png, gif, webp) and PDFs are allowed',
            'attachment.max' => 'File size must not exceed 10MB',
        ]);
        
        // At least message or attachment must be present
        if (!$request->message && !$request->hasFile('attachment')) {
            return back()->with('error', 'Please provide a message or attachment');
        }
        
        // Handle file upload
        $attachmentPath = null;
        $attachmentName = null;
        $attachmentType = null;
        
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $originalName = $file->getClientOriginalName();
            
            // Determine type
            $mimeType = $file->getMimeType();
            if (str_starts_with($mimeType, 'image/')) {
                $attachmentType = 'image';
                $folder = 'message_attachments/images';
            } else {
                $attachmentType = 'pdf';
                $folder = 'message_attachments/pdfs';
            }
            
            // Store file
            $attachmentPath = $file->store($folder, 'public');
            $attachmentName = $originalName;
        }
        
        // Create message
        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $userId,
            'message' => $request->message,
            'attachment_path' => $attachmentPath,
            'attachment_name' => $attachmentName,
            'attachment_type' => $attachmentType,
        ]);
        
        // Update conversation's last message timestamp
        $conversation->update([
            'last_message_at' => now(),
        ]);
        
        return back()->with('success', 'Message sent successfully');
    }

    /**
     * Start a new conversation with a user
     */
    public function startConversation(Request $request, User $user)
    {
        $userId = Auth::id();
        
        // Can't message yourself
        if ($userId == $user->id) {
            return back()->with('error', 'You cannot message yourself');
        }
        
        // Check if users are connected
        if (!$this->areUsersConnected($userId, $user->id)) {
            return back()->with('error', 'You can only message connected study partners');
        }
        
        // Check if conversation already exists
        $existingConversation = Conversation::where(function ($query) use ($userId, $user) {
            $query->where('user_one_id', $userId)->where('user_two_id', $user->id);
        })->orWhere(function ($query) use ($userId, $user) {
            $query->where('user_one_id', $user->id)->where('user_two_id', $userId);
        })->first();
        
        if ($existingConversation) {
            // Redirect to existing conversation
            return redirect()->route('messages.conversation.show', $existingConversation->id);
        }
        
        // Create new conversation
        $conversation = Conversation::create([
            'user_one_id' => $userId,
            'user_two_id' => $user->id,
            'last_message_at' => now(),
        ]);
        
        return redirect()->route('messages.conversation.show', $conversation->id)
            ->with('success', 'Conversation started');
    }

    /**
     * Check for new messages (AJAX polling endpoint)
     */
    public function checkNewMessages(Conversation $conversation)
    {
        $userId = Auth::id();
        
        // Verify user is part of this conversation
        if (!$this->userInConversation($conversation, $userId)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        // Get timestamp from request (last checked time)
        $lastChecked = request('last_checked');
        
        if ($lastChecked) {
            // Get new messages since last check
            $newMessages = $conversation->messages()
                ->with('sender')
                ->where('created_at', '>', $lastChecked)
                ->orderBy('created_at', 'asc')
                ->get();
        } else {
            // If no timestamp, return empty (shouldn't happen normally)
            $newMessages = collect();
        }
        
        return response()->json([
            'newMessages' => $newMessages,
            'count' => $newMessages->count(),
        ]);
    }

    /**
     * Mark all messages in a conversation as read
     */
    public function markAsRead(Conversation $conversation)
    {
        $userId = Auth::id();
        
        // Verify user is part of this conversation
        if (!$this->userInConversation($conversation, $userId)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        // Mark all messages from other user as read
        $conversation->messages()
            ->where('sender_id', '!=', $userId)
            ->where('is_read', false)
            ->update(['is_read' => true]);
        
        return response()->json(['success' => true]);
    }

    /**
     * Helper: Check if user is part of conversation
     */
    private function userInConversation(Conversation $conversation, $userId)
    {
        return $conversation->user_one_id == $userId || $conversation->user_two_id == $userId;
    }

    /**
     * Helper: Check if two users are connected study partners
     */
    private function areUsersConnected($userId1, $userId2)
    {
        return Connection::where(function ($query) use ($userId1, $userId2) {
            $query->where('requesterID', $userId1)->where('receiverID', $userId2);
        })->orWhere(function ($query) use ($userId1, $userId2) {
            $query->where('requesterID', $userId2)->where('receiverID', $userId1);
        })->where('connection_status', Connection::STATUS_ACCEPTED)->exists();
    }

    /**
     * Helper: Mark conversation messages as read
     */
    private function markConversationAsRead(Conversation $conversation, $userId)
    {
        $conversation->messages()
            ->where('sender_id', '!=', $userId)
            ->where('is_read', false)
            ->update(['is_read' => true]);
    }
}