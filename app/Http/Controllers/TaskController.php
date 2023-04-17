<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TaskController extends Controller {

    public function index() {
        $tasks = Task::orderByDesc('created_at')->get();

        return Inertia::render('Tasks', [
            'title' => 'Show all tasks',
            'tasks' => $tasks->toArray(),
        ]);
    }

    public function store(StoreTaskRequest $request) {
        $validated = $request->validated();
        if ($validated) {
            Task::create($validated);
        } else {
            return redirect()->back()->withErrors($request->errors());
        }
    }

    public function update(Request $request, Task $task) {
        $validated = $request->validate([
            'title' => 'required',
            'body' => 'required',
            'status' => 'required',
        ]);

        $task->update($validated);
        return redirect()->back();
    }

    public function destroy(Task $task) {
        $task->delete();
        return redirect()->back();
    }
}