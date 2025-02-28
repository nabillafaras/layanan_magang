<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PersyaratanController extends Controller
{
    public function index()
    {
        return view('persyaratan'); // Mengarahkan ke file informasi.blade.php
    }
}
