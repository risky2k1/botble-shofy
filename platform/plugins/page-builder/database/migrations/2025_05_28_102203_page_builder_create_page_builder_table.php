<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        if (! Schema::hasTable('page_builders')) {
            Schema::create('page_builders', function (Blueprint $table) {
                $table->id();
                $table->string('name', 255);
                $table->string('status', 60)->default('published');
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('page_builders_translations')) {
            Schema::create('page_builders_translations', function (Blueprint $table) {
                $table->string('lang_code');
                $table->foreignId('page_builders_id');
                $table->string('name', 255)->nullable();

                $table->primary(['lang_code', 'page_builders_id'], 'page_builders_translations_primary');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('page_builders');
        Schema::dropIfExists('page_builders_translations');
    }
};
