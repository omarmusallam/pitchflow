<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('proposals', function (Blueprint $table) {
            $table->text('follow_up_note')->nullable()->after('notes');
            $table->timestamp('followed_up_at')->nullable()->after('follow_up_note');
            $table->timestamp('follow_up_remind_at')->nullable()->after('followed_up_at');
        });
    }

    public function down(): void
    {
        Schema::table('proposals', function (Blueprint $table) {
            $table->dropColumn([
                'follow_up_note',
                'followed_up_at',
                'follow_up_remind_at',
            ]);
        });
    }
};
