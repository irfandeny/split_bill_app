<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TripMember extends Model
{
    use HasFactory;

    protected $fillable = ['trip_id', 'user_id', 'name'];

    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function payedExpenses(): HasMany
    {
        return $this->hasMany(ExpensePayer::class);
    }

    public function participatedExpenses(): HasMany
    {
        return $this->hasMany(ExpenseParticipant::class);
    }

    public function settlementsSent(): HasMany
    {
        return $this->hasMany(Settlement::class, 'from_trip_member_id');
    }

    public function settlementsReceived(): HasMany
    {
        return $this->hasMany(Settlement::class, 'to_trip_member_id');
    }
}