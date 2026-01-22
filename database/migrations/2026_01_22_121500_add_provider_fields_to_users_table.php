<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'bank_provider')) {
                $table->string('bank_provider')->nullable()->after('ewallet_number');
            }
            if (!Schema::hasColumn('users', 'ewallet_provider')) {
                $table->string('ewallet_provider')->nullable()->after('bank_provider');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'bank_provider')) {
                $table->dropColumn('bank_provider');
            }
            if (Schema::hasColumn('users', 'ewallet_provider')) {
                $table->dropColumn('ewallet_provider');
            }
        });
    }
};
