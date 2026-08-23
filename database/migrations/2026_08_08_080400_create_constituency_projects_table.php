<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('constituency_projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->foreignId('category_id')->constrained('project_categories')->cascadeOnDelete();
            $table->foreignId('state_id')->constrained('states')->cascadeOnDelete();
            $table->foreignId('lga_id')->constrained('lgas')->cascadeOnDelete();
            $table->string('location')->nullable();
            $table->string('status_project')->default('Proposed'); // Proposed, Ongoing, Completed, Commissioned
            $table->decimal('cost', 15, 2)->nullable();
            $table->integer('beneficiaries_count')->nullable();
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
        Schema::dropIfExists('constituency_projects');
    }
};
