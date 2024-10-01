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
<<<<<<<< HEAD:database/migrations/2024_09_28_094204_create_brands_table.php
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('name', 20)->unique();
            // unique dữ liệu ko được phép trùng nhau
            $table->string('logo', 100);
            $table->string('slug', 100);
========
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
>>>>>>>> 45fccf81dd0db1a6d9fc4581b1660a197a6fec42:database/migrations/2024_09_29_124346_create_transactions_table.php
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
<<<<<<<< HEAD:database/migrations/2024_09_28_094204_create_brands_table.php
        Schema::dropIfExists('brands');
========
        Schema::dropIfExists('transactions');
>>>>>>>> 45fccf81dd0db1a6d9fc4581b1660a197a6fec42:database/migrations/2024_09_29_124346_create_transactions_table.php
    }
};