<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('external_link_button_text')->nullable()->after('external_link');
        });

        Schema::table('blogs', function (Blueprint $table) {
            $table->string('external_link_button_text')->nullable()->after('external_link');
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('external_link_button_text');
        });

        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn('external_link_button_text');
        });
    }
};
