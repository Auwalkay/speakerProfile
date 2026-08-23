<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ConstituencyProject extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'title', // Fallback title
        'name',  // Detailed name
        'slug',
        'category_id',
        'state_id',
        'lga_id',
        'community',
        'location',
        'latitude',
        'longitude',
        'cost',
        'budget',
        'funding_source',
        'start_date',
        'expected_completion',
        'completion_percentage',
        'beneficiaries_count',
        'status_project', // Project execution status
        'summary',
        'description',
        'status', // Workflow status
        'published_at',
        'created_by',
        'updated_by',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'start_date' => 'date',
        'expected_completion' => 'date',
        'published_at' => 'datetime',
        'cost' => 'decimal:2',
        'budget' => 'decimal:2',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('before')->singleFile();
        $this->addMediaCollection('during')->singleFile();
        $this->addMediaCollection('after')->singleFile();
        $this->addMediaCollection('gallery');
        $this->addMediaCollection('documents');
        $this->addMediaCollection('videos');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProjectCategory::class, 'category_id');
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
