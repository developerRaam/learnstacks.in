<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NoteCategory extends Model
{
    protected $guarded = [];

    public function notes()
    {
        return $this->hasMany(Note::class, 'category_id');
    }
}
