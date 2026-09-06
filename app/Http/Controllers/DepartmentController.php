<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DepartmentController extends Controller
{
    public function index(): View
    {
        $departments = Department::latest()->paginate(10);

        return view('departments.index', compact('departments'));
    }

    public function create(): View
    {
        return view('departments.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'code' => 'required|string|max:50|unique:departments,code',
            'name' => 'required|string|max:150',
        ]);

        Department::create($data);

        return redirect()->route('departments.index')->with('success', 'Department berhasil ditambahkan.');
    }

    public function edit(Department $department): View
    {
        return view('departments.edit', compact('department'));
    }

    public function update(Request $request, Department $department): RedirectResponse
    {
        $data = $request->validate([
            'code' => 'required|string|max:50|unique:departments,code,' . $department->id,
            'name' => 'required|string|max:150',
        ]);

        $department->update($data);

        return redirect()->route('departments.index')->with('success', 'Department berhasil diperbarui.');
    }

    public function destroy(Department $department): RedirectResponse
    {
        $department->delete();

        return redirect()->route('departments.index')->with('success', 'Department berhasil dihapus.');
    }
}
