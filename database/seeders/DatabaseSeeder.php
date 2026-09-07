<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\Dealer;
use App\Models\Department;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $supervisor = User::create([
            'name' => 'Supervisor ASTRA',
            'email' => 'supervisor@astra.test',
            'password' => Hash::make('password'),
            'role' => 'supervisor',
        ]);

        $departmentSales = Department::create(['code' => 'SLS', 'name' => 'Sales']);
        $departmentAfterSales = Department::create(['code' => 'AFS', 'name' => 'After Sales']);

        $areaJateng = Area::create(['code' => 'JTG', 'name' => 'Jawa Tengah']);
        $areaJatim = Area::create(['code' => 'JTM', 'name' => 'Jawa Timur']);

        $dealerOne = Dealer::create(['code' => 'D001', 'name' => 'Dealer Semarang']);
        $dealerTwo = Dealer::create(['code' => 'D002', 'name' => 'Dealer Surabaya']);

        User::create([
            'name' => 'Dealer Semarang',
            'email' => 'dealer1@astra.test',
            'password' => Hash::make('password'),
            'role' => 'dealer',
            'dealer_id' => $dealerOne->id,
        ]);

        User::create([
            'name' => 'Dealer Surabaya',
            'email' => 'dealer2@astra.test',
            'password' => Hash::make('password'),
            'role' => 'dealer',
            'dealer_id' => $dealerTwo->id,
        ]);

        Task::create([
            'title' => 'Laporan Penjualan Bulan Ini',
            'department_id' => $departmentSales->id,
            'area_id' => $areaJateng->id,
            'due_at' => now()->addDays(7),
            'created_by' => $supervisor->id,
        ]);

        Task::create([
            'title' => 'Laporan Servis Berkala',
            'department_id' => $departmentAfterSales->id,
            'area_id' => $areaJatim->id,
            'due_at' => now()->addDays(14),
            'created_by' => $supervisor->id,
        ]);
    }
}
