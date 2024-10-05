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
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // unsignedBigInteger mặc định
            $table->unsignedBigInteger('role_id')->nullable(); // Khóa ngoại đến bảng roles
            $table->string('full_name');
            $table->string('cover')->nullable();
            $table->string('phone');
            $table->string('password');
            $table->string('email')->unique();
            $table->tinyInteger('gender')->nullable();
            $table->string('status')->default('active');
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamps();
            $table->softDeletes(); // Thời điểm xóa mềm
        
            // Thiết lập khóa ngoại
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
