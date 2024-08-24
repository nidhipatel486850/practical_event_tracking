<?php
namespace App\Repositories;

use App\Models\User;
use App\Models\TicketSale;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class AuthRepositories
{
    private User $model;

    /**
     * AuthRepositories constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function register($request): bool
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role'=>$request->role
        ]);
        if($user){
            Auth::login($user);
            return true;
        }else{
            return false;
        }
    }

}
