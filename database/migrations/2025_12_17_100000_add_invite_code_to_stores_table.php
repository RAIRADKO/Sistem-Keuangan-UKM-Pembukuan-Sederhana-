<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Store;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->string('invite_code', 8)->unique()->nullable()->after('phone');
        });

        // Generate invite codes for existing stores
        $stores = Store::whereNull('invite_code')->get();
        foreach ($stores as $store) {
            $store->invite_code = Store::generateInviteCode();
            $store->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->dropColumn('invite_code');
        });
    }
};
