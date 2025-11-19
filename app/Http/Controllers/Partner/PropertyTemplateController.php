<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;

class PropertyTemplateController extends Controller
{
    public function index()
    {
        $templates = Property::where('user_id', auth()->id())
            ->where('status', 'active')
            ->with(['amenities', 'languages', 'photos'])
            ->get()
            ->map(function ($property) {
                return [
                    'id' => $property->id,
                    'title' => $property->title,
                    'category' => $property->category->name ?? 'Unknown',
                    'amenities_count' => $property->amenities->count(),
                    'photos_count' => $property->photos->count(),
                    'adult_price' => $property->adult_price,
                    'child_price' => $property->child_price,
                    'commission_rate' => $property->commission_rate,
                ];
            });

        return view('partner.templates.index', compact('templates'));
    }

    public function createFromTemplate(Request $request, $templateId)
    {
        $template = Property::where('id', $templateId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // Create new property from template
        $newProperty = $template->replicate([
            'id', 'created_at', 'updated_at', 'status', 'published_at'
        ]);
        
        $newProperty->title = $template->title . ' (Copy)';
        $newProperty->status = 'draft';
        $newProperty->save();

        // Copy relationships
        $this->copyRelationships($template, $newProperty);

        return response()->json([
            'success' => true,
            'property_id' => $newProperty->id,
            'message' => 'Property created from template successfully'
        ]);
    }

    public function saveAsTemplate(Request $request, $propertyId)
    {
        $property = Property::where('id', $propertyId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $request->validate([
            'template_name' => 'required|string|max:100'
        ]);

        // Create template copy
        $template = $property->replicate([
            'id', 'created_at', 'updated_at'
        ]);
        
        $template->title = $request->template_name;
        $template->status = 'template';
        $template->save();

        // Copy relationships
        $this->copyRelationships($property, $template);

        return response()->json([
            'success' => true,
            'template_id' => $template->id,
            'message' => 'Template saved successfully'
        ]);
    }

    private function copyRelationships($source, $target)
    {
        // Copy amenities
        if ($source->amenities()->exists()) {
            $target->amenities()->sync($source->amenities->pluck('id'));
        }

        // Copy languages
        if ($source->languages()->exists()) {
            $target->languages()->sync($source->languages->pluck('id'));
        }

        // Copy additional details
        if ($source->additionalDetails) {
            $target->additionalDetails()->create($source->additionalDetails->toArray());
        }

        // Copy policies
        if ($source->policies) {
            $target->policies()->create($source->policies->toArray());
        }

        // Copy services
        if ($source->services) {
            $target->services()->create($source->services->toArray());
        }

        // Copy host profile
        if ($source->hostProfile) {
            $target->hostProfile()->create($source->hostProfile->toArray());
        }

        // Copy bedrooms
        if ($source->bedrooms()->exists()) {
            foreach ($source->bedrooms as $bedroom) {
                $target->bedrooms()->create($bedroom->toArray());
            }
        }

        // Copy seasonal pricing
        if ($source->seasonalPricings()->exists()) {
            foreach ($source->seasonalPricings as $pricing) {
                $target->seasonalPricings()->create($pricing->toArray());
            }
        }
    }

    public function destroy($templateId)
    {
        Property::where('id', $templateId)
            ->where('user_id', auth()->id())
            ->where('status', 'template')
            ->delete();

        return response()->json([
            'success' => true,
            'message' => 'Template deleted successfully'
        ]);
    }
}