<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\DetailIsianRubrik;
use App\Models\Periode;
use App\Models\PeriodeInsentif;
use App\Models\RAbsen;
use App\Models\RCapaianSkp;
use App\Models\RIntegritas;
use App\Models\Tendik;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AdministratorRekapitulasiController extends Controller
{
    public function index(){
        $periode_aktif = Periode::where('status','aktif')->first();
        if (is_null($periode_aktif)) {
            $notification = array(
                'message' => 'Gagal, periode remunerasi p1 dan p2 aktif tidak ditemukan!',
                'alert-type' => 'error'
            );
            return redirect()->route('administrator.dashboard')->with($notification);
        } else {
            $table = "rekapitulasi_".str_replace('-', '_', $periode_aktif->slug);
            $find = Schema::hasTable($table);
            if (empty($find)) {
                $notification = array(
                    'message' => 'Gagal, remunerasi p1 dan p2 pada periode ini belum digenerate oleh operator kepegawaian!',
                    'alert-type' => 'error'
                );
                return redirect()->route('administrator.dashboard')->with($notification);
            } else {
                $datas =  DB::table($table)->where('periode_id',$periode_aktif->id)
                                ->get();
                if (count($datas)<1) {
                    $notification = array(
                        'message' => 'Gagal, remunerasi p1 dan p2 pada periode ini belum digenerate oleh operator kepegawaian!',
                        'alert-type' => 'error'
                    );
                    return redirect()->route('administrator.dashboard')->with($notification);
                } else {
                    return view('administrator/rekapitulasi.index',compact('datas','periode_aktif'));
                }
            }
            
        }
    }

    public function rekapP3(){
        $periode_aktif = PeriodeInsentif::where('status','aktif')->first();
        
        if (is_null($periode_aktif)) {
            $notification = array(
                'message' => 'Gagal, periode remunerasi p3 aktif tidak ditemukan!',
                'alert-type' => 'error'
            );
            return redirect()->route('administrator.dashboard')->with($notification);
        } else {
            $laporans = DetailIsianRubrik::join('isian_rubriks','isian_rubriks.id','detail_isian_rubriks.isian_rubrik_id')
            ->join('tendiks','tendiks.id','detail_isian_rubriks.tendik_id')
            ->join('units','units.id','tendiks.unit_id')
            ->select(DB::raw('sum(rate_remun) as jumlah'), 'tendiks.nip','nm_tendik','nm_unit')
            ->groupBy('tendik_id')
            ->get();
            return view('administrator/rekapitulasi.p3',compact('laporans','periode_aktif'));
        }
    }
}
