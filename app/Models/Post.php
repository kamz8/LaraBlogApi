<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;
    protected $fillable = ['category_id', 'user_id', 'title', 'content', 'scheduled_at', 'thumbnail'];

    protected $dates = ['scheduled_at'];

    // Specify property types
    protected $casts = [
        'category_id' => 'integer',
        'user_id' => 'integer',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getThumbnailUrlAttribute(): string
    {
        return Storage::url($this->thumbnail);
    }

    // Automatically generate slug when title is set
    public function setTitleAttribute(string $value): void
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value); // Generate slug from title
    }
}
