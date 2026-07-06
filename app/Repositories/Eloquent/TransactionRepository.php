<?php

namespace App\Repositories\Eloquent;

use App\Models\Transaction;
use App\Models\User;
use App\Repositories\Contracts\TransactionRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class TransactionRepository implements TransactionRepositoryInterface
{
    public function create(array $attributes): Transaction
    {
        return Transaction::query()->create($attributes);
    }

    public function updateStatus(Transaction $transaction, string $status): Transaction
    {
        $transaction->update(['status' => $status]);

        return $transaction->refresh();
    }

    public function paginateForUser(User $user, array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Transaction::query()->where('user_id', $user->id);

        $this->applyDateRangeFilter($query, $filters['range'] ?? null);
        $this->applySearchFilter($query, $filters['search'] ?? null);

        return $query->latest()->paginate($perPage)->withQueryString();
    }

    public function recentForUser(User $user, int $limit = 5)
    {
        return Transaction::query()
            ->where('user_id', $user->id)
            ->latest()
            ->limit($limit)
            ->get();
    }

    public function paginateForAdmin(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Transaction::query()->with('user:id,name,mobile');

        if (! empty($filters['service_type'])) {
            $query->where('service_type', $filters['service_type']);
        }

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (! empty($filters['from'])) {
            $query->whereDate('created_at', '>=', $filters['from']);
        }

        if (! empty($filters['to'])) {
            $query->whereDate('created_at', '<=', $filters['to']);
        }

        $this->applySearchFilter($query, $filters['search'] ?? null);

        return $query->latest()->paginate($perPage)->withQueryString();
    }

    public function countsByServiceType(): array
    {
        return Transaction::query()
            ->select('service_type', DB::raw('count(*) as total'))
            ->groupBy('service_type')
            ->pluck('total', 'service_type')
            ->toArray();
    }

    public function dailyCounts(int $days = 14): array
    {
        $start = Carbon::now()->subDays($days - 1)->startOfDay();

        return Transaction::query()
            ->select(DB::raw('DATE(created_at) as day'), DB::raw('count(*) as total'))
            ->where('created_at', '>=', $start)
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('day')
            ->get()
            ->pluck('total', 'day')
            ->toArray();
    }

    public function monthlyCounts(int $months = 6): array
    {
        $start = Carbon::now()->subMonths($months - 1)->startOfMonth();

        return Transaction::query()
            ->select(DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"), DB::raw('count(*) as total'))
            ->where('created_at', '>=', $start)
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
            ->orderBy('month')
            ->get()
            ->pluck('total', 'month')
            ->toArray();
    }

    private function applyDateRangeFilter(Builder $query, ?string $range): void
    {
        match ($range) {
            'today' => $query->whereDate('created_at', Carbon::today()),
            'this_week' => $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]),
            'this_month' => $query->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]),
            default => null,
        };
    }

    private function applySearchFilter(Builder $query, ?string $search): void
    {
        if (! empty($search)) {
            $query->where('reference_number', 'like', "%{$search}%");
        }
    }
}
