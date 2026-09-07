<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function index(Request $request): View
    {
        $dealerId = $request->user()->dealer_id;

        $tasks = Task::with(['department', 'area'])
            ->with(['submissions' => fn ($query) => $query->where('dealer_id', $dealerId)])
            ->latest('due_at')
            ->paginate(10);

        return view('dealer.tasks.index', compact('tasks'));
    }

    public function show(Request $request, Task $task): View
    {
        $task->load(['department', 'area']);

        $submission = $task->submissions()
            ->where('dealer_id', $request->user()->dealer_id)
            ->with('logs.actor')
            ->first();

        return view('dealer.tasks.show', compact('task', 'submission'));
    }
}
