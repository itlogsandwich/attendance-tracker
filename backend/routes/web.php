<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TimeEntryController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('api/v1')->group(function()
{
    Route::get('/time-entries', [TimeEntryController::class, 'index'])->name("timeEntries.index");
    Route::post('/time-entries', [TimeEntryController::class, 'startTimeEntry'])->name("timeEntries.start");
    Route::patch('/time-entries/{id}', [TimeEntryController::class, 'stopTimeEntry'])->name("timeEntries.stop");
});
