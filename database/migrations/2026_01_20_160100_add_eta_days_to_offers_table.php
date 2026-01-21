<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('offers', 'eta_days')) {
            Schema::table('offers', function (Blueprint $table) {
                $table->unsignedInteger('eta_days')->default(1)->after('price');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('offers', 'eta_days')) {
            Schema::table('offers', function (Blueprint $table) {
                $table->dropColumn('eta_days');
            });
        }
    }
};

