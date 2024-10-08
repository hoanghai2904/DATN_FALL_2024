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
        Schema::create('wards', function (Blueprint $table) {
            $table->id(); // Khóa chính
            $table->unsignedBigInteger('district_id'); // ID quận/huyện
            $table->string('name'); // Tên phường/xã
            $table->timestamps(); // Thời điểm tạo và cập nhật
            $table->softDeletes(); // Xóa mềm (deleted_at)

            // Thiết lập khóa ngoại
            $table->foreign('district_id')->references('id')->on('districts')->onDelete('cascade');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wards');
    }
};
