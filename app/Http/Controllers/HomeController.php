<?php

namespace projetoGCA\Http\Controllers;

use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $agent = new Agent();
        if($agent->isMobile()){
            return view('_mobile.home');
        }else{
            return view('home');
        }
    }
}
