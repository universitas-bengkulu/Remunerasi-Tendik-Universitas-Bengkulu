<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\DetailIsianRubrik;
use App\Models\IsianRubrik;
use App\Models\Periode;
use App\Models\PeriodeInsentif;
use App\Models\Rubrik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardOperatorController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','isOperator']);
    }

    public function dashboard(){
        $jumlah_isian = IsianRubrik::select(DB::raw('count(id)'))->where('status_validasi','diterima')->firstOrFail();
        $jumlah_rubrik = Rubrik::select(DB::raw('count(id) as total_isian'))->first();
        $periode_aktif = PeriodeInsentif::select('masa_kinerja')->where('status','aktif')->firstOrFail();
        $total_remun    = DetailIsianRubrik::select(DB::raw('sum(rate_remun) as total_remun'))->firstOrFail();
        
        return view('operator/dashboard');
    }
}
