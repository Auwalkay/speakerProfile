<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class MediaItem extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $table = 'media_items';

    protected $fillable = [
        'album_id',
        'title',
        'caption',
        'file_path',
        'type', // image, video, audio
        'date',
        'status',
        'published_at',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'date' => 'date',
        'published_at' => 'datetime',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('media')->singleFile();
    }

    public function album(): BelongsTo
    {
        return $this->belongsTo(MediaAlbum::class, 'album_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
