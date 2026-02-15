<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TimeEntryController;
use App\Http\Controllers\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {

    //Users
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/register', [UserController::class, 'register']);

    //TimeEntries
    Route::get('/time-entries', [TimeEntryController::class, 'index'])->name("timeEntries.index");
    Route::post('/time-entries', [TimeEntryController::class, 'startTimeEntry'])->name("timeEntries.start");
    Route::patch('/time-entries/{id}', [TimeEntryController::class, 'stopTimeEntry'])->name("timeEntries.stop");

    //Projects
    Route::get('/projects', [ProjectController::class, 'index'])->name("projects.index");
});
