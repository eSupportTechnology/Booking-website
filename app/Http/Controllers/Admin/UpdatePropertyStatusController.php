<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\DTOs\Admin\StatusUpdateDTO;
use App\Services\Admin\PropertyStatusService;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

class UpdatePropertyStatusController extends Controller
{
    public function __construct(
        private PropertyStatusService $propertyStatusService
    ) {}

    public function __invoke(Request $request, Property $property): JsonResponse
    {
        $request->validate([
            'status' => ['required', Rule::in(['active', 'inactive', 'pending'])]
        ]);

        $dto = StatusUpdateDTO::fromRequest(
            $request->all(),
            $property->id,
            'property'
        );

        if (!$dto->isValidStatus()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid status provided.'
            ], 400);
        }

        $result = $this->propertyStatusService->updateStatus($dto);

        return response()->json($result, $result['success'] ? 200 : 500);
    }
}
