<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('theme_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_enabled')->default(false);
            $table->string('primary_color', 7)->default('#4BAF47');
            $table->string('secondary_color', 7)->default('#938A42');
            $table->string('accent_color', 7)->default('#ED8A19');
            $table->string('dark_color', 7)->default('#24231D');
            $table->string('light_color', 7)->default('#F8F7F0');
            $table->string('body_color', 7)->default('#FFFFFF');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('theme_settings');
    }
};
