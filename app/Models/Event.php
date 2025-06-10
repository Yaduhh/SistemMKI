<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_event',
        'jadwal',
        'location',
        'deskripsi',
        'peserta',
        'created_by',
        'status',
        'status_deleted'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'peserta' => 'array',
        'jadwal' => 'datetime',
        'status_deleted' => 'boolean',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * The timezone that should be used for date casting.
     *
     * @var string
     */
    protected $timezone = 'Asia/Jakarta';

    /**
     * Get the user that created the event.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the users who are invited to the event.
     */
    public function invitedUsers()
    {
        return $this->belongsToMany(User::class, null, null, null, 'peserta');
    }

    /**
     * Scope to get upcoming events.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('jadwal', '>', now());
    }

    /**
     * Scope to get past events.
     */
    public function scopePast($query)
    {
        return $query->where('jadwal', '<', now());
    }

    /**
     * Scope to get active events only.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active')->where('status_deleted', false);
    }

    /**
     * Scope to get non-deleted events.
     */
    public function scopeNotDeleted($query)
    {
        return $query->where('status_deleted', false);
    }

    /**
     * Check if event is upcoming.
     */
    public function isUpcoming()
    {
        return $this->jadwal > now();
    }

    /**
     * Check if event is past.
     */
    public function isPast()
    {
        return $this->jadwal < now();
    }

    /**
     * Check if event is active.
     */
    public function isActive()
    {
        return $this->status === 'active' && !$this->status_deleted;
    }

    /**
     * Check if event is cancelled.
     */
    public function isCancelled()
    {
        return $this->status === 'cancelled';
    }

    /**
     * Check if event is completed.
     */
    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    /**
     * Soft delete the event.
     */
    public function softDelete()
    {
        $this->update(['status_deleted' => true]);
    }

    /**
     * Restore the event.
     */
    public function restore()
    {
        $this->update(['status_deleted' => false]);
    }
} 