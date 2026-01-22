<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            if (!Schema::hasColumn('payments', 'seller_payout_id')) {
                $table->foreignId('seller_payout_id')->nullable()->constrained('user_payouts')->nullOnDelete()->after('order_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            if (Schema::hasColumn('payments', 'seller_payout_id')) {
                $table->dropConstrainedForeignId('seller_payout_id');
            }
        });
    }
};
