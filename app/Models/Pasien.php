<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
 
use DB;
class Pasien extends Model
{
    

    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'nik','no_mkcare','no_jkn','nama','alamat','email','provinsi_id','kabupaten_id', 'kecamatan_id', 'kelurahan_id','jenis_kelamin',
        'tempat_lahir','tanggal_lahir','nomor_wa','nomor_hp','id_user'
    ];

    
    public function rekam()
    {
        return $this->hasMany('App\Models\Rekam','id_pasien','id');
    }
    public static function  total_pasien(){
            $data           = DB::table('pasiens')->count();
               
        if($data){
            return $data;
        }
    }
    public static function total_bulan_ini($bulan,$tahun){
        $data=DB::table('pasiens')->join('rekams','pasiens.id','rekams.id_pasien')->
        whereMonth('rekams.tgl_rekam','=',$bulan)
        ->whereYear('rekams.tgl_rekam','=',$tahun)->count();
        if($data) {
            return $data;
        }
    }
     
    
    public function kabupaten()
    {
        return $this->belongsTo('App\Models\Regency','kabupaten_id');
    }

    public function kecamatan()
    {
        return $this->belongsTo('App\Models\District','kecamatan_id');
    }

    public function kelurahan()
    {
        return $this->belongsTo('App\Models\Village','kelurahan_id');
    }

}
