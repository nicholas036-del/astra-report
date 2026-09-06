<?php

namespace App\Http\Controllers;

use App\Models\Pengumpulan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PemeriksaanController extends Controller
{
    /**
     * Daftar pengumpulan tugas terbaru dari setiap dealer, untuk diperiksa supervisor.
     */
    public function index(): View
    {
        $pengumpulans = Pengumpulan::with(['tugas', 'dealer'])->latest()->paginate(10);

        return view('pemeriksaan.index', compact('pengumpulans'));
    }

    public function show(Pengumpulan $pengumpulan): View
    {
        $pengumpulan->load(['tugas', 'dealer', 'logs']);

        return view('pemeriksaan.show', compact('pengumpulan'));
    }

    public function update(Request $request, Pengumpulan $pengumpulan): RedirectResponse
    {
        $data = $request->validate([
            'status' => 'required|in:DISETUJUI,REVISI,DITOLAK',
            'catatan' => 'nullable|string',
        ]);

        $pengumpulan->update(['status' => $data['status']]);

        $aktivitas = match ($data['status']) {
            'DISETUJUI' => 'Supervisor Menyetujui Pengumpulan',
            'REVISI' => 'Supervisor Minta Revisi',
            'DITOLAK' => 'Supervisor Menolak Hasil Pekerjaan',
        };

        $pengumpulan->logs()->create([
            'aktivitas' => $aktivitas,
            'catatan' => $data['catatan'] ?? null,
            'tanggal' => now(),
        ]);

        return redirect()->route('pemeriksaan.index')->with('success', 'Pemeriksaan tugas berhasil disimpan.');
    }
}
