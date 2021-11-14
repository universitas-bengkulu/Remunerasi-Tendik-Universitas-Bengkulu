<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rubrik;
use Illuminate\Support\Str;

class AdministratorRubrikController extends Controller
{
    public function index(){
        $rubriks = Rubrik::all();
        return view('administrator/rubrik.index',compact('rubriks'));
    }

    public function post(Request $request){
        $this->validate($request,[
            'nm_rubrik'   =>  'required',
            'tingkatan'    =>  'required',
           
        ]);

        Rubrik::create([
            'nm_rubrik'       =>  $request->nm_rubrik,
            'tingkatan'     =>  $request->tingkatan,
            'slug'  =>  Str::slug($request->nm_rubrik),
        ]);

        return redirect()->route('administrator.rubrik')->with(['success' =>  'rubrik berhasil ditambahkan']);
    }

   
    public function edit($id){
        $rubriks = Rubrik::find($id);
        return $rubriks;
    }

    public function update(Request $request){
        $this->validate($request, [
            'nm_rubrik'    =>  'required',
            'tingkatan'    =>  'required',
           
           
            
        ]);
        $rubriks = Rubrik::where('id',$request->id)->update([
            'nm_rubrik'    =>  $request->nm_rubrik,
            'tingkatan'    =>  $request->tingkatan,
            'slug'  =>  Str::slug($request->nm_rubrik),
           
        ]);

        return redirect()->route('administrator.rubrik')->with(['success'    =>  'Data rubrik Berhasil Diubah !!']);
    }

    public function delete(Request $request){
        $rubrik = Rubrik::find($request->id);
        $rubrik->delete();

        return redirect()->route('administrator.rubrik')->with(['success'    =>  'Data rubrik Berhasil Dihapus !!']);
    }
}
