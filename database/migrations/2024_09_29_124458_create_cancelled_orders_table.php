<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
<<<<<<< HEAD
    public function up()
    {
        Schema::create('cancelled_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->string('reason');
            $table->timestamp('cancelled_at')->useCurrent();
            $table->timestamps();
        });
    }
    
=======
    public function up(): void
    {
        Schema::create('cancelled_orders', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
    }
>>>>>>> 45fccf81dd0db1a6d9fc4581b1660a197a6fec42

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cancelled_orders');
    }
};
