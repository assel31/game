<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sheepfold extends Model
{
    protected $fillable = [
        'name',
    ];

    public function sheeps()
    {
        return $this->hasMany(Sheep::class)->where('is_dead', 0);
    }

    public function histories()
    {
        return $this->hasMany(History::class);
    }
}
