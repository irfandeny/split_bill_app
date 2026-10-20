<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Settlement extends Model
{
    use HasFactory;

    protected $fillable = [
        'trip_id', 'from_trip_member_id', 'to_trip_member_id', 'amount', 'note', 'settled_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'settled_at' => 'date',
    ];

    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class);
    }

    public function fromMember(): BelongsTo
    {
        return $this->belongsTo(TripMember::class, 'from_trip_member_id');
    }

    public function toMember(): BelongsTo
    {
        return $this->belongsTo(TripMember::class, 'to_trip_member_id');
    }
}