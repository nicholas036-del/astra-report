<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Department;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function index(): View
    {
        $tasks = Task::with(['department', 'area'])
            ->withCount('submissions')
            ->latest()
            ->paginate(10);

        return view('supervisor.tasks.index', compact('tasks'));
    }

    public function create(): View
    {
        $departments = Department::orderBy('name')->get();
        $areas = Area::orderBy('name')->get();

        return view('supervisor.tasks.create', compact('departments', 'areas'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        $request->user()->tasks()->create($data);

        return redirect()->route('supervisor.tasks.index')
            ->with('status', 'Tugas baru berhasil dibuat.');
    }

    public function edit(Task $task): View
    {
        abort_if($task->isLocked(), 403, 'Tugas tidak dapat diedit karena sudah ada dealer yang mengumpulkan.');

        $departments = Department::orderBy('name')->get();
        $areas = Area::orderBy('name')->get();

        return view('supervisor.tasks.edit', compact('task', 'departments', 'areas'));
    }

    public function update(Request $request, Task $task): RedirectResponse
    {
        abort_if($task->isLocked(), 403, 'Tugas tidak dapat diedit karena sudah ada dealer yang mengumpulkan.');

        $task->update($this->validated($request));

        return redirect()->route('supervisor.tasks.index')
            ->with('status', 'Tugas berhasil diperbarui.');
    }

    public function destroy(Task $task): RedirectResponse
    {
        abort_if($task->isLocked(), 403, 'Tugas tidak dapat dihapus karena sudah ada dealer yang mengumpulkan.');

        $task->delete();

        return redirect()->route('supervisor.tasks.index')
            ->with('status', 'Tugas berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'department_id' => ['required', 'exists:departments,id'],
            'area_id' => ['required', 'exists:areas,id'],
            'due_at' => ['required', 'date'],
        ]);
    }
}
