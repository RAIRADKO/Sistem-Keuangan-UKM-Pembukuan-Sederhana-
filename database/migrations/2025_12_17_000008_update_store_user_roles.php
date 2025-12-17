<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, update existing 'staff' to 'kasir'
        DB::table('store_user')->where('role', 'staff')->update(['role' => 'kasir']);
        
        // Then alter the column to support new enum values
        // Note: For MySQL, we need to modify the enum
        DB::statement("ALTER TABLE store_user MODIFY COLUMN role ENUM('owner', 'manager', 'kasir') DEFAULT 'kasir'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert 'kasir' back to 'staff', 'manager' to 'staff'
        DB::table('store_user')->where('role', 'kasir')->update(['role' => 'staff']);
        DB::table('store_user')->where('role', 'manager')->update(['role' => 'staff']);
        
        DB::statement("ALTER TABLE store_user MODIFY COLUMN role ENUM('owner', 'staff') DEFAULT 'staff'");
    }
};
