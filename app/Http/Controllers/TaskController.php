<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteTaskRequest;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTask;
use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Http\Services\TaskService;
use App\Models\Task;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = QueryBuilder::for(Task::class)
            ->allowedFilters('is_done')
            ->allowedSorts(['created_at', 'id'])
            ->paginate();
        return new TaskCollection($tasks);
    }

    public function store(StoreTaskRequest $request)
    {

        $validated = $request->validated();

        $task = Task::create($validated);

        return new TaskResource($task);
    }

    public function show(Task $task)
    {
        return new TaskResource($task);
    }

    public function update(UpdateTask $request, Task $task)
    {
        $validated = $request->validated();
        $task->update($validated);

        return new TaskResource($task);
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json([
            'message' => 'registro deletado com sucesso!',
            'linha deletada'=> $task
        ]);
    }
}
