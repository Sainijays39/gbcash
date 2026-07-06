<?php

namespace App\Repositories\Contracts;

use App\Models\ElectricityRequest;

interface ElectricityRepositoryInterface
{
    public function create(array $attributes): ElectricityRequest;

    public function updateStatus(ElectricityRequest $request, string $status): ElectricityRequest;
}
