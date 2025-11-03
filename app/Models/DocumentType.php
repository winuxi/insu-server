<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use App\Traits\PopulateTenantID;
use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{
    use BelongsToTenant, PopulateTenantID;

    protected $table = 'document_types';

    protected $fillable = [
        'name',
        'tenant_id',
    ];

    public function policies()
    {
        return $this->hasMany(Policy::class, 'policy_document_type_id');
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'document_type_id');
    }
}
