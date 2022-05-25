<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;
    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'user_id',
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
    public function articles()
    {
        return $this->belongsTo(Articles::class);
    }
}
