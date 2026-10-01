<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\Dealer;
use App\Models\Department;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $dealer = Dealer::firstOrCreate(
            ['code' => 'D001'],
            ['name' => 'Dealer Test', 'address' => 'Jakarta', 'phone' => '08123456789']
        );

        $department = Department::firstOrCreate(['name' => 'Sales'], ['description' => 'Departemen Sales']);
        $area = Area::firstOrCreate(['name' => 'Jakarta'], ['description' => 'Wilayah Jakarta']);

        $admin = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Admin', 'password' => 'password123', 'role' => 'admin']
        );

        User::updateOrCreate(
            ['email' => 'supervisor@example.com'],
            ['name' => 'Supervisor Test', 'password' => 'password123', 'role' => 'supervisor']
        );

        User::updateOrCreate(
            ['email' => 'dealer@example.com'],
            ['name' => 'Dealer Test', 'password' => 'password123', 'role' => 'dealer', 'dealer_id' => $dealer->id]
        );

        Task::firstOrCreate(
            ['title' => 'Laporan Bulanan'],
            [
                'description' => 'Laporan penjualan bulanan dealer.',
                'department_id' => $department->id,
                'area_id' => $area->id,
                'due_date' => now()->addDays(14),
                'is_active' => true,
                'created_by' => $admin->id,
            ]
        );
    }
}