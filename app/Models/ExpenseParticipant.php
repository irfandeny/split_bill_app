<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExpenseParticipant extends Model
{
    use HasFactory;

    protected $fillable = ['expense_id', 'trip_member_id', 'share_amount', 'share_percentage'];

    protected $casts = [
        'share_amount' => 'decimal:2',
        'share_percentage' => 'decimal:2',
    ];

    public function expense(): BelongsTo
    {
        return $this->belongsTo(Expense::class);
    }

    public function tripMember(): BelongsTo
    {
        return $this->belongsTo(TripMember::class);
    }
}