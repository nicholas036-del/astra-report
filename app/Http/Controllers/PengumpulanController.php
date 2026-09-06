<?php

namespace App\Http\Controllers;

use App\Models\Pengumpulan;
use App\Models\Tugas;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PengumpulanController extends Controller
{
    /**
     * Daftar tugas yang bisa/sudah dikumpulkan oleh dealer yang sedang login.
     */
    public function index(Request $request): View
    {
        $dealerId = $request->user()->dealer_id;

        $tugas = Tugas::with(['department', 'area', 'pengumpulans' => function ($q) use ($dealerId) {
            $q->where('dealer_id', $dealerId)->latest();
        }])->latest()->paginate(10);

        return view('pengumpulan.index', compact('tugas'));
    }

    public function create(Request $request, Tugas $tugas): View|RedirectResponse
    {
        $dealerId = $request->user()->dealer_id;
        $existing = Pengumpulan::where('tugas_id', $tugas->id)
            ->where('dealer_id', $dealerId)
            ->latest()
            ->first();

        if ($existing && ! $existing->canBeResubmitted()) {
            return redirect()->route('pengumpulan.index')
                ->with('error', 'Tugas ini tidak dapat dikumpulkan lagi.');
        }

        if (! $existing && $tugas->isExpired()) {
            return redirect()->route('pengumpulan.index')
                ->with('error', 'Batas waktu tugas ini sudah lewat.');
        }

        return view('pengumpulan.create', compact('tugas', 'existing'));
    }

    public function store(Request $request, Tugas $tugas): RedirectResponse
    {
        $dealerId = $request->user()->dealer_id;

        $data = $request->validate([
            'drive_link' => 'required|url|max:255',
            'catatan' => 'nullable|string',
        ]);

        $existing = Pengumpulan::where('tugas_id', $tugas->id)
            ->where('dealer_id', $dealerId)
            ->latest()
            ->first();

        if ($existing && ! $existing->canBeResubmitted()) {
            return redirect()->route('pengumpulan.index')
                ->with('error', 'Tugas ini tidak dapat dikumpulkan lagi.');
        }

        if (! $existing && $tugas->isExpired()) {
            return redirect()->route('pengumpulan.index')
                ->with('error', 'Batas waktu tugas ini sudah lewat.');
        }

        $isResubmission = (bool) $existing;

        $pengumpulan = Pengumpulan::create([
            'tugas_id' => $tugas->id,
            'dealer_id' => $dealerId,
            'drive_link' => $data['drive_link'],
            'catatan' => $data['catatan'] ?? null,
            'status' => 'REVISI',
        ]);

        $pengumpulan->logs()->create([
            'aktivitas' => $isResubmission ? 'Pengumpulan Ulang' : 'Kumpul',
            'catatan' => $data['catatan'] ?? null,
            'tanggal' => now(),
        ]);

        return redirect()->route('pengumpulan.index')->with('success', 'Tugas berhasil dikumpulkan.');
    }

    public function show(Tugas $tugas, Pengumpulan $pengumpulan): View
    {
        $pengumpulan->load('logs');

        return view('pengumpulan.show', compact('tugas', 'pengumpulan'));
    }
}
