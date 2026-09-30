<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('role', 50)->default('dealer')->change();
            });
        } else {
            Schema::table('users', function (Blueprint $table) {
                $table->string('role', 50)->default('dealer')->after('email'); // dealer, supervisor, admin
            });
        }
    }

    public function down(): void
    {
        //
    }
};