<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JenisIuran;
use App\Models\PembayaranIuran;
use Illuminate\Http\Request;

class PembayaranIuranController extends Controller
{
    public function index(Request $request)
    {
        $query = PembayaranIuran::with(['rumah', 'penghuni', 'jenisIuran']);

        // Filter by month & year jika ada
        if ($request->month && $request->year) {
            $query->where('month', $request->month)
                ->where('year', $request->year);
        }

        return response()->json($query->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'rumah_id'    => 'required|exists:rumah,id',
            'penghuni_id' => 'required|exists:penghuni,id',
            'jenis_iuran_id' => 'required|exists:jenis_iuran,id',
            'month'       => 'required|integer|min:1|max:12',
            'year'        => 'required|integer',
            'status'      => 'in:lunas,belum',
            'paid_at'     => 'nullable|date',
            'pay_annual'  => 'boolean',
        ]);

        $feeType = JenisIuran::find($request->jenis_iuran_id);

        // Jika bayar tahunan (hanya untuk kebersihan)
        if ($request->pay_annual && $feeType->name === 'Kebersihan') {
            $payments = [];
            for ($m = 1; $m <= 12; $m++) {
                $payments[] = PembayaranIuran::create([
                    'rumah_id'    => $request->rumah_id,
                    'penghuni_id' => $request->penghuni_id,
                    'jenis_iuran_id' => $request->jenis_iuran_id,
                    'month'       => $m,
                    'year'        => $request->year,
                    'amount'      => $feeType->amount,
                    'status'      => 'lunas',
                    'paid_at'     => $request->paid_at ?? now(),
                ]);
            }
            return response()->json($payments, 201);
        }

        // Bayar bulanan biasa
        $payment = PembayaranIuran::create([
            'rumah_id'    => $request->rumah_id,
            'penghuni_id' => $request->penghuni_id,
            'jenis_iuran_id' => $request->jenis_iuran_id,
            'month'       => $request->month,
            'year'        => $request->year,
            'amount'      => $feeType->amount,
            'status'      => $request->status ?? 'belum',
            'paid_at'     => $request->paid_at,
        ]);

        return response()->json($payment, 201);
    }

    public function show(PembayaranIuran $payment)
    {
        $payment->load(['rumah', 'penghuni', 'jenis_iuran']);
        return response()->json($payment);
    }

    public function update(Request $request, PembayaranIuran $payment)
    {
        $request->validate([
            'status'  => 'in:lunas,belum',
            'paid_at' => 'nullable|date',
        ]);

        $payment->update($request->only('status', 'paid_at'));
        return response()->json($payment);
    }

    public function destroy(PembayaranIuran $payment)
    {
        $payment->delete();
        return response()->json(['message' => 'Payment deleted']);
    }
}
