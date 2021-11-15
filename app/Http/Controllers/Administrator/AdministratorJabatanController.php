<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jabatan;
use Illuminate\Support\Str;

class AdministratorJabatanController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    
    public function index(){
        $jabatans = Jabatan::orderBy('id','desc')->get();
        return view('administrator/jabatan.index',compact('jabatans'));
    }

    public function post(Request $request){
        $messages = [
            'required' => ':attribute harus diisi',
            'numeric' => ':attribute harus angka',
        ];
        $attributes = [
            'kelas_jabatan'   =>  'Kelas Jabatan',
            'nm_jabatan'    =>  'Nama Jabatan',
            'remunerasi'    =>  'Nilai Remunerasi',
        ];
        $this->validate($request, [
            'kelas_jabatan'    =>  'required|numeric',
            'nm_jabatan'    =>  'required',
            'remunerasi'    =>  'required|numeric',
        ],$messages,$attributes);
        $sudah = Jabatan::select('nm_jabatan')->get();
        for ($i=0; $i <count($sudah) ; $i++) { 
            if ($request->nm_jabatan == $sudah[$i]->nm_jabatan) {
                return redirect()->route('administrator.jabatan')->with(['error'   =>  'Jabatan Sudah Ditambahkan']);
            }
        }
        Jabatan::create([
            'kelas_jabatan' => $request->kelas_jabatan,
            'nm_jabatan' => $request->nm_jabatan,
            'remunerasi' => $request->remunerasi,
        ]);

        $notification = array(
            'message' => 'Berhasil, jabatan berhasil ditambahkan!',
            'alert-type' => 'success'
        );
        
        return redirect()->route('administrator.jabatan')->with($notification);
    }

    public function edit($id){
        $jabatan = Jabatan::find($id);
        return $jabatan;
    }

    public function update(Request $request){
        $messages = [
            'required' => ':attribute harus diisi',
            'numeric' => ':attribute harus angka',
        ];
        $attributes = [
            'kelas_jabatan_edit'   =>  'Kelas Jabatan',
            'nm_jabatan_edit'    =>  'Nama Jabatan',
            'remunerasi_edit'    =>  'Nilai Remunerasi',
        ];
        $this->validate($request, [
            'kelas_jabatan_edit'    =>  'required|numeric',
            'nm_jabatan_edit'    =>  'required',
            'remunerasi_edit'    =>  'required|numeric',
        ],$messages,$attributes);
        
        Jabatan::where('id',$request->id)->update([
            'kelas_jabatan' =>  $request->kelas_jabatan_edit,
            'nm_jabatan' =>  $request->nm_jabatan_edit,
            'remunerasi' =>  $request->remunerasi_edit,
        ]);

        $notification = array(
            'message' => 'Berhasil, jabatan berhasil diubah!',
            'alert-type' => 'success'
        );

        return redirect()->route('administrator.jabatan')->with($notification);
    }

    public function delete(Request $request){
        $jabatan = Jabatan::find($request->id);
        $jabatan->delete();
        $notification = array(
            'message' => 'Berhasil, jabatan berhasil dihapus!',
            'alert-type' => 'success'
        );

        return redirect()->route('administrator.jabatan')->with($notification);
    }
}
