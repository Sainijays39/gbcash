<?php

namespace App\Repositories\Eloquent;

use App\Models\ElectricityRequest;
use App\Repositories\Contracts\ElectricityRepositoryInterface;

class ElectricityRepository implements ElectricityRepositoryInterface
{
    public function create(array $attributes): ElectricityRequest
    {
        return ElectricityRequest::query()->create($attributes);
    }

    public function updateStatus(ElectricityRequest $request, string $status): ElectricityRequest
    {
        $request->update(['status' => $status]);

        return $request->refresh();
    }
}
