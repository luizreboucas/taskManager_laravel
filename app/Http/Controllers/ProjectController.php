<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProject;
use App\Http\Resources\ProjectCollection;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index()
    {
        return new ProjectCollection(Project::query()->where('creator_id', Auth::id()));
    }

    public function store(StoreProject $request)
    {
        $validated = $request->validated();

        $project = Auth::user()->projects()->create($validated);

        if($project)
        {
            return new ProjectResource($project);
        }
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title'=>'required'
        ]);

        $project->update($validated);

        return new ProjectResource($project);
    }
}
