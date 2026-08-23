<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bills', function (Blueprint $table) {
            $table->string('category')->nullable()->after('bill_number');
            $table->date('date_introduced')->nullable()->after('category');
            $table->date('date_passed')->nullable()->after('date_introduced');
            $table->string('assent_status')->nullable()->after('date_passed');
            $table->boolean('featured')->default(false)->after('status');
        });

        Schema::table('motions', function (Blueprint $table) {
            $table->date('date')->nullable()->after('sponsor');
            $table->text('documents')->nullable()->after('description');
        });
    }

    public function down(): void
    {
        Schema::table('bills', function (Blueprint $table) {
            $table->dropColumn(['category', 'date_introduced', 'date_passed', 'assent_status', 'featured']);
        });

        Schema::table('motions', function (Blueprint $table) {
            $table->dropColumn(['date', 'documents']);
        });
    }
};
