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
        Schema::create('districts', function (Blueprint $table) {
            $table->id(); // Khóa chính
            $table->unsignedBigInteger('province_id'); // ID tỉnh/thành phố
            $table->string('name'); // Tên quận/huyện
            $table->timestamps(); // Thời điểm tạo và cập nhật
            $table->softDeletes(); // Xóa mềm (deleted_at)

            // Thiết lập khóa ngoại
            $table->foreign('province_id')->references('id')->on('provinces')->onDelete('cascade');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('districts');
    }
};
