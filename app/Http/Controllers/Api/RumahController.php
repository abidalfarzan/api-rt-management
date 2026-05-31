<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PenghuniRumah;
use App\Models\Rumah;
use Illuminate\Http\Request;

class RumahController extends Controller
{
    public function index()
    {
        $houses = Rumah::with(['residents' => function($q) {
            $q->wherePivot('is_active', true);
        }])->get();

        return response()->json($houses);
    }

    public function store(Request $request)
    {
        $request->validate([
            'house_number' => 'required|string|unique:rumah,house_number',
            'address'      => 'nullable|string',
            'status'       => 'in:dihuni,tidak_dihuni',
        ]);

        $house = Rumah::create($request->all());
        return response()->json($house, 201);
    }

    public function show(Rumah $house)
    {
        $house->load([
            'residents',          // semua penghuni (historis)
            'payments.feeType',   // history pembayaran
            'payments.resident',
        ]);

        return response()->json($house);
    }

    public function update(Request $request, Rumah $house)
    {
        $request->validate([
            'house_number' => 'string|unique:rumah,house_number,' . $house->id,
            'address'      => 'nullable|string',
            'status'       => 'in:dihuni,tidak_dihuni',
        ]);

        $house->update($request->all());
        return response()->json($house);
    }

    public function destroy(Rumah $house)
    {
        $house->delete();
        return response()->json(['message' => 'House deleted']);
    }

    // Assign penghuni ke rumah
    public function assignResident(Request $request, Rumah $house)
    {
        $request->validate([
            'penghuni_id' => 'required|exists:penghuni,id',
            'start_date'  => 'required|date',
        ]);

        // Nonaktifkan penghuni lama dulu
        PenghuniRumah::where('rumah_id', $house->id)
            ->where('is_active', true)
            ->update([
                'is_active' => false,
                'end_date'  => now(),
            ]);

        // Assign penghuni baru
        PenghuniRumah::create([
            'rumah_id'    => $house->id,
            'penghuni_id' => $request->penghuni_id,
            'start_date'  => $request->start_date,
            'is_active'   => true,
        ]);

        // Update status rumah
        $house->update(['status' => 'dihuni']);

        return response()->json(['message' => 'Resident assigned successfully']);
    }

    // Unassign penghuni dari rumah
    public function unassignResident(Request $request, Rumah $house)
    {
        PenghuniRumah::where('rumah_id', $house->id)
            ->where('is_active', true)
            ->update([
                'is_active' => false,
                'end_date'  => now(),
            ]);

        $house->update(['status' => 'tidak_dihuni']);

        return response()->json(['message' => 'Resident unassigned successfully']);
    }
}
