<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Unit;
use Illuminate\Support\Str;


class AdministratorUnitController extends Controller
{
    public function index(){
        $units = Unit::orderBy('id','desc')->get();
        return view('administrator/unit.index',compact('units'));
    }

    public function post(Request $request){
        $messages = [
            'required' => ':attribute harus diisi',
            'numeric' => ':attribute harus angka',
        ];
        $attributes = [
          
            'nm_unit'    =>  'Nama unit',
            'tingkatan'   =>  'Kelas unit',
          
        ];
        $this->validate($request, [
            'tingkatan'    =>  'required|numeric',
            'nm_unit'    =>  'required',
        
        ],$messages,$attributes);
        $sudah = Unit::select('nm_unit')->get();
        for ($i=0; $i <count($sudah) ; $i++) { 
            if ($request->nm_unit == $sudah[$i]->nm_unit) {
                return redirect()->route('administrator.unit')->with(['error'   =>  'unit Sudah Ditambahkan']);
            }
        }
        Unit::create([
            'tingkatan' => $request->tingkatan,
            'nm_unit' => $request->nm_unit,
          
        ]);

        $notification = array(
            'message' => 'Berhasil, unit berhasil ditambahkan!',
            'alert-type' => 'success'
        );
        
        return redirect()->route('administrator.unit')->with($notification);
    }

    public function edit($id){
        $unit = Unit::find($id);
        return $unit;
    }

    public function update(Request $request){
        $messages = [
            'required' => ':attribute harus diisi',
            'numeric' => ':attribute harus angka',
        ];
        $attributes = [
            'tingkatan'   =>  'tingkatan',
            'nm_unit'    =>  'Nama unit',
           
        ];
        $this->validate($request, [
            'tingkatan'    =>  'required',
            'nm_unit'    =>  'required',
          
        ],$messages,$attributes);
        
        Unit::where('id',$request->id)->update([
            'tingkatan' =>  $request->tingkatan,
            'nm_unit' =>  $request->nm_unit,
    
        ]);

        $notification = array(
            'message' => 'Berhasil, unit berhasil diubah!',
            'alert-type' => 'success'
        );

        return redirect()->route('administrator.unit')->with($notification);
    }

    public function delete(Request $request){
        $unit = Unit::find($request->id);
        $unit->delete();
        $notification = array(
            'message' => 'Berhasil, unit berhasil dihapus!',
            'alert-type' => 'success'
        );

        return redirect()->route('administrator.unit')->with($notification);
    }
}
