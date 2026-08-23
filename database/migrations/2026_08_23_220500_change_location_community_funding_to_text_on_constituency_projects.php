<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('constituency_projects', function (Blueprint $table) {
            $table->text('location')->nullable()->change();
            $table->text('community')->nullable()->change();
            $table->text('funding_source')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('constituency_projects', function (Blueprint $table) {
            $table->string('location', 255)->nullable()->change();
            $table->string('community', 255)->nullable()->change();
            $table->string('funding_source', 255)->nullable()->change();
        });
    }
};
