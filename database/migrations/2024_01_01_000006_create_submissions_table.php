<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('submissions')) {
            return;
        }

        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained()->cascadeOnDelete();
            $table->foreignId('dealer_id')->constrained()->cascadeOnDelete();
            $table->foreignId('submitted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('content');
            $table->string('file_path')->nullable();
            $table->string('status', 20)->default('MENUNGGU'); // MENUNGGU, DISETUJUI, REVISI, DITOLAK
            $table->text('reviewer_note')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->unsignedInteger('resubmit_count')->default(0);
            $table->timestamps();

            $table->unique(['task_id', 'dealer_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};