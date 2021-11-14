<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IsianRubrik;
use Illuminate\Support\Str;

class AdministratorIsianRubrikController extends Controller
{
    public function index(){
        $isianrubriks = IsianRubrik::all();
        return view('administrator/isianrubrik.index',compact('isianrubriks'));
    }

    public function post(Request $request){
        $this->validate($request,[
            'nm_isianrubrik'   =>  'required',
            'tingkatan'    =>  'required',
           
        ]);

        IsianRubrik::create([
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

        return redirect()->route('administrator.isianrubrik')->with(['success' =>  'isianrubrik berhasil ditambahkan']);
    }

   
    public function edit($id){
        $isianrubriks = IsianRubrik::find($id);
        return $isianrubriks;
    }

    public function update(Request $request){
        $this->validate($request, [
            'nm_isianrubrik'    =>  'required',
            'tingkatan'    =>  'required',
           
           
            
        ]);
        $isianrubriks = IsianRubrik::where('id',$request->id)->update([
            'nm_isianrubrik'    =>  $request->nm_isianrubrik,
            'tingkatan'    =>  $request->tingkatan,
            'slug'  =>  Str::slug($request->nm_isianrubrik),
           
        ]);

        return redirect()->route('administrator.isianrubrik')->with(['success'    =>  'Data isianrubrik Berhasil Diubah !!']);
    }

    public function delete(Request $request){
        $isianrubrik = IsianRubrik::find($request->id);
        $isianrubrik->delete();

        return redirect()->route('administrator.isianrubrik')->with(['success'    =>  'Data isianrubrik Berhasil Dihapus !!']);
    }
}
