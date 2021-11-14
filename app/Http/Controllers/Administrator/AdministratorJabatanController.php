<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jabatan;
use Illuminate\Support\Str;

class AdministratorJabatanController extends Controller
{
    public function index(){
        $jabatans = Jabatan::all();
        return view('administrator/jabatan.index',compact('jabatans'));
    }

    public function post(Request $request){
        $this->validate($request,[
            'nm_jabatan'   =>  'required',
            'tingkatan'    =>  'required',
           
        ]);

        Jabatan::create([
            'rubrik_id'       =>  $request->rubrik_id,
            'periode_id'       =>  $request->periode_id,
            'no_sk'       =>  $request->no_sk,
            'isian_1'     =>  $request->isian_1,
            'isian_2'     =>  $request->isian_2,
            'isian_3'     =>  $request->isian_3,
            'isian_4'     =>  $request->isian_4,
            'isian_5'     =>  $request->isian_5,
            'isian_6'     =>  $request->isian_6,
            'isian_7'     =>  $request->isian_7,
            'isian_8'     =>  $request->isian_8,
            'isian_9'     =>  $request->isian_9,
            'isian_10'     =>  $request->isian_10,
            
        ]);

        return redirect()->route('administrator.jabatan')->with(['success' =>  'jabatan berhasil ditambahkan']);
    }

   
    public function edit($id){
        $jabatans = Jabatan::find($id);
        return $jabatans;
    }

    public function update(Request $request){
        $this->validate($request, [
            'nm_jabatan'    =>  'required',
            'tingkatan'    =>  'required',
           
           
            
        ]);
        $jabatans = Jabatan::where('id',$request->id)->update([
            'nm_jabatan'    =>  $request->nm_jabatan,
            'tingkatan'    =>  $request->tingkatan,
            'slug'  =>  Str::slug($request->nm_jabatan),
           
        ]);

        return redirect()->route('administrator.jabatan')->with(['success'    =>  'Data jabatan Berhasil Diubah !!']);
    }

    public function delete(Request $request){
        $jabatan = Jabatan::find($request->id);
        $jabatan->delete();

        return redirect()->route('administrator.jabatan')->with(['success'    =>  'Data jabatan Berhasil Dihapus !!']);
    }
}
