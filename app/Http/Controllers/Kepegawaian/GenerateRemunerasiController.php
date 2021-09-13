<?php

namespace App\Http\Controllers\Kepegawaian;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Periode;
use Illuminate\Support\Facades\Crypt;

// use Illuminate\Support\Facades\Crypt;

if(version_compare(PHP_VERSION, '7.2.0', '>=')) {
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
}
class GenerateRemunerasiController extends Controller
{
    public function index(){
        $periode_aktif = Periode::where('status','1')->select('id')->first();
        $datas = Remunerasi::select('nm_lengkap','nip','pangkat','golongan','kelas_jabatan','nm_jabatan',
                                    'remunerasi_per_bulan','jumlah_bulan','no_rekening')
                            ->where('periode_id',$periode_aktif->id)        
                            ->get();
        return view('admin/remunerasi.index', compact('datas','periode_aktif'));
    }

    public function generateDataTendik($periode_id){
        $datas = Tendik::leftJoin('jabatans','jabatans.id','tendiks.jabatan_id')
                        ->select('tendiks.id','nm_lengkap','nip','pangkat','golongan','no_rekening','kelas_jabatan','jabatans.nm_jabatan','remunerasi')
                        ->get();
        $jumlah_bulan = Periode::where('id',$periode_id)->select('jumlah_bulan')->first();
        $array = [];
        for ($i=0; $i <count($datas) ; $i++) { 
            $array[]    =   [
                'periode_id'    =>  $periode_id,
                'tendik_id'    =>  $datas[$i]->id,
                'nm_lengkap'    =>  $datas[$i]->nm_lengkap,
                'nip'    =>  $datas[$i]->nip,
                'pangkat'    =>  $datas[$i]->pangkat,
                'golongan'    =>  $datas[$i]->golongan,
                'kelas_jabatan'    =>  $datas[$i]->kelas_jabatan,
                'nm_jabatan'    =>  $datas[$i]->nm_jabatan,
                'remunerasi_per_bulan'    =>  $datas[$i]->remunerasi,
                'no_rekening'    =>  $datas[$i]->no_rekening,
                'jumlah_bulan'    =>  $jumlah_bulan->jumlah_bulan,
            ];
        }
        Remunerasi::insert($array);
        return redirect()->route('kepegawaian.remunerasi')->with(['success'   =>  'Data Tenaga Kependidikan Berhasil Digenerate !!']);
    }

    public function totalRemun($periode_id){
        $periode_aktif = Periode::where('status','1')->select('id')->first();
        $datas = Remunerasi::select('nm_lengkap','remunerasi_per_bulan','remunerasi_30','remunerasi_70','jumlah_bulan',
                                                        'jumlah_remun_30','jumlah_remun_70','total_remun')
                            ->where('periode_id',$periode_id)
                            ->get();
        for ($i=0; $i < count($datas); $i++) { 
            if ($datas[$i]->total_remun != null) {
                $a = "sudah";
            }
            else{
                $a = "belum";
            }
        }
        return view('admin/remunerasi.total_remun', compact('datas','periode_aktif','a'));
    }

    public function generateTotalRemun($periode_id){
        $datas = Remunerasi::select('remunerasis.id','tendik_id')
                        ->where('periode_id',$periode_id)
                        ->get();
        // $array = [];
        for ($i=0; $i <count($datas) ; $i++) {
            $data = RIntegritas::where('tendik_id',$datas[$i]->tendik_id)->where('periode_id',$periode_id)->first();
            Remunerasi::where('id',$datas[$i]->id)->update([
                'remunerasi_30' =>  $data->remun_30,
                'remunerasi_70' =>  $data->remun_70,
                'jumlah_remun_30' =>  $data->total_remun_30,
                'jumlah_remun_70' =>  $data->total_remun_70,
                'total_remun' =>  $data->total_remun,
            ]);
            
        }
        return redirect()->route('kepegawaian.remunerasi.total_remun',[$periode_id])->with(['success'   =>  'Data Remunerasi Berhasil Digenerate !!']);
    }

    public function integritas($periode_id){
        $periode_id = Crypt::decrypt($periode_id);
        $periode_aktif = Periode::where('status','1')->select('id')->first();
        $datas = Remunerasi::select('nm_lengkap','potongan_pph','laporan_lhkpn_lhkasn','sanksi_disiplin',
                                    'nominal_lhkpn_lhkasn','nominal_sanksi_disiplin','potongan_integritas_satu_bulan','total_integritas')
                            ->where('periode_id',$periode_id)
                            ->get();
        for ($i=0; $i < count($datas); $i++) { 
            if ($datas[$i]->total_integritas != null) {
                $a = "sudah";
            }
            else{
                $a = "belum";
            }
        }
        return view('admin/remunerasi.integritas', compact('datas','periode_aktif','a'));
    }

    public function generateIntegritas($periode_id){
        $periode_id = Crypt::decrypt($periode_id);
        $datas = Remunerasi::select('remunerasis.id','tendik_id')
                        ->where('periode_id',$periode_id)
                        ->get();
        // $array = [];
        for ($i=0; $i <count($datas) ; $i++) {
            $data = RIntegritas::where('tendik_id',$datas[$i]->tendik_id)->where('periode_id',$periode_id)->first();
            Remunerasi::where('id',$datas[$i]->id)->update([
                'potongan_pph' =>  $data->pajak_pph,
                'laporan_lhkpn_lhkasn' =>  $data->laporan_lhkpn_lhkasn,
                'sanksi_disiplin' =>  $data->sanksi_disiplin,
                'nominal_lhkpn_lhkasn' =>  $data->potongan_lhkpn_lhkasn,
                'nominal_sanksi_disiplin' =>  $data->potongan_sanksi_disiplin,
                'potongan_integritas_satu_bulan' =>  $data->integritas_satu_bulan,
                'total_integritas' =>  $data->total_integritas,
            ]);
            
        }
        return redirect()->route('kepegawaian.remunerasi.integritas',[$periode_id])->with(['success'   =>  'Rubrik Integritas Berhasil Digenerate !!']);
    }

    public function skp($periode_id){
        $periode_id = Crypt::decrypt($periode_id);
        $periode_aktif = Periode::where('status','1')->select('id')->first();
        $datas = Remunerasi::select('nm_lengkap','nilai_skp','potongan_skp',
                                    'nominal_potongan')
                            ->where('periode_id',$periode_id)
                            ->get();
        for ($i=0; $i < count($datas); $i++) { 
            if (empty($datas[$i]->nominal_potongan)) {
                $a = "sudah";
            }
            else{
                $a = "belum";
            }
        }
        return view('admin/remunerasi.skp', compact('datas','periode_aktif','a'));
    }

    public function generateSkp($periode_id){
        $periode_id = Crypt::decrypt($periode_id);
        $datas = Remunerasi::select('remunerasis.id','tendik_id')
                        ->where('periode_id',$periode_id)
                        ->get();
        $jumlah_bulan = Periode::where('id',$periode_id)->select('jumlah_bulan')->first();
        // $array = [];
        for ($i=0; $i <count($datas) ; $i++) {
            $data = RCapaianSkp::where('tendik_id',$datas[$i]->tendik_id)->where('periode_id',$periode_id)->first();
            Remunerasi::where('id',$datas[$i]->id)->update([
                'nilai_skp' =>  $data->nilai_skp,
                'potongan_skp' =>  $data->potongan_skp,
                'nominal_potongan' =>  $data->nominal_potongan,
                'total_skp' =>  $data->nominal_potongan * $jumlah_bulan->jumlah_bulan,
            ]);
        }

        return redirect()->route('kepegawaian.remunerasi.skp',[$periode_id])->with(['success'   =>  'Rubrik SKP Berhasil Digenerate !!']);
    }

    public function persentaseAbsen($periode_id){
        $periode_id = Crypt::decrypt($periode_id);
        $periode_aktif = Periode::where('status','1')->select('id')->first();
        $datas = Remunerasi::select('persen_absen_bulan_satu','persen_absen_bulan_dua','persen_absen_bulan_tiga',
                                    'nominal_absen_bulan_satu','nominal_absen_bulan_dua','nominal_absen_bulan_tiga','total_absensi')
                            ->where('periode_id',$periode_id)
                            ->get();
        for ($i=0; $i < count($datas); $i++) { 
            if ($datas[$i]->total_absensi != null) {
                $a = "sudah";
            }
            else{
                $a = "belum";
            }
        }
        return view('admin/remunerasi.persentase_absen',[$periode_aktif], compact('datas','periode_aktif','a'));
    }
}
