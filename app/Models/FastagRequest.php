<?php

namespace App\Models;

use App\Enums\RequestStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FastagRequest extends Model
{
    use HasUuids;

    protected $fillable = [
        'user_id',
        'vehicle_number',
        'issuer_bank',
        'customer_name',
        'current_balance',
        'amount',
        'status',
        'meta',
    ];

    protected function casts(): array
    {
        return [
            'current_balance' => 'decimal:2',
            'amount' => 'decimal:2',
            'status' => RequestStatus::class,
            'meta' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
