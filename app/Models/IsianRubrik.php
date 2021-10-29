<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IsianRubrik extends Model
{
    use HasFactory;
    protected $fillable = [
        'rubrik_id','nomor_sk','periode_id','isian_1','isian_2','isian_3','isian_4','isian_5','isian_6','isian_7','isian_8','isian_9','isian_10','file_upload','status_validasi'
    ];

    protected $dates = ['isian_9,isian_10'];

    public function rubrik()
    {
        return $this->belongsTo('App\Models\Rubrik');
    }

    public function periode()
    {
        return $this->belongsTo('App\Models\Periode');
    }

    public function detailisianrubrik(){
        return $this->hasMany('App\Models\DetailIsianRubrik');
    }
}
