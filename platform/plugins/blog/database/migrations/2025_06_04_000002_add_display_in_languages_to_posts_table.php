<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        if (! Schema::hasColumn('posts', 'display_in_languages')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->text('display_in_languages')->nullable();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('posts', 'display_in_languages')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->dropColumn('display_in_languages');
            });
        }
    }
};
