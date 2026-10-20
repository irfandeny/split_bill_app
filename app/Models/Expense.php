<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'trip_id', 'title', 'total_amount', 'split_method', 'notes', 'expense_date',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'expense_date' => 'date',
    ];

    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class);
    }

    public function payers(): HasMany
    {
        return $this->hasMany(ExpensePayer::class);
    }

    public function participants(): HasMany
    {
        return $this->hasMany(ExpenseParticipant::class);
    }
}