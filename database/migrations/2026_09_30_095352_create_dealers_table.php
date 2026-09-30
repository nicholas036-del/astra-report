<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('dealers')) {
            Schema::create('dealers', function (Blueprint $table) {
                $table->id();
                $table->string('code', 30)->unique();
                $table->string('name');
                $table->string('address')->nullable();
                $table->string('phone', 30)->nullable();
                $table->timestamps();
            });

            return;
        }

        Schema::table('dealers', function (Blueprint $table) {
            if (! Schema::hasColumn('dealers', 'code')) {
                $table->string('code', 30)->nullable()->after('id');
            }
            if (! Schema::hasColumn('dealers', 'name')) {
                $table->string('name')->nullable();
            }
            if (! Schema::hasColumn('dealers', 'address')) {
                $table->string('address')->nullable();
            }
            if (! Schema::hasColumn('dealers', 'phone')) {
                $table->string('phone', 30)->nullable();
            }
            if (! Schema::hasColumn('dealers', 'created_at')) {
                $table->timestamps();
            }
        });
    }

    public function down(): void
    {
        //
    }
};