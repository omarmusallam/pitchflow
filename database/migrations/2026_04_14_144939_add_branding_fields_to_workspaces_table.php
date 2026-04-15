<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('workspaces', function (Blueprint $table) {
            $table->string('brand_name')->nullable()->after('name');
            $table->string('logo_path')->nullable()->after('brand_name');

            $table->string('primary_color', 20)->nullable()->after('logo_path');
            $table->string('accent_color', 20)->nullable()->after('primary_color');

            $table->string('company_email')->nullable()->after('accent_color');
            $table->string('company_phone')->nullable()->after('company_email');
            $table->string('company_website')->nullable()->after('company_phone');

            $table->string('company_address')->nullable()->after('company_website');
            $table->string('company_city')->nullable()->after('company_address');
            $table->string('company_country')->nullable()->after('company_city');

            $table->text('email_signature')->nullable()->after('company_country');
            $table->text('proposal_footer')->nullable()->after('email_signature');

            $table->unsignedInteger('default_validity_days')->default(7)->after('proposal_footer');
            $table->boolean('show_branding_on_public_pages')->default(true)->after('default_validity_days');
            $table->boolean('show_branding_on_pdf')->default(true)->after('show_branding_on_public_pages');
        });
    }

    public function down(): void
    {
        Schema::table('workspaces', function (Blueprint $table) {
            $table->dropColumn([
                'brand_name',
                'logo_path',
                'primary_color',
                'accent_color',
                'company_email',
                'company_phone',
                'company_website',
                'company_address',
                'company_city',
                'company_country',
                'email_signature',
                'proposal_footer',
                'default_validity_days',
                'show_branding_on_public_pages',
                'show_branding_on_pdf',
            ]);
        });
    }
};
