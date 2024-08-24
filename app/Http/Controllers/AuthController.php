<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Repositories\AuthRepositories;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     *
     * @return void
    */

    protected AuthRepositories $authRepositories ;
    public function __construct(AuthRepositories $authRepositories)
    {
        $this->authRepositories  = $authRepositories;
    }

    public function register(RegisterRequest $request)
    {
        $response = $this->authRepositories->register($request);
        if($response){
            return response()->json([
                'status'=>1,
                'message'=>"User registered successfully.",
                'redirection_link'=>$request->role == 1 ? route('dashboard'):route('ticket.index')
            ]);
        }else{
            return response()->json([
                'status'=>0,
                'message'=>"Something Went Wrong, Please try again."
            ]);
        }
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user=Auth::user();
            return response()->json([
                'status'=>1,
                'message'=>"Login successfully.",
                'redirection_link'=>$user->role == 1 ? route('dashboard'):route('ticket.index')
            ]);
        }else{
            return response()->json([
                'status'=>0,
                'message'=>"The provided credentials do not match our records."
            ]);
        }
    }

    public function logout(){
        Auth::logout();
        return redirect('/');
    }
}
