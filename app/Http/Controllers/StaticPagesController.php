<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaticPagesController extends Controller
{
    // public function home()
    // {
    //     echo "主页";
    // }
    //
    // public function help()
    // {
    //     echo "帮助页";
    // }
    //
    // public function about()
    // {
    //     echo "关于页";
    // }

    public function home()
    {
        return view('static_pages/home');
    }

    public function help()
    {
        return view('static_pages/help');
    }

    public function about()
    {
        return view('static_pages/about');
    }
}
