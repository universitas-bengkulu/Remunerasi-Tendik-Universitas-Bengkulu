<?php

namespace App\Http\Controllers\AuthPimpinan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tendik;

class LoginPimpinanController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:pimpinan')->except(['logout','logoutTendik']);
    }

    public function showLoginForm(){
        return view('authPimpinan.login');
    }

    public function login(Request $request){
        $this->validate($request, [
            'pasNama' => 'required',
            'password' => 'required'
        ]);

        $credential = [
            'pasNama' => $request->pasNama,
            'password' => $request->password
        ];

        // Attempt to log the user in
        if (Auth::guard('pimpinan')->attempt($credential, $request->member)){
            // If login succesful, then redirect to their intended location
            return redirect()->intended(route('pimpinan.dashboard'));
        }

        // If Unsuccessful, then redirect back to the login with the form data
        return redirect()->back()->withInput($request->only('email', 'remember'));
    }

    public function username()
    {
        return 'pasNama';
    }

    public function logoutTendik(){
        Auth::guard('pimpinan')->logout();
        return redirect()->route('tendik.login');
    }
}
