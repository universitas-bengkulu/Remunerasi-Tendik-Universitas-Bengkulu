<?php

namespace App\Http\Controllers\Kepegawaian;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Periode;
use App\Models\RIntegritas;
use App\Models\Tendik;
use Illuminate\Support\Facades\Crypt;
if(version_compare(PHP_VERSION, '7.2.0', '>=')) {
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
}
class IntegritasController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','isKepegawaian']);
    }

    public function index($periode_id){
        $integritas = RIntegritas::join('periodes','periodes.id','r_integritas.periode_id')
                                                ->join('tendiks','tendiks.id','r_integritas.tendik_id')
                            ->leftJoin('jabatans','jabatans.id','tendiks.jabatan_id')
                            ->select('r_integritas.id','periode_id','jumlah_bulan','nm_lengkap','remunerasi'
                                        )
                            ->where('periode_id',$periode_id)
                            ->get();
        $periode_aktif = Periode::select('id','nm_periode')->where('id',$periode_id)->first();
        if (count($periode_aktif) < 1) {
            $notification = array(
                'message' => 'Gagal, Harap Aktifkan Periode Remunerasi Terlebih Dahulu!',
                'alert-type' => 'error'
            );
            return redirect()->route('kepegawaian.periode')->with($notification);
        }
        return view('kepegawaian/integritas.index',compact('integritas','periode_aktif'));
    }

    public function generateTendik($periode_id){
        $periode = Periode::select('id')->where('id',$periode_id)->first();
        if (count($periode)>0) {
            $tendiks = Tendik::select('id','nip','nm_lengkap')->get();
            $array = [];
            for ($i=0; $i <count($tendiks) ; $i++) { 
                $array[]    =   [
                    'periode_id'            =>  $periode->id,
                    'tendik_id'             =>  $tendiks[$i]->id,
                    'laporan_lhkpn_lhkasn'  =>  'sudah',
                    'sanksi_disiplin'       =>  'tidak',
                ];
            }
            RIntegritas::insert($array);
            $notification = array(
                'message' => 'Berhasil, data tendik berhasil digenerate!',
                'alert-type' => 'success'
            );
            return redirect()->route('kepegawaian.r_integritas',[$periode_id])->with($notification);
        }
        else{
            $notification2 = array(
                'message' => 'Gagal, silahkan aktifkan periode saat ini terlebih dahulu!',
                'alert-type' => 'error'
            );
            return redirect()->route('kepegawaian.r_integritas',[$periode_id])->with(['error'  =>  'Silahkan Aktifkan Periode Saat Ini Terlebih Dahulu !!']);
        }
    }

    public function remunTigaPuluh($periode_id){
        $datas = RIntegritas::join('periodes','periodes.id','r_integritas.periode_id')
                            ->join('tendiks','tendiks.id','r_integritas.tendik_id')
                            ->leftJoin('jabatans','jabatans.id','tendiks.jabatan_id')
                            ->select('r_integritas.id','periode_id','jumlah_bulan','nm_lengkap','remun_30','total_remun_30'
                                        )
                            ->where('periode_id',$periode_id)
                            ->get();
        $periode_aktif = Periode::select('id')->where('id',$periode_id)->first();
        for ($i=0; $i < count($datas); $i++) { 
            if ($datas[$i]->remun_30 != null) {
                $a = "sudah";
            }
            else{
                $a = "belum";
            }
        }
        return view('kepegawaian/integritas.remun_tiga_puluh',compact('datas','periode_aktif','a','periode_id'));
    }

    public function generateRemunTigaPuluh($periode_id){
        $data_r30 = RIntegritas::join('periodes','periodes.id','r_integritas.periode_id')
                            ->join('tendiks','tendiks.id','r_integritas.tendik_id')
                            ->leftJoin('jabatans','jabatans.id','tendiks.jabatan_id')
                            ->select('r_integritas.id','nip','jumlah_bulan','remunerasi','periode_id')
                            ->where('periodes.id',$periode_id)
                            ->get();
        if (empty($data_r30[0]->nip)) {
            $notification = array(
                'message' => 'Gagal, Silahkan Kembali dan Generate Data Tendik Terlebih Dahulu!',
                'alert-type' => 'error'
            );
            return redirect()->route('kepegawaian.r_integritas.remun_30',[$periode_id])->with($notification);
        }
        
        for ($i=0; $i <count($data_r30) ; $i++) { 
            RIntegritas::where('id',$data_r30[$i]->id)->where('periode_id',$data_r30[$i]->periode_id)->update([
                'remun_30'  =>  (($data_r30[$i]->remunerasi *30) / 100),
                'total_remun_30'  =>  (($data_r30[$i]->remunerasi *30) / 100) * $data_r30[$i]->jumlah_bulan ,
            ]);
        }
        $notification = array(
            'message' => 'Berhasil, Remunerasi 30% berhasil di generate!',
            'alert-type' => 'success'
        );
        return redirect()->route('kepegawaian.r_integritas.remun_30',[$periode_id])->with($notification);
    }

    public function remunTujuhPuluh($periode_id){
        $datas = RIntegritas::join('periodes','periodes.id','r_integritas.periode_id')
                            ->join('tendiks','tendiks.id','r_integritas.tendik_id')
                            ->leftJoin('jabatans','jabatans.id','tendiks.jabatan_id')
                            ->select('r_integritas.id','periode_id','jumlah_bulan','nm_lengkap','remun_70','total_remun_70'
                                        )
                            ->where('periode_id',$periode_id)
                            ->get();
        $periode_aktif = Periode::select('id')->where('id',$periode_id)->first();
        for ($i=0; $i < count($datas); $i++) { 
            if ($datas[$i]->remun_70 != null) {
                $a = "sudah";
            }
            else{
                $a = "belum";
            }
        }
        return view('kepegawaian/integritas.remun_tujuh_puluh',compact('datas','periode_aktif','a','periode_id'));
    }

    public function generateRemunTujuhPuluh($periode_id){
        $data_r70 = RIntegritas::join('periodes','periodes.id','r_integritas.periode_id')
                            ->join('tendiks','tendiks.id','r_integritas.tendik_id')
                            ->leftJoin('jabatans','jabatans.id','tendiks.jabatan_id')
                            ->select('r_integritas.id','nip','remunerasi','jumlah_bulan','periode_id','total_remun_30')
                            ->where('periode_id',$periode_id)
                            ->get();
        if (empty($data_r70[0]->total_remun_30)) {
            $notification = array(
                'message' => 'Gagal, Silahkan Kembali dan Generate Data Remun 30% Terlebih Dahulu!',
                'alert-type' => 'error'
            );
            return redirect()->route('kepegawaian.r_integritas.remun_70',[$periode_id])->with($notification);
        }
        for ($i=0; $i <count($data_r70) ; $i++) { 
            RIntegritas::where('id',$data_r70[$i]->id)->where('periode_id',$data_r70[$i]->periode_id)->update([
                'remun_70'  =>  (($data_r70[$i]->remunerasi *70) / 100),
                'total_remun_70'  =>  (($data_r70[$i]->remunerasi *70) / 100) * $data_r70[$i]->jumlah_bulan,
            ]);
        }
        $notification = array(
            'message' => 'Berhasil, Remunerasi 70% berhasil di generate!',
            'alert-type' => 'success'
        );
        return redirect()->route('kepegawaian.r_integritas.remun_70',[$periode_id])->with($notification);
    }

    public function totalRemun($periode_id){
        $datas = RIntegritas::join('periodes','periodes.id','r_integritas.periode_id')
                            ->join('tendiks','tendiks.id','r_integritas.tendik_id')
                            ->leftJoin('jabatans','jabatans.id','tendiks.jabatan_id')
                            ->select('r_integritas.id','periode_id','nm_lengkap','jumlah_bulan','total_remun_30','total_remun_70','total_remun'
                                        )
                            ->where('periode_id',$periode_id)
                            ->get();
        $periode_aktif = Periode::select('id')->where('id',$periode_id)->first();
        for ($i=0; $i < count($datas); $i++) { 
            if ($datas[$i]->total_remun != null) {
                $a = "sudah";
            }
            else{
                $a = "belum";
            }
        }
        return view('kepegawaian/integritas.total_remun',compact('datas','periode_aktif','a','periode_id'));
    }

    public function generateTotalRemun($periode_id){
        $total = RIntegritas::select('r_integritas.id','periode_id','total_remun_30','total_remun_70')
                            ->where('periode_id',$periode_id)
                            ->get();
        if ( $total[0]->total_remun_70 ==null) {
            $notification = array(
                'message' => 'Gagal, Silahkan Kembali dan Generate Data Temun 70% Terlebih Dahulu!',
                'alert-type' => 'error'
            );
            return redirect()->route('kepegawaian.r_integritas.total_remun',[$periode_id])->with($notification);
        }
        for ($i=0; $i <count($total) ; $i++) { 
            RIntegritas::where('id',$total[$i]->id)->update([
                'total_remun'   =>  $total[$i]->total_remun_30 + $total[$i]->total_remun_70,
            ]); 
        }

        $notification2 = array(
            'message' => 'Berhasil, Total Remunerasi 30% + 70% berhasil di generate!',
            'alert-type' => 'success'
        );
        return redirect()->route('kepegawaian.r_integritas.total_remun',[$periode_id])->with($notification2);
    }

    public function pajakPph($periode_id){
        $datas = RIntegritas::join('periodes','periodes.id','r_integritas.periode_id')
                            ->join('tendiks','tendiks.id','r_integritas.tendik_id')
                            ->leftJoin('jabatans','jabatans.id','tendiks.jabatan_id')
                            ->select('r_integritas.id','periode_id','nm_lengkap','golongan','pajak_pph','total_remun'
                                        )
                            ->where('periode_id',$periode_id)
                            ->orderBy('golongan','desc')
                            ->get();
        $periode_aktif = Periode::select('id')->where('id',$periode_id)->first();
        for ($i=0; $i < count($datas); $i++) { 
            if ($datas[$i]->pajak_pph != null) {
                $a = "sudah";
            }
            else{
                $a = "belum";
            }
        }
        return view('kepegawaian/integritas.pajak_pph',compact('datas','periode_aktif','a','periode_id'));
    }

    public function generatePph($periode_id){
        $data = RIntegritas::join('periodes','periodes.id','r_integritas.periode_id')
                            ->join('tendiks','tendiks.id','r_integritas.tendik_id')
                            ->select('r_integritas.id','periode_id','golongan','total_remun')
                            ->where('periode_id',$periode_id)
                            ->get();
        if (empty($data[0]->total_remun)) {
            return redirect()->route('kepegawaian.r_integritas.pajak_pph',[$periode_id])->with(['error'  =>  'Silahkan Kembali dan Generate Total Remunerasi Terlebih Dahulu !!']);
        }
        for ($i=0; $i <count($data) ; $i++) { 
            if (substr($data[$i]->golongan, 0 ,1) == 4) {
                RIntegritas::where('id',$data[$i]->id)->update([
                    'pajak_pph' =>  ($data[$i]->total_remun * 15)/100,
                ]);
            }elseif (substr($data[$i]->golongan,0,1) == 3) {
                RIntegritas::where('id',$data[$i]->id)->update([
                    'pajak_pph' =>  ($data[$i]->total_remun * 5)/100,
                ]);
            } else {
                RIntegritas::where('id',$data[$i]->id)->update([
                    'pajak_pph' =>  ($data[$i]->total_remun * 0)/100,
                ]);
            }
        }
        $notification = array(
            'message' => 'Berhasil, pajak PPH berhasil di generate!',
            'alert-type' => 'success'
        );
        return redirect()->route('kepegawaian.r_integritas.pajak_pph',[$periode_id])->with($notification);
    }

    public function lhkpnLhkasn($periode_id){
        $datas = RIntegritas::join('periodes','periodes.id','r_integritas.periode_id')
                            ->join('tendiks','tendiks.id','r_integritas.tendik_id')
                            ->leftJoin('jabatans','jabatans.id','tendiks.jabatan_id')
                            ->select('r_integritas.id','periode_id','nm_lengkap','laporan_lhkpn_lhkasn','potongan_lhkpn_lhkasn'
                                        )
                            ->where('periode_id',$periode_id)
                            ->get();
        $periode_aktif = Periode::select('id')->where('id',$periode_id)->first();
        for ($i=0; $i < count($datas); $i++) { 
            if ($datas[$i]->potongan_lhkpn_lhkasn != null) {
                $a = "sudah";
            }
            else{
                $a = "belum";
            }
        }
        return view('kepegawaian/integritas.lhkpn_lhkasn',compact('datas','periode_aktif','a','periode_id'));
    }

    public function updateDataLhkpnLhkasn(Request $request, $id,$periode_id){
        RIntegritas::where('id',$id)->where('periode_id',$periode_id)->update([
            'laporan_lhkpn_lhkasn'  =>  $request->laporan_lhkpn_lhkasn,
        ]);
        $notification = array(
            'message' => 'Berhasil, data laporan LHKPN/LHKASN berhasil di update!',
            'alert-type' => 'success'
        );
        return redirect()->route('kepegawaian.r_integritas.lhkpn_lhkasn',[$periode_id])->with($notification);
    }

    public function generateLhkpnLhkasn($periode_id){
        $datas = RIntegritas::select('r_integritas.id','periode_id','laporan_lhkpn_lhkasn','remun_30','pajak_pph')
                            ->where('periode_id',$periode_id)
                            ->get();
        if ( $datas[0]->pajak_pph ==null) {
            $notification = array(
                'message' => 'Gagal, silahkan kembali dan generate potongan pajak PPH terlebih dahulu!',
                'alert-type' => 'error'
            );
            return redirect()->route('kepegawaian.r_integritas.lhkpn_lhkasn',[$periode_id])->with($notification);
        }
        for ($i=0; $i <count($datas) ; $i++) { 
            if ($datas[$i]->laporan_lhkpn_lhkasn == "sudah") {
                RIntegritas::where('id',$datas[$i]->id)->update([
                    'potongan_lhkpn_lhkasn' =>  (($datas[$i]->remun_30 * 0)/100),
                ]);
            }
            else {
                RIntegritas::where('id',$datas[$i]->id)->update([
                    'potongan_lhkpn_lhkasn' =>  (($datas[$i]->remun_30 * 30)/100),
                ]);
            }
        } 
        $notification = array(
            'message' => 'Berhasil, potongan LHKPN/LHKASN berhasil di generate!',
            'alert-type' => 'success'
        );
        return redirect()->route('kepegawaian.r_integritas.lhkpn_lhkasn',[$periode_id])->with($notification);
    }

    public function sanksiDisiplin($periode_id){
        $datas = RIntegritas::join('periodes','periodes.id','r_integritas.periode_id')
                            ->join('tendiks','tendiks.id','r_integritas.tendik_id')
                            ->leftJoin('jabatans','jabatans.id','tendiks.jabatan_id')
                            ->select('r_integritas.id','periode_id','nm_lengkap','sanksi_disiplin','potongan_sanksi_disiplin'
                                        )
                            ->where('periode_id',$periode_id)
                            ->get();
        $periode_aktif = Periode::select('id')->where('id',$periode_id)->first();
        for ($i=0; $i < count($datas); $i++) { 
            if ($datas[$i]->potongan_sanksi_disiplin != null) {
                $a = "sudah";
            }
            else{
                $a = "belum";
            }
        }
        return view('kepegawaian/integritas.sanksi_disiplin',compact('datas','periode_aktif','periode_id','a'));
    }

    public function updateDataSanksiDisiplin(Request $request, $id,$periode_id){
        RIntegritas::where('id',$id)->where('periode_id',$periode_id)->update([
            'sanksi_disiplin'  =>  $request->sanksi_disiplin,
        ]);
        $notification = array(
            'message' => 'Berhasil, data sanksi disiplin berhasil di update!',
            'alert-type' => 'success'
        );
        return redirect()->route('kepegawaian.r_integritas.sanksi_disiplin',[$periode_id])->with($notification);
    }

    public function generateSanksiDisiplin($periode_id){
        $datas = RIntegritas::select('r_integritas.id','periode_id','sanksi_disiplin','remun_70','potongan_lhkpn_lhkasn')
                            ->where('periode_id',$periode_id)
                            ->get();
        if ($datas[0]->potongan_lhkpn_lhkasn == null) {
            $notification = array(
                'message' => 'Gagal, silahkan kembali dan generate potongan LHKPN/LHKASN terlebih dahulu!',
                'alert-type' => 'error'
            );
            return redirect()->route('kepegawaian.r_integritas.sanksi_disiplin',[$periode_id])->with($notification);
        }
        for ($i=0; $i <count($datas) ; $i++) { 
            if ($datas[$i]->sanksi_disiplin == "tidak") {
                RIntegritas::where('id',$datas[$i]->id)->update([
                    'potongan_sanksi_disiplin' =>  (($datas[$i]->remun_70 * 0)/100),
                ]);
            }
            else {
                RIntegritas::where('id',$datas[$i]->id)->update([
                    'potongan_sanksi_disiplin' =>  (($datas[$i]->remun_70 * 30)/100),
                ]);
            }
        } 
        $notification = array(
            'message' => 'Berhasil, potongan sanksi disiplin berhasil digenerate!',
            'alert-type' => 'success'
        );
        return redirect()->route('kepegawaian.r_integritas.sanksi_disiplin',[$periode_id])->with($notification);
    }

    public function integritasSatuBulan($periode_id){
        $datas = RIntegritas::join('periodes','periodes.id','r_integritas.periode_id')
                            ->join('tendiks','tendiks.id','r_integritas.tendik_id')
                            ->leftJoin('jabatans','jabatans.id','tendiks.jabatan_id')
                            ->select('r_integritas.id','periode_id','nm_lengkap','potongan_lhkpn_lhkasn','potongan_sanksi_disiplin','integritas_satu_bulan'
                                        )
                            ->where('periode_id',$periode_id)
                            ->get();
        $periode_aktif = Periode::select('id')->where('id',$periode_id)->first();
        for ($i=0; $i < count($datas); $i++) { 
            if ($datas[$i]->integritas_satu_bulan != null) {
                $a = "sudah";
            }
            else{
                $a = "belum";
            }
        }
        return view('kepegawaian/integritas.integritas_satu_bulan',compact('datas','periode_aktif','periode_id','a'));
    }

    public function generateIntegritasSatuBulan($periode_id){
        $datas = RIntegritas::select('r_integritas.id','periode_id','potongan_lhkpn_lhkasn','potongan_sanksi_disiplin')
                            ->where('periode_id',$periode_id)
                            ->get();
        if ($datas[0]->potongan_sanksi_disiplin == null) {
            $notification = array(
                'message' => 'Gagal, Silahkan Kembali dan Generate Potongan Sanksi Disiplin Terlebih Dahulu!',
                'alert-type' => 'error'
            );
            return redirect()->route('kepegawaian.r_integritas.integritas_satu_bulan',[$periode_id])->with($notification);
        }
        for ($i=0; $i <count($datas) ; $i++) { 
            RIntegritas::where('id',$datas[$i]->id)->update([
                'integritas_satu_bulan' =>  ($datas[$i]->potongan_lhkpn_lhkasn)+ ($datas[$i]->potongan_sanksi_disiplin),
            ]);
        } 
        $notification = array(
            'message' => 'Berhasil, Potongan Integritas Satu Bulan Berhasil Di Generate!',
            'alert-type' => 'success'
        );
        return redirect()->route('kepegawaian.r_integritas.integritas_satu_bulan',[$periode_id])->with($notification);
    }

    public function totalIntegritas($periode_id){
        $datas = RIntegritas::join('periodes','periodes.id','r_integritas.periode_id')
                            ->join('tendiks','tendiks.id','r_integritas.tendik_id')
                            ->leftJoin('jabatans','jabatans.id','tendiks.jabatan_id')
                            ->select('r_integritas.id','periode_id','nm_lengkap','integritas_satu_bulan','jumlah_bulan','total_integritas'
                                        )
                            ->where('periode_id',$periode_id)
                            ->get();
        $periode_aktif = Periode::select('id')->where('id',$periode_id)->first();
        for ($i=0; $i < count($datas); $i++) { 
            if ($datas[$i]->total_integritas != null) {
                $a = "sudah";
            }
            else{
                $a = "belum";
            }
        }
        return view('kepegawaian/integritas.total_integritas',compact('datas','periode_id','periode_aktif','a'));
    }

    public function generateTotalIntegritas($periode_id){
        $datas = RIntegritas::join('periodes','periodes.id','r_integritas.periode_id')
                                ->select('r_integritas.id','periode_id','integritas_satu_bulan','jumlah_bulan')
                            ->where('periode_id',$periode_id)
                            ->get();
        if ($datas[0]->integritas_satu_bulan == null) {
            $notification = array(
                'message' => 'Berhasil, Silahkan Kembali dan Generate Potongan Integritas Satu Bulan Terlebih Dahulu!',
                'alert-type' => 'success'
            );
            return redirect()->route('kepegawaian.r_integritas.total_integritas',[$periode_id])->with($notification);
        }
        for ($i=0; $i <count($datas) ; $i++) { 
            RIntegritas::where('id',$datas[$i]->id)->update([
                'total_integritas' =>  (($datas[$i]->integritas_satu_bulan) * $datas[$i]->jumlah_bulan),
            ]);
        } 
        $notification = array(
            'message' => 'Berhasil, Potongan Integritas Tiga Bulan Berhasil Di Generate!',
            'alert-type' => 'success'
        );
        return redirect()->route('kepegawaian.r_integritas.total_integritas',[$periode_id])->with($notification);
    }

}
