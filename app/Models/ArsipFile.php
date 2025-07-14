<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArsipFile extends Model
{
    use HasFactory;

    /**
     * Status constants
     */
    const STATUS_DRAFT = 'draft';
    const STATUS_ON_PROGRESS = 'on progress';
    const STATUS_DONE = 'done';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'arsip_file';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'id_client',
        'file',
        'status_deleted',
        'status',
        'created_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status_deleted' => 'boolean',
    ];

    /**
     * Get the client that owns the arsip file.
     */
    public function client()
    {
        return $this->belongsTo(Client::class, 'id_client');
    }

    /**
     * Get the user that created the arsip file.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get all available status options
     */
    public static function getStatusOptions()
    {
        return [
            self::STATUS_DRAFT => 'Draft',
            self::STATUS_ON_PROGRESS => 'On Progress',
            self::STATUS_DONE => 'Done',
        ];
    }

    /**
     * Get status badge class
     */
    public function getStatusBadgeClass()
    {
        return match ($this->status) {
            self::STATUS_DRAFT => 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200',
            self::STATUS_ON_PROGRESS => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
            self::STATUS_DONE => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
            default => 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200',
        };
    }

    /**
     * Check if status is draft
     */
    public function isDraft()
    {
        return $this->status === self::STATUS_DRAFT;
    }

    /**
     * Check if status is on progress
     */
    public function isOnProgress()
    {
        return $this->status === self::STATUS_ON_PROGRESS;
    }

    /**
     * Check if status is done
     */
    public function isDone()
    {
        return $this->status === self::STATUS_DONE;
    }
}
