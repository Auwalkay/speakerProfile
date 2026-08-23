<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('constituency_projects', function (Blueprint $table) {
            $table->integer('completion_percentage')->nullable()->default(0)->change();
        });
    }

    public function down(): void
    {
        Schema::table('constituency_projects', function (Blueprint $table) {
            $table->integer('completion_percentage')->default(0)->change();
        });
    }
};
