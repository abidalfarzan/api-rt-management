<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penghuni extends Model
{
    protected $table = "penghuni";
    use SoftDeletes;

    protected $fillable = [
        'full_name', 'ktp_photo', 'status',
        'phone_number', 'is_married'
    ];

    protected $casts = [
        'is_married' => 'boolean',
    ];

    // Rumah yang pernah dihuni (historis)
    public function houses()
    {
        return $this->belongsToMany(Rumah::class, 'penghuni_rumah')
                    ->withPivot('start_date', 'end_date', 'is_active')
                    ->withTimestamps();
    }

    // Rumah yang sedang dihuni sekarang
    public function activeHouse()
    {
        return $this->houses()->wherePivot('is_active', true)->first();
    }

    public function payments()
    {
        return $this->hasMany(PembayaranIuran::class);
    }
}
