<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('platform_settings', function (Blueprint $table) {
            $table->id();

            $table->string('app_name')->default('PitchFlow');
            $table->string('app_tagline')->nullable();

            $table->string('support_email')->nullable();
            $table->string('platform_url')->nullable();

            $table->string('logo_path')->nullable();
            $table->string('favicon_path')->nullable();

            $table->string('primary_color', 20)->nullable();
            $table->string('accent_color', 20)->nullable();

            $table->string('default_meta_title')->nullable();
            $table->text('default_meta_description')->nullable();

            $table->boolean('show_platform_branding')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('platform_settings');
    }
};
