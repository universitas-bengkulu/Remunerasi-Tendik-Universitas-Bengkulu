<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\DetailIsianRubrik;
use App\Models\IsianRubrik;
use App\Models\PenggunaRubrik;
use App\Models\Periode;
use App\Models\PeriodeInsentif;
use App\Models\Rubrik;
use App\Models\Tendik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardOperatorController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','isOperator']);
    }

    public function dashboard(){
        $jumlah_rubrik = PenggunaRubrik::select(DB::raw('count(id) as jumlah'))->where('unit_id',Auth::user()->unit_id)->first();
        $periode_aktif = PeriodeInsentif::select('masa_kinerja')->where('status','aktif')->first();
        $jumlah_tendik = Tendik::select(DB::raw('count(id) as jumlah'))->where('unit_id',Auth::user()->unit_id)->first();
        $total_remun    = DetailIsianRubrik::join('tendiks','tendiks.id','detail_isian_rubriks.tendik_id')
                                            ->select(DB::raw('sum(rate_remun) as total_remun'))
                                            ->where('unit_id',Auth::user()->unit_id)
                                            ->first();
        return view('operator/dashboard',compact('jumlah_rubrik','periode_aktif','jumlah_tendik','total_remun'));
    }
}
