<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\CommissionInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CommissionController extends Controller
{
    public function index()
    {
        $partner = Auth::user()->partner;
        $invoices = CommissionInvoice::where('partner_id', $partner->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('partner.commission.index', compact('invoices'));
    }

    public function submitPayment(Request $request, CommissionInvoice $invoice)
    {
        $request->validate([
            'payment_proof' => 'required|image|max:2048'
        ]);

        if ($request->hasFile('payment_proof')) {
            $path = $request->file('payment_proof')->store('payment-proofs', 'public');
            
            $invoice->update([
                'payment_proof' => $path,
                'payment_status' => 'submitted'
            ]);
        }

        return back()->with('success', 'Payment proof submitted successfully.');
    }
}