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
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->id(); // id: Khóa chính
            $table->unsignedBigInteger('user_id'); // user_id: ID người dùng
            $table->text('full_name'); // full_name: Họ và tên người dùng
            $table->text('cover')->nullable(); // cover: Đường dẫn ảnh bìa (nullable nếu không bắt buộc)
            $table->string('phone', 15); // phone: SĐT người dùng (giới hạn độ dài)
            $table->text('address'); // address: Địa chỉ người dùng
            $table->string('email'); // email: Email người dùng
            $table->unsignedInteger('province_id'); // province_id: ID tỉnh/thành phố
            $table->string('district_id'); // district_id: ID quận/huyện
            $table->string('ward_id'); // ward_id: ID phường/xã
            $table->tinyInteger('is_default')->default(0); // is_default: Có phải địa chỉ mặc định (0: Không, 1: Có)
            $table->timestamps(); // created_at, updated_at: Thời gian tạo và cập nhật
            $table->softDeletes(); // deleted: Thời gian xóa mềm
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
