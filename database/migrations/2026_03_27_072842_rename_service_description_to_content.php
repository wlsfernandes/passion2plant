<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->renameColumn('description_en', 'content_en');
            $table->renameColumn('description_es', 'content_es');
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->renameColumn('content_en', 'description_en');
            $table->renameColumn('content_es', 'description_es');
        });
    }
};
