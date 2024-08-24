<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\DashboardRepositories;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class DashboardController extends Controller
{
     /**
     *
     * @return void
    */
    protected DashboardRepositories $dashboardRepositories ;
    public function __construct(DashboardRepositories $dashboardRepositories)
    {
        $this->dashboardRepositories  = $dashboardRepositories;
    }

    public function index(Request $request)
    {
        $data=$this->dashboardRepositories->index($request);
        return view('dashboard', compact('data'));
    }
}
