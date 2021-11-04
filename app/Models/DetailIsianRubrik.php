<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailIsianRubrik extends Model
{
    use HasFactory;
    protected $fillable =[
        'isian_rubrik_id','nip','keterangan','rate_remun','nama_dosen','prodi'
    ];

    public function isianrubrik()
    {
        return $this->belongsTo('App\Models\IsianRubrik');
    }
}
