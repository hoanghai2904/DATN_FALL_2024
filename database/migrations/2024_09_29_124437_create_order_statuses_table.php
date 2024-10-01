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
        Schema::create('order_statuses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->string('status'); // Trạng thái (Pending, Shipped, Delivered, Cancelled)
            $table->timestamp('changed_at')->useCurrent();
            $table->timestamps();
        });
    }
    
=======
    public function up(): void
    {
        Schema::create('order_statuses', function (Blueprint $table) {
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
        Schema::dropIfExists('order_statuses');
    }
};
