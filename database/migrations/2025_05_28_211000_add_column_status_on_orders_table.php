<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //pendente, em preparo, pronto, entregue.

        Schema::table('orders', function (Blueprint $table) {
            $table->enum('status', ['pending', 'preparing', 'prepared', 'delivered'])->after('dependent_id')->default('pending');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
};
