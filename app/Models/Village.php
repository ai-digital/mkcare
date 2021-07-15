<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    use HasFactory;
    protected $fillable = [];
    public function kecamatan()
    {
        return $this->belongsTo('App\Models\District','district_id');
    }
}
