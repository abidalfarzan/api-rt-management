<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    protected $table = "pengeluaran";
    protected $fillable = [
        'description', 'amount',
        'month', 'year',
        'expense_date', 'is_recurring'
    ];

    protected $casts = [
        'is_recurring' => 'boolean',
        'expense_date' => 'date',
    ];
}
