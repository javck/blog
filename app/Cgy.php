<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cgy extends Model
{
    public function songs()
    {
        return $this->hasMany(\App\Song::class);
    }

    public function tags()
    {
        return $this->belongsToMany(\App\Tag::class)->withPivot('description')->withTimestamps();
    }

    public function scopeEnabled($query){
        return $query->where('enabled',true);
    }
}
