<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        if(!$user->isAdmin()){
            $request->merge(['user_ids' => [$user->id]]);
        }
        
        $tasks = Task::query()
                    ->when($request->has('user_ids'), function($query) use ($request){
                        return $query->whereIn('user_id', $request->user_ids);
                    })
                    ->when($request->has('status'), function($query) use ($request){
                        return $query->where('status', $request->status);
                    })
                    ->paginate(10);

        return new TaskCollection($tasks);
    }

    public function store(StoreTaskRequest $request)
    {
        $data = $request->validated();
        $task = Task::create($data);
        return new TaskResource($task, Response::HTTP_CREATED, 'Task created successfully');
    }

    public function show(Task $task)
    {
        Gate::authorize('view', $task);
        return new TaskResource($task, Response::HTTP_OK, 'Task fetched successfully');
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        Gate::authorize('update', $task);
        $data = $request->validated();
        $task->update($data);
        return new TaskResource($task, Response::HTTP_OK, 'Task updated successfully');
    }

    public function destroy(Task $task)
    {
        Gate::authorize('delete', $task);
        $task->delete();
        return new TaskResource($task, Response::HTTP_ACCEPTED, 'Task deleted successfully');
    }
}
