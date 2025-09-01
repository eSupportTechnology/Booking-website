<?php


// app/Http/Controllers/Admin/AdminAccountController.php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Services\Admin\AdminAccountService;
use App\View\Admin\AdminAccountViewModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AdminAccountController extends Controller
{
    protected $adminAccountService;
    public function __construct(AdminAccountService $adminAccountService)
    {
        $this->adminAccountService = $adminAccountService;
    }
    public function index()
    {
        // Get the ID of the currently authenticated user (super admin)
        $superAdminId = Auth::id(); // Assuming the super admin is authenticated
        // Fetch all admin accounts excluding the super admin
        $adminAccounts = $this->adminAccountService->getAllAdminAccounts($superAdminId);
        $viewModel = new AdminAccountViewModel($adminAccounts);

        return view('admin.accounts.index', compact('viewModel'));
    }
    public function toggleStatus($id)
    {
        $this->adminAccountService->toggleAdminStatus($id);
        return redirect()->route('admin.accounts.index')->with('success', 'Admin status updated successfully.');
    }
}
