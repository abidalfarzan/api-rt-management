<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PembayaranIuran;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function summary(Request $request)
    {
        $year = $request->year ?? now()->year;

        $data = [];
        for ($m = 1; $m <= 12; $m++) {
            $income = PembayaranIuran::where('year', $year)
                ->where('month', $m)
                ->where('status', 'lunas')
                ->sum('amount');

            $expense = Pengeluaran::where('year', $year)
                ->where('month', $m)
                ->sum('amount');

            $data[] = [
                'month'   => $m,
                'income'  => $income,
                'expense' => $expense,
                'balance' => $income - $expense,
            ];
        }

        return response()->json([
            'year' => $year,
            'data' => $data,
        ]);
    }

    // Detail bulan tertentu
    public function monthly(Request $request, $year, $month)
    {
        $payments = PembayaranIuran::with(['penghuni', 'rumah', 'jenisIuran'])
            ->where('year', $year)
            ->where('month', $month)
            ->get();

        $expenses = Pengeluaran::where('year', $year)
            ->where('month', $month)
            ->get();

        $totalIncome  = $payments->where('status', 'lunas')->sum('amount');
        $totalExpense = $expenses->sum('amount');

        return response()->json([
            'year'          => $year,
            'month'         => $month,
            'total_income'  => $totalIncome,
            'total_expense' => $totalExpense,
            'balance'       => $totalIncome - $totalExpense,
            'payments'      => $payments,
            'expenses'      => $expenses,
        ]);
    }
}
