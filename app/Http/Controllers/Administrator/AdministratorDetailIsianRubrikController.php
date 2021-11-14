<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DetailIsianRubrik;
use Illuminate\Support\Str;

class AdministratorDetailIsianRubrikController extends Controller
{
    public function index(){
        $detailisianrubriks = DetailIsianRubrik::all();
        return view('administrator/detailisianrubrik.index',compact('detailisianrubriks'));
    }

    public function post(Request $request){
        $this->validate($request,[
            'nm_detailisianrubrik'   =>  'required',
            'tingkatan'    =>  'required',
           
        ]);

        DetailIsianRubrik::create([
            'nm_detailisianrubrik'       =>  $request->nm_detailisianrubrik,
            'tingkatan'     =>  $request->tingkatan,
            'slug'  =>  Str::slug($request->nm_detailisianrubrik),
        ]);

        return redirect()->route('administrator.detailisianrubrik')->with(['success' =>  'detailisianrubrik berhasil ditambahkan']);
    }

   
    public function edit($id){
        $detailisianrubriks = DetailIsianRubrik::find($id);
        return $detailisianrubriks;
    }

    public function update(Request $request){
        $this->validate($request, [
            'nm_detailisianrubrik'    =>  'required',
            'tingkatan'    =>  'required',
           
           
            
        ]);
        $detailisianrubriks = DetailIsianRubrik::where('id',$request->id)->update([
            'nm_detailisianrubrik'    =>  $request->nm_detailisianrubrik,
            'tingkatan'    =>  $request->tingkatan,
            'slug'  =>  Str::slug($request->nm_detailisianrubrik),
           
        ]);

        return redirect()->route('administrator.detailisianrubrik')->with(['success'    =>  'Data detailisianrubrik Berhasil Diubah !!']);
    }

    public function delete(Request $request){
        $detailisianrubrik = DetailIsianRubrik::find($request->id);
        $detailisianrubrik->delete();

        return redirect()->route('administrator.detailisianrubrik')->with(['success'    =>  'Data rubrik Berhasil Dihapus !!']);
    }
}
