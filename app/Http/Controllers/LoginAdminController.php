<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginAdminController extends Controller
{
    public function index()
    {
        return view('admin.login');
    }

}