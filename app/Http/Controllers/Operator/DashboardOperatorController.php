<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\PeriodeInsentif;
use Illuminate\Http\Request;

class DashboardOperatorController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','isOperator']);
    }

    public function dashboard(){
            return view('operator/dashboard');
    }
}
