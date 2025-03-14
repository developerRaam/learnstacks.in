<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $guarded = [];

    public function noteCategory()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
