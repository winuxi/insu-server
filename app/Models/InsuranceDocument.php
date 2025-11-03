<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class InsuranceDocument extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $table = 'insurance_documents';

    protected $fillable = [
        'document_type_id',
        'insurance_id',
        'status',
    ];

    const UNVERIFIED = 0;

    const VERIFIED = 1;

    const STATUS = [
        self::UNVERIFIED => 'Unverified',
        self::VERIFIED => 'Verified',
    ];

    const FILE = 'insurance_document';

    public function documentType()
    {
        return $this->belongsTo(DocumentType::class, 'document_type_id');
    }

    public function insurance()
    {
        return $this->belongsTo(Insurance::class, 'insurance_id');
    }
}
