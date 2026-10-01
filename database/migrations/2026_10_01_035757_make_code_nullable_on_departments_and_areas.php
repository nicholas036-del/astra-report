<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        foreach (['departments', 'areas'] as $tableName) {
            if (Schema::hasColumn($tableName, 'code')) {
                Schema::table($tableName, function ($table) {
                    $table->string('code', 50)->nullable()->change();
                });
            }
        }
    }

    public function down(): void
    {
        //
    }
};