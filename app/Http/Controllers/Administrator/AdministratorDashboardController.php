<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Periode;
use App\User;

class AdministratorDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','isAdministrator']);
    }

    public function dashboard(){
        return view('administrator/dashboard');
    }
    public function index(){
       
        $user_administrators = User:: select('users.id as id','nama_lengkap','email','role','status_user')->where('role','administrator')
        ->get();
        return view('administrator/dashboard',compact('user_administrators'));
    }

    public function post(Request $request){
        
        // return $request->all();

        $this->validate($request,[
            
           
            'nama_lengkap'   =>  'required',
            'email'   =>  'required',
        
            'password'   =>  'required',
            
            
            
        ]);

        User::create([
            'nama_lengkap'       =>  $request->nama_lengkap,
        
           
            
            
            'email'   =>  $request->email,
            'password'   =>  bcrypt($request->password),
         
            'role' => 'administrator'
        ]);


        return redirect()->route('administrator.dashboard')->with(['success' =>  'administrator berhasil ditambahkan']);
    }
    public function nonaktifkanStatus($id){
        User::where('id',$id)->update([
            'status_user'    =>  'nonaktif'
        ]);
        return redirect()->route('administrator.dashboard')->with(['success' =>  'User Berhasil Di Nonaktifkan !!']);
    }

    public function aktifkanStatus($id){
        User::where('id',$id)->update([
            'status_user'    =>  'aktif'
        ]);
        return redirect()->route('administrator.dashboard')->with(['success' =>  'User Berhasil Di Aktifkan !!']);
    }
    public function edit($id){
        $user = User::find($id);
   
       
        $periode = Periode::where('status','aktif')->first();
   
        return view('backend/administrator/user_administrator.edit',compact('user','periode'));
    }
    
    public function update(Request $request,$id){
        $this->validate($request,[
            'role'   =>  'required',
            'nama_lengkao'   =>  'required',
            'email'   =>  'required',
           
            'password'   =>  'required',
            'no_hp'   =>  'required',
        ]);

        User::where('id',$id)->update([
            'nama_lengkap'       =>  $request->nama_lengkap,
        
           
            
            
            'email'   =>  $request->email,
            'password'   =>  bcrypt($request->password),
           
            'role' => 'administrator'
        ]);

        return redirect()->route('administrator.dashboard')->with(['success'   =>  'User berhasil diubah']);
    }

    public function delete(Request $request){
        $user = User::find($request->id);
        User::where('id',$request->id)->delete();
        return redirect()->route('administrator.dashboard')->with(['success'   =>  'User '.$user->nm_user.' berhasil dihapus']);
    }

}
