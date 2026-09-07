<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

class DashboardController extends Controller
{
    public function __invoke(): RedirectResponse
    {
        $user = auth()->user();

        return $user->isSupervisor()
            ? redirect()->route('supervisor.tasks.index')
            : redirect()->route('dealer.tasks.index');
    }
}