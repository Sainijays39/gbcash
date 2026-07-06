<?php

namespace App\Repositories\Contracts;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface TransactionRepositoryInterface
{
    public function create(array $attributes): Transaction;

    public function updateStatus(Transaction $transaction, string $status): Transaction;

    public function paginateForUser(User $user, array $filters = [], int $perPage = 15): LengthAwarePaginator;

    public function recentForUser(User $user, int $limit = 5);

    public function paginateForAdmin(array $filters = [], int $perPage = 15): LengthAwarePaginator;

    public function countsByServiceType(): array;

    public function dailyCounts(int $days = 14): array;

    public function monthlyCounts(int $months = 6): array;
}
