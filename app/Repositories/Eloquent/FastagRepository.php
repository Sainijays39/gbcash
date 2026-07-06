<?php

namespace App\Repositories\Eloquent;

use App\Models\FastagRequest;
use App\Repositories\Contracts\FastagRepositoryInterface;

class FastagRepository implements FastagRepositoryInterface
{
    public function create(array $attributes): FastagRequest
    {
        return FastagRequest::query()->create($attributes);
    }

    public function updateStatus(FastagRequest $request, string $status): FastagRequest
    {
        $request->update(['status' => $status]);

        return $request->refresh();
    }
}
