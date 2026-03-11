<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::rename('service_packages', 'categories');

        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['price', 'description']);
        });

        Schema::table('subscriptions', function (Blueprint $table) {
            $table->renameColumn('service_package_id', 'category_id');
        });
    }

    public function down(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->renameColumn('category_id', 'service_package_id');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->decimal('price', 12, 2)->after('name')->default(0);
            $table->text('description')->nullable()->after('price');
        });

        Schema::rename('categories', 'service_packages');
    }
};
