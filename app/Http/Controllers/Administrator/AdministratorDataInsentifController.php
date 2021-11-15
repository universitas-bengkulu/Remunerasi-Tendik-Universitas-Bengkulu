<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PenggunaRubrik;
use App\Models\PeriodeInsentif;
use App\Models\Rubrik;
use Illuminate\Support\Facades\Auth;

class AdministratorDataInsentifController extends Controller
{
    
    public function index(){
        $periode = PeriodeInsentif::where('status','aktif')->firstOrFail();
       
            $data_rubriks = PenggunaRubrik::join('rubriks','rubriks.id','pengguna_rubriks.rubrik_id')
            ->join('units','units.id','pengguna_rubriks.unit_id')
            ->select('rubriks.id as id_rubrik','nama_rubrik','nm_unit')
            ->where('units.id',Auth::user()->unit_id)
            ->get();
            return view('administrator.data_insentif.index',compact('data_rubriks','periode'));
    }
}
