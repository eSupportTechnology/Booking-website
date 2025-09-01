<?php

namespace App\Services\Admin;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class CustomersService
{
    public function getCustomersData(int $perPage = 10, ?string $search = null, ?string $status = null): LengthAwarePaginator
    {
        $query = User::query()
            ->whereDoesntHave('partner') // Only users who are not partners
            ->with(['bookings', 'reviews', 'customerPersonalDetail'])
            ->withCount(['bookings', 'reviews']);

        // Apply search filter
        if ($search) {
            $query->where(function (Builder $q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Apply status filter
        if ($status) {
            switch ($status) {
                case 'active':
                    $query->whereNotNull('email_verified_at');
                    break;
                case 'inactive':
                    $query->whereNull('email_verified_at');
                    break;
                case 'pending':
                    $query->whereNull('email_verified_at');
                    break;
            }
        }

        return $query->orderBy('created_at', 'desc')
                    ->paginate($perPage)
                    ->appends([
                        'per_page' => $perPage,
                        'search' => $search,
                        'status' => $status
                    ]);
    }

    public function getCustomerById(int $id): ?User
    {
        return User::with(['bookings', 'reviews', 'customerPersonalDetail'])
                   ->whereDoesntHave('partner')
                   ->find($id);
    }

    public function getCustomerStats(): array
    {
        $totalCustomers = User::whereDoesntHave('partner')->count();
        $activeCustomers = User::whereDoesntHave('partner')
                              ->whereNotNull('email_verified_at')
                              ->count();
        $pendingCustomers = User::whereDoesntHave('partner')
                               ->whereNull('email_verified_at')
                               ->count();

        return [
            'total' => $totalCustomers,
            'active' => $activeCustomers,
            'pending' => $pendingCustomers,
        ];
    }
}
