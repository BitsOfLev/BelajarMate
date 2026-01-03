<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\NoteResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class NoteResourceController extends Controller
{
    /**
     * 1. store()    - Upload file OR add link to a note
     * 2. download() - Download a file resource
     * 3. destroy()  - Delete a resource (file or link)
    * */

    /**
     * Store a new resource (file or link) for a note.
     * 
     * @param Request $request
     * @param Note $note - The note to attach the resource to
     */
    public function store(Request $request, Note $note)
    {
        // Authorization: Check if this note belongs to the current user
        if ($note->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        // Validate based on resource type
        $request->validate([
            'resource_type' => 'required|in:file,link',
            'file' => 'required_if:resource_type,file|file|mimes:pdf,jpg,jpeg,png,gif,webp|max:5120', // 5MB max
            'link' => 'required_if:resource_type,link|url|max:500',
            'resource_name' => 'nullable|string|max:255',
        ]);
        
        $resourceType = $request->resource_type;
        
        // Handle FILE upload
        if ($resourceType === 'file') {
            // Get the uploaded file
            $file = $request->file('file');
            
            // Generate a unique filename to prevent conflicts
            // Format: timestamp_originalname.ext
            $filename = time() . '_' . $file->getClientOriginalName();
            
            // Store the file in storage/app/public/notes
            // This will create the directory if it doesn't exist
            $filePath = $file->storeAs('notes', $filename, 'public');
            
            // Create the resource record
            $note->resources()->create([
                'resource_type' => 'file',
                'resource_file_path' => $filePath,
                'resource_link' => null,
                'resource_name' => $request->resource_name ?? $file->getClientOriginalName(),
            ]);
            
            $message = 'File uploaded successfully!';
        } 
        // Handle LINK addition
        else {
            // Create the resource record
            $note->resources()->create([
                'resource_type' => 'link',
                'resource_link' => $request->link,
                'resource_file_path' => null,
                'resource_name' => $request->resource_name ?? $request->link,
            ]);
            
            $message = 'Link added successfully!';
        }
        
        // Redirect back to the note detail page
        return redirect()
            ->route('notes.show', $note->id)
            ->with('success', $message);
    }

    /**
     * Download a file resource.
     * 
     * @param NoteResource $resource
     */
    public function download(NoteResource $resource)
    {
        // Load the note relationship to check authorization
        $resource->load('note');
        
        // Authorization: Check if the note belongs to the current user
        if ($resource->note->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        // Check if this is actually a file (not a link)
        if ($resource->resource_type !== 'file') {
            return redirect()->back()->with('error', 'This resource is not a file.');
        }
        
        // Check if file exists in storage
        if (!Storage::disk('public')->exists($resource->resource_file_path)) {
            return redirect()->back()->with('error', 'File not found.');
        }
        
        // Download the file
        // This will prompt the browser to download the file
        return Storage::disk('public')->download(
            $resource->resource_file_path,
            $resource->resource_name ?? basename($resource->resource_file_path)
        );
    }

    /**
     * View a file resource inline (for images and PDFs).
     * 
     * @param NoteResource $resource
     */
    public function view(NoteResource $resource)
    {
        // Load the note relationship to check authorization
        $resource->load('note');
        
        // Authorization: Check if the note belongs to the current user
        if ($resource->note->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        // Check if this is actually a file (not a link)
        if ($resource->resource_type !== 'file') {
            return redirect()->back()->with('error', 'This resource is not a file.');
        }
        
        // Check if file exists in storage
        if (!Storage::disk('public')->exists($resource->resource_file_path)) {
            return redirect()->back()->with('error', 'File not found.');
        }
        
        // Get file path and MIME type
        $filePath = storage_path('app/public/' . $resource->resource_file_path);
        $mimeType = Storage::disk('public')->mimeType($resource->resource_file_path);
        
        // Return file for inline viewing
        return response()->file($filePath, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . ($resource->resource_name ?? basename($resource->resource_file_path)) . '"'
        ]);
    }

    /**
     * Delete a resource (file or link).
     * The file will be automatically deleted from storage
     * thanks to the NoteResource model's booted() method.
     * 
     * @param NoteResource $resource
     */
    public function destroy(NoteResource $resource)
    {
        // Load the note relationship to check authorization
        $resource->load('note');
        
        // Authorization: Check if the note belongs to the current user
        if ($resource->note->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        // Get the note ID before deleting (for redirect)
        $noteId = $resource->note_id;
        
        // Delete the resource
        // If it's a file, the NoteResource model's booted() method
        // will automatically delete the file from storage
        $resource->delete();
        
        // Redirect back to the note detail page
        return redirect()
            ->route('notes.show', $noteId)
            ->with('success', 'Resource deleted successfully!');
    }
}