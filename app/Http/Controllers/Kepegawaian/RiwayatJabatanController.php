<?php

namespace App\Http\Controllers\Kepegawaian;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\RiwayatJabatan;
use App\Periode;
use App\Tendik;
if(version_compare(PHP_VERSION, '7.2.0', '>=')) {
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
}
class RiwayatJabatanController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','isKepegawaian']);
    }

    public function index(){
        $riwayats = RiwayatJabatan::join('periodes','periodes.id','riwayat_jabatans.periode_id')
                            ->join('tendiks','tendiks.id','riwayat_jabatans.tendik_id')
                            ->leftJoin('jabatans','jabatans.id','tendiks.jabatan_id')
                            ->select('riwayat_jabatans.id','nm_lengkap','riwayat_jabatans.pangkat','riwayat_jabatans.golongan','nm_periode','jabatans.nm_jabatan'
                                        )
                            ->where('periodes.status','1')
                            ->get();
        $periode_aktif = Periode::select('id','nm_periode')->where('status','1')->first();
        if (count($periode_aktif) < 1) {
            return redirect()->back()->with(['error'  =>  "Tidak Ada Periode Aktif, Silahkan Aktifkan Periode Terlebih Dahulu Lalu Coba Lagi !!"]);
        }
        return view('kepegawaian
/riwayat_jabatan.index',compact('riwayats','periode_aktif'));
    }

    public function generateRiwayatJabatan(){
        $periode_aktif = Periode::select('id')->where('status','1')->first();
        $jabatans = Tendik::select('tendiks.id as tendik_id','golongan','pangkat','jabatan_id')
                            ->get();
        $array = [];
        for ($i=0; $i <count($jabatans) ; $i++) { 
            $array[]    =   [
                'tendik_id' =>  $jabatans[$i]->tendik_id,
                'jabatan_id' =>  $jabatans[$i]->jabatan_id,
                'periode_id' =>  $periode_aktif->id,
                'pangkat' =>  $jabatans[$i]->pangkat,
                'golongan' =>  $jabatans[$i]->golongan,
            ];
        }
        RiwayatJabatan::insert($array);

        return redirect()->route('kepegawaian.r_jabatan')->with(['success'    =>  'Riwayat Jabatan Berhasil Digenerate !!']);
    }

}
