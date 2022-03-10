<?php

namespace App\Http\Controllers\AuthTendik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tendik;

class LoginTendikController extends Controller
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
        $this->middleware('guest:tendik')->except(['logout','logoutTendik']);
    }

    public function showLoginForm(){
        return view('authTendik.login');
    }

    public function login(Request $request){
        $this->validate($request, [
            'nip' => 'required',
            'password' => 'required'
        ]);

        $credential = [
            'nip' => $request->nip,
            'password' => $request->password
        ];

        // Attempt to log the user in
        if (Auth::guard('tendik')->attempt($credential, $request->member)){
            // If login succesful, then redirect to their intended location
            return redirect()->intended(route('tendik.dashboard'));
        }

        // If Unsuccessful, then redirect back to the login with the form data
        return redirect()->back()->withInput($request->only('email', 'remember'));
    }

    public function username()
    {
        return 'nip';
    }

    public function logoutTendik(){
        Auth::guard('tendik')->logout();
        return redirect()->route('tendik.login');
    }
}
