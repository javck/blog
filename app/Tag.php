<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public function cgies()
    {
        return $this->belongsToMany(\App\Cgy::class)->withPivot('description')->withTimestamps();
    }
}
