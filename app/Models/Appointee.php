<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Appointee extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'designation',
        'category',
        'bio',
        'sort_order',
        'status',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')->singleFile();
    }
}
