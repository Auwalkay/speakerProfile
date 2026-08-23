<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class HeroSlide extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'title',
        'subtitle',
        'badge',
        'link_text',
        'link_url',
        'sort_order',
        'status',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('slide_image')->singleFile();
        $this->addMediaCollection('side_image')->singleFile();
    }
}
