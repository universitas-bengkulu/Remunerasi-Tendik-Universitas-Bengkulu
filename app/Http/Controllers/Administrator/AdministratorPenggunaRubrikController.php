<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PenggunaRubrik;
use Illuminate\Support\Str;

class AdministratorPenggunaRubrikController extends Controller
{
    public function index(){
        $penggunarubriks = PenggunaRubrik::all();
        return view('administrator/penggunarubrik.index',compact('penggunarubriks'));
    }

    public function post(Request $request){
        $this->validate($request,[
            'nm_penggunarubrik'   =>  'required',
            'tingkatan'    =>  'required',
           
        ]);

        PenggunaRubrik::create([
            'rubrik_id'       =>  $request->rubrik_id,
            'periode_id'       =>  $request->periode_id,
            'no_sk'       =>  $request->no_sk,
            'pengguna_1'     =>  $request->pengguna_1,
            'pengguna_2'     =>  $request->pengguna_2,
            'pengguna_3'     =>  $request->pengguna_3,
            'pengguna_4'     =>  $request->pengguna_4,
            'pengguna_5'     =>  $request->pengguna_5,
            'pengguna_6'     =>  $request->pengguna_6,
            'pengguna_7'     =>  $request->pengguna_7,
            'pengguna_8'     =>  $request->pengguna_8,
            'pengguna_9'     =>  $request->pengguna_9,
            'pengguna_10'     =>  $request->pengguna_10,
            
        ]);

        return redirect()->route('administrator.penggunarubrik')->with(['success' =>  'penggunarubrik berhasil ditambahkan']);
    }

   
    public function edit($id){
        $penggunarubriks = PenggunaRubrik::find($id);
        return $penggunarubriks;
    }

    public function update(Request $request){
        $this->validate($request, [
            'nm_penggunarubrik'    =>  'required',
            'tingkatan'    =>  'required',
           
           
            
        ]);
        $penggunarubriks = PenggunaRubrik::where('id',$request->id)->update([
            'nm_penggunarubrik'    =>  $request->nm_penggunarubrik,
            'tingkatan'    =>  $request->tingkatan,
            'slug'  =>  Str::slug($request->nm_penggunarubrik),
           
        ]);

        return redirect()->route('administrator.penggunarubrik')->with(['success'    =>  'Data penggunarubrik Berhasil Diubah !!']);
    }

    public function delete(Request $request){
        $penggunarubrik = PenggunaRubrik::find($request->id);
        $penggunarubrik->delete();

        return redirect()->route('administrator.penggunarubrik')->with(['success'    =>  'Data penggunarubrik Berhasil Dihapus !!']);
    }
    public function aktifkanStatus($id){
        Penggunarubrik::where('id','!=',$id)->update([
            'status'    =>  'nonaktif',
        ]);
        $penggunarubrik = Penggunarubrik::where('id',$id)->update([
            'status'    =>  'aktif',
        ]);
    }

    public function nonAktifkanStatus($id){
        $penggunarubrik = Penggunarubrik::where('id',$id)->update([
            'status'    =>  'nonaktif',
        ]);
    }

  
}
