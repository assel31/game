<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sheep extends Model
{
    protected $fillable = [
        'name', 'is_dead', 'sheepfold_id',
    ];

    public function sheepfold()
    {
        return $this->belongsTo(Sheepfold::class);
    }

    public function histories()
    {
        return $this->hasMany(History::class);
    }
}
