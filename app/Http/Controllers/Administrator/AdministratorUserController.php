<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Unit;

use Illuminate\Support\Str;
class AdministratorUserController extends Controller
{
    public function index(){
        $units = Unit::select('id','nm_unit')->get();
        $users = User::leftJoin('units','units.id','users.unit_id')
                        ->select('users.id','nama_lengkap','email','nm_unit','role','status')
                        ->orderBy('users.id','desc')
                        ->get();
        return view('administrator/user.index',compact('users','units'));
    }


    public function post(Request $request){
        $messages = [
            'required' => ':attribute harus diisi',
            'numeric' => ':attribute harus angka',
        ];
        $attributes = [
            'nama_lengkap'   =>  'Nama User',
            'email'    =>  'email',
            'password'   =>  'password',
            'unit_id'   =>  'unit_id',
            'role'   =>  'role',

           
        ];
        $this->validate($request, [
            'nama_lengkap'   =>  'required',
            'email'    =>  'required',
            'password'   =>  'required',
            'unit_id'   =>  'required',
            'role'   =>  'required',

           
        ], $messages, $attributes);
        User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'unit_id' => $request->unit_id,
            'role' => $request->role,



            'slug' => Str::slug($request->nama_lengkap),
           
        ]);

        $notification = array(
            'message' => 'Berhasil, data user berhasil ditambakan!',
            'alert-type' => 'success'
        );

        return redirect()->route('administrator.user')->with($notification);
    }

    public function edit($id){
        $user = User::find($id);
        return $user;
    }

    public function update(Request $request){
        User::where('id',$request->id_ubah)->update([
      
            'slug' => Str::slug($request->nama_lengkap),
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
   
            'unit_id' => $request->unit_id,
            'role' => $request->role,

        ]);

        $notification = array(
            'message' => 'Berhasil, data user berhasil diupdate!',
            'alert-type' => 'success'
        );

        return redirect()->route('administrator.user')->with($notification);
    }

    public function delete(Request $request){
        $user = User::find($request->id);
        $user->delete();

        return redirect()->route('administrator.user')->with(['success' =>  'Data user berhasil dihapus !']);
    }

    public function generatePassword(Request $request){
        User::where('status','aktif')->update([
            'password'  =>  bcrypt($request->password),
        ]);

        return redirect()->route('administrator.user')->with(['success' =>  'Password berhasil di generate !']);
    }

    public function ubahPassword(Request $request){
        User::where('id',$request->id)->update([
            'password'  =>  bcrypt($request->password_ubah),
        ]);

        return redirect()->route('administrator.user')->with(['success' =>  'Password berhasil di generate !']);
    }
   
    public function aktifkanStatus($id){
       
        $user = User::where('id',$id)->update([
            'status'    =>  'aktif',
        ]);
    }

    public function nonAktifkanStatus($id){
        $user = User::where('id',$id)->update([
            'status'    =>  'nonaktif',
        ]);
    }

}
