<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('provinces', function (Blueprint $table) {
            $table->id(); // Khóa chính
            $table->string('name'); // Tên tỉnh/thành phố
            $table->timestamps(); // Thời điểm tạo và cập nhật
            $table->softDeletes(); // Xóa mềm (deleted_at)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('provinces');
    }
};
