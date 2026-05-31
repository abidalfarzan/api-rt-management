<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisIuran extends Model
{
    protected $table = "jenis_iuran";
    protected $fillable = ['name', 'amount'];

    public function payments()
    {
        return $this->hasMany(PembayaranIuran::class);
    }
}
