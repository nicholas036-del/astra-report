<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('users', 'dealer_id')) {
            return;
        }

        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('dealer_id')->nullable()->constrained()->nullOnDelete();
        });
    }

    public function down(): void
    {
        //
    }
};