<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;

class DashboardController extends Controller
{
    //
    public function index()
    {
        Artisan::call('optimize:clear');
        return view('home');
    }
}
