<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;
class WilayahController extends Controller
{
    public function listkabupaten(Request $request)
	{
		//
		$kodeprovinsi = $request->kodeprovinsi;
		if($kodeprovinsi != ''){
			$kabupaten = Regency::where('province_id', '=', $kodeprovinsi)
				->orderBy('id', 'asc')->get();
			return view('layouts/page_templates/listkabupaten')->with('kabupatens', $kabupaten);
		}else{
			return '<option value="">&mdash; Pilih &mdash;</option>';
		}
	}
    public function listkecamatan(Request $request)
	{
		//
		$kodekota = $request->kodekota;
		if($kodekota != ''){
			$camats = District::where('regency_id', '=', $kodekota)
				->orderBy('id', 'asc')->get();
			return view('layouts/page_templates/listkecamatan')->with('camats', $camats);
		}else{
			return '<option value="">&mdash; Pilih &mdash;</option>';
		}
	}

	public function listkelurahan(Request $request)
	{
		//
		$kodecamat = $request->kodecamat;
		if($kodecamat != ''){
			$lurahs = Village::where('district_id', '=', $kodecamat)
				->orderBy('id', 'asc')->get();
			return view('layouts/page_templates/listkelurahan')->with('lurahs', $lurahs);
		}else{
			return '<option value="">&mdash; Pilih &mdash;</option>';
		}
	}
}
