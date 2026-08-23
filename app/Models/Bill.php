<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Bill extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'title',
        'slug',
        'bill_number',
        'category',
        'sponsor',
        'status_legislative',
        'summary',
        'description',
        'document_path',
        'date_introduced',
        'date_passed',
        'assent_status',
        'status',
        'featured',
        'published_at',
        'created_by',
        'updated_by',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'date_introduced' => 'date',
        'date_passed' => 'date',
        'published_at' => 'datetime',
        'featured' => 'boolean',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('documents')
            ->acceptsMimeTypes(['application/pdf'])
            ->singleFile();
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
