<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;

class BulkOperationsController extends Controller
{
    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'property_ids' => 'required|array',
            'property_ids.*' => 'exists:properties,id',
            'action' => 'required|in:activate,deactivate,delete,update_commission,update_pricing'
        ]);

        $propertyIds = $request->property_ids;
        $action = $request->action;
        
        // Ensure user owns all properties
        $properties = Property::whereIn('id', $propertyIds)
            ->where('user_id', auth()->id())
            ->get();
            
        if ($properties->count() !== count($propertyIds)) {
            return response()->json([
                'success' => false,
                'message' => 'You do not have permission to modify some of these properties'
            ], 403);
        }

        $result = $this->executeAction($properties, $action, $request);
        
        return response()->json($result);
    }

    private function executeAction($properties, $action, $request)
    {
        switch ($action) {
            case 'activate':
                $properties->each(function ($property) {
                    $property->update(['status' => 'active']);
                });
                return [
                    'success' => true,
                    'message' => count($properties) . ' properties activated successfully'
                ];

            case 'deactivate':
                $properties->each(function ($property) {
                    $property->update(['status' => 'inactive']);
                });
                return [
                    'success' => true,
                    'message' => count($properties) . ' properties deactivated successfully'
                ];

            case 'delete':
                $properties->each(function ($property) {
                    $property->delete();
                });
                return [
                    'success' => true,
                    'message' => count($properties) . ' properties deleted successfully'
                ];

            case 'update_commission':
                $request->validate([
                    'commission_rate' => 'required|numeric|min:0|max:100'
                ]);
                
                $properties->each(function ($property) use ($request) {
                    $commissionRate = $request->commission_rate;
                    $basePrice = ($property->adult_price ?? 0) + ($property->child_price ?? 0);
                    $totalPrice = $basePrice + ($basePrice * $commissionRate / 100);
                    
                    $property->update([
                        'commission_rate' => $commissionRate,
                        'total_price_with_commission' => $totalPrice
                    ]);
                });
                return [
                    'success' => true,
                    'message' => 'Commission rate updated for ' . count($properties) . ' properties'
                ];

            case 'update_pricing':
                $request->validate([
                    'adult_price' => 'nullable|numeric|min:0',
                    'child_price' => 'nullable|numeric|min:0',
                    'commission_rate' => 'nullable|numeric|min:0|max:100'
                ]);
                
                $properties->each(function ($property) use ($request) {
                    $updateData = [];
                    
                    if ($request->has('adult_price')) {
                        $updateData['adult_price'] = $request->adult_price;
                    }
                    if ($request->has('child_price')) {
                        $updateData['child_price'] = $request->child_price;
                    }
                    if ($request->has('commission_rate')) {
                        $updateData['commission_rate'] = $request->commission_rate;
                    }
                    
                    // Recalculate total price
                    $adultPrice = $updateData['adult_price'] ?? $property->adult_price ?? 0;
                    $childPrice = $updateData['child_price'] ?? $property->child_price ?? 0;
                    $commissionRate = $updateData['commission_rate'] ?? $property->commission_rate ?? 0;
                    
                    $basePrice = $adultPrice + $childPrice;
                    $updateData['total_price_with_commission'] = $basePrice + ($basePrice * $commissionRate / 100);
                    
                    $property->update($updateData);
                });
                return [
                    'success' => true,
                    'message' => 'Pricing updated for ' . count($properties) . ' properties'
                ];

            default:
                return [
                    'success' => false,
                    'message' => 'Invalid action'
                ];
        }
    }

    public function bulkExport(Request $request)
    {
        $request->validate([
            'property_ids' => 'required|array',
            'property_ids.*' => 'exists:properties,id',
            'format' => 'required|in:csv,json'
        ]);

        $properties = Property::whereIn('id', $request->property_ids)
            ->where('user_id', auth()->id())
            ->with(['amenities', 'photos', 'reviews'])
            ->get();

        if ($request->format === 'csv') {
            return $this->exportToCsv($properties);
        } else {
            return $this->exportToJson($properties);
        }
    }

    private function exportToCsv($properties)
    {
        $filename = 'properties_export_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($properties) {
            $file = fopen('php://output', 'w');
            
            // CSV headers
            fputcsv($file, [
                'ID', 'Title', 'Status', 'Category', 'Adult Price', 'Child Price', 
                'Commission Rate', 'Total Price', 'Address', 'City', 'Country',
                'Amenities Count', 'Photos Count', 'Reviews Count', 'Avg Rating'
            ]);
            
            foreach ($properties as $property) {
                fputcsv($file, [
                    $property->id,
                    $property->title,
                    $property->status,
                    $property->category->name ?? '',
                    $property->adult_price,
                    $property->child_price,
                    $property->commission_rate,
                    $property->total_price_with_commission,
                    $property->address,
                    $property->city,
                    $property->country,
                    $property->amenities->count(),
                    $property->photos->count(),
                    $property->reviews->count(),
                    round($property->reviews->avg('rating') ?? 0, 1)
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function exportToJson($properties)
    {
        $filename = 'properties_export_' . date('Y-m-d_H-i-s') . '.json';
        
        $data = $properties->map(function ($property) {
            return [
                'id' => $property->id,
                'title' => $property->title,
                'status' => $property->status,
                'category' => $property->category->name ?? '',
                'adult_price' => $property->adult_price,
                'child_price' => $property->child_price,
                'commission_rate' => $property->commission_rate,
                'total_price_with_commission' => $property->total_price_with_commission,
                'address' => $property->address,
                'city' => $property->city,
                'country' => $property->country,
                'amenities' => $property->amenities->pluck('name'),
                'photos_count' => $property->photos->count(),
                'reviews_count' => $property->reviews->count(),
                'avg_rating' => round($property->reviews->avg('rating') ?? 0, 1)
            ];
        });

        return response()->json($data)
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
}