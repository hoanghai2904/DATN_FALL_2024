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
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->id(); // Khóa chính
            $table->unsignedBigInteger('user_id'); // ID người dùng
            $table->text('address'); // Địa chỉ người dùng
            $table->unsignedInteger('province_id'); // ID tỉnh / thành phố
            $table->unsignedInteger('district_id'); // ID quận / huyện
            $table->unsignedInteger('ward_id'); // ID phường / xã
            $table->tinyInteger('is_default')->default(0); // Địa chỉ mặc định (0: Không, 1: Có)
            $table->timestamps(); // Thời điểm tạo và cập nhật
            $table->softDeletes(); // Xóa mềm (deleted_at)
            // Thiết lập khóa ngoại
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_addresses');
    }
};
