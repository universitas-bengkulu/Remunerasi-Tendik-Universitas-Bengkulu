<?php

namespace App\Http\Controllers\Tendik;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use App\Models\Periode;
use App\Models\Tendik;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
if(version_compare(PHP_VERSION, '7.2.0', '>=')) {
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
}
class TendikDashboardController extends Controller
{
    public function __construct(){
        $this->middleware('auth:tendik');
    }

    public function index(){
        $periode_aktif = Periode::where('status','aktif')->first();
        if (count((array)$periode_aktif)>0) {
            $table = "rekapitulasi_".str_replace('-', '_', $periode_aktif->slug);
            $find = Schema::hasTable($table);
            if (empty($find)) {
                $absensi  = 0;
                $integritas  = 0;
                $skp  = 0;
                $total  = 0;
                $periode = Periode::where('status','aktif')->first();
                $about = Tendik::leftJoin('jabatans','jabatans.id','tendiks.jabatan_id')->where('nip',Auth::guard('tendik')->user()->nip)->first();
                $jabatans = Jabatan::get();
                // return view('tendik/dashboard', compact('about','jabatans','periode','absensi','skp','integritas','total'));
            } else {
                $datas =  DB::table($table)->where('periode_id',$periode_aktif->id)
                                ->where('tendik_id',Auth::guard('tendik')->user()->id)
                                ->first();
                if (count((array)$datas)<1) {
                    $absensi  = 0;
                    $integritas  = 0;
                    $skp  = 0;
                    $total  = 0;
                    $periode = Periode::where('status','aktif')->first();
                    $about = Tendik::leftJoin('jabatans','jabatans.id','tendiks.jabatan_id')->where('nip',Auth::guard('tendik')->user()->nip)->first();
                    $jabatans = Jabatan::get();
                    // return view('tendik/dashboard', compact('about','jabatans','periode','absensi','skp','integritas','total'));
                } else {
                    $periode = Periode::where('status','aktif')->first();
                    $about = Tendik::leftJoin('jabatans','jabatans.id','tendiks.jabatan_id')->where('nip',Auth::guard('tendik')->user()->nip)->first();
                    $jabatans = Jabatan::get();
                    $absensi = $datas->total_absensi;
                    $skp = $datas->total_skp;
                    $integritas = $datas->total_integritas;
                    $total = $datas->total_akhir_remun;
                }
            }
            return view('tendik/dashboard', compact('about','jabatans','periode','absensi','skp','integritas','total'));
        }
        else{
            return redirect()->back();  
        }
    }

    public function ubahPassword(Request $request){
        if ($request->password != $request->ulangi_password) {
            return redirect()->route('tendik.dashboard')->with(['error'  =>  'Password yang anda masukan tidak sama']);
        }
        else{
            Tendik::where('id',Auth::guard('tendik')->user()->id)->update([
                'password'  =>  bcrypt($request->password), 
            ]);

            return redirect()->route('tendik.dashboard')->with(['success'  =>  'Password berhasil diubah']);
        }
    }
    
    public function ubahData(Request $request){
        $this->validate($request,[
            'nm_lengkap' =>  'required',
            'nip'  =>  "required",
            'pangkat'  =>  "required",
            'golongan'  =>  "required",
            'jabatan'  =>  "required",
            'jenis_kepegawaian'  =>  "required",
            'jenis_kelamin'  =>  "required",
            'no_rekening'  =>  "required",
            'no_npwp'  =>  "required",
        ]);
        $jabatan = Jabatan::select('nm_jabatan','remunerasi')->where('id',$request->jabatan)->firstOrFail();
        Tendik::where('id',Auth::guard('tendik')->user()->id)->update([
            'nm_lengkap'    =>  $request->nm_lengkap,
            'nip'   =>  $request->nip,
            'pangkat'   =>  $request->pangkat,
            'golongan'  =>  $request->golongan,
            'jabatan_id'   =>  $request->jabatan,
            'jenis_kepegawaian' =>  $request->jenis_kepegawaian,
            'jenis_kelamin' =>  $request->jenis_kelamin,
            'no_rekening'   =>  $request->no_rekening,
            'no_npwp'   =>  $request->no_npwp,
        ]);

        return redirect()->route('tendik.dashboard')->with(['success'  =>  'Data anda berhasil diubah']);
    }
}
