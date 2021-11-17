<?php

namespace App\Http\Controllers\Kepegawaian;

use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use App\Models\Periode;
use App\Models\Tendik;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','isKepegawaian']);
    }

    public function dashboard(){
        $periode_aktif = Periode::where('status','aktif')->first();
        $jumlah_tendik = count(Tendik::where('status','aktif')->get());
        $jumlah_jabatan = count(Jabatan::all());
        return view('kepegawaian/dashboard',compact('periode_aktif','jumlah_tendik','jumlah_jabatan'));
    }
}
