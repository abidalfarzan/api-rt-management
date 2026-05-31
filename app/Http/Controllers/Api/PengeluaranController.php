<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;

class PengeluaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengeluaran::query();

        if ($request->month && $request->year) {
            $query->where('month', $request->month)
                ->where('year', $request->year);
        }

        return response()->json($query->orderBy('expense_date', 'desc')->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'description'  => 'required|string',
            'amount'       => 'required|integer|min:0',
            'month'        => 'required|integer|min:1|max:12',
            'year'         => 'required|integer',
            'expense_date' => 'required|date',
            'is_recurring' => 'boolean',
        ]);

        $expense = Pengeluaran::create($request->all());
        return response()->json($expense, 201);
    }

    public function show(Pengeluaran $expense)
    {
        return response()->json($expense);
    }

    public function update(Request $request, Pengeluaran $expense)
    {
        $request->validate([
            'description'  => 'string',
            'amount'       => 'integer|min:0',
            'expense_date' => 'date',
            'is_recurring' => 'boolean',
        ]);

        $expense->update($request->all());
        return response()->json($expense);
    }

    public function destroy(Pengeluaran $expense)
    {
        $expense->delete();
        return response()->json(['message' => 'Expense deleted']);
    }
}
