<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->text('excerpt')->nullable()->after('summary');
            $table->string('author')->nullable()->after('featured_image');
            $table->boolean('featured')->default(false)->after('status');
        });

        Schema::table('speeches', function (Blueprint $table) {
            $table->string('event')->nullable()->after('delivered_at');
            $table->date('speech_date')->nullable()->after('event');
            $table->longText('transcript')->nullable()->after('content');
            $table->string('video_url')->nullable()->after('transcript');
        });

        Schema::table('publications', function (Blueprint $table) {
            $table->string('category')->nullable()->after('slug');
            $table->date('publication_date')->nullable()->after('document_path');
        });
    }

    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn(['excerpt', 'author', 'featured']);
        });

        Schema::table('speeches', function (Blueprint $table) {
            $table->dropColumn(['event', 'speech_date', 'transcript', 'video_url']);
        });

        Schema::table('publications', function (Blueprint $table) {
            $table->dropColumn(['category', 'publication_date']);
        });
    }
};
