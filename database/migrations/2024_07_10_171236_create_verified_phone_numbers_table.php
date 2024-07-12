<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVerifiedPhoneNumbersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('verified_phone_numbers', function (Blueprint $table) {
            $table->id();
            $table->text("phone")->nullable();
            $table->string('status', 10)->default(0);
            $table->string('verify_code',100);
            $table->timestamp('expire_at')->default(now());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('verified_phone_numbers');
    }
}
