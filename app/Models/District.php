<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;
    protected $fillable = [];
    public function provinsi()
    {
        return $this->belongsTo('App\Models\Province','regency_id');
    }
}
