<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Dealer;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    private const ROLES = ['admin', 'supervisor', 'dealer'];

    public function index(): View
    {
        $users = User::with('dealer')->latest()->paginate(10);

        return view('users.index', compact('users'));
    }

    public function create(): View
    {
        return view('users.create', ['dealers' => Dealer::orderBy('name')->get()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', Rule::in(self::ROLES)],
            'dealer_id' => ['nullable', 'required_if:role,dealer', 'exists:dealers,id'],
        ], [
            'dealer_id.required_if' => 'Dealer wajib dipilih untuk role dealer.',
        ]);

        $data['email'] = strtolower($data['email']);

        if ($data['role'] !== 'dealer') {
            $data['dealer_id'] = null;
        }

        $user = User::create($data);

        ActivityLog::record('create_user', $user, "User {$user->email} ({$user->role}) dibuat");

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user): View
    {
        return view('users.edit', [
            'user' => $user,
            'dealers' => Dealer::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8'],
            'role' => ['required', Rule::in(self::ROLES)],
            'dealer_id' => ['nullable', 'required_if:role,dealer', 'exists:dealers,id'],
        ], [
            'dealer_id.required_if' => 'Dealer wajib dipilih untuk role dealer.',
        ]);

        if ($user->id === $request->user()->id && $data['role'] !== 'admin') {
            return back()->withInput()->withErrors(['role' => 'Kamu tidak bisa menurunkan role akunmu sendiri.']);
        }

        $data['email'] = strtolower($data['email']);

        if ($data['role'] !== 'dealer') {
            $data['dealer_id'] = null;
        }

        if (empty($data['password'])) {
            unset($data['password']);
        }

        $user->update($data);

        ActivityLog::record('update_user', $user, "User {$user->email} ({$user->role}) diperbarui");

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        if ($user->id === $request->user()->id) {
            return redirect()->route('users.index')->with('success', 'Kamu tidak bisa menghapus akunmu sendiri.');
        }

        ActivityLog::record('delete_user', $user, "User {$user->email} ({$user->role}) dihapus");

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }
}