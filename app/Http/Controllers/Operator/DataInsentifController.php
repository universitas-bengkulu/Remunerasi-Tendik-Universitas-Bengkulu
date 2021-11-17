<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\PenggunaRubrik;
use App\Models\PeriodeInsentif;
use App\Models\Rubrik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DataInsentifController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','isOperator']);
    }

    public function index(){
        $periode = PeriodeInsentif::where('status','aktif')->first();
        if (empty($periode)) {
            return redirect()->back();
        } else {
            $data_rubriks = PenggunaRubrik::join('rubriks','rubriks.id','pengguna_rubriks.rubrik_id')
            ->join('units','units.id','pengguna_rubriks.unit_id')
            ->select('rubriks.id as id_rubrik','nama_rubrik','nm_unit')
            ->where('units.id',Auth::user()->unit_id)
            ->get();
            return view('operator.data_insentif.index',compact('data_rubriks','periode'));
        }
    }
}
