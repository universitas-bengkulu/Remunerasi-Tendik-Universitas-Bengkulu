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
        $laporans = DetailIsianRubrik::select(DB::raw('sum(rate_remun) as jumlah'), 'nip','nama_dosen','prodi')
                                    ->groupBy('nip')
                                    ->get();
        $prodis = DetailIsianRubrik::select('prodi')->groupBy('prodi')->get();
        $unit = Unit::select('nm_unit')->where('id',Auth::user()->unit_id)->first();
        return view('operator/laporan.index',compact('laporans','unit','prodis'));
    }
}
