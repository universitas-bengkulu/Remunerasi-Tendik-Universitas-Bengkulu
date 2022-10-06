<?php

namespace App\Http\Controllers\Kepegawaian;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Periode;
use App\Models\RAbsen;
use App\Models\Tendik;

if(version_compare(PHP_VERSION, '7.2.0', '>=')) {
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
}
class AbsensiController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','isKepegawaian']);
    }

    public function index(Request $request,$periode_id){
        $periode_aktif = Periode::select('id','jumlah_bulan','nm_periode')->where('id',$periode_id)->first();
        $filter = $request->query('filter');
        if (!empty($filter)){
            $absensis = RAbsen::join('tendiks','tendiks.id','r_absens.tendik_id')
                            ->select('r_absens.id as id','periode_id','nip','nm_lengkap','potongan_bulan_1','potongan_bulan_2','potongan_bulan_3','potongan_bulan_4','potongan_bulan_5','potongan_bulan_6')
                                ->where('tendiks.nm_lengkap','like','%'.$filter.'%')
                                ->orWhere('nip','like','%'.$filter.'%')
                                ->orderBy('tendiks.id','desc')
                                ->paginate(15);
        } else
        {
            $absensis = RAbsen::join('tendiks','tendiks.id','r_absens.tendik_id')
                            ->select('r_absens.id as id','periode_id','nip','nm_lengkap','potongan_bulan_1','potongan_bulan_2','potongan_bulan_3','potongan_bulan_4','potongan_bulan_5','potongan_bulan_6')
                            ->where('periode_id',$periode_id)
                            ->paginate(15);
        }
        if (count((array)$periode_aktif)<1) {
            $notification = array(
                'message' => 'Gagal, Harap Aktifkan Periode Remunerasi Terlebih Dahulu!',
                'alert-type' => 'error'
            );
            return \redirect()->route('kepegawaian.periode')->with($notification);
        }

        return view('kepegawaian/absensi.index',compact('absensis','periode_aktif'));
    }

    public function generateTendik($periode_id){
        $periode = Periode::select('id','jumlah_bulan')->where('id',$periode_id)->first();
        if (count((array)$periode)>0) {
            $tendiks = Tendik::select('id','nip','nm_lengkap')->get();
            $array = [];
            for ($i=0; $i <count($tendiks) ; $i++) {
                if ($periode->jumlah_bulan == "3") {
                    $array[]    =   [
                        'periode_id'        =>  $periode->id,
                        'tendik_id'         =>  $tendiks[$i]->id,
                        'potongan_bulan_1'  =>  '0',
                        'potongan_bulan_2'  =>  '0',
                        'potongan_bulan_3'  =>  '0',
                    ];
                } elseif ($periode->jumlah_bulan == "2") {
                    $array[]    =   [
                        'periode_id'        =>  $periode->id,
                        'tendik_id'         =>  $tendiks[$i]->id,
                        'potongan_bulan_1'  =>  '0',
                        'potongan_bulan_2'  =>  '0',
                    ];
                }elseif ($periode->jumlah_bulan == "4") {
                    $array[]    =   [
                        'periode_id'        =>  $periode->id,
                        'tendik_id'         =>  $tendiks[$i]->id,
                        'potongan_bulan_1'  =>  '0',
                        'potongan_bulan_2'  =>  '0',
                        'potongan_bulan_3'  =>  '0',
                        'potongan_bulan_4'  =>  '0',
                    ];
                }elseif ($periode->jumlah_bulan == "5") {
                    $array[]    =   [
                        'periode_id'        =>  $periode->id,
                        'tendik_id'         =>  $tendiks[$i]->id,
                        'potongan_bulan_1'  =>  '0',
                        'potongan_bulan_2'  =>  '0',
                        'potongan_bulan_3'  =>  '0',
                        'potongan_bulan_4'  =>  '0',
                        'potongan_bulan_5'  =>  '0',
                    ];
                }elseif ($periode->jumlah_bulan == "6") {
                    $array[]    =   [
                        'periode_id'        =>  $periode->id,
                        'tendik_id'         =>  $tendiks[$i]->id,
                        'potongan_bulan_1'  =>  '0',
                        'potongan_bulan_2'  =>  '0',
                        'potongan_bulan_3'  =>  '0',
                        'potongan_bulan_4'  =>  '0',
                        'potongan_bulan_5'  =>  '0',
                        'potongan_bulan_6'  =>  '0',
                    ];
                } else {
                    $array[]    =   [
                        'periode_id'        =>  $periode->id,
                        'tendik_id'         =>  $tendiks[$i]->id,
                        'potongan_bulan_1'  =>  '0',
                    ];
                }
            }
            RAbsen::insert($array);
            $notification = array(
                'message' => 'Berhasil,  data tendik berhasil digenerate!',
                'alert-type' => 'success'
            );
            return redirect()->route('kepegawaian.r_absensi',[$periode_id])->with($notification);
        } else {
            $notification = array(
                'message' => 'Gagal,  data tendik gagal digenerate!',
                'alert-type' => 'error'
            );
            return redirect()->route('kepegawaian.r_absensi',[$periode_id])->with($notification);
        }
    }

    public function updatePotongan(Request $request, $id, $periode_id){
        $periode = Periode::select('id','jumlah_bulan')->where('id',$periode_id)->first();
        if ($periode->jumlah_bulan == "3") {
            RAbsen::where('id',$id)->update([
                'potongan_bulan_1'  =>  $request->potongan_bulan_1,
                'potongan_bulan_2'  =>  $request->potongan_bulan_2,
                'potongan_bulan_3'  =>  $request->potongan_bulan_3,
            ]);
        } elseif ($periode->jumlah_bulan == "2") {
            RAbsen::where('id',$id)->update([
                'potongan_bulan_1'  =>  $request->potongan_bulan_1,
                'potongan_bulan_2'  =>  $request->potongan_bulan_2,
            ]);
        }elseif ($periode->jumlah_bulan == "4") {
            RAbsen::where('id',$id)->update([
                'potongan_bulan_1'  =>  $request->potongan_bulan_1,
                'potongan_bulan_2'  =>  $request->potongan_bulan_2,
                'potongan_bulan_3'  =>  $request->potongan_bulan_3,
                'potongan_bulan_4'  =>  $request->potongan_bulan_4,
            ]);
        }elseif ($periode->jumlah_bulan == "5") {
            RAbsen::where('id',$id)->update([
                'potongan_bulan_1'  =>  $request->potongan_bulan_1,
                'potongan_bulan_2'  =>  $request->potongan_bulan_2,
                'potongan_bulan_3'  =>  $request->potongan_bulan_3,
                'potongan_bulan_4'  =>  $request->potongan_bulan_4,
                'potongan_bulan_5'  =>  $request->potongan_bulan_5,
            ]);
        }elseif ($periode->jumlah_bulan == "6") {
            RAbsen::where('id',$id)->update([
                'potongan_bulan_1'  =>  $request->potongan_bulan_1,
                'potongan_bulan_2'  =>  $request->potongan_bulan_2,
                'potongan_bulan_3'  =>  $request->potongan_bulan_3,
                'potongan_bulan_4'  =>  $request->potongan_bulan_4,
                'potongan_bulan_5'  =>  $request->potongan_bulan_5,
                'potongan_bulan_6'  =>  $request->potongan_bulan_6,
            ]);
        } else{
            RAbsen::where('id',$id)->update([
                'potongan_bulan_1'  =>  $request->potongan_bulan_1,
            ]);
        }
        $notification = array(
            'message' => 'Berhasil, Absensi berhasil diupdate!',
            'alert-type' => 'success'
        );
        // return \redirect()->route('kepegawaian.periode')->with($notification);
        return redirect()->route('kepegawaian.r_absensi',$periode_id)->with($notification);
    }

    public function potonganBulanSatu($periode_id){
        $periode_aktif = Periode::select('id','jumlah_bulan','nm_periode')->where('id',$periode_id)->first();
        $datas = RAbsen::join('tendiks','tendiks.id','r_absens.tendik_id')
                            ->leftJoin('jabatans','jabatans.id','tendiks.jabatan_id')
                            ->select('r_absens.id','periode_id','nm_lengkap','potongan_bulan_1','remunerasi','nominal_bulan_1')
                            ->where('periode_id',$periode_id)
                            ->get();
        $cek = RAbsen::select('nominal_bulan_1')->where('periode_id',$periode_id)->first();
        if ($cek->nominal_bulan_1 != null) {
            $a = "sudah";
        }
        else{
            $a = "belum";
        }
        return view('kepegawaian/absensi.potongan_bulan_satu',compact('datas','a','periode_aktif','periode_id'));
    }

    public function generatePotonganBulanSatu($periode_id){
        $datas = RAbsen::join('tendiks','tendiks.id','r_absens.tendik_id')
                            ->leftJoin('jabatans','jabatans.id','tendiks.jabatan_id')
                            ->select('r_absens.id','remunerasi','potongan_bulan_1')
                            ->where('periode_id',$periode_id)
                            ->get();
        for ($i=0; $i <count($datas) ; $i++) {
            RAbsen::where('id',$datas[$i]->id)->where('periode_id',$periode_id)->update([
                'nominal_bulan_1'   =>  (($datas[$i]->remunerasi * $datas[$i]->potongan_bulan_1)/100),
            ]);
        }
        $notification = array(
            'message' => 'Berhasil, Absensi berhasil diupdate!',
            'alert-type' => 'success'
        );
        return redirect()->route('kepegawaian.r_absensi.potongan_bulan_1',[$periode_id])->with($notification);
    }

    public function potonganBulanDua($periode_id){
        $periode_aktif = Periode::select('id','jumlah_bulan','nm_periode')->where('id',$periode_id)->first();
        $datas = RAbsen::join('tendiks','tendiks.id','r_absens.tendik_id')
                            ->leftJoin('jabatans','jabatans.id','tendiks.jabatan_id')
                            ->select('r_absens.id','nm_lengkap','potongan_bulan_2','remunerasi','nominal_bulan_2')
                            ->where('periode_id',$periode_id)
                            ->get();
        $cek = RAbsen::select('nominal_bulan_2')->where('periode_id',$periode_id)->first();
        if ($cek->nominal_bulan_2 != null) {
            $a = "sudah";
        }
        else{
            $a = "belum";
        }
        return view('kepegawaian/absensi.potongan_bulan_dua',compact('datas','a','periode_aktif','periode_id'));
    }

    public function generatePotonganBulanDua($periode_id){
        $periode_aktif = Periode::select('id','jumlah_bulan','nm_periode')->where('status','1')->first();
        $datas = RAbsen::join('tendiks','tendiks.id','r_absens.tendik_id')
                            ->leftJoin('jabatans','jabatans.id','tendiks.jabatan_id')
                            ->select('r_absens.id','remunerasi','potongan_bulan_2')
                            ->where('periode_id',$periode_id)
                            ->get();
        for ($i=0; $i <count($datas) ; $i++) {
            RAbsen::where('id',$datas[$i]->id)->update([
                'nominal_bulan_2'   =>  ($datas[$i]->remunerasi * $datas[$i]->potongan_bulan_2)/100,
            ]);
        }
        $notification = array(
            'message' => 'Berhasil, Absensi berhasil diupdate!',
            'alert-type' => 'success'
        );
        return redirect()->route('kepegawaian.r_absensi.potongan_bulan_2',[$periode_id])->with($notification);
    }

    public function potonganBulanTiga($periode_id){
        $periode_aktif = Periode::select('id','jumlah_bulan','nm_periode')->where('id',$periode_id)->first();
        $datas = RAbsen::join('tendiks','tendiks.id','r_absens.tendik_id')
                            ->leftJoin('jabatans','jabatans.id','tendiks.jabatan_id')
                            ->select('r_absens.id','nm_lengkap','potongan_bulan_3','remunerasi','nominal_bulan_3')
                            ->where('periode_id',$periode_id)
                            ->get();
        $cek = RAbsen::select('nominal_bulan_3')->where('periode_id',$periode_id)->first();
        if ($cek->nominal_bulan_3 != null) {
            $a = "sudah";
        }
        else{
            $a = "belum";
        }
        return view('kepegawaian/absensi.potongan_bulan_tiga',compact('datas','a','periode_id','periode_aktif'));
    }

    public function generatePotonganBulanTiga($periode_id){
        $periode_aktif = Periode::select('id','jumlah_bulan','nm_periode')->where('id',$periode_id)->first();
        $datas = RAbsen::join('tendiks','tendiks.id','r_absens.tendik_id')
                            ->leftJoin('jabatans','jabatans.id','tendiks.jabatan_id')
                            ->select('r_absens.id','remunerasi','potongan_bulan_3')
                            ->where('periode_id',$periode_id)
                            ->get();
        for ($i=0; $i <count($datas) ; $i++) {
            RAbsen::where('id',$datas[$i]->id)->update([
                'nominal_bulan_3'   =>  ($datas[$i]->remunerasi * $datas[$i]->potongan_bulan_3)/100,
            ]);
        }
        $notification = array(
            'message' => 'Berhasil, Absensi berhasil diupdate!',
            'alert-type' => 'success'
        );
        return redirect()->route('kepegawaian.r_absensi.potongan_bulan_3',[$periode_id])->with($notification);
    }

    public function potonganBulanEmpat($periode_id){
        $periode_aktif = Periode::select('id','jumlah_bulan','nm_periode')->where('id',$periode_id)->first();
        $datas = RAbsen::join('tendiks','tendiks.id','r_absens.tendik_id')
                            ->leftJoin('jabatans','jabatans.id','tendiks.jabatan_id')
                            ->select('r_absens.id','nm_lengkap','potongan_bulan_4','remunerasi','nominal_bulan_4')
                            ->where('periode_id',$periode_id)
                            ->get();
        $cek = RAbsen::select('nominal_bulan_4')->where('periode_id',$periode_id)->first();
        if ($cek->nominal_bulan_4 != null) {
            $a = "sudah";
        }
        else{
            $a = "belum";
        }
        return view('kepegawaian/absensi.potongan_bulan_empat',compact('datas','a','periode_id','periode_aktif'));
    }

    public function generatePotonganBulanEmpat($periode_id){
        $periode_aktif = Periode::select('id','jumlah_bulan','nm_periode')->where('id',$periode_id)->first();
        $datas = RAbsen::join('tendiks','tendiks.id','r_absens.tendik_id')
                            ->leftJoin('jabatans','jabatans.id','tendiks.jabatan_id')
                            ->select('r_absens.id','remunerasi','potongan_bulan_4')
                            ->where('periode_id',$periode_id)
                            ->get();
        for ($i=0; $i <count($datas) ; $i++) {
            RAbsen::where('id',$datas[$i]->id)->update([
                'nominal_bulan_4'   =>  ($datas[$i]->remunerasi * $datas[$i]->potongan_bulan_4)/100,
            ]);
        }
        $notification = array(
            'message' => 'Berhasil, Absensi berhasil diupdate!',
            'alert-type' => 'success'
        );
        return redirect()->route('kepegawaian.r_absensi.potongan_bulan_4',[$periode_id])->with($notification);
    }

    public function potonganBulanLima($periode_id){
        $periode_aktif = Periode::select('id','jumlah_bulan','nm_periode')->where('id',$periode_id)->first();
        $datas = RAbsen::join('tendiks','tendiks.id','r_absens.tendik_id')
                            ->leftJoin('jabatans','jabatans.id','tendiks.jabatan_id')
                            ->select('r_absens.id','nm_lengkap','potongan_bulan_5','remunerasi','nominal_bulan_5')
                            ->where('periode_id',$periode_id)
                            ->get();
        $cek = RAbsen::select('nominal_bulan_5')->where('periode_id',$periode_id)->first();
        if ($cek->nominal_bulan_5 != null) {
            $a = "sudah";
        }
        else{
            $a = "belum";
        }
        return view('kepegawaian/absensi.potongan_bulan_lima',compact('datas','a','periode_id','periode_aktif'));
    }

    public function generatePotonganBulanLima($periode_id){
        $periode_aktif = Periode::select('id','jumlah_bulan','nm_periode')->where('id',$periode_id)->first();
        $datas = RAbsen::join('tendiks','tendiks.id','r_absens.tendik_id')
                            ->leftJoin('jabatans','jabatans.id','tendiks.jabatan_id')
                            ->select('r_absens.id','remunerasi','potongan_bulan_5')
                            ->where('periode_id',$periode_id)
                            ->get();
        for ($i=0; $i <count($datas) ; $i++) {
            RAbsen::where('id',$datas[$i]->id)->update([
                'nominal_bulan_5'   =>  ($datas[$i]->remunerasi * $datas[$i]->potongan_bulan_5)/100,
            ]);
        }
        $notification = array(
            'message' => 'Berhasil, Absensi berhasil diupdate!',
            'alert-type' => 'success'
        );
        return redirect()->route('kepegawaian.r_absensi.potongan_bulan_5',[$periode_id])->with($notification);
    }

    public function potonganBulanEnam($periode_id){
        $periode_aktif = Periode::select('id','jumlah_bulan','nm_periode')->where('id',$periode_id)->first();
        $datas = RAbsen::join('tendiks','tendiks.id','r_absens.tendik_id')
                            ->leftJoin('jabatans','jabatans.id','tendiks.jabatan_id')
                            ->select('r_absens.id','nm_lengkap','potongan_bulan_6','remunerasi','nominal_bulan_6')
                            ->where('periode_id',$periode_id)
                            ->get();
        $cek = RAbsen::select('nominal_bulan_6')->where('periode_id',$periode_id)->first();
        if ($cek->nominal_bulan_6 != null) {
            $a = "sudah";
        }
        else{
            $a = "belum";
        }
        return view('kepegawaian/absensi.potongan_bulan_enam',compact('datas','a','periode_id','periode_aktif'));
    }

    public function generatePotonganBulanEnam($periode_id){
        $periode_aktif = Periode::select('id','jumlah_bulan','nm_periode')->where('id',$periode_id)->first();
        $datas = RAbsen::join('tendiks','tendiks.id','r_absens.tendik_id')
                            ->leftJoin('jabatans','jabatans.id','tendiks.jabatan_id')
                            ->select('r_absens.id','remunerasi','potongan_bulan_6')
                            ->where('periode_id',$periode_id)
                            ->get();
        for ($i=0; $i <count($datas) ; $i++) {
            RAbsen::where('id',$datas[$i]->id)->update([
                'nominal_bulan_6'   =>  ($datas[$i]->remunerasi * $datas[$i]->potongan_bulan_6)/100,
            ]);
        }
        $notification = array(
            'message' => 'Berhasil, Absensi berhasil diupdate!',
            'alert-type' => 'success'
        );
        return redirect()->route('kepegawaian.r_absensi.potongan_bulan_6',[$periode_id])->with($notification);
    }
}
