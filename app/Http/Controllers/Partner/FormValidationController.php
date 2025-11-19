<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FormValidationController extends Controller
{
    private array $validationRules = [
        'title' => 'required|min:10|max:100',
        'description' => 'required|min:50|max:1000',
        'adult_price' => 'required|numeric|min:1|max:10000',
        'child_price' => 'nullable|numeric|min:0|max:10000',
        'commission_rate' => 'required|numeric|min:0|max:50',
        'address' => 'required|min:10|max:200',
        'city' => 'required|min:2|max:50',
        'country' => 'required|min:2|max:50',
        'zipcode' => 'required|min:3|max:20',
        'apartment' => 'nullable|max:50',
    ];

    public function validateField(Request $request)
    {
        $field = $request->input('field');
        $value = $request->input('value');
        
        if (!isset($this->validationRules[$field])) {
            return response()->json(['valid' => true]);
        }
        
        $validator = Validator::make(
            [$field => $value], 
            [$field => $this->validationRules[$field]]
        );
        
        return response()->json([
            'valid' => !$validator->fails(),
            'message' => $validator->errors()->first($field),
            'field' => $field
        ]);
    }
    
    public function validateForm(Request $request)
    {
        $validator = Validator::make($request->all(), $this->validationRules);
        
        return response()->json([
            'valid' => !$validator->fails(),
            'errors' => $validator->errors()->toArray()
        ]);
    }
}