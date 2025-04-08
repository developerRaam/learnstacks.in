<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $guarded = [];

    public function noteCategory()
    {
        return $this->belongsTo(NoteCategory::class, 'category_id');
    }
}
