<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rubrik extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_rubrik',
        'nama_kolom_1',
        'nama_kolom_2',
        'nama_kolom_3',
        'nama_kolom_4',
        'nama_kolom_5',
        'nama_kolom_6',
        'nama_kolom_7',
        'nama_kolom_8',
        'nama_kolom_9',
        'nama_kolom_10',
      
    ];
    public function isianrubrik(){
        return $this->hasMany('App\Models\IsianRubrik');
    }
}
