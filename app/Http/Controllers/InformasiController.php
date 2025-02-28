<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InformasiController extends Controller
{
    public function index()
    {
        return view('informasi'); // Mengarahkan ke file informasi.blade.php
    }
}
