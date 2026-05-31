<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Penghuni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PenghuniController extends Controller
{
    public function index()
    {
        $residents = Penghuni::with('houses')->get();
        return response()->json($residents);
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name'    => 'required|string',
            'ktp_photo'    => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'status'       => 'required|in:tetap,kontrak',
            'phone_number' => 'required|string',
            'is_married'   => 'required|boolean',
        ]);

        // Upload foto KTP
        $path = $request->file('ktp_photo')->store('ktp_photos', 'public');

        $resident = Penghuni::create([
            'full_name'    => $request->full_name,
            'ktp_photo'    => $path,
            'status'       => $request->status,
            'phone_number' => $request->phone_number,
            'is_married'   => $request->is_married,
        ]);

        return response()->json($resident, 201);
    }

    public function show(Penghuni $resident)
    {
        $resident->load(['houses', 'payments.feeType']);
        return response()->json($resident);
    }

    public function update(Request $request, Penghuni $resident)
    {
        $request->validate([
            'full_name'    => 'string',
            'ktp_photo'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status'       => 'in:tetap,kontrak',
            'phone_number' => 'string',
            'is_married'   => 'boolean',
        ]);

        $data = $request->except('ktp_photo');

        // Ganti foto KTP jika ada file baru
        if ($request->hasFile('ktp_photo')) {
            Storage::disk('public')->delete($resident->ktp_photo);
            $data['ktp_photo'] = $request->file('ktp_photo')
                ->store('ktp_photos', 'public');
        }

        $resident->update($data);
        return response()->json($resident);
    }

    public function destroy(Penghuni $resident)
    {
        // SoftDelete — data tidak hilang permanen
        $resident->delete();
        return response()->json(['message' => 'Resident deleted']);
    }
}
