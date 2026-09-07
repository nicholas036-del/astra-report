<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\Dealer;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class DealerController extends Controller
{
    public function index(): View
    {
        $dealers = Dealer::with('user')->latest()->paginate(10);

        return view('supervisor.dealers.index', compact('dealers'));
    }

    public function create(): View
    {
        return view('supervisor.dealers.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'code' => ['required', 'string', 'max:50', 'unique:dealers,code'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        DB::transaction(function () use ($data): void {
            $dealer = Dealer::create([
                'code' => $data['code'],
                'name' => $data['name'],
            ]);

            User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => 'dealer',
                'dealer_id' => $dealer->id,
            ]);
        });

        return redirect()->route('supervisor.dealers.index')
            ->with('status', 'Dealer baru berhasil ditambahkan.');
    }

    public function edit(Dealer $dealer): View
    {
        return view('supervisor.dealers.edit', compact('dealer'));
    }

    public function update(Request $request, Dealer $dealer): RedirectResponse
    {
        $data = $request->validate([
            'code' => ['required', 'string', 'max:50', 'unique:dealers,code,'.$dealer->id],
            'name' => ['required', 'string', 'max:255'],
        ]);

        $dealer->update($data);

        return redirect()->route('supervisor.dealers.index')
            ->with('status', 'Data dealer berhasil diperbarui.');
    }

    public function destroy(Dealer $dealer): RedirectResponse
    {
        $dealer->delete();

        return redirect()->route('supervisor.dealers.index')
            ->with('status', 'Data dealer berhasil dihapus.');
    }
}
