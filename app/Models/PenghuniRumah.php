<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenghuniRumah extends Model
{
    protected $table = "penghuni_rumah";
    protected $fillable = [
        'rumah_id', 'penghuni_id',
        'start_date', 'end_date', 'is_active'
    ];

    protected $casts = [
        'is_active'  => 'boolean',
        'start_date' => 'date',
        'end_date'   => 'date',
    ];

    public function house()
    {
        return $this->belongsTo(Rumah::class);
    }

    public function resident()
    {
        return $this->belongsTo(Penghuni::class);
    }
}
