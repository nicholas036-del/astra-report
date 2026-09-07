<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DepartmentController extends Controller
{
    public function index(): View
    {
        $departments = Department::latest()->paginate(10);

        return view('supervisor.departments.index', compact('departments'));
    }

    public function create(): View
    {
        return view('supervisor.departments.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'code' => ['required', 'string', 'max:50', 'unique:departments,code'],
            'name' => ['required', 'string', 'max:255'],
        ]);

        Department::create($data);

        return redirect()->route('supervisor.departments.index')
            ->with('status', 'Departemen baru berhasil ditambahkan.');
    }

    public function edit(Department $department): View
    {
        return view('supervisor.departments.edit', compact('department'));
    }

    public function update(Request $request, Department $department): RedirectResponse
    {
        $data = $request->validate([
            'code' => ['required', 'string', 'max:50', 'unique:departments,code,'.$department->id],
            'name' => ['required', 'string', 'max:255'],
        ]);

        $department->update($data);

        return redirect()->route('supervisor.departments.index')
            ->with('status', 'Departemen berhasil diperbarui.');
    }

    public function destroy(Department $department): RedirectResponse
    {
        $department->delete();

        return redirect()->route('supervisor.departments.index')
            ->with('status', 'Departemen berhasil dihapus.');
    }
}
