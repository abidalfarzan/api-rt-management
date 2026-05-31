<?php

use App\Http\Controllers\Api\LaporanController;
use App\Http\Controllers\Api\PembayaranIuranController;
use App\Http\Controllers\Api\PengeluaranController;
use App\Http\Controllers\Api\PenghuniController;
use App\Http\Controllers\Api\RumahController;
use Illuminate\Support\Facades\Route; // ✅ Ganti ini

Route::apiResource('houses', RumahController::class);
Route::apiResource('residents', PenghuniController::class);
Route::apiResource('payments', PembayaranIuranController::class);
Route::apiResource('expenses', PengeluaranController::class);

Route::post('houses/{house}/assign-resident', [RumahController::class, 'assignResident']);
Route::post('houses/{house}/unassign-resident', [RumahController::class, 'unassignResident']);
Route::get('reports/summary', [LaporanController::class, 'summary']);
Route::get('reports/monthly/{year}/{month}', [LaporanController::class, 'monthly']);