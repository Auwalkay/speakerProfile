<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('constituency_projects', function (Blueprint $table) {
            $table->index(['status', 'published_at']);
            $table->index('status_project');
        });

        Schema::table('news', function (Blueprint $table) {
            $table->index(['status', 'published_at']);
        });

        Schema::table('bills', function (Blueprint $table) {
            $table->index(['status', 'published_at']);
        });

        Schema::table('motions', function (Blueprint $table) {
            $table->index(['status', 'published_at']);
        });

        Schema::table('achievements', function (Blueprint $table) {
            $table->index(['status', 'published_at']);
        });

        Schema::table('speeches', function (Blueprint $table) {
            $table->index(['status', 'published_at']);
        });

        Schema::table('publications', function (Blueprint $table) {
            $table->index(['status', 'published_at']);
        });
    }

    public function down(): void
    {
        Schema::table('constituency_projects', function (Blueprint $table) {
            $table->dropIndex(['status', 'published_at']);
            $table->dropIndex(['status_project']);
        });

        Schema::table('news', function (Blueprint $table) {
            $table->dropIndex(['status', 'published_at']);
        });

        Schema::table('bills', function (Blueprint $table) {
            $table->dropIndex(['status', 'published_at']);
        });

        Schema::table('motions', function (Blueprint $table) {
            $table->dropIndex(['status', 'published_at']);
        });

        Schema::table('achievements', function (Blueprint $table) {
            $table->dropIndex(['status', 'published_at']);
        });

        Schema::table('speeches', function (Blueprint $table) {
            $table->dropIndex(['status', 'published_at']);
        });

        Schema::table('publications', function (Blueprint $table) {
            $table->dropIndex(['status', 'published_at']);
        });
    }
};
