<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Department;
use App\Models\Tugas;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TugasController extends Controller
{
    public function index(): View
    {
        $tugas = Tugas::with(['department', 'area'])->latest()->paginate(10);

        return view('tugas.index', compact('tugas'));
    }

    public function create(): View
    {
        $departments = Department::orderBy('name')->get();
        $areas = Area::orderBy('name')->get();

        return view('tugas.create', compact('departments', 'areas'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => 'required|string|max:200',
            'department_id' => 'required|exists:departments,id',
            'area_id' => 'required|exists:areas,id',
            'due_at' => 'required|date',
        ]);

        $data['created_by'] = $request->user()->id;

        Tugas::create($data);

        return redirect()->route('tugas.index')->with('success', 'Tugas berhasil ditambahkan.');
    }

    public function edit(Tugas $tugas): View|RedirectResponse
    {
        if ($tugas->hasSubmission()) {
            return redirect()->route('tugas.index')
                ->with('error', 'Tugas sudah dikumpulkan dealer, tidak dapat diedit.');
        }

        $departments = Department::orderBy('name')->get();
        $areas = Area::orderBy('name')->get();

        return view('tugas.edit', compact('tugas', 'departments', 'areas'));
    }

    public function update(Request $request, Tugas $tugas): RedirectResponse
    {
        if ($tugas->hasSubmission()) {
            return redirect()->route('tugas.index')
                ->with('error', 'Tugas sudah dikumpulkan dealer, tidak dapat diedit.');
        }

        $data = $request->validate([
            'title' => 'required|string|max:200',
            'department_id' => 'required|exists:departments,id',
            'area_id' => 'required|exists:areas,id',
            'due_at' => 'required|date',
        ]);

        $tugas->update($data);

        return redirect()->route('tugas.index')->with('success', 'Tugas berhasil diperbarui.');
    }

    public function destroy(Tugas $tugas): RedirectResponse
    {
        if ($tugas->hasSubmission()) {
            return redirect()->route('tugas.index')
                ->with('error', 'Tugas sudah dikumpulkan dealer, tidak dapat dihapus.');
        }

        $tugas->delete();

        return redirect()->route('tugas.index')->with('success', 'Tugas berhasil dihapus.');
    }
}
