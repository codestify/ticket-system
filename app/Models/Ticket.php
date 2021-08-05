<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    use HasFactory;

    protected $casts = [
        'status' => 'boolean'
    ];

    public function scopeOpen($query)
    {
        $query->where('status', false);
    }

    public function scopeClosed($query)
    {
        $query->where('status', true);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function mostRecentProcessedTime()
    {
        return static::closed()->latest()->first()->updated_at->format('H:i:s');
    }
}
