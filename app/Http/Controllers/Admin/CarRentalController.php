<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarRentalController extends Controller
{
    public function index(Request $request)
    {
        $query = Car::with(['brand', 'model', 'company', 'renter']);

        // Search filter
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('number_plate', 'LIKE', "%{$request->search}%")
                  ->orWhereHas('brand', fn($b) => $b->where('brand_name', 'LIKE', "%{$request->search}%"))
                  ->orWhereHas('model', fn($m) => $m->where('model_name', 'LIKE', "%{$request->search}%"))
                  ->orWhereHas('renter', fn($u) => 
                        $u->where('full_name', 'LIKE', "%{$request->search}%")
                          ->orWhere('company_name', 'LIKE', "%{$request->search}%")
                    );
            });
        }

        // Status filter
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $cars = $query->orderBy('id', 'desc')->paginate(10);

        return view('admin.admin-carrentals', compact('cars'));
    }

    public function updateStatus(Request $request, $id)
    {
        $car = Car::findOrFail($id);

        $car->status = $request->status;
        $car->approval_status = $request->approval ?? $car->approval_status;

        $car->save();

        return response()->json([
            'success' => true,
            'message' => 'Vehicle updated successfully!'
        ]);
    }

    public function destroy($id)
    {
        $car = Car::findOrFail($id);

        // Delete images if they exist
        if ($car->car_front) Storage::delete($car->car_front);
        if ($car->car_back) Storage::delete($car->car_back);
        if ($car->car_inside) Storage::delete($car->car_inside);

        $car->delete();

        return redirect()
            ->route('admin.rental.carrentals')
            ->with('success', 'Vehicle deleted successfully!');
    }
}
