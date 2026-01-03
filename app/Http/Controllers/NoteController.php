<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    /**
     * 1. index()   - Display all notes for the logged-in user
     * 2. create()  - Show the form to create a new note
     * 3. store()   - Save the new note to database
     * 4. show()    - Display a single note with its resources
     * 5. edit()    - Show the form to edit an existing note
     * 6. update()  - Save the updated note to database
     * 7. destroy() - Delete a note
    * */

    /**
     * Display a listing of notes for the logged-in user.
     * Includes pagination, search, and tag filtering.
     */
    public function index(Request $request)
    {
        // Start building the query for notes belonging to current user
        $query = Note::forUser(Auth::id());
        
        // Search functionality (search in title, description, content)
        if ($request->has('search') && $request->search != '') {
            $query->search($request->search);
        }
        
        // Filter by tag
        if ($request->has('tag') && $request->tag != '') {
            $query->withTag($request->tag);
        }
        
        // Get notes with pagination (10 per page) and order by newest first
        $notes = $query->latest()->paginate(10);
        
        // Get all unique tags for the filter dropdown
        // This gets all tags from user's notes and splits them into individual tags
        $allUserNotes = Note::forUser(Auth::id())->get();
        $allTags = [];
        
        foreach ($allUserNotes as $note) {
            if ($note->tags) {
                // Split comma-separated tags
                $tags = array_map('trim', explode(',', $note->tags));
                $allTags = array_merge($allTags, $tags);
            }
        }
        
        // Remove duplicates and sort alphabetically
        $allTags = array_unique($allTags);
        sort($allTags);
        
        return view('notes.index', compact('notes', 'allTags'));
    }

    /**
     * Show the form for creating a new note.
     */
    public function create()
    {
        return view('notes.create');
    }

    /**
     * Store a newly created note in the database.
     * Tags should be comma-separated (e.g., "SEM,Software Engineering,Exam")
     */
    public function store(Request $request)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'required|string',
            'tags' => 'nullable|string|max:255',
        ]);
        
        // Create the note
        // user_id is added automatically from the logged-in user
        $note = Note::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'content' => $validated['content'] ?? null,
            'tags' => $validated['tags'] ?? null, // Comma-separated tags
        ]);
        
        // Redirect to notes index page with success message
        return redirect()
            ->route('notes.index')
            ->with('success', 'Note created successfully!');
    }

    /**
     * Display a single note with all its resources.
     * 
     * @param Note $note - Laravel automatically finds the note by ID (Route Model Binding)
     */
    public function show(Note $note)
    {
        // Authorization: Check if this note belongs to the current user
        if ($note->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        // Load the note's resources (files and links)
        // This is called "eager loading" - prevents N+1 query problem
        $note->load('resources');
        
        // Separate resources by type for easier display
        $files = $note->resources()->files()->get();
        $links = $note->resources()->links()->get();
        
        return view('notes.show', compact('note', 'files', 'links'));
    }

    /**
     * Show the form for editing a note.
     */
    public function edit(Note $note)
    {
        // Authorization: Check if this note belongs to the current user
        if ($note->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('notes.edit', compact('note'));
    }

    /**
     * Update an existing note in the database.
     */
    public function update(Request $request, Note $note)
    {
        // Authorization: Check if this note belongs to the current user
        if ($note->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        // Validate the incoming data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'required|string',
            'tags' => 'nullable|string|max:255',
        ]);
        
        // Update the note
        $note->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'content' => $validated['content'] ?? null,
            'tags' => $validated['tags'] ?? null,
        ]);
        
        // Redirect to the note detail page with success message
        return redirect()
            ->route('notes.show', $note->id)
            ->with('success', 'Note updated successfully!');
    }

    /**
     * Delete a note from the database.
     * Also automatically deletes all associated resources (files and links)
     * thanks to the cascade delete in the migration and model.
     */
    public function destroy(Note $note)
    {
        // Authorization: Check if this note belongs to the current user
        if ($note->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        // Delete the note
        // The note's resources will be automatically deleted because:
        // 1. Migration has onDelete('cascade')
        // 2. NoteResource model has booted() method that deletes files from storage
        $note->delete();
        
        // Redirect to notes index with success message
        return redirect()
            ->route('notes.index')
            ->with('success', 'Note deleted successfully!');
    }
}
