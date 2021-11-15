<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PeriodeInsentif;
use Illuminate\Support\Str;

class AdministratorPeriodeInsentifController extends Controller
{
   
    public function index(){
        $periodeinsentifs = PeriodeInsentif::orderBy('id','desc')->get();
        return view('administrator/periodeinsentif.index',compact('periodeinsentifs'));
    }

    public function post(Request $request){
        $messages = [
            'required' => ':attribute harus diisi',
            'numeric' => ':attribute harus angka',
        ];
        $attributes = [
            'masa_kinerja'   =>  'Nama Periode insentif',
            'periode_pembayaran'    =>  'periode pembayaran',
           
          
        ];
        $this->validate($request, [
            'masa_kinerja'    =>  'required',
            'periode_pembayaran'    =>  'required',
           
        ],$messages,$attributes);
        PeriodeInsentif::create([
            'masa_kinerja'    =>  $request->masa_kinerja,
            'periode_pembayaran'    =>  $request->periode_pembayaran,
       
            'slug'  =>  Str::slug($request->masa_kinerja),
        ]);
        

        $notification = array(
            'message' => 'Berhasil, data periodeinsentif berhasil ditambakan!',
            'alert-type' => 'success'
        );

        return redirect()->route('administrator.periodeinsentif')->with($notification);
    }

    public function aktifkanStatus($id){
        PeriodeInsentif::where('id','!=',$id)->update([
            'status'    =>  'nonaktif',
        ]);
        $periodeinsentif = PeriodeInsentif::where('id',$id)->update([
            'status'    =>  'aktif',
        ]);
    }

    public function nonAktifkanStatus($id){
        $periodeinsentif = PeriodeInsentif::where('id',$id)->update([
            'status'    =>  'nonaktif',
        ]);
    }

    public function edit($id){
        $periodeinsentif = PeriodeInsentif::find($id);
        return $periodeinsentif;
    }

    public function update(Request $request){
// return $request->all();
        $messages = [
            'required' => ':attribute harus diisi',
            'numeric' => ':attribute harus angka',
        ];
        $attributes = [
            'periode_pembayaran'   =>  'Tanggal Awal',
            'masa_kinerja'    =>  'Nama periodeinsentif',
          
        ];
        $this->validate($request, [
            'periode_pembayaran'    =>  'required',
            'masa_kinerja'    =>  'required',
           

        ],$messages,$attributes);
        PeriodeInsentif::where('id',$request->id)->update([
            'periode_pembayaran' =>  $request->periode_pembayaran,
            'masa_kinerja' =>  $request->masa_kinerja,
        
            

        ]);

        $notification = array(
            'message' => 'Berhasil, periodeinsentif berhasil diubah!',
            'alert-type' => 'success'
        );

        return redirect()->route('administrator.periodeinsentif')->with($notification);
    }

    public function delete(Request $request){
        $periodeinsentif = PeriodeInsentif::find($request->id);
        $periodeinsentif->delete();

        return redirect()->route('administrator.periodeinsentif')->with(['success'    =>  'Data Periodeinsentif Berhasil Dihapus !!']);
    }
}
