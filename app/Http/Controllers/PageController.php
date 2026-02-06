<?php

namespace App\Http\Controllers;

use App\Models\Produk;
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
        $data = Produk::all();
        return view('pages.etalase', compact('active', 'data'));
    }

    public function detail($id){
        $active = 'produk';
        $data = Produk::findorFail($id);
        return view('pages.detail', compact('active', 'data'));
    }

    public function login(){
        return view('auth.login');
    }

    public function register(){
        return view('auth.register');
    }
}
