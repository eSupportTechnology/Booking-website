<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\AdminDashboardService;
use App\Actions\Admin\PropertyApprovalAction;
use App\DTOs\Admin\PropertyApprovalDTO;
use Illuminate\Http\Request;
use App\Models\Property;

class PropertyManagementController extends Controller
{
    public function __construct(
        private AdminDashboardService $dashboardService,
        private PropertyApprovalAction $approvalAction
    ) {}

    public function pending(Request $request)
    {
        $filters = $request->only(['search', 'type']);
        $properties = $this->dashboardService->getPendingProperties($filters);

        return view('admin.properties.pending', [
            'properties' => $properties,
            'pendingCount' => Property::where('status', 'pending')->count()
        ]);
    }

    public function review($id)
    {
        $property = Property::with(['partner', 'amenities', 'photos'])->findOrFail($id);

        return view('admin.properties.review', [
            'property' => $property,
            'guestReviews' => $property->guestReviews,
            'hostReviews' => $property->hostReviews
        ]);
    }

    public function approve(Request $request, $id)
    {
        $dto = PropertyApprovalDTO::fromRequest([
            'property_id' => $id,
            'status' => 'approved'
        ]);

        $this->approvalAction->execute($dto);

        return response()->json([
            'message' => 'Property approved successfully'
        ]);
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:500'
        ]);

        $dto = PropertyApprovalDTO::fromRequest([
            'property_id' => $id,
            'status' => 'rejected',
            'rejection_reason' => $request->reason
        ]);

        $this->approvalAction->execute($dto);

        return response()->json([
            'message' => 'Property rejected successfully'
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:active,inactive,pending'
        ]);

        $property = Property::findOrFail($id);
        $property->status = $request->status;
        $property->save();

        return response()->json([
            'message' => 'Property status updated successfully'
        ]);
    }
}
