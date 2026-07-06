<?php

namespace App\Repositories\Contracts;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface
{
    public function findByMobile(string $mobile): ?User;

    public function create(array $attributes): User;

    public function update(User $user, array $attributes): User;

    public function paginate(int $perPage = 15): LengthAwarePaginator;
}
