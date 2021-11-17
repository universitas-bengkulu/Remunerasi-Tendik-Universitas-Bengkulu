<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\DetailIsianRubrik;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(){
        $laporans = DetailIsianRubrik::join('isian_rubriks','isian_rubriks.id','detail_isian_rubriks.isian_rubrik_id')
                                    ->join('tendiks','tendiks.id','detail_isian_rubriks.tendik_id')
                                    ->join('units','units.id','tendiks.unit_id')
                                    ->select(DB::raw('sum(rate_remun) as jumlah'), 'tendiks.nip','nm_tendik','nm_unit')
                                    ->where('units.id',Auth::user()->unit_id)
                                    ->groupBy('tendik_id')
                                    ->get();
        $unit = Unit::select('nm_unit')->where('id',Auth::user()->unit_id)->first();
        return view('operator/laporan.index',compact('laporans','unit'));
    }
}
