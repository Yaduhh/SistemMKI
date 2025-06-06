<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Decking extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'decking';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'lebar',
        'tebal',
        'panjang',
        'luas_btg',
        'luas_m2',
        'satuan',
        'created_by',
        'status_deleted'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'lebar' => 'double',
        'tebal' => 'double',
        'panjang' => 'double',
        'luas_btg' => 'double',
        'luas_m2' => 'double',
        'status_deleted' => 'boolean',
    ];

    /**
     * Get the user that created the decking.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeActive($query)
    {
        return $query->where('status_deleted', false);
    }
} 