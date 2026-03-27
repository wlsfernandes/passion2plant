<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // BLOGS
        Schema::table('blogs', function (Blueprint $table) {
            $table->text('title_en')->change();
            $table->text('title_es')->change();
        });

        // SERVICES
        Schema::table('services', function (Blueprint $table) {
            $table->text('title_en')->change();
            $table->text('title_es')->change();
        });

        // TEAMS
        Schema::table('teams', function (Blueprint $table) {
            $table->text('name')->change();
        });

        // EVENTS
        Schema::table('events', function (Blueprint $table) {
            $table->text('title_en')->change();
            $table->text('title_es')->change();
        });
    }

    public function down(): void
    {
        // Revert back to string (VARCHAR 255)
        Schema::table('blogs', function (Blueprint $table) {
            $table->string('title_en', 255)->change();
            $table->string('title_es', 255)->change();
        });

        Schema::table('services', function (Blueprint $table) {
            $table->string('title_en', 255)->change();
            $table->string('title_es', 255)->change();
        });

        Schema::table('teams', function (Blueprint $table) {
            $table->string('name', 255)->change();
        });

        Schema::table('events', function (Blueprint $table) {
            $table->string('title_en', 255)->change();
            $table->string('title_es', 255)->change();
        });
    }
};
