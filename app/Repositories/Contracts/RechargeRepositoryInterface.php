<?php

namespace App\Repositories\Contracts;

use App\Models\RechargeRequest;

interface RechargeRepositoryInterface
{
    public function create(array $attributes): RechargeRequest;

    public function updateStatus(RechargeRequest $request, string $status): RechargeRequest;
}
