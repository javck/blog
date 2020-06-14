<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;


class Song extends Model
{
    use Translatable;

    protected $guarded = [];
    protected $dates = ['sell_at'];
    protected $touches = ['cgy'];
    //public $incrementing = false;
    //protected $keyType = 'string';

    protected $casts = [
        "json" => 'array',
        "created_at" => 'datetime:Y-m-d'
    ];




    protected $translatable = ['name'];

    public function cgy(){
        return $this->belongsTo(\App\Cgy::class);
    }

    public function getNameAttribute($value){
        return strtoupper($value);
    }

    public function setNameAttribute($value){
        $this->attributes['name'] = 'New Name ' . $value;
    }

    public function getNewNameAttribute(){
        return 'My ' . strtoupper($this->name) ;
    }
}
