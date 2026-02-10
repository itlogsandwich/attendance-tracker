<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TimeEntryController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function()
{
    Route::get('/time-entries', [TimeEntryController::class, 'index'])->name("timeEntries.index");
    Route::post('/time-entries', [TimeEntryController::class, 'startTimeEntry'])->name("timeEntries.start");
    Route::patch('/time-entries/{id}', [TimeEntryController::class, 'stopTimeEntry'])->name("timeEntries.stop");
});
