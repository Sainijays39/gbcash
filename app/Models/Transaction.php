<?php

namespace App\Models;

use App\Enums\RequestStatus;
use App\Enums\ServiceType;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasUuids;

    protected $fillable = [
        'user_id',
        'service_type',
        'service_id',
        'reference_number',
        'amount',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'service_type' => ServiceType::class,
            'amount' => 'decimal:2',
            'status' => RequestStatus::class,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
