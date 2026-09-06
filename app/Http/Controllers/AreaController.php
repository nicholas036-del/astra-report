<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AreaController extends Controller
{
    public function index(): View
    {
        $areas = Area::latest()->paginate(10);

        return view('areas.index', compact('areas'));
    }

    public function create(): View
    {
        return view('areas.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'code' => 'required|string|max:50|unique:areas,code',
            'name' => 'required|string|max:150',
        ]);

        Area::create($data);

        return redirect()->route('areas.index')->with('success', 'Area berhasil ditambahkan.');
    }

    public function edit(Area $area): View
    {
        return view('areas.edit', compact('area'));
    }

    public function update(Request $request, Area $area): RedirectResponse
    {
        $data = $request->validate([
            'code' => 'required|string|max:50|unique:areas,code,' . $area->id,
            'name' => 'required|string|max:150',
        ]);

        $area->update($data);

        return redirect()->route('areas.index')->with('success', 'Area berhasil diperbarui.');
    }

    public function destroy(Area $area): RedirectResponse
    {
        $area->delete();

        return redirect()->route('areas.index')->with('success', 'Area berhasil dihapus.');
    }
}
