<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articles extends Model
{
    use HasFactory;
    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'image',
        'title',
        'content',
        'user_id',
        'categories_id',
    ];

    /**
     * Get the user for the article.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the categories for the article.
     */
    public function categories()
    {
        return $this->hasOne(Categories::class);
    }
}
