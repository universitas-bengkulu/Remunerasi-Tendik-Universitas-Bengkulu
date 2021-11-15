<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Periode;
use Illuminate\Support\Str;

class AdministratorPeriodeController extends Controller
{
    

    public function index(){
        $periodes = Periode::orderBy('id','desc')->get();
        return view('administrator/periode.index',compact('periodes'));
    }

    public function post(Request $request){
        $messages = [
            'required' => ':attribute harus diisi',
            'numeric' => ':attribute harus angka',
        ];
        $attributes = [
            'nm_periode'   =>  'Nama Periode',
            'tanggal_awal'    =>  'Tanggal Awal',
            'tanggal_akhir'    =>  'Tanggal Akhir',
            'jumlah_bulan'    =>  'Jumlah Bulan',
          
        ];
        $this->validate($request, [
            'nm_periode'    =>  'required',
            'tanggal_awal'    =>  'required',
            'tanggal_akhir'    =>  'required',
            'jumlah_bulan'    =>  'required|numeric',
        ],$messages,$attributes);
        Periode::create([
            'nm_periode'    =>  $request->nm_periode,
            'tanggal_awal'    =>  $request->tanggal_awal,
            'tanggal_akhir'    =>  $request->tanggal_akhir,
            'jumlah_bulan'    =>  $request->jumlah_bulan,
      
            'slug'  =>  Str::slug($request->masa_kinerja),
        ]);
        

        $notification = array(
            'message' => 'Berhasil, data periode berhasil ditambakan!',
            'alert-type' => 'success'
        );

        return redirect()->route('administrator.periode')->with($notification);
    }

    public function aktifkanStatus($id){
        Periode::where('id','!=',$id)->update([
            'status'    =>  'nonaktif',
        ]);
        $periode = Periode::where('id',$id)->update([
            'status'    =>  'aktif',
        ]);
    }

    public function nonAktifkanStatus($id){
        $periode = Periode::where('id',$id)->update([
            'status'    =>  'nonaktif',
        ]);
    }

    public function edit($id){
        $periode = Periode::find($id);
        return $periode;
    }

    public function update(Request $request){
// return $request->all();
        $messages = [
            'required' => ':attribute harus diisi',
            'numeric' => ':attribute harus angka',
        ];
        $attributes = [
            'tanggal_awal'   =>  'Tanggal Awal',
            'nm_periode'    =>  'Nama periode',
            'tanggal_akhir'    =>  'tanggal_akhir',
            'jumlah_bulan'    =>  'jumlah_bulan',
        ];
        $this->validate($request, [
            'tanggal_awal'    =>  'required',
            'nm_periode'    =>  'required',
            'tanggal_akhir'    =>  'required',
            
            'jumlah_bulan'    =>  'required',

        ],$messages,$attributes);
        Periode::where('id',$request->id)->update([
            'tanggal_awal' =>  $request->tanggal_awal,
            'nm_periode' =>  $request->nm_periode,
            'tanggal_akhir' =>  $request->tanggal_akhir,
            'jumlah_bulan' =>  $request->jumlah_bulan,
            

        ]);

        $notification = array(
            'message' => 'Berhasil, periode berhasil diubah!',
            'alert-type' => 'success'
        );

        return redirect()->route('administrator.periode')->with($notification);
    }

    public function delete(Request $request){
        $periode = Periode::find($request->id);
        $periode->delete();

        return redirect()->route('administrator.periode')->with(['success'    =>  'Data Periode Berhasil Dihapus !!']);
    }
}
