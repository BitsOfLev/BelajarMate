<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class NoteResource extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'note_id',
        'resource_type',
        'resource_link',
        'resource_file_path',
        'resource_name',
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
     * Get the note that owns this resource.
     */
    public function note()
    {
        return $this->belongsTo(Note::class);
    }

    // -------------------------------
    // Scopes
    // -------------------------------

    /**
     * Scope a query to only include file resources.
     */
    public function scopeFiles($query)
    {
        return $query->where('resource_type', 'file');
    }

    /**
     * Scope a query to only include link resources.
     */
    public function scopeLinks($query)
    {
        return $query->where('resource_type', 'link');
    }

    // -------------------------------
    // Helper Methods
    // -------------------------------

    /**
     * Check if this resource is a file.
     */
    public function isFile()
    {
        return $this->resource_type === 'file';
    }

    /**
     * Check if this resource is a link.
     */
    public function isLink()
    {
        return $this->resource_type === 'link';
    }

    /**
     * Get the display name for the resource.
     */
    public function getDisplayName()
    {
        if ($this->resource_name) {
            return $this->resource_name;
        }

        if ($this->isFile() && $this->resource_file_path) {
            return basename($this->resource_file_path);
        }

        if ($this->isLink() && $this->resource_link) {
            return $this->resource_link;
        }

        return 'Untitled Resource';
    }

    /**
     * Get the file extension (for file resources).
     */
    public function getFileExtension()
    {
        if ($this->isFile() && $this->resource_file_path) {
            return pathinfo($this->resource_file_path, PATHINFO_EXTENSION);
        }

        return null;
    }

    /**
     * Check if file is an image.
     */
    public function isImage()
    {
        if (!$this->isFile()) {
            return false;
        }

        $extension = strtolower($this->getFileExtension());
        return in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
    }

    /**
     * Check if file is a PDF.
     */
    public function isPdf()
    {
        if (!$this->isFile()) {
            return false;
        }

        return strtolower($this->getFileExtension()) === 'pdf';
    }

    /**
     * Get the full URL for the resource.
     */
    public function getUrl()
    {
        if ($this->isLink()) {
            return $this->resource_link;
        }

        if ($this->isFile() && $this->resource_file_path) {
            return Storage::url($this->resource_file_path);
        }

        return null;
    }

    /**
     * Get file size in human-readable format.
     */
    public function getFileSize()
    {
        if ($this->isFile() && $this->resource_file_path && Storage::exists($this->resource_file_path)) {
            $bytes = Storage::size($this->resource_file_path);
            
            $units = ['B', 'KB', 'MB', 'GB'];
            $i = 0;
            
            while ($bytes >= 1024 && $i < count($units) - 1) {
                $bytes /= 1024;
                $i++;
            }
            
            return round($bytes, 2) . ' ' . $units[$i];
        }

        return null;
    }

    /**
     * Delete the file from storage when model is deleted.
     */
    protected static function booted()
    {
        static::deleting(function ($resource) {
            if ($resource->isFile() && $resource->resource_file_path) {
                Storage::delete($resource->resource_file_path);
            }
        });
    }
}