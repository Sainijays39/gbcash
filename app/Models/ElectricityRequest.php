<?php

namespace App\Models;

use App\Enums\RequestStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ElectricityRequest extends Model
{
    use HasUuids;

    protected $fillable = [
        'user_id',
        'provider',
        'consumer_number',
        'customer_name',
        'bill_number',
        'bill_date',
        'due_date',
        'bill_amount',
        'status',
        'meta',
    ];

    protected function casts(): array
    {
        return [
            'bill_date' => 'date',
            'due_date' => 'date',
            'bill_amount' => 'decimal:2',
            'status' => RequestStatus::class,
            'meta' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
