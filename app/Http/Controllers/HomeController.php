<?php

namespace App\Http\Controllers;
use App\Models\Pasien;
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
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $bulan=date("m");
        $tahun=date("Y");
        $pasien=Pasien::total_pasien();
        $pasienbulanini=Pasien::total_bulan_ini($bulan,$tahun);
        return view('dashboard',compact('pasien','pasienbulanini'));
    }
}
