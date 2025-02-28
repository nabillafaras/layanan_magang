<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class Pendaftaran_SummaryController extends Controller
{
    public function index($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        return view('pendaftaran_summary', compact('pendaftaran'));
    }
}