<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Testimonial extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $table = 'testimonials';

    protected $fillable = [
        'name',
        'title',
        'description',
    ];

    const TESTIMONIAL_IMAGE = 'testimonial_image';
}
