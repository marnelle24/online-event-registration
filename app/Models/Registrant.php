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
        'regStatus',
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
        'emailStatus' => 'boolean',
        'soft_delete' => 'boolean'
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
}
