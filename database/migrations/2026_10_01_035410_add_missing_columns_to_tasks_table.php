<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            if (! Schema::hasColumn('tasks', 'title')) {
                $table->string('title')->nullable();
            }
            if (! Schema::hasColumn('tasks', 'description')) {
                $table->text('description')->nullable();
            }
            if (! Schema::hasColumn('tasks', 'department_id')) {
                $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
            }
            if (! Schema::hasColumn('tasks', 'area_id')) {
                $table->foreignId('area_id')->nullable()->constrained()->nullOnDelete();
            }
            if (! Schema::hasColumn('tasks', 'due_date')) {
                $table->date('due_date')->nullable();
            }
            if (! Schema::hasColumn('tasks', 'is_active')) {
                $table->boolean('is_active')->default(true);
            }
            if (! Schema::hasColumn('tasks', 'created_by')) {
                $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        //
    }
};