<?php

namespace App\Http\Controllers;

use App\Models\Programme;
use App\Models\Promotion;
use App\Models\Promocode;
use App\Models\Registrant;
use App\Services\Payment\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class RegistrantController extends Controller
{
    public function register(Request $request, $programmeCode)
    {
        $programme = Programme::where('programmeCode', $programmeCode)
            ->with('promotions')
            ->first();
        
        if (!$programme) {
            abort(404);
        }

        
        $promotionParameter = $request->query('promotion');
        $selectedPromotion = null;

        if ($promotionParameter) {
            $selectedPromotion = $this->resolveSelectedPromotion($programme, $promotionParameter);

            if ($selectedPromotion) {
                $promotionParameter = Str::slug($selectedPromotion->title, ' ');
            } else {
                $promotionParameter = null;
            }
        }

        $promotionForRegister = $selectedPromotion;
        
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
            ->with('hasActivePromocodes', $hasActivePromocodes)
            ->with('promotionForRegister', $promotionForRegister)
            ->with('selectedPromotionParam', $promotionParameter);
    }

    public function registerV2(Request $request, $programmeCode)
    {
        $programme = Programme::where('programmeCode', $programmeCode)
            ->with('promotions')
            ->first();

        if (!$programme) {
            abort(404);
        }

        $promotionId = $request->query('promotion');
        $selectedPromotion = null;

        if ($promotionId) {

            $selectedPromotion = $programme->promotions->firstWhere('id', $promotionId);
            // $selectedPromotion = $this->resolvePromotionById($programme, $promotionId);

            if ($selectedPromotion) {
                $promotionId = $selectedPromotion->id;
            } else {
                $promotionId = null;
            }
        }

        $user = auth()->user();

        $hasActivePromocodes = $programme->promocodes()
            ->where('isActive', true)
            ->where(function ($query) {
                $now = now();
                $query->whereNull('startDate')
                      ->orWhere(function ($q) use ($now) {
                          $q->where('startDate', '<=', $now)
                            ->where(function ($q2) use ($now) {
                                $q2->whereNull('endDate')
                                   ->orWhere('endDate', '>=', $now);
                            });
                      });
            })
            ->exists();

        return view('pages.programme-register-v2', [
            'programme' => $programme,
            'programmeCode' => $programmeCode,
            'user' => $user,
            'hasActivePromocodes' => $hasActivePromocodes,
            'promotionForRegister' => $selectedPromotion,
        ]);
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
            'promotionId' => 'nullable|exists:promotions,id',
            'totalCost' => 'sometimes|numeric'
        ]);

        $programme = Programme::findOrFail($request->programmeId);
        $programme->loadMissing('promotions');

        $selectedPromotion = $this->resolvePromotionById($programme, $request->input('promotionId'));

        if (!$selectedPromotion) {
            $selectedPromotion = $this->getDefaultActivePromotion($programme);
        }

        $promotionId = $selectedPromotion?->id;
        $promotionPrice = $selectedPromotion?->price;

        $discountAmount = $promotionPrice ?? 0;
        $netAmount = $promotionPrice ?? $programme->price;

        $promocodeId = null;
        if ($request->promocodeId) 
        {
            $promocode = Promocode::find($request->promocodeId);

            if ($promocode && $promocode->isActive) 
            {
                $netAmount = $promocode->price;
                $discountAmount = $promocode->price;
                $promocodeId = $promocode->id;
            }
        }

        // Generate unique registration code for main registrant
        // $mainRegCode = $this->generateRegCode($programme->programmeCode);
        $confirmationCode = $programme->programmeCode.'_'.strtoupper(substr(uniqid(), -6));
        
        // Generate unique group registration ID if this is a group registration
        $groupRegistrationId = $request->isGroupRegistration ? $confirmationCode : null;

        // Create main registrant
        $mainRegistrant = Registrant::create([
            'regCode' =>$netAmount > 0 ? NULL : $this->generateRegCode($programme->programmeCode),
            'confirmationCode' => $confirmationCode,
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
            'price' => $programme->price,
            'discountAmount' => $discountAmount,
            'netAmount' => $netAmount,
            'promocode_id' => $promocodeId,
            'promotion_id' => $promotionId,
            'paymentStatus' => $netAmount > 0 ? 'pending' : 'free',
            'regStatus' => $netAmount > 0 ? 'pending' : 'confirmed',
            'extraFields' => $request->extraFields ?? null,
            'registrationType' => $request->registrationType,
            'groupRegistrationID' => $groupRegistrationId,
        ]);
        
        if ($request->isGroupRegistration && $request->has('groupMembers') && is_array($request->groupMembers)) 
        {
            foreach ($request->groupMembers as $member) 
            {
                $groupMember = Registrant::create([
                    'confirmationCode' => $confirmationCode,
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
                    'promotion_id' => $promotionId,
                    'paymentStatus' => $netAmount > 0 ? 'group_member_pending' : 'free',
                    'regStatus' => $netAmount > 0 ? 'group_reg_pending' : 'confirmed',
                    'registrationType' => 'group_member',
                    'groupRegistrationID' => $groupRegistrationId, // Link to main registrant with same group ID
                ]);
            }
        }

        // Determine redirect URL based on payment status and pre-registration settings
        $redirectUrl = route('registration.confirmation', ['confirmationCode' => $confirmationCode]);
        
        // If this is a paid event, check pre-registration settings
        if ($netAmount > 0) 
        {
            if ($programme->allowPreRegistration) 
            {
                // Allow pre-registration: redirect to confirmation page
                $redirectUrl = route('registration.confirmation', ['confirmationCode' => $confirmationCode]);
            } 
            else 
            {
                // No pre-registration: redirect to payment page
                $redirectUrl = route('registration.payment', ['confirmationCode' => $confirmationCode]);
            }
        }

        sleep(2);

        return response()->json([
            'success' => true,
            'registrantId' => $mainRegistrant->id,
            'mainRegCode' => $confirmationCode,
            'isGroupRegistration' => $request->isGroupRegistration,
            'groupRegistrationId' => $groupRegistrationId,
            'redirectUrl' => $redirectUrl
        ]);
    }

    public function payment($confirmationCode)
    {
        $registrant = Registrant::where('confirmationCode', $confirmationCode)->firstOrFail();
        
        // Load related data
        $registrant->load('programme', 'promocode');
        
        // Verify this is a paid event
        if ($registrant->netAmount <= 0) {
            return redirect()->route('registration.confirmation', ['confirmationCode' => $confirmationCode]);
        }
        
        // Check if payment is already completed
        $isPaid = in_array($registrant->paymentStatus, ['paid', 'group_member_paid', 'free']);
        
        // Get group members if this is a group registration (always return collection)
        $groupMembers = collect();
        if ($registrant->groupRegistrationID) {
            $groupMembers = Registrant::where('groupRegistrationID', $registrant->groupRegistrationID)
                ->where('confirmationCode', '=', $confirmationCode)
                ->orderBy('id', 'asc')
                ->get();
        }

        return view('pages.registration-payment', [
            'registrant' => $registrant,
            'groupMembers' => $groupMembers,
            'isPaid' => $isPaid
        ]);
    }

    public function paymentV2($confirmationCode)
    {
        $registrant = Registrant::with(['programme', 'promocode'])
            ->where('confirmationCode', $confirmationCode)
            ->firstOrFail();

        if ($registrant->netAmount <= 0) {
            return redirect()->route('registration.confirmation', ['confirmationCode' => $confirmationCode]);
        }

        return view('pages.registration-payment-v2', [
            'confirmationCode' => $confirmationCode,
        ]);
    }

    public function confirmation($confirmationCode)
    {
        $registrant = Registrant::where('confirmationCode', $confirmationCode)->firstOrFail();
        
        // Load related data
        $registrant->load('programme', 'promocode');
        
        // Get group members if this is a group registration (always return collection)
        $groupMembers = collect();
        if ($registrant->groupRegistrationID) {
            $groupMembers = Registrant::where('groupRegistrationID', $registrant->groupRegistrationID)
                ->where('confirmationCode', '=', $confirmationCode)
                ->orderBy('id', 'asc')
                ->get();
        }
        
        return view('pages.registration-confirmation', [
            'registrant' => $registrant,
            'groupMembers' => $groupMembers
        ]);
    }

    /**
     * Process payment with selected payment method
     *
     * @param Request $request
     * @param string $confirmationCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function processPayment(Request $request, $confirmationCode)
    {
        $request->validate([
            'payment_method' => 'required|string|in:hitpay,paypal,stripe,bank_transfer',
        ]);

        try {
            $registrant = Registrant::where('confirmationCode', $confirmationCode)->firstOrFail();
            
            // Verify this is a paid event
            if ($registrant->netAmount <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'This is a free event, no payment required.',
                ], 400);
            }

            // Check if already paid
            if ($registrant->paymentStatus === 'paid') {
                return response()->json([
                    'success' => false,
                    'message' => 'Payment has already been completed.',
                ], 400);
            }

            $paymentService = new PaymentService();
            $result = $paymentService->processPayment(
                $registrant, 
                $request->payment_method,
                $request->only(['card_token', 'payment_token']) // Additional data for specific gateways
            );

            if ($result['success']) {
                return response()->json([
                    'success' => true,
                    'payment_method' => $request->payment_method,
                    'data' => $result['data'],
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => $result['error'] ?? 'Payment processing failed',
            ], 500);

        } catch (\Exception $e) {
            Log::error('Payment processing error', [
                'confirmationCode' => $confirmationCode,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing payment',
            ], 500);
        }
    }

    /**
     * Handle payment callback from payment gateways
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function paymentCallback(Request $request)
    {
        try 
        {
            // Determine payment method from request
            $paymentMethod = $this->detectPaymentMethod($request);

            if (!$paymentMethod) {
                return redirect()->route('registration.payment.v2', ['confirmationCode' => $confirmationCode])->with('error', 'Invalid payment callback');
            }

            $paymentService = new PaymentService();
            $result = $paymentService->verifyPaymentCallback($paymentMethod, $request->all());

            if ($result['verified']) 
            {
                $referenceNo = $result['reference_no'];

                $registrant = Registrant::where('paymentReferenceNo', $referenceNo)
                    ->orWhere('confirmationCode', $referenceNo)
                    ->first();

                if ($registrant) 
                {
                    return redirect()
                        ->route('registration.confirmation', ['confirmationCode' => $registrant->confirmationCode])
                        ->with('success', 'Payment successful! Your registration is confirmed.');
                }
            }

            return redirect()->route('registration.payment.v2', ['confirmationCode' => $registrant->confirmationCode])->with('error', 'Payment verification failed');

        } 
        catch (\Exception $e) 
        {
            Log::error('Payment callback error', [
                'error' => $e->getMessage(),
                'request' => $request->all(),
            ]);

            return redirect()->route('registration.payment.v2', ['confirmationCode' => $referenceNo])->with('error', 'Payment verification failed');
        }
    }

    /**
     * Handle payment webhook from payment gateways
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function paymentWebhook(Request $request)
    {
        try {
            // Determine payment method from request
            $paymentMethod = $this->detectPaymentMethod($request);
            
            if (!$paymentMethod) {
                return response()->json(['error' => 'Invalid webhook'], 400);
            }

            $paymentService = new PaymentService();
            $result = $paymentService->verifyPaymentCallback($paymentMethod, $request->all());

            Log::info('Payment webhook received', [
                'payment_method' => $paymentMethod,
                'verified' => $result['verified'] ?? false,
                'result' => $result,
            ]);

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            Log::error('Payment webhook error', [
                'error' => $e->getMessage(),
                'request' => $request->all(),
            ]);

            return response()->json(['error' => 'Webhook processing failed'], 500);
        }
    }

    /**
     * Get available payment methods for registrant
     *
     * @param string $confirmationCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPaymentMethods($confirmationCode)
    {
        try {
            $registrant = Registrant::where('confirmationCode', $confirmationCode)->firstOrFail();
            
            $paymentService = new PaymentService();
            $methods = $paymentService->getAvailablePaymentMethods();

            return response()->json([
                'success' => true,
                'payment_methods' => $methods,
                'registrant' => [
                    'confirmationCode' => $registrant->confirmationCode,
                    'amount' => $registrant->netAmount,
                    'currency' => 'SGD', // Default currency
                ],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load payment methods',
            ], 500);
        }
    }

    /**
     * Admin: Verify bank transfer payment manually
     *
     * @param Request $request
     * @param string $confirmationCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyBankTransfer(Request $request, $confirmationCode)
    {
        // This should be protected by admin middleware
        $request->validate([
            'verified' => 'required|boolean',
            'notes' => 'nullable|string',
        ]);

        try {
            $registrant = Registrant::where('confirmationCode', $confirmationCode)->firstOrFail();

            if ($request->verified) {
                $paymentService = new PaymentService();
                $paymentService->confirmPayment($registrant->paymentReferenceNo, [
                    'verified_by' => auth()->user()->name ?? 'Admin',
                    'verified_at' => now(),
                    'notes' => $request->notes,
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Payment verified and registration confirmed',
                ]);
            }

            $registrant->update([
                'paymentStatus' => 'rejected',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Payment rejected',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to verify payment',
            ], 500);
        }
    }

    /**
     * Detect payment method from request
     *
     * @param Request $request
     * @return string|null
     */
    protected function detectPaymentMethod(Request $request): ?string
    {
        // Check for HitPay
        if ($request->has('hmac') || $request->has('reference')) {
            return 'hitpay';
        }

        // Check for Stripe
        if ($request->has('session_id')) {
            return 'stripe';
        }

        // Check for PayPal
        if ($request->has('token') || $request->has('PayerID')) {
            return 'paypal';
        }

        // Check explicit payment_method parameter
        if ($request->has('payment_method')) {
            return $request->payment_method;
        }

        return null;
    }

    protected function resolveSelectedPromotion(Programme $programme, ?string $promotionParameter): ?Promotion
    {
        if (!$promotionParameter)
            return null;

        $promotion = $programme->promotions->firstWhere('id', $promotionParameter);

        return $promotion;
    }

    protected function resolvePromotionById(Programme $programme, ?int $promotionId): ?Promotion
    {
        if (!$promotionId) {
            return null;
        }

        $promotion = $programme->promotions->firstWhere('id', $promotionId);

        if (!$promotion) {
            return null;
        }

        return $this->promotionIsCurrentlyActive($promotion) ? $promotion : null;
    }

    protected function getDefaultActivePromotion(Programme $programme): ?Promotion
    {
        return $programme->promotions
            ->filter(fn (Promotion $promotion) => $this->promotionIsCurrentlyActive($promotion))
            ->sortBy([
                ['arrangement', 'asc'],
                ['startDate', 'asc'],
            ])
            ->first();
    }

    protected function promotionIsCurrentlyActive(Promotion $promotion): bool
    {
        $now = now();

        if (!$promotion->isActive) {
            return false;
        }

        if ($promotion->startDate && $promotion->startDate->gt($now)) {
            return false;
        }

        if ($promotion->endDate && $promotion->endDate->lt($now)) {
            return false;
        }

        return true;
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
