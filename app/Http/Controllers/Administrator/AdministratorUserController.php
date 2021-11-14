<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
class AdministratorUserController extends Controller
{
    public function index(){
        $users = User::orderBy('id','desc')->get();
        return view('administrator/user.index',compact('users'));
    }
    public function post(Request $request){
        
        // return $request->all();

        $this->validate($request,[
         
            'nama_lengkap'   =>  'required',
            'email'   =>  'required',
            'password'   =>  'required',
            'role'   =>  'required',
        ]);

        User::create([
            'nama_lengkap'       =>  $request->nama_lengkap,
          
            'email'   =>  $request->email,
            'password'   =>  bcrypt($request->password),
            'role'   =>  $request->role,
            'status' => 'aktif',
        ]);


        return redirect()->route('administrator.user')->with(['success' =>  'Pimpinan berhasil ditambahkan']);
    }
     public function nonaktifkanStatus($id){
        User::where('id',$id)->update([
            'status'    =>  '0'
        ]);
        return redirect()->route('administrator.user')->with(['success' =>  'User Berhasil Di Nonaktifkan !!']);
    }

    public function aktifkanStatus($id){
        User::where('id',$id)->update([
            'status'    =>  '1'
        ]);
        return redirect()->route('administrator.user')->with(['success' =>  'User Berhasil Di Aktifkan !!']);
    }
    public function edit($id){
        $user = User::find($id);
      ;
       
        $periode = Periode::where('status','aktif')->first();
   
        return view('administrator/user.edit',compact('user','periode'));
    }
    
    public function update(Request $request,$id){
        $this->validate($request,[
            'nama_lengkap'   =>  'required',
            'email'   =>  'required',
            'password'   =>  'required',
            'role'   =>  'required',
        ]);

        User::where('id',$id)->update([
            'nama_lengkap'       =>  $request->nama_lengkap,
          
            'email'   =>  $request->email,
            'password'   =>  bcrypt($request->password),
            'role'   =>  $request->role,
            'status' => 'aktif',
        ]);

        return redirect()->route('administrator.user')->with(['success'   =>  'User berhasil diubah']);
    }

    public function delete(Request $request){
        $user = User::find($request->id);
        User::where('id',$request->id)->delete();
        return redirect()->route('administrator.user')->with(['success'   =>  'User '.$user->nm_user.' berhasil dihapus']);
    }
   

}
