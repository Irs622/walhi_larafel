<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'body',
        'tags',
        'status',
        'image_url',
        'publish_date',
        'category',
    ];

    protected $casts = [
        'publish_date' => 'date:Y-m-d',
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
