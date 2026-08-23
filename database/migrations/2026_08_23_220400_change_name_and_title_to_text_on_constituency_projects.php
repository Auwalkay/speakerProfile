<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('constituency_projects', function (Blueprint $table) {
            $table->text('name')->nullable()->change();
            $table->text('title')->nullable()->change();
            $table->string('slug', 500)->change();
        });
    }

    public function down(): void
    {
        Schema::table('constituency_projects', function (Blueprint $table) {
            $table->string('name', 255)->nullable()->change();
            $table->string('title', 255)->nullable()->change();
            $table->string('slug', 255)->change();
        });
    }
};
