<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;

class Nkri extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = ['nama','provinsi_id','parent_id','alias','kode_bps','x','y'];

    public function nkri_filter($kolom, $id)
    {
        return collect(Arr::prepend(collect(Nkri::where($kolom, $id)->pluck('nama', 'id'))->toArray(), 'TIDAK ADA', 0))->reverse();
    }

  	public function kecamatan($kab)
    {
        return $this->whereParentId($kab)->orderBy('id','desc')->get();
    }
  	public function kelurahan($kec)
    {
        return $this->whereParentId($kec)->get();
    }

    public function cek_daerah($id=null)
    {
        return $id != null ? $this->find($id) : '';
    }
}
