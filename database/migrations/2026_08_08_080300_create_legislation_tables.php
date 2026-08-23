<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('bill_number')->nullable();
            $table->string('sponsor')->nullable();
            $table->string('status_legislative')->default('First Reading'); // First Reading, Second Reading, Committee Stage, Report Stage, Third Reading, Passed House, Passed Senate, Assented, Vetoed
            $table->text('summary')->nullable();
            $table->longText('description')->nullable();
            $table->string('document_path')->nullable();
            
            // Workflow columns
            $table->string('status')->default('draft'); // draft, review, approved, published, archived
            $table->timestamp('published_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            
            // SEO columns
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();

            $table->timestamps();
        });

        Schema::create('motions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('sponsor')->nullable();
            $table->date('date_presented')->nullable();
            $table->text('summary')->nullable();
            $table->longText('description')->nullable();
            
            // Workflow columns
            $table->string('status')->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();

            // SEO columns
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();

            $table->timestamps();
        });

        Schema::create('legislative_works', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('type')->default('Committee'); // Committee, Oversight, Plenary, Constituency Engagement
            $table->text('summary')->nullable();
            $table->longText('description')->nullable();

            // Workflow columns
            $table->string('status')->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();

            // SEO columns
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('legislative_works');
        Schema::dropIfExists('motions');
        Schema::dropIfExists('bills');
    }
};
