<?php

use App\Models\Province;
use App\Models\District;
use App\Models\Regency;
use App\Models\Village;

function changeDateFormate($date,$date_format){
    return \Carbon\Carbon::createFromFormat('Y-m-d', $date)->format($date_format);    
}
function showDateTime($carbon, $format = "d M Y @ H:i") {
    return $carbon->translatedFormat($format);
}
   
function productImagePath($image_name)
{
    return public_path('images/products/'.$image_name);
}
 function tglIndoFullHari($tgl) {
	$dt = new  \Carbon\Carbon($tgl);
	setlocale(LC_TIME, 'IND');
		
	return $dt->formatLocalized('%A, %e %B %Y'); // Senin, 3 September 2018
} 
function tglIndoFull($tgl) {
	$dt = new  \Carbon\Carbon($tgl);
	setlocale(LC_TIME, 'IND');
		
	return $dt->formatLocalized('%e %B %Y'); // Senin, 3 September 2018
} 
function tglIndoPendek($tgl) {
	$dt = new  \Carbon\Carbon($tgl);
	setlocale(LC_TIME, 'IND');
		
	return $dt->formatLocalized('%d/%m/%Y'); // Senin, 3 September 2018
} 

function usia($tgllahir)
{
	$now =\Carbon\Carbon::now(); // Tanggal sekarang
	$b_day = \Carbon\Carbon::parse($tgllahir); // Tanggal Lahir
	$age = $b_day->diffInYears($now);  // Menghitung umur
	return $age;  
}
 function secretName(string $string = NULL)
{
    if (!$string) {
        return NULL;
    }
    $length = strlen($string);
    $visibleCount = (int) round($length / 4);
    $hiddenCount = $length - ($visibleCount * 2);
    return  substr($string, 0, $visibleCount) . str_repeat('*', $hiddenCount) . substr($string, ($visibleCount * -1), $visibleCount);
 
}
function secretKTP($number){
	$len = strlen($number);
  //  $mask_number =  str_repeat("*", strlen($number)-4) . substr($number, -4);
	$mask_number= substr($number, 0, 11).str_repeat('*', $len - 11);
    return $mask_number;
}
 
function outnama($id, $tabel, $kolom)
{
    if($tabel == 'provinsi'){
        $hasil = Province::find($id);
    }elseif($tabel == 'kota'){
        $hasil = Regency::find($id);
    }elseif($tabel == 'camat'){
        $hasil = District::find($id);
    }elseif($tabel == 'lurah'){
        $hasil = Village::find($id);
    }

    if(!is_null($hasil)){
        return $hasil[$kolom];   
    }else{
        return '';
    }

}