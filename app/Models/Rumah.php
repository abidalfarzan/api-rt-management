<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rumah extends Model
{
    protected $table = "rumah";
    protected $fillable = ['house_number', 'address', 'status'];

    // Semua penghuni (historis)
    public function residents()
    {
        return $this->belongsToMany(Penghuni::class, 'penghuni_rumah')
                    ->withPivot('start_date', 'end_date', 'is_active')
                    ->withTimestamps();
    }

    // Penghuni aktif sekarang
    public function activeResident()
    {
        return $this->residents()->wherePivot('is_active', true)->first();
    }

    public function payments()
    {
        return $this->hasMany(PembayaranIuran::class);
    }
}
