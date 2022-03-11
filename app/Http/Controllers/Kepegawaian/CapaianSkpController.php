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
    public function __construct()
    {
        $this->middleware(['auth','isKepegawaian']);
    }

    public function index($periode_id){
        $skps = RCapaianSkp::join('periodes','periodes.id','r_capaian_skps.periode_id')
                                ->join('tendiks','tendiks.id','r_capaian_skps.tendik_id')
                                ->select('r_capaian_skps.id','nip','r_capaian_skps.status','nm_lengkap','nilai_skp','path','nm_periode')
                                ->where('r_capaian_skps.status',NULL)
                                ->where('periode_id',$periode_id)
                                ->orWhere('r_capaian_skps.status','menunggu')
                                ->orWhere('r_capaian_skps.status','terkirim')
                                ->get();
        $verifieds = RCapaianSkp::join('periodes','periodes.id','r_capaian_skps.periode_id')
                                ->join('tendiks','tendiks.id','r_capaian_skps.tendik_id')
                                ->select('r_capaian_skps.id','nip','r_capaian_skps.status','nm_lengkap','nilai_skp','path','nm_periode')
                                ->where('r_capaian_skps.status','berhasil')
                                ->where('periode_id',$periode_id)
                                ->get();
        $tendiks =RCapaianSkp::where('periode_id',$periode_id)->get();
        $jumlah = RCapaianSkp::where('r_capaian_skps.status','!=','menunggu')
                    ->where('periode_id',$periode_id)
                    ->groupBy('tendik_id')
                    ->get();
        $jumlah_tendik = Count(Tendik::all());
        $jumlah_skp = Count($jumlah);
        $periode_aktif = Periode::where('status','aktif')->select('id','slug')->first();
        if (count((array)$periode_aktif)<1) {
            $notification = array(
                'message' => 'Gagal, Harap Aktifkan Periode Remunerasi Terlebih Dahulu!',
                'alert-type' => 'error'
            );
            return \redirect()->back()->with($notification);
        }
        return view('kepegawaian/skp.index', compact('skps','verifieds','tendiks','jumlah_tendik','jumlah_skp','periode_id','periode_aktif'));
    }

    public function updateNilai($id,$periode_id, Request $request){
        RCapaianSkp::where('id',$id)->where('periode_id',$periode_id)->update([
            'nilai_skp' =>  $request->nilai_skp,
        ]);
        $notification = array(
            'message' => 'Berhasil, nilai berhasil diubah!',
            'alert-type' => 'success'
        );
        return redirect()->route('kepegawaian.r_skp',[$periode_id])->with($notification);
    }

    public function generateTendik($periode_id){
        $periode = Periode::select('id')->where('id',$periode_id)->first();
        if (count((array)$periode)>0) {
            $tendiks = Tendik::select('id','nip','nm_lengkap')->get();
            $array = [];
            for ($i=0; $i <count($tendiks) ; $i++) { 
                $array[]    =   [
                    'periode_id'            =>  $periode->id,
                    'tendik_id'             =>  $tendiks[$i]->id,
                    'nilai_skp'  =>  0,
                ];
            }

            RCapaianSkp::insert($array);
            $notification = array(
                'message' => 'Berhasil, data tendik berhasil digenerate!',
                'alert-type' => 'success'
            );
            return redirect()->route('kepegawaian.r_skp',[$periode_id])->with($notification);
        }
        else{
            $notification2 = array(
                'message' => 'Gagal, silahkan aktifkan periode saat ini terlebih dahulu!',
                'alert-type' => 'error'
            );
            return redirect()->route('kepegawaian.r_integritas',[$periode_id])->with(['error'  =>  'Silahkan Aktifkan Periode Saat Ini Terlebih Dahulu !!']);
        }
    }

    public function verifikasi(Request $request,$periode_id){
        $this->validate($request, [
            'verifikasi'    =>  'required',
        ]);
        if ($request->verifikasi == "diterima") {
            RCapaianSkp::where('id',$request->id)->update([
                'status'    =>  'berhasil',
            ]);
        } else{
            RCapaianSkp::where('id',$request->id)->update([
                'path'  =>  NULL,
                'nilai_skp' =>  0,
                'status'    =>  NULL,
            ]); 
        }

        return redirect()->route('kepegawaian.r_skp',[$periode_id])->with(['success'    =>  'Data rubrik skp berhasil di verifikasi !!']);
    }

    public function generate($periode_id){
        $datas = RCapaianSkp::leftJoin('tendiks','tendiks.id','r_capaian_skps.tendik_id')
                        ->leftJoin('jabatans','jabatans.id','tendiks.jabatan_id')
                        ->select('r_capaian_skps.id','nip','nm_lengkap','remunerasi','potongan_skp','nilai_skp')
                        // ->where('r_capaian_skps.status','!=','gagal')
                        ->groupBy('r_capaian_skps.id')
                        ->where('periode_id',$periode_id)
                        ->get();
        $cek = RCapaianSkp::select('potongan_skp')->where('periode_id',$periode_id)->first();
        $periode_aktif = Periode::where('status','1')->select('id')->first();
        if ($cek->potongan_skp != null) {
            $a = "sudah";
        }
        else{
            $a = "belum";
        }
        return view('kepegawaian/skp.generate',compact('datas','periode_aktif','periode_id','a'));
    }

    public function generateSubmit($periode_id){
        $datas = RCapaianSkp::join('tendiks','tendiks.id','r_capaian_skps.tendik_id')
                                ->leftJoin('jabatans','jabatans.id','tendiks.jabatan_id')
                                ->select('r_capaian_skps.id','nilai_skp','remunerasi')
                                ->where('periode_id',$periode_id)
                                // ->where('r_capaian_skps.status','berhasil')
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
            } elseif($datas[$i]->nilai_skp == 0) {
                RCapaianSkp::where('id',$datas[$i]->id)->update([
                    'potongan_skp'  =>  '100',
                ]);
            }
        }
        $notification = array(
            'message' => 'Berhasil, persentase potongan skp berhasil digenerate!',
            'alert-type' => 'success'
        );
        return redirect()->route('kepegawaian.r_skp.generate',[$periode_id])->with($notification);
    }

    public function generateNominal($periode_id){
        $datas = RCapaianSkp::rightJoin('tendiks','tendiks.id','r_capaian_skps.tendik_id')
                        ->leftJoin('jabatans','jabatans.id','tendiks.jabatan_id')
                        ->leftJoin('periodes','periodes.id','r_capaian_skps.periode_id')
                        ->select('r_capaian_skps.id','nip','nm_lengkap','remunerasi','jumlah_bulan','potongan_skp','nominal_potongan')
                        ->where('periode_id',$periode_id)
                        ->get();
        $cek = RCapaianSkp::select('nominal_potongan')->where('periode_id',$periode_id)->first();
        if ($cek->nominal_potongan != null) {
            $a = "sudah";
        }
        else{
            $a = "belum";
        }
        return view('kepegawaian/skp.generate_nominal',compact('datas','periode_aktif','periode_id','a'));
    }
    
    public function generateNominalSubmit($periode_id){
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
        $notification = array(
            'message' => 'Berhasil, potongan nominal rubrik skp berhasil digenerate!',
            'alert-type' => 'success'
        );
        return redirect()->route('kepegawaian.r_skp.generate_nominal',[$periode_id])->with($notification);
    }
}
