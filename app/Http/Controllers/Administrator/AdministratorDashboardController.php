<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\DetailIsianRubrik;
use App\Models\PeriodeInsentif;
use App\Models\Tendik;
use Illuminate\Http\Request;
use App\Models\Periode;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
if(version_compare(PHP_VERSION, '7.2.0', '>=')) {
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
}
class AdministratorDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','isAdministrator']);
    }

    public function dashboard(){

        $periode_p1 = Periode::where('status','aktif')->first();
        $table = "rekapitulasi_".str_replace('-', '_', $periode_p1->slug);
        $find = Schema::hasTable($table);
        if (empty($find)) {
            $absensi  = 0;
            $integritas  = 0;
            $skp  = 0;
            $total  = 0;
            $periode_aktif = PeriodeInsentif::select('masa_kinerja')->where('status','aktif')->first();
                $jumlah_tendik = Tendik::select(DB::raw('count(id) as jumlah'))->where('unit_id',Auth::user()->unit_id)->first();
                $total_remun    = DetailIsianRubrik::join('tendiks','tendiks.id','detail_isian_rubriks.tendik_id')
                                                    ->select(DB::raw('sum(rate_remun) as total_remun'))
                                                    ->first();
                $total_p1 = DB::table($table)->where('periode_id',$periode_p1->id)
                            ->select(DB::raw('sum(total_akhir_remun) as total'))
                            ->first();
                return view('administrator/dashboard',compact('periode_aktif','jumlah_tendik','total_remun','total_p1'));
        } else {
            $datas =  DB::table($table)->where('periode_id',$periode_p1->id)
                            ->first();
            if (count($datas)<1) {
                $absensi  = 0;
                $integritas  = 0;
                $skp  = 0;
                $total  = 0;
                $periode_aktif = PeriodeInsentif::select('masa_kinerja')->where('status','aktif')->first();
                $jumlah_tendik = Tendik::select(DB::raw('count(id) as jumlah'))->where('unit_id',Auth::user()->unit_id)->first();
                $total_remun    = DetailIsianRubrik::join('tendiks','tendiks.id','detail_isian_rubriks.tendik_id')
                                                    ->select(DB::raw('sum(rate_remun) as total_remun'))
                                                    ->first();
                $total_p1 = DB::table($table)->where('periode_id',$periode_p1->id)
                            ->select(DB::raw('sum(total_akhir_remun) as total'))
                            ->first();
                return view('administrator/dashboard',compact('periode_aktif','jumlah_tendik','total_remun','total_p1'));
            } else {
                $periode_aktif = PeriodeInsentif::select('masa_kinerja')->where('status','aktif')->first();
                $jumlah_tendik = Tendik::select(DB::raw('count(id) as jumlah'))->where('unit_id',Auth::user()->unit_id)->first();
                $total_remun    = DetailIsianRubrik::join('tendiks','tendiks.id','detail_isian_rubriks.tendik_id')
                                                    ->select(DB::raw('sum(rate_remun) as total_remun'))
                                                    ->first();
                $total_p1 = DB::table($table)->where('periode_id',$periode_p1->id)
                            ->select(DB::raw('sum(total_akhir_remun) as total'))
                            ->first();
                return view('administrator/dashboard',compact('periode_aktif','jumlah_tendik','total_remun','total_p1'));
            }
        }
    }
    public function index(){
       
        $user_administrators = User:: select('users.id as id','nama_lengkap','email','role','status_user')->where('role','administrator')
        ->get();
        return view('administrator/dashboard',compact('user_administrators'));
    }

    public function post(Request $request){
        
        // return $request->all();

        $this->validate($request,[
            
           
            'nama_lengkap'   =>  'required',
            'email'   =>  'required',
        
            'password'   =>  'required',
            
            
            
        ]);

        User::create([
            'nama_lengkap'       =>  $request->nama_lengkap,
        
           
            
            
            'email'   =>  $request->email,
            'password'   =>  bcrypt($request->password),
         
            'role' => 'administrator'
        ]);


        return redirect()->route('administrator.dashboard')->with(['success' =>  'administrator berhasil ditambahkan']);
    }
    public function nonaktifkanStatus($id){
        User::where('id',$id)->update([
            'status_user'    =>  'nonaktif'
        ]);
        return redirect()->route('administrator.dashboard')->with(['success' =>  'User Berhasil Di Nonaktifkan !!']);
    }

    public function aktifkanStatus($id){
        User::where('id',$id)->update([
            'status_user'    =>  'aktif'
        ]);
        return redirect()->route('administrator.dashboard')->with(['success' =>  'User Berhasil Di Aktifkan !!']);
    }
    public function edit($id){
        $user = User::find($id);
   
       
        $periode = Periode::where('status','aktif')->first();
   
        return view('backend/administrator/user_administrator.edit',compact('user','periode'));
    }
    
    public function update(Request $request,$id){
        $this->validate($request,[
            'role'   =>  'required',
            'nama_lengkao'   =>  'required',
            'email'   =>  'required',
           
            'password'   =>  'required',
            'no_hp'   =>  'required',
        ]);

        User::where('id',$id)->update([
            'nama_lengkap'       =>  $request->nama_lengkap,
        
           
            
            
            'email'   =>  $request->email,
            'password'   =>  bcrypt($request->password),
           
            'role' => 'administrator'
        ]);

        return redirect()->route('administrator.dashboard')->with(['success'   =>  'User berhasil diubah']);
    }

    public function delete(Request $request){
        $user = User::find($request->id);
        User::where('id',$request->id)->delete();
        return redirect()->route('administrator.dashboard')->with(['success'   =>  'User '.$user->nm_user.' berhasil dihapus']);
    }

}
