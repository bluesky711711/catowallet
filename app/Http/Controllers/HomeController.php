<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
      //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('index', [
          'page' => 'Index'
        ]);
    }

    public function download()
    {
        return view('download', [
          'page' => 'Index'
        ]);
    }

    public function fund()
    {
        return view('fund', [
          'page' => 'fund'
        ]);
    }

}
