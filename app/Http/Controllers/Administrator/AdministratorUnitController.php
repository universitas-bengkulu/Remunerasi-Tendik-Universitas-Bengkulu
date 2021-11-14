<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Unit;
use Illuminate\Support\Str;


class AdministratorUnitController extends Controller
{
    public function index(){
        $units = Unit::all();
        return view('administrator/unit.index',compact('units'));
    }

    public function post(Request $request){
        $this->validate($request,[
            'nm_unit'   =>  'required',
            'tingkatan'    =>  'required',
           
        ]);

        Unit::create([
            'nm_unit'       =>  $request->nm_unit,
            'tingkatan'     =>  $request->tingkatan,
            'slug'  =>  Str::slug($request->nm_unit),
        ]);

        return redirect()->route('administrator.unit')->with(['success' =>  'Unit berhasil ditambahkan']);
    }

   
    public function edit($id){
        $units = Unit::find($id);
        return $units;
    }

    public function update(Request $request){
        $this->validate($request, [
            'nm_unit'    =>  'required',
            'tingkatan'    =>  'required',
           
           
            
        ]);
        $units = Unit::where('id',$request->id)->update([
            'nm_unit'    =>  $request->nm_unit,
            'tingkatan'    =>  $request->tingkatan,
            'slug'  =>  Str::slug($request->nm_unit),
           
        ]);

        return redirect()->route('administrator.unit')->with(['success'    =>  'Data Unit Berhasil Diubah !!']);
    }

    public function delete(Request $request){
        $unit = Unit::find($request->id);
        $unit->delete();

        return redirect()->route('administrator.unit')->with(['success'    =>  'Data Unit Berhasil Dihapus !!']);
    }
}
