<?php

namespace App\Repositories\Contracts;

use App\Models\FastagRequest;

interface FastagRepositoryInterface
{
    public function create(array $attributes): FastagRequest;

    public function updateStatus(FastagRequest $request, string $status): FastagRequest;
}
