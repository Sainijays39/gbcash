<?php

namespace App\Repositories\Eloquent;

use App\Models\RechargeRequest;
use App\Repositories\Contracts\RechargeRepositoryInterface;

class RechargeRepository implements RechargeRepositoryInterface
{
    public function create(array $attributes): RechargeRequest
    {
        return RechargeRequest::query()->create($attributes);
    }

    public function updateStatus(RechargeRequest $request, string $status): RechargeRequest
    {
        $request->update(['status' => $status]);

        return $request->refresh();
    }
}
