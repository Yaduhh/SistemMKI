<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class FileManager extends Model
{

    protected $fillable = [
        'original_name',
        'file_name',
        'file_path',
        'file_url',
        'mime_type',
        'file_extension',
        'file_type',
        'file_size',
        'file_size_human',
        'title',
        'description',
        'alt_text',
        'metadata',
        'is_public',
        'is_featured',
        'download_count',
        'view_count',
        'last_accessed_at',
        'uploaded_by',
        'status_deleted'
    ];

    protected $casts = [
        'metadata' => 'array',
        'is_public' => 'boolean',
        'is_featured' => 'boolean',
        'status_deleted' => 'boolean',
        'last_accessed_at' => 'datetime',
        'file_size' => 'integer',
        'download_count' => 'integer',
        'view_count' => 'integer'
    ];

    /**
     * Get the user who uploaded this file
     */
    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Get the full URL of the file
     */
    public function getFullUrlAttribute(): string
    {
        if ($this->file_url) {
            return $this->file_url;
        }

        // Ensure we're using the public disk for URL generation
        return Storage::disk('public')->url($this->file_path);
    }

    /**
     * Get the file size in human readable format
     */
    public function getHumanFileSizeAttribute(): string
    {
        if ($this->file_size_human) {
            return $this->file_size_human;
        }

        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Check if file is an image
     */
    public function isImage(): bool
    {
        return $this->file_type === 'image';
    }

    /**
     * Check if file is a document
     */
    public function isDocument(): bool
    {
        return $this->file_type === 'document';
    }

    /**
     * Check if file is a video
     */
    public function isVideo(): bool
    {
        return $this->file_type === 'video';
    }

    /**
     * Check if file is an audio
     */
    public function isAudio(): bool
    {
        return $this->file_type === 'audio';
    }

    /**
     * Get file icon based on file type
     */
    public function getFileIconAttribute(): string
    {
        return match($this->file_type) {
            'image' => 'image',
            'document' => 'document-text',
            'video' => 'video-camera',
            'audio' => 'musical-note',
            default => 'document'
        };
    }

    /**
     * Scope for public files
     */
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    /**
     * Scope for featured files
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope for specific file type
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('file_type', $type);
    }

    /**
     * Scope for files uploaded by specific user
     */
    public function scopeByUser($query, int $userId)
    {
        return $query->where('uploaded_by', $userId);
    }

    /**
     * Increment download count
     */
    public function incrementDownloadCount(): void
    {
        $this->increment('download_count');
        $this->update(['last_accessed_at' => now()]);
    }

    /**
     * Increment view count
     */
    public function incrementViewCount(): void
    {
        $this->increment('view_count');
        $this->update(['last_accessed_at' => now()]);
    }

    /**
     * Soft delete the file
     */
    public function softDelete(): bool
    {
        return $this->update(['status_deleted' => true]);
    }

    /**
     * Restore the file
     */
    public function restore(): bool
    {
        return $this->update(['status_deleted' => false]);
    }

    /**
     * Scope for non-deleted files (override default behavior)
     */
    public function scopeActive($query)
    {
        return $query->where('status_deleted', false);
    }
}
