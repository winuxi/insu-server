<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ClaimDocument extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $table = 'claim_documents';

    protected $fillable = [
        'document_type_id',
        'claim_id',
        'status',
    ];

    const UNVERIFIED = 0;

    const VERIFIED = 1;

    const STATUS = [
        self::UNVERIFIED => 'Unverified',
        self::VERIFIED => 'Verified',
    ];

    const FILE = 'claim_document';

    public function documentType()
    {
        return $this->belongsTo(DocumentType::class, 'document_type_id');
    }

    public function claim()
    {
        return $this->belongsTo(Claim::class, 'claim_id');
    }
}
