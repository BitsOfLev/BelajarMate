<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'content',
        'tags',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // -------------------------------
    // Relationships
    // -------------------------------

    /**
     * Get the user that owns the note.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all resources (files/links) attached to this note.
     */
    public function resources()
    {
        return $this->hasMany(NoteResource::class);
    }

    // -------------------------------
    // Scopes
    // -------------------------------

    /**
     * Scope a query to only include notes belonging to a specific user.
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope a query to filter notes by tag.
     */
    public function scopeWithTag($query, $tag)
    {
        return $query->where('tags', 'LIKE', "%{$tag}%");
    }

    /**
     * Scope a query to search notes by title or content.
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('title', 'LIKE', "%{$search}%")
              ->orWhere('description', 'LIKE', "%{$search}%")
              ->orWhere('content', 'LIKE', "%{$search}%");
        });
    }

    // -------------------------------
    // Helper Methods
    // -------------------------------

    /**
     * Get tags as an array.
     */
    public function getTagsArray()
    {
        return $this->tags ? explode(',', $this->tags) : [];
    }

    /**
     * Check if note has any resources.
     */
    public function hasResources()
    {
        return $this->resources()->exists();
    }

    /**
     * Get count of resources.
     */
    public function getResourcesCount()
    {
        return $this->resources()->count();
    }

    /**
     * Get only file resources (PDFs, images).
     */
    public function getFileResources()
    {
        return $this->resources()->where('resource_type', 'file')->get();
    }

    /**
     * Get only link resources.
     */
    public function getLinkResources()
    {
        return $this->resources()->where('resource_type', 'link')->get();
    }

    //for sharing
    public function canView(User $user)
    {
        // Owner can always view
        if ($this->user_id === $user->id) {
            return true;
        }

        // Check if user is a connected study partner
        return $this->user->connectedPartners()->contains('id', $user->id);
    }

    public function isOwner(User $user)
    {
        return $this->user_id === $user->id;
    }
}