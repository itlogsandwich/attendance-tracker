<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    private function index()
    {
        $projects = Project::all();

        return response()->json($projects, 200);
    }
}
