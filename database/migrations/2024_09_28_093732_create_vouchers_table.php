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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->text('discount_type');
            $table->tinyInteger('status')->default(0);
<<<<<<< HEAD
            $table->float('discount');
=======
            $table->DECIMAL ('discount',10,2);
>>>>>>> 1a9bff7e643d48fb179836b504e2e50cad27a7bc
            $table->string('qty');
            $table->integer('max_uses')->nullable();
            $table->softDeletes();
            $table->timestamp('start')->nullable();
            $table->timestamp('end')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
