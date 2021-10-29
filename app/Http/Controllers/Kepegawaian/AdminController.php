<?php

namespace App\Http\Controllers\Kepegawaian;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','isKepegawaian']);
    }
    
    public function index(){
        $users = User::all();
        return view('admin/admin.index',compact('users'));
    }

    public function post(Request $request){
        $admin = new User;
        $admin->nm_user = $request->nm_user;
        $admin->email = $request->email;
        $admin->password = bcrypt($request->password);
        $admin->save();

        return redirect()->route('kepegawaian.admin')->with(['success'    =>  'Data Administrator Baru Berhasil Ditambah !!']);
    }

    public function ubahPassword(Request $request){
        $user = User::where('id',$request->id)->update([
            'password'  =>  bcrypt($request->password_baru)
        ]);

        return redirect()->route('kepegawaian.admin')->with(['success'    =>  'Password Administrator Berhasil Diupdate !!']);
    }

    public function aktifkanStatus($id){
        $user = User::where('id',$id)->update([
            'status'    =>  '1',
        ]);
    }

    public function nonAktifkanStatus($id){
        $user = User::where('id',$id)->update([
            'status'    =>  '0',
        ]);
    }

    public function edit($id){
        $user = User::find($id);
        return $user;
    }

    public function update(Request $request){
        $user = User::where('id',$request->id)->update([
            'nm_user'    =>  $request->nm_lengkap,
            'email'    =>  $request->email,
        ]);

        return redirect()->route('kepegawaian.admin')->with(['success'    =>  'Data Administrator Berhasil Diubah !!']);
    }

    public function delete(Request $request){
        $user = User::find($request->id);
        $user->delete();

        return redirect()->route('kepegawaian.admin')->with(['success'    =>  'Data Administrator Berhasil Dihapus !!']);
    }
}
