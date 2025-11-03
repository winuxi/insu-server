<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Policy extends Model
{
    protected $table = 'policies';

    const FAMILY = 1;

    const GROUP = 2;

    const INDIVIDUAL = 3;

    const COVERAGE_TYPES = [
        self::FAMILY => 'Family',
        self::GROUP => 'Group',
        self::INDIVIDUAL => 'Individual',
    ];

    const AUTO = 1;

    const BUSINESS = 2;

    const HOME_OWNERS = 3;

    const LIABILITY_RISKS = [
        self::AUTO => 'Auto',
        self::BUSINESS => 'Business',
        self::HOME_OWNERS => 'Home Owners',
    ];

    protected $fillable = [
        'title',
        'policy_type_id',
        'policy_sub_type_id',
        'coverage_type',
        'total_insured_person',
        'liability_risk',
        'sum_assured',
        'user_id',
        'policy_document_type_id',
        'claim_document_type_id',
        'tax_id',
        'description',
        'term',
        'tenant_id',
    ];

    public function policyType()
    {
        return $this->belongsTo(PolicyType::class, 'policy_type_id');
    }

    public function policySubType()
    {
        return $this->belongsTo(PolicySubType::class, 'policy_sub_type_id');
    }

    public function documentType()
    {
        return $this->belongsTo(DocumentType::class, 'policy_document_type_id');
    }

    public function tax()
    {
        return $this->belongsTo(Tax::class, 'tax_id');
    }

    public function policyPricings()
    {
        return $this->hasMany(PolicyPricing::class, 'policy_id');
    }

    public function insurances()
    {
        return $this->hasMany(Insurance::class, 'policy_id');
    }
}
