<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PenggunaRubrik;
use App\Models\Unit;
use App\Models\Rubrik;


use Illuminate\Support\Str;

class AdministratorPenggunaRubrikController extends Controller
{
  public function index(){
        $units = Unit::select('id','nm_unit')->get();
        $rubriks = Rubrik::select('id','nama_rubrik')->get();

        $penggunarubriks = PenggunaRubrik::leftJoin('units','units.id','pengguna_rubriks.unit_id')
                                            ->leftJoin('rubriks','rubriks.id','pengguna_rubriks.rubrik_id')
                                            ->select('pengguna_rubriks.id','nama_rubrik','nm_unit')
                                            ->orderBy('pengguna_rubriks.id','desc')
                                            ->get();
                                          
        return view('administrator/penggunarubrik.index',compact('penggunarubriks','rubriks','units'));
    }

    public function post(Request $request){
        $messages = [
            'required' => ':attribute harus diisi',
            'numeric' => ':attribute harus angka',
        ];
        $attributes = [
            'rubrik_id'   =>  'Nama Rubrik',
            'unit_id'    =>  'Nama Unit',
            
        ];
        $this->validate($request, [
            'rubrik_id'    =>  'required',
            'unit_id'    =>  'required',
           
        ], $messages, $attributes);
        PenggunaRubrik::create([
            'rubrik_id' => $request->rubrik_id,
            'unit_id' => $request->unit_id,
            
        ]);

        $notification = array(
            'message' => 'Berhasil, data penggunarubrik berhasil ditambakan!',
            'alert-type' => 'success'
        );

        return redirect()->route('administrator.penggunarubrik')->with($notification);
    }

    public function edit($id){
        $penggunarubrik = PenggunaRubrik::find($id);
        return $penggunarubrik;
    }

    public function update(Request $request){
        PenggunaRubrik::where('id',$request->id_ubah)->update([
            'unit_id'    =>  $request->unit_id,
            'rubrik_id'    =>  $request->rubrik_id,
        
        ]);

        $notification = array(
            'message' => 'Berhasil, data penggunarubrik berhasil diupdate!',
            'alert-type' => 'success'
        );

        return redirect()->route('administrator.penggunarubrik')->with($notification);
    }

    public function delete(Request $request){
        $penggunarubrik = PenggunaRubrik::find($request->id);
        $penggunarubrik->delete();

        return redirect()->route('administrator.penggunarubrik')->with(['success' =>  'Data penggunarubrik berhasil dihapus !']);
    }

    public function aktifkanStatus($id){
        PenggunaRubrik::where('id','!=',$id)->update([
            'status'    =>  'nonaktif',
        ]);
        $penggunarubrik = PenggunaRubrik::where('id',$id)->update([
            'status'    =>  'aktif',
        ]);
    }

    public function nonAktifkanStatus($id){
        $penggunarubrik = PenggunaRubrik::where('id',$id)->update([
            'status'    =>  'nonaktif',
        ]);
    }

  
}
