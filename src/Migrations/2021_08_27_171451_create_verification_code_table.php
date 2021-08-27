<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVerificationCodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('verification_codes', function (Blueprint $table) {
            $table->char('phone', 11)->unique()->comment('手机号');
            $table->char('code', 10)->nullable()->comment('验证码');
            $table->dateTime('send_time')->comment('发送时间');
            $table->tinyInteger('expired')->default(10)->comment('多少分钟过期');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('verification_codes');
    }
}
