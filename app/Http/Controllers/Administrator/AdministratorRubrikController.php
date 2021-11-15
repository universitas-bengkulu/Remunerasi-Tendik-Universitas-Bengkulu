<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rubrik;
use Illuminate\Support\Str;

class AdministratorRubrikController extends Controller
{
    public function index(){
        $rubriks = Rubrik::orderBy('id','desc')->get();
        return view('administrator/rubrik.index',compact('rubriks'));
    }

    public function post(Request $request){
        $messages = [
            'required' => ':attribute harus diisi',
            'numeric' => ':attribute harus angka',
        ];
        $attributes = [
           
            'nama_rubrik'    =>  'Nama rubrik',
            'nama_kolom_1'   =>  'Nama Kolom 1',
            'nama_kolom_2'   =>  'Nama Kolom 2',
            'nama_kolom_3'   =>  'Nama Kolom 3',
            'nama_kolom_4'   =>  'Nama Kolom 4',
            'nama_kolom_5'   =>  'Nama Kolom 5',
            'nama_kolom_6'   =>  'Nama Kolom 6',
            'nama_kolom_7'   =>  'Nama Kolom 7',
            'nama_kolom_8'   =>  'Nama Kolom 8',
            'nama_kolom_9'   =>  'Nama Kolom 9',
            'nama_kolom_10'   =>  'Nama Kolom 10',

        ];
        $this->validate($request, [
            'nama_rubrik'    =>  'required'
          
        ],$messages,$attributes);
        $sudah = Rubrik::select('nama_rubrik')->get();
        for ($i=0; $i <count($sudah) ; $i++) { 
            if ($request->nama_rubrik == $sudah[$i]->nama_rubrik) {
                return redirect()->route('administrator.rubrik')->with(['error'   =>  'rubrik Sudah Ditambahkan']);
            }
        }
        Rubrik::create([
           
            'nama_rubrik' => $request->nama_rubrik,
            'nama_kolom_1' => $request->nama_kolom_1,
            'nama_kolom_2' => $request->nama_kolom_2,
            'nama_kolom_3' => $request->nama_kolom_3,
            'nama_kolom_4' => $request->nama_kolom_4,
            'nama_kolom_5' => $request->nama_kolom_5,
            'nama_kolom_6' => $request->nama_kolom_6,
            'nama_kolom_7' => $request->nama_kolom_7,
            'nama_kolom_8' => $request->nama_kolom_8,
            'nama_kolom_9' => $request->nama_kolom_9,
            'nama_kolom_10' => $request->nama_kolom_10,
        ]);

        $notification = array(
            'message' => 'Berhasil, rubrik berhasil ditambahkan!',
            'alert-type' => 'success'
        );
        
        return redirect()->route('administrator.rubrik')->with($notification);
    }

    public function edit($id){
        $rubrik = Rubrik::find($id);
        return $rubrik;
    }

    public function update(Request $request){
        $messages = [
            'required' => ':attribute harus diisi',
            'numeric' => ':attribute harus angka',
        ];
        $attributes = [
            'nama_rubrik'    =>  'Nama rubrik',
            'nama_kolom_1'   =>  'Nama Kolom 1',
            'nama_kolom_2'   =>  'Nama Kolom 2',
            'nama_kolom_3'   =>  'Nama Kolom 3',
            'nama_kolom_4'   =>  'Nama Kolom 4',
            'nama_kolom_5'   =>  'Nama Kolom 5',
            'nama_kolom_6'   =>  'Nama Kolom 6',
            'nama_kolom_7'   =>  'Nama Kolom 7',
            'nama_kolom_8'   =>  'Nama Kolom 8',
            'nama_kolom_9'   =>  'Nama Kolom 9',
            'nama_kolom_10'   =>  'Nama Kolom 10',
        ];
        $this->validate($request, [
        
           
        ],$messages,$attributes);
        
        Rubrik::where('id',$request->id)->update([
            'nama_rubrik' => $request->nama_rubrik,
            'nama_kolom_1' => $request->nama_kolom_1,
            'nama_kolom_2' => $request->nama_kolom_2,
            'nama_kolom_3' => $request->nama_kolom_3,
            'nama_kolom_4' => $request->nama_kolom_4,
            'nama_kolom_5' => $request->nama_kolom_5,
            'nama_kolom_6' => $request->nama_kolom_6,
            'nama_kolom_7' => $request->nama_kolom_7,
            'nama_kolom_8' => $request->nama_kolom_8,
            'nama_kolom_9' => $request->nama_kolom_9,
            'nama_kolom_10' => $request->nama_kolom_10,
        ]);

        $notification = array(
            'message' => 'Berhasil, rubrik berhasil diubah!',
            'alert-type' => 'success'
        );

        return redirect()->route('administrator.rubrik')->with($notification);
    }

    public function delete(Request $request){
        $rubrik = Rubrik::find($request->id);
        $rubrik->delete();
        $notification = array(
            'message' => 'Berhasil, rubrik berhasil dihapus!',
            'alert-type' => 'success'
        );

        return redirect()->route('administrator.rubrik')->with($notification);
    }
}
