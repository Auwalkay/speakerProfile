<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('constituency_projects', function (Blueprint $table) {
            $table->string('name')->nullable()->after('title');
            $table->string('community')->nullable()->after('location');
            $table->decimal('latitude', 10, 8)->nullable()->after('community');
            $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
            $table->decimal('budget', 15, 2)->nullable()->after('cost');
            $table->string('funding_source')->nullable()->after('budget');
            $table->date('start_date')->nullable()->after('funding_source');
            $table->date('expected_completion')->nullable()->after('start_date');
            $table->integer('completion_percentage')->default(0)->after('expected_completion');
        });
    }

    public function down(): void
    {
        Schema::table('constituency_projects', function (Blueprint $table) {
            $table->dropColumn([
                'name',
                'community',
                'latitude',
                'longitude',
                'budget',
                'funding_source',
                'start_date',
                'expected_completion',
                'completion_percentage'
            ]);
        });
    }
};
