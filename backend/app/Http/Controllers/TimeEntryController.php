<?php

namespace App\Http\Controllers;


use App\Models\TimeEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class TimeEntryController extends Controller
{
    public function index()
    {
        $timeEntries = TimeEntry::all();

        return response()->json($timeEntries, 200);
    }

    public function startTimeEntry(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'project_id' => 'nullable',
            'start_time' => 'required|date',
        ]);

        $timeEntry = TimeEntry::create([
            'title' => $validated['title'],
            'project_id' => $validated['project_id'] ?? null,
            'start_time' => $validated['start_time'],
            'end_time' => null,
            'total_seconds' => 0,
        ]);

        return response()->json($timeEntry, 201);
    }

    public function stopTimeEntry(Request $request, $id)
    {
        $validated = $request->validate([
            'end_time' => 'required|date',
        ]);

        $timeEntry = TimeEntry::findOrFail($id);


        $start = Carbon::parse($timeEntry->start_time);
        $end = Carbon::parse($validated['end_time']);

        $totalSeconds = $start->diffInSeconds($end);

        $timeEntry->update([
            'end_time' => $validated['end_time'],
            'total_seconds' => $totalSeconds,
        ]);

        return response()->json($timeEntry, 200);
    }
}
