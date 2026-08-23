<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('achievements', function (Blueprint $table) {
            $table->date('achievement_date')->nullable()->after('category_id');
            $table->foreignId('state_id')->nullable()->after('achievement_date')->constrained('states')->nullOnDelete();
            $table->foreignId('lga_id')->nullable()->after('state_id')->constrained('lgas')->nullOnDelete();
            $table->string('location')->nullable()->after('lga_id');
            $table->text('impact_summary')->nullable()->after('content');
            $table->boolean('featured')->default(false)->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('achievements', function (Blueprint $table) {
            $table->dropForeign(['state_id']);
            $table->dropForeign(['lga_id']);
            $table->dropColumn(['achievement_date', 'state_id', 'lga_id', 'location', 'impact_summary', 'featured']);
        });
    }
};
