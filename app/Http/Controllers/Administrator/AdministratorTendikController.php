<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tendik;
use Illuminate\Support\Str;

class AdministratorTendikController extends Controller
{
    public function index(){
        $tendiks = Tendik::orderBy('id','desc')->get();
        return view('administrator/tendik.index',compact('tendiks'));
    }
    public function post(Request $request){
        
        // return $request->all();

        $this->validate($request,[
         
            'nama_lengkap'   =>  'required',
            'email'   =>  'required',
            'password'   =>  'required',
            'role'   =>  'required',
        ]);

        Tendik::create([
            'nama_lengkap'       =>  $request->nama_lengkap,
          
            'email'   =>  $request->email,
            'password'   =>  bcrypt($request->password),
            'role'   =>  $request->role,
            'status' => 'aktif',
        ]);


        return redirect()->route('administrator.tendik')->with(['success' =>  'Pimpinan berhasil ditambahkan']);
    }
     public function nonaktifkanStatus($id){
        Tendik::where('id',$id)->update([
            'status'    =>  '0'
        ]);
        return redirect()->route('administrator.tendik')->with(['success' =>  'tendik Berhasil Di Nonaktifkan !!']);
    }

    public function aktifkanStatus($id){
        Tendik::where('id',$id)->update([
            'status'    =>  '1'
        ]);
        return redirect()->route('administrator.tendik')->with(['success' =>  'tendik Berhasil Di Aktifkan !!']);
    }
    public function edit($id){
        $tendik = Tendik::find($id);
      ;
       
        $periode = Periode::where('status','aktif')->first();
   
        return view('administrator/tendik.edit',compact('tendik','periode'));
    }
    
    public function update(Request $request,$id){
        $this->validate($request,[
            'nama_lengkap'   =>  'required',
            'email'   =>  'required',
            'password'   =>  'required',
            'role'   =>  'required',
        ]);

        Tendik::where('id',$id)->update([
            'nama_lengkap'       =>  $request->nama_lengkap,
          
            'email'   =>  $request->email,
            'password'   =>  bcrypt($request->password),
            'role'   =>  $request->role,
            'status' => 'aktif',
        ]);

        return redirect()->route('administrator.tendik')->with(['success'   =>  'tendik berhasil diubah']);
    }

    public function delete(Request $request){
        $tendik = Tendik::find($request->id);
        Tendik::where('id',$request->id)->delete();
        return redirect()->route('administrator.tendik')->with(['success'   =>  'tendik '.$tendik->nm_tendik.' berhasil dihapus']);
    }
   
}
