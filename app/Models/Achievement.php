<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Achievement extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'title',
        'slug',
        'summary',
        'content',
        'category_id',
        'achievement_date',
        'state_id',
        'lga_id',
        'location',
        'impact_summary',
        'status',
        'featured',
        'published_at',
        'created_by',
        'updated_by',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'achievement_date' => 'date',
        'published_at' => 'datetime',
        'featured' => 'boolean',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('featured_image')
            ->singleFile();

        $this->addMediaCollection('gallery');

        $this->addMediaCollection('documents');

        $this->addMediaCollection('videos');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(AchievementCategory::class, 'category_id');
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function lga(): BelongsTo
    {
        return $this->belongsTo(Lga::class);
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
