<?php
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
        $superAdminId = Auth::guard('admin')->id();
        $adminAccounts = $this->adminAccountService->getAllAdminAccounts($superAdminId);
        $viewModel = new AdminAccountViewModel($adminAccounts);
        return view('admin.accounts.index', compact('viewModel'));
    }
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected,pending'
        ]);
        $admin = $this->adminAccountService->updateAdminStatus($id, $request->status);
        return redirect()->route('admin.accounts.index')
            ->with('success', "Admin status updated to {$request->status} successfully.");
    }
}
