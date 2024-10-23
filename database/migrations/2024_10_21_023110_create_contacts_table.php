<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id(); // ID
            $table->string('name'); // Tên của bạn (bắt buộc)
            $table->string('email'); // Địa chỉ Email (bắt buộc)
            $table->string('phone')->nullable(); // Số điện thoại liên hệ (bắt buộc)
            $table->text('message')->nullable(); // Thông điệp
            $table->string('status_contacts')->default('Chưa giải quyết');
            $table->timestamps(); // Được tạo ra tại
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}