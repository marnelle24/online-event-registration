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
        
        // Check if there are active promocodes for this programme
        $hasActivePromocodes = $programme->promocodes()
            ->where('isActive', true)
            ->where(function($query) {
                $now = now();
                $query->whereNull('startDate')
                      ->orWhere(function($q) use ($now) {
                          $q->where('startDate', '<=', $now)
                            ->where(function($q2) use ($now) {
                                $q2->whereNull('endDate')
                                   ->orWhere('endDate', '>=', $now);
                            });
                      });
            })
            ->exists();
        
        return view('pages.programme-register')
            ->with('programme', $programme)
            ->with('programmeCode', $programmeCode)
            ->with('user', $user)
            ->with('hasActivePromocodes', $hasActivePromocodes);
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
        // Validate main registrant
        $request->validate([
            'nric' => 'nullable|string',
            'title' => 'required|string',
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'email' => 'required|email',
            'contactNumber' => 'required|string',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'postalCode' => 'nullable|string',
            'isGroupRegistration' => 'boolean',
            'groupMembers' => 'sometimes|array',
            'groupMembers.*.title' => 'required_with:groupMembers|string',
            'groupMembers.*.firstName' => 'required_with:groupMembers|string',
            'groupMembers.*.lastName' => 'required_with:groupMembers|string',
            'groupMembers.*.email' => 'required_with:groupMembers|email',
            'groupMembers.*.contactNumber' => 'required_with:groupMembers|string',
            'groupMembers.*.nric' => 'nullable|string',
            'totalCost' => 'sometimes|numeric'
        ]);

        $programme = Programme::findOrFail($request->programmeId);

        // Calculate pricing (use totalCost from frontend or calculate)
        $price = $programme->price;
        $discountAmount = 0;
        $netAmount = $request->totalCost ?? $price;
        $promocodeId = null;

        if ($request->promocodeId) 
        {
            $promocode = Promocode::find($request->promocodeId);

            if ($promocode && $promocode->isActive) 
            {
                $netAmount = $request->totalCost ?? $promocode->price;
                $discountAmount = $price - $netAmount;
                $promocodeId = $promocode->id;
                
                // Increment usage count
                $promocode->increment('usedCount');
            }
        }

        // Generate unique registration code for main registrant
        $mainRegCode = $this->generateRegCode($programme->programmeCode);
        
        // Generate unique group registration ID if this is a group registration
        $groupRegistrationId = $request->isGroupRegistration ? strtoupper(substr(uniqid(), -8)) : null;

        // Create main registrant
        $mainRegistrant = Registrant::create([
            'regCode' => $mainRegCode,
            'programCode' => $programme->programmeCode,
            'programme_id' => $programme->id,
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
            'regStatus' => 'pending',
            'extraFields' => $request->extraFields ?? null,
            'registrationType' => $request->registrationType,
            'groupRegistrationID' => $groupRegistrationId,
        ]);

        // If free event, mark as confirmed
        if ($netAmount == 0) {
            $mainRegistrant->update([
                'regStatus' => 'confirmed',
                'paymentStatus' => 'free'
            ]);
        }

        
        if ($request->isGroupRegistration && $request->has('groupMembers') && is_array($request->groupMembers)) 
        {
            foreach ($request->groupMembers as $member) {
                $memberRegCode = $this->generateRegCode($programme->programmeCode);
                
                $groupMember = Registrant::create([
                    'regCode' => $memberRegCode,
                    'programCode' => $programme->programmeCode,
                    'programme_id' => $programme->id,
                    'nric' => $member['nric'] ?? null,
                    'title' => $member['title'],
                    'firstName' => $member['firstName'],
                    'lastName' => $member['lastName'],
                    'email' => $member['email'],
                    'contactNumber' => $member['contactNumber'],
                    'price' => 0, // Price is paid by main registrant
                    'discountAmount' => 0,
                    'netAmount' => 0,
                    'promocode_id' => $promocodeId,
                    'paymentStatus' => 'group_member',
                    'regStatus' => 'pending',
                    'registrationType' => 'group_member',
                    'groupRegistrationID' => $groupRegistrationId, // Link to main registrant with same group ID
                ]);

                if ($netAmount == 0) {
                    $groupMember->update(['regStatus' => 'confirmed']);
                }
            }
        }

        // Determine redirect URL based on payment status and pre-registration settings
        $redirectUrl = route('registration.confirmation', ['regCode' => $mainRegCode]);
        
        // If this is a paid event, check pre-registration settings
        if ($netAmount > 0) 
        {
            if ($programme->allowPreRegistration) 
            {
                // Allow pre-registration: redirect to confirmation page
                $redirectUrl = route('registration.confirmation', ['regCode' => $mainRegCode]);
            } 
            else 
            {
                // No pre-registration: redirect to payment page
                $redirectUrl = route('registration.payment', ['regCode' => $mainRegCode]);
            }
        }
        // For free events ($netAmount == 0), always redirect to confirmation page
        
        sleep(2);

        return response()->json([
            'success' => true,
            'registrantId' => $mainRegistrant->id,
            'mainRegCode' => $mainRegCode,
            'isGroupRegistration' => $request->isGroupRegistration,
            'groupRegistrationId' => $groupRegistrationId,
            'redirectUrl' => $redirectUrl
        ]);
    }

    public function payment($regCode)
    {
        $registrant = Registrant::where('regCode', $regCode)->firstOrFail();
        
        // Load related data
        $registrant->load('programme', 'promocode');
        
        // Verify this is a paid event
        if ($registrant->netAmount <= 0) {
            return redirect()->route('registration.confirmation', ['regCode' => $regCode]);
        }
        
        // Get group members if this is a group registration (always return collection)
        $groupMembers = collect();
        if ($registrant->groupRegistrationID) {
            $groupMembers = Registrant::where('groupRegistrationID', $registrant->groupRegistrationID)
                ->where('regCode', '!=', $regCode)
                ->get();
        }
        
        return view('pages.registration-payment', [
            'registrant' => $registrant,
            'groupMembers' => $groupMembers
        ]);
    }

    public function confirmation($regCode)
    {
        $registrant = Registrant::where('regCode', $regCode)->firstOrFail();
        
        // Load related data
        $registrant->load('programme', 'promocode');
        
        // Get group members if this is a group registration (always return collection)
        $groupMembers = collect();
        if ($registrant->groupRegistrationID) {
            $groupMembers = Registrant::where('groupRegistrationID', $registrant->groupRegistrationID)
                ->where('regCode', '!=', $regCode)
                ->get();
        }
        
        return view('pages.registration-confirmation', [
            'registrant' => $registrant,
            'groupMembers' => $groupMembers
        ]);
    }

    private function generateRegCode($programmeCode)
    {
        // Count existing registrants for this programme
        $count = Registrant::where('programCode', $programmeCode)->count();
        
        // Increment to get the current registrant number
        $registrantNumber = $count + 1;
        
        // Pad with zeros (3 digits)
        $paddedNumber = str_pad($registrantNumber, 3, '0', STR_PAD_LEFT);
        
        // Generate registration code: PROGRAMMECODE_XXX
        $regCode = $programmeCode . '_' . $paddedNumber;
        
        // Check if regCode already exists (safety check)
        while (Registrant::where('regCode', $regCode)->exists()) {
            $registrantNumber++;
            $paddedNumber = str_pad($registrantNumber, 3, '0', STR_PAD_LEFT);
            $regCode = $programmeCode . '_' . $paddedNumber;
        }

        return $regCode;
    }
}
