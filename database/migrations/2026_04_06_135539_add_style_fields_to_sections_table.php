<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('sections', function (Blueprint $table) {

            // Spacing
            $table->integer('margin_top')->default(0)->after('is_published');
            $table->integer('margin_bottom')->default(0)->after('margin_top');
            $table->integer('padding_top')->default(0)->after('margin_bottom');
            $table->integer('padding_bottom')->default(0)->after('padding_top');

            // Colors
            $table->string('background_color')->nullable()->after('padding_bottom');
            $table->string('text_color')->nullable()->after('background_color');

            // Background image
            $table->string('background_image_url')->nullable()->after('text_color');

            // Layout helpers
            $table->string('container')->default('container')->after('background_image_url');
            $table->string('custom_class')->nullable()->after('container');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sections', function (Blueprint $table) {

            $table->dropColumn([
                'margin_top',
                'margin_bottom',
                'padding_top',
                'padding_bottom',
                'background_color',
                'text_color',
                'background_image_url',
                'container',
                'custom_class',
            ]);
        });
    }
};
