<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home(){
        $active = 'home';
        return view('pages.home', compact('active'));
    }

    public function aiRecommendation(){
        $active = 'ai';
        return view('pages.ai', compact('active'));
    }

    public function etalase(){
        $active = 'produk';
        return view('pages.etalase', compact('active'));
    }

    public function detail(){
        $active = 'produk';
        return view('pages.detail', compact('active'));
    }
}
