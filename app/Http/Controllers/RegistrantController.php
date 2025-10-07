<?php

namespace App\Http\Controllers;

use App\Models\Programme;
use App\Models\Promocode;
use App\Models\Registrant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RegistrantController extends Controller
{
    public function register($programmeCode)
    {
        $programme = Programme::where('programmeCode', $programmeCode)->first();
        
        if (!$programme) {
            abort(404);
        }
        
        // Get authenticated user data if available
        $user = auth()->user();
        
        return view('pages.programme-register')
            ->with('programme', $programme)
            ->with('programmeCode', $programmeCode)
            ->with('user', $user);
    }

    public function validatePromocode(Request $request)
    {
        $request->validate([
            'promocode' => 'required|string',
            'programmeCode' => 'required|string'
        ]);

        $promocode = Promocode::where('promocode', strtoupper($request->promocode))
            ->where('programCode', $request->programmeCode)
            ->where('isActive', true)
            ->first();

        if (!$promocode) {
            return response()->json([
                'valid' => false,
                'message' => 'Invalid promo code'
            ]);
        }

        // Check if promo code is within valid date range
        $now = now();
        if ($promocode->startDate && $now->lt($promocode->startDate)) {
            return response()->json([
                'valid' => false,
                'message' => 'Promo code is not yet active'
            ]);
        }

        if ($promocode->endDate && $now->gt($promocode->endDate)) {
            return response()->json([
                'valid' => false,
                'message' => 'Promo code has expired'
            ]);
        }

        // Check if promo code has reached max uses
        if ($promocode->maxUses && $promocode->usedCount >= $promocode->maxUses) {
            return response()->json([
                'valid' => false,
                'message' => 'Promo code has reached maximum usage limit'
            ]);
        }

        return response()->json([
            'valid' => true,
            'promocodeId' => $promocode->id,
            'price' => $promocode->price,
            'message' => 'Promo code applied successfully'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'programmeCode' => 'required|string',
            'programmeId' => 'required|integer',
            'title' => 'required|string',
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'email' => 'required|email',
            'contactNumber' => 'required|string'
        ]);

        $programme = Programme::findOrFail($request->programmeId);

        // Calculate pricing
        $price = $programme->price;
        $discountAmount = 0;
        $netAmount = $price;
        $promocodeId = null;

        if ($request->promocodeId) {
            $promocode = Promocode::find($request->promocodeId);
            if ($promocode && $promocode->isActive) {
                $netAmount = $promocode->price;
                $discountAmount = $price - $netAmount;
                $promocodeId = $promocode->id;
                
                // Increment usage count
                $promocode->increment('usedCount');
            }
        }

        // Generate unique registration code
        $regCode = $this->generateRegCode();

        // Create registrant
        $registrant = Registrant::create([
            'regCode' => $regCode,
            'programCode' => $request->programmeCode,
            'programme_id' => $request->programmeId,
            'nric' => $request->nric,
            'title' => $request->title,
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'address' => $request->address,
            'city' => $request->city,
            'postalCode' => $request->postalCode,
            'email' => $request->email,
            'contactNumber' => $request->contactNumber,
            'price' => $price,
            'discountAmount' => $discountAmount,
            'netAmount' => $netAmount,
            'promocode_id' => $promocodeId,
            'paymentStatus' => $netAmount > 0 ? 'pending' : 'free',
            'regStatus' => 'pending'
        ]);

        // If free event, mark as confirmed
        if ($netAmount == 0) {
            $registrant->update([
                'regStatus' => 'confirmed',
                'paymentStatus' => 'free'
            ]);
        }

        return response()->json([
            'success' => true,
            'registrantId' => $registrant->id,
            'regCode' => $regCode,
            'redirectUrl' => route('registration.confirmation', ['regCode' => $regCode])
        ]);
    }

    private function generateRegCode()
    {
        do {
            $regCode = 'REG' . strtoupper(Str::random(8));
        } while (Registrant::where('regCode', $regCode)->exists());

        return $regCode;
    }
}
