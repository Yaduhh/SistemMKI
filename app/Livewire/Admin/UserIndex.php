<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserIndex extends Component
{
    use WithPagination;

    public string $search = '';
    public string $roleFilter = '';
    public string $statusFilter = '';
    public int $perPage = 12;

    protected $queryString = [
        'search' => ['except' => ''],
        'roleFilter' => ['except' => ''],
        'statusFilter' => ['except' => ''],
    ];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedRoleFilter()
    {
        $this->resetPage();
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->reset(['search', 'roleFilter', 'statusFilter']);
        $this->resetPage();
    }

    public function render()
    {
        $query = User::where('status_deleted', false);

        // Search functionality
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%')
                  ->orWhere('notelp', 'like', '%' . $this->search . '%');
            });
        }

        // Role filter
        if (!empty($this->roleFilter)) {
            $query->where('role', $this->roleFilter);
        }

        // Status filter
        if ($this->statusFilter !== '') {
            $query->where('status', $this->statusFilter === 'active');
        }

        $users = $query->latest()->paginate($this->perPage);

        // Get stats
        $totalUsers = User::where('status_deleted', false)->count();
        $adminCount = User::where('status_deleted', false)->where('role', 1)->count();
        $salesCount = User::where('status_deleted', false)->where('role', 2)->count();
        $financeCount = User::where('status_deleted', false)->where('role', 3)->count();
        $digitalMarketingCount = User::where('status_deleted', false)->where('role', 4)->count();

        return view('livewire.admin.user-index', [
            'users' => $users,
            'totalUsers' => $totalUsers,
            'adminCount' => $adminCount,
            'salesCount' => $salesCount,
            'financeCount' => $financeCount,
            'digitalMarketingCount' => $digitalMarketingCount,
        ])->layout('components.layouts.app');
    }
} 