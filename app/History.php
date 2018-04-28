<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $fillable = [
        'sheep_id', 'sheepfold_id', 'day', 'action',
    ];

    public function sheep()
    {
        return $this->belongsTo(Sheep::class);
    }

    public function sheepfold()
    {
        return $this->belongsTo(Sheepfold::class);
    }

}
