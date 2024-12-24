<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    function DashboardPage(){
        return view('pages.dashboard.dashboard-page');
    }

    function HomePage(){
        return view('pages.user.home-page');
    }
}
