<?php

namespace App\Http\Controllers;

use App\Models\Dealer;
use App\Models\Submission;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $user = $request->user();

        $query = Submission::query();

        if ($user->isDealer()) {
            $query->where('dealer_id', $user->dealer_id);
        }

        $counts = (clone $query)
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $stats = [
            Submission::MENUNGGU => $counts[Submission::MENUNGGU] ?? 0,
            Submission::DISETUJUI => $counts[Submission::DISETUJUI] ?? 0,
            Submission::REVISI => $counts[Submission::REVISI] ?? 0,
            Submission::DITOLAK => $counts[Submission::DITOLAK] ?? 0,
        ];

        $activeTasks = Task::where('is_active', true)->count();

        $notSubmitted = null;
        $pending = collect();
        $dealerCount = null;

        if ($user->isDealer()) {
            $notSubmitted = Task::where('is_active', true)
                ->whereDoesntHave('submissions', fn ($q) => $q->where('dealer_id', $user->dealer_id))
                ->count();
        } else {
            $pending = Submission::with(['dealer', 'task'])
                ->where('status', Submission::MENUNGGU)
                ->latest('submitted_at')
                ->limit(5)
                ->get();

            if ($user->isAdmin()) {
                $dealerCount = Dealer::count();
            }
        }

        return view('dashboard', compact('stats', 'activeTasks', 'notSubmitted', 'pending', 'dealerCount'));
    }
}