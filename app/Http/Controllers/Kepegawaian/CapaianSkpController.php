<?php

namespace App\Http\Controllers\Kepegawaian;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Periode;
use App\Models\RCapaianSkp;
use App\Models\Tendik;
use Illuminate\Support\Facades\Crypt;

if(version_compare(PHP_VERSION, '7.2.0', '>=')) {
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
}
class CapaianSkpController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function index(){
        $skps = RCapaianSkp::join('periodes','periodes.id','r_capaian_skps.periode_id')
                                ->join('tendiks','tendiks.id','r_capaian_skps.tendik_id')
                                ->select('r_capaian_skps.id','nip','r_capaian_skps.status','nm_lengkap','nilai_skp','file_skp','nm_periode')
                                ->where('r_capaian_skps.status','1')
                                ->get();
        $verifieds = RCapaianSkp::join('periodes','periodes.id','r_capaian_skps.periode_id')
                                ->join('tendiks','tendiks.id','r_capaian_skps.tendik_id')
                                ->select('r_capaian_skps.id','nip','r_capaian_skps.status','nm_lengkap','nilai_skp','file_skp','nm_periode')
                                ->where('r_capaian_skps.status','!=','terkirim')
                                ->where('r_capaian_skps.status','!=','menunggu')
                                ->get();
        $skps_2 = RCapaianSkp::where('r_capaian_skps.status','!=','menunggu')
                                ->get();
        $jumlah = RCapaianSkp::where('r_capaian_skps.status','!=','menunggu')
                    ->groupBy('tendik_id')
                    ->get();
        $jumlah_tendik = Count(Tendik::all());
        $jumlah_skp = Count($jumlah);
        $periode_aktif = Periode::where('status','aktif')->select('id')->first();
        if (count($periode_aktif)<1) {
            $notification = array(
                'message' => 'Gagal, Harap Aktifkan Periode Remunerasi Terlebih Dahulu!',
                'alert-type' => 'error'
            );
            return \redirect()->back()->with($notification);
        }
        return view('kepegawaian/skp.index', compact('skps','verifieds','jumlah_tendik','jumlah_skp','periode_aktif'));
    }

    public function verifikasi(Request $request){
        $this->validate($request, [
            'verifikasi'    =>  'required',
        ]);
        RCapaianSkp::where('id',$request->id)->update([
            'status'    =>  $request->verifikasi,
        ]);

        return redirect()->route('kepegawaian.r_skp')->with(['success'    =>  'Data rubrik skp berhasil di verifikasi !!']);
    }

    public function generate(){
        $datas = RCapaianSkp::leftJoin('tendiks','tendiks.id','r_capaian_skps.tendik_id')
                        ->leftJoin('jabatans','jabatans.id','tendiks.jabatan_id')
                        ->select('r_capaian_skps.id','nip','nm_lengkap','remunerasi','potongan_skp','nilai_skp')
                        // ->where('r_capaian_skps.status','!=','gagal')
                        ->groupBy('r_capaian_skps.id')
                        ->get();
        $cek = RCapaianSkp::select('potongan_skp')->get();
        $periode_aktif = Periode::where('status','1')->select('id')->first();
        for ($i=0; $i < count($cek); $i++) { 
            if ($cek[$i]->potongan_skp != null) {
                $a = "sudah";
            }
            else{
                $a = "belum";
            }
        }
        return view('kepegawaian/skp.generate',compact('datas','periode_aktif','a'));
    }

    public function generateSubmit($periode_id){
        $periode_id = Crypt::decrypt($periode_id);
        $datas = RCapaianSkp::join('tendiks','tendiks.id','r_capaian_skps.tendik_id')
                                ->leftJoin('jabatans','jabatans.id','tendiks.jabatan_id')
                                ->select('r_capaian_skps.id','nilai_skp','remunerasi')
                                ->where('periode_id',$periode_id)
                                ->where('r_capaian_skps.status','2')
                                ->groupBy('r_capaian_skps.id')
                                ->get();
        for ($i=0; $i <count($datas) ; $i++) { 
            if ($datas[$i]->nilai_skp >=85) {
                RCapaianSkp::where('id',$datas[$i]->id)->update([
                    'potongan_skp'  =>  '0',
                ]);
            } elseif ($datas[$i]->nilai_skp >=80 && $datas[$i]->nilai_skp <83) {
                RCapaianSkp::where('id',$datas[$i]->id)->update([
                    'potongan_skp'  =>  '10',
                ]);
            } elseif ($datas[$i]->nilai_skp >=75 && $datas[$i]->nilai_skp <80) {
                RCapaianSkp::where('id',$datas[$i]->id)->update([
                    'potongan_skp'  =>  '20',
                ]);
            } elseif ($datas[$i]->nilai_skp >=70 && $datas[$i]->nilai_skp <75) {
                RCapaianSkp::where('id',$datas[$i]->id)->update([
                    'potongan_skp'  =>  '30',
                ]);
            } elseif ($datas[$i]->nilai_skp >=65 && $datas[$i]->nilai_skp <70) {
                RCapaianSkp::where('id',$datas[$i]->id)->update([
                    'potongan_skp'  =>  '40',
                ]);
            } elseif ($datas[$i]->nilai_skp >=1 && $datas[$i]->nilai_skp <65) {
                RCapaianSkp::where('id',$datas[$i]->id)->update([
                    'potongan_skp'  =>  '50',
                ]);
            } else {
                RCapaianSkp::where('id',$datas[$i]->id)->update([
                    'potongan_skp'  =>  '100',
                ]);
            }
        }
        return redirect()->route('kepegawaian.r_skp.generate')->with(['success'    =>  'Potongan rubrik skp berhasil di generate !!']);
    }

    public function generateNominal(){
        $datas = RCapaianSkp::rightJoin('tendiks','tendiks.id','r_capaian_skps.tendik_id')
                        ->leftJoin('jabatans','jabatans.id','tendiks.jabatan_id')
                        ->leftJoin('periodes','periodes.id','r_capaian_skps.periode_id')
                        ->select('r_capaian_skps.id','nip','nm_lengkap','remunerasi','jumlah_bulan','potongan_skp','nominal_potongan')
                        ->get();
        $cek = RCapaianSkp::select('nominal_potongan')->get();
        $periode_aktif = Periode::where('status','1')->select('id')->first();
        for ($i=0; $i < count($cek); $i++) { 
            if ($cek[$i]->nominal_potongan != null) {
                $a = "sudah";
            }
            else{
                $a = "belum";
            }
        }
        return view('kepegawaian/skp.generate_nominal',compact('datas','periode_aktif','a'));
    }
    
    public function generateNominalSubmit($periode_id){
        $periode_id = Crypt::decrypt($periode_id);
        $datas = RCapaianSkp::join('tendiks','tendiks.id','r_capaian_skps.tendik_id')
                                ->leftJoin('jabatans','jabatans.id','tendiks.jabatan_id')
                                ->select('r_capaian_skps.id','nilai_skp','potongan_skp','remunerasi')
                                ->where('periode_id',$periode_id)
                                ->get();
        for ($i=0; $i <count($datas) ; $i++) { 
            RCapaianSkp::where('id',$datas[$i]->id)->update([
                'nominal_potongan'  =>  ($datas[$i]->potongan_skp/100) * (($datas[$i]->remunerasi * 40)/100),
            ]);
        }
        return redirect()->route('kepegawaian.r_skp.generate_nominal')->with(['success'    =>  'Potongan Nominal rubrik skp berhasil di generate !!']);
    }
}
