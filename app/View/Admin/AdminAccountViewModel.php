<?php
namespace App\View\Admin;
class AdminAccountViewModel
{
    public $adminAccounts;
    public function __construct($adminAccounts)
    {
        $this->adminAccounts = $adminAccounts;
    }
    public function getStatusBadgeClass($status)
    {
        return match($status) {
            'approved' => 'bg-green-100 text-green-800',
            'rejected' => 'bg-red-100 text-red-800',
            'pending' => 'bg-yellow-100 text-yellow-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }
    public function getStatusLabel($status)
    {
        return ucfirst($status);
    }
}
