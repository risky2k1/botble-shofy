<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        if (! Schema::hasColumn('ec_product_categories', 'page_id')) {
            Schema::table('ec_product_categories', function (Blueprint $table) {
                $table->unsignedBigInteger('page_id')->nullable();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('ec_product_categories', 'page_id')) {
            Schema::table('ec_product_categories', function (Blueprint $table) {
                $table->dropColumn('page_id');
            });
        }
    }
};
