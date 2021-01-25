<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function index() {
        $data = ['me' => 0];
        return view('home', $data);
    }
    public function about() {
        $data = ['me' => 0];
        return view('about', $data);
    }
    public function bukufront() {
        $data = ['me' => 0];
        return view('bukufront', $data);
    }
}
