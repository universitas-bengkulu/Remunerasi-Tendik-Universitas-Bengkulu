<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailIsianRubrik extends Model
{
    use HasFactory;
    protected $fillable =[
        'isian_rubrik_id','tendik_id','keterangan','rate_remun','nm_tendik'
    ];

    public function isianrubrik()
    {
        return $this->belongsTo('App\Models\IsianRubrik');
    }
}
