<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registrant extends Model
{
    protected $fillable = [
        'regCode',
        'programCode',
        'programme_id',
        'nric',
        'title',
        'firstName',
        'lastName',
        'address',
        'city',
        'postalCode',
        'email',
        'contactNumber',
        'extraFields',
        'paymentStatus',
        'price',
        'discountAmount',
        'netAmount',
        'paymentOption',
        'paymentReferenceNo',
        'payment_gateway',
        'payment_transaction_id',
        'payment_metadata',
        'payment_verified_by',
        'payment_verified_at',
        'payment_initiated_at',
        'payment_completed_at',
        'regStatus',
        'confirmationCode',
        'groupRegistrationID',
        'promocode_id',
        'promotion_id',
        'emailStatus',
        'registrationType',
        'confirmedBy',
        'approvedBy',
        'approvedDate',
        'soft_delete'
    ];

    protected $casts = [
        'extraFields' => 'array',
        'payment_metadata' => 'array',
        'emailStatus' => 'boolean',
        'soft_delete' => 'boolean',
        'payment_verified_at' => 'datetime',
        'payment_initiated_at' => 'datetime',
        'payment_completed_at' => 'datetime',
    ];

    public function programme()
    {
        return $this->belongsTo(Programme::class);
    }

    public function promocode()
    {
        return $this->belongsTo(Promocode::class);
    }

    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }

    /**
     * Get all group members for this registrant
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function groupMembers()
    {
        if (!$this->groupRegistrationID) {
            return collect();
        }

        return Registrant::where('groupRegistrationID', $this->groupRegistrationID)
            ->where('id', '!=', $this->id)
            ->get();
    }

    /**
     * Check if this registrant is the main registrant of a group
     *
     * @return bool
     */
    public function isMainRegistrant()
    {
        return $this->groupRegistrationID && $this->registrationType !== 'group_member';
    }

    /**
     * Check if this registrant is a group member
     *
     * @return bool
     */
    public function isGroupMember()
    {
        return $this->registrationType === 'group_member';
    }
}
