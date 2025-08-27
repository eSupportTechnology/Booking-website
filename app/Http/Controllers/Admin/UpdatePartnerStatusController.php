<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\DTOs\Admin\StatusUpdateDTO;
use App\Services\Admin\UserStatusService;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

class UpdatePartnerStatusController extends Controller
{
    public function __construct(
        private UserStatusService $userStatusService
    ) {}

    public function __invoke(Request $request, Partner $partner): JsonResponse
    {
        $request->validate([
            'status' => ['required', Rule::in(['active', 'inactive', 'pending'])]
        ]);

        $dto = StatusUpdateDTO::fromRequest(
            $request->all(),
            $partner->id,
            'partner'
        );

        if (!$dto->isValidStatus()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid status provided.'
            ], 400);
        }

        $result = $this->userStatusService->updatePartnerStatus($dto);

        return response()->json($result, $result['success'] ? 200 : 500);
    }
}
