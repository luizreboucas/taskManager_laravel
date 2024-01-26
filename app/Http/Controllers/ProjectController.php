<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProject;
use App\Http\Resources\ProjectCollection;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = QueryBuilder::for(Project::class)
            ->allowedIncludes('tasks')
            ->paginate();
        return new ProjectCollection($projects);
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

    public function show(Request $request, Project $project)
    {
        return new ProjectResource(($project)->load('tasks'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title'=>'required'
        ]);

        $project->update($validated);

        return new ProjectResource($project);
    }

    public function destroy(Request $request, Project $project)
    {
        $project->delete();
        return response()->json([
            'message'=> 'project deleted successfully',
            'project' => $project
        ]);
    }
}
