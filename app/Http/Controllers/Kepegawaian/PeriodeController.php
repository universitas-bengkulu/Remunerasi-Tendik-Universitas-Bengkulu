<?php

namespace App\Http\Controllers\Kepegawaian;

use App\Http\Controllers\Controller;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PeriodeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','isKepegawaian']);
    }

    public function index(){
        $periodes = Periode::orderBy('id','desc')->get();
        return view('kepegawaian/periode.index',compact('periodes'));
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
            'nm_periode' => $request->nm_periode,
            'tanggal_awal' => $request->tanggal_awal,
            'tanggal_akhir' => $request->tanggal_akhir,
            'jumlah_bulan' => $request->jumlah_bulan,
            'slug'  =>  Str::slug($request->nm_periode),
        ]);

        $notification = array(
            'message' => 'Berhasil, data periode berhasil ditambakan!',
            'alert-type' => 'success'
        );

        return redirect()->route('kepegawaian.periode')->with($notification);
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
        $this->validate($request, [
            'nm_periode'    =>  'required',
            'tanggal_awal'    =>  'required',
            'tanggal_akhir'    =>  'required',
            'jumlah_bulan'    =>  'required',
        ]);
        $periode = Periode::where('id',$request->id)->update([
            'nm_periode'    =>  $request->nm_periode,
            'tanggal_awal'    =>  $request->tanggal_awal,
            'tanggal_akhir'    =>  $request->tanggal_akhir,
            'jumlah_bulan'    =>  $request->jumlah_bulan,
        ]);

        return redirect()->route('kepegawaian.periode')->with(['success'    =>  'Data Periode Berhasil Diubah !!']);
    }

    public function delete(Request $request){
        $periode = Periode::find($request->id);
        $periode->delete();

        return redirect()->route('kepegawaian.periode')->with(['success'    =>  'Data Periode Berhasil Dihapus !!']);
    }
}
