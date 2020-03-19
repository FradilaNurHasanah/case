<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $table = "pelanggan";

    protected $fillable = ['id_pelanggan', 'id_tarif', 'nomor_kwh', 'nama_pelanggan','alamat'];

    public function pelanggan(){
        return $this->belongsTo('App\Pelanggan', 'id_pelanggan', 'id_tarif');
    }
    public function tarif(){
        return $this->belongsTo('App\Tarif', 'id_tarif', 'id_pelanggan'); 
    }
}
