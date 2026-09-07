<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\Area;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AreaController extends Controller
{
    public function index(): View
    {
        $areas = Area::latest()->paginate(10);

        return view('supervisor.areas.index', compact('areas'));
    }

    public function create(): View
    {
        return view('supervisor.areas.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'code' => ['required', 'string', 'max:50', 'unique:areas,code'],
            'name' => ['required', 'string', 'max:255'],
        ]);

        Area::create($data);

        return redirect()->route('supervisor.areas.index')
            ->with('status', 'Area baru berhasil ditambahkan.');
    }

    public function edit(Area $area): View
    {
        return view('supervisor.areas.edit', compact('area'));
    }

    public function update(Request $request, Area $area): RedirectResponse
    {
        $data = $request->validate([
            'code' => ['required', 'string', 'max:50', 'unique:areas,code,'.$area->id],
            'name' => ['required', 'string', 'max:255'],
        ]);

        $area->update($data);

        return redirect()->route('supervisor.areas.index')
            ->with('status', 'Area berhasil diperbarui.');
    }

    public function destroy(Area $area): RedirectResponse
    {
        $area->delete();

        return redirect()->route('supervisor.areas.index')
            ->with('status', 'Area berhasil dihapus.');
    }
}
