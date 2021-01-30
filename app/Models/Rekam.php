<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Rekam extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    protected $fillable = ['id_pasien','tgl_rekam','keluhan','diagnosa','tindakan','petugas','id_user'];
  
   public function pasien()
   {
       return $this->belongsTo('App\Models\Pasien','id','id_pasien');
       
   }
}
