<?php
/**
 * Desription
 *
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * @param null
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function login()
    {
        return view('login');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function loginPost(Request $request)
    {

        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);
        if(Auth::attempt([ 'email' => $request->email, 'password' => $request->password ]))
        {
            if(Auth::check() && Auth::user()->status != 1){
                Auth::logout();
                return redirect()->route('login')->with('alert-danger', 'You Are Not Approved For Login');
            }
            return redirect()->route('admin.dashboard');
        }else{
            $request->session()->flash('alert-danger', 'Incorrect Login Username & Password !');
            return redirect()->back();
        }

    }

    public function logout(Request $request){
        if(Auth::check()) {
            Auth::logout();
            $request->session()->flush();
            return redirect()->route('login');
        }else{
            return redirect()->route('login');
        }
    }
}
