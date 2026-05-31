<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PembayaranIuran extends Model
{
    protected $table = "pembayaran_iuran";

    protected $fillable = [
        'rumah_id',
        'penghuni_id',
        'jenis_iuran_id',
        'month',
        'year',
        'amount',
        'status',
        'paid_at'
    ];

    protected $casts = [
        'paid_at' => 'date',
    ];

    public function rumah()
    {
        return $this->belongsTo(Rumah::class, 'rumah_id');
    }

    public function penghuni()
    {
        return $this->belongsTo(Penghuni::class, 'penghuni_id');
    }

    public function jenisIuran()
    {
        return $this->belongsTo(JenisIuran::class, 'jenis_iuran_id');
    }
}
