<?php

namespace App\Http\Controllers;

use App\Models\Dealer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DealerController extends Controller
{
    public function index(): View
    {
        $dealers = Dealer::latest()->paginate(10);

        return view('dealers.index', compact('dealers'));
    }

    public function create(): View
    {
        return view('dealers.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'code' => 'required|string|max:50|unique:dealers,code',
            'name' => 'required|string|max:150',
        ]);

        Dealer::create($data);

        return redirect()->route('dealers.index')->with('success', 'Dealer berhasil ditambahkan.');
    }

    public function edit(Dealer $dealer): View
    {
        return view('dealers.edit', compact('dealer'));
    }

    public function update(Request $request, Dealer $dealer): RedirectResponse
    {
        $data = $request->validate([
            'code' => 'required|string|max:50|unique:dealers,code,' . $dealer->id,
            'name' => 'required|string|max:150',
        ]);

        $dealer->update($data);

        return redirect()->route('dealers.index')->with('success', 'Dealer berhasil diperbarui.');
    }

    public function destroy(Dealer $dealer): RedirectResponse
    {
        $dealer->delete();

        return redirect()->route('dealers.index')->with('success', 'Dealer berhasil dihapus.');
    }
}
