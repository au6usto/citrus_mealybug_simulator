<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Simulator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function simulador()
    {
        return view('simulador');
    }

    public function simuladorResults()
    {
        return view('simulador_results');
    }

    public function simuladorChart()
    {
        $simulation = new Simulator();
        $simulation->simulate();
        // dd($simulation->getPropertyPerPeriod('occupiedfruitPercentage'));
        return view('simulador_chart', compact('simulation'));
    }
}
