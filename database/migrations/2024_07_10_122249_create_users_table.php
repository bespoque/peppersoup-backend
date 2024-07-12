<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('firstname',50)->nullable();
            $table->string('lastname',50)->nullable();
            $table->string('gender',8)->nullable();
            $table->string('email',50)->nullable();
            $table->string('identity')->nullable();
            $table->longText('password')->nullable();
            $table->string('phone',15)->nullable();
            $table->longText('about')->nullable();
            $table->longText('dob')->nullable();
            $table->longText('profile_image')->nullable();
            $table->string('is_admin',10)->default(0)->nullable();
            $table->string('status',10)->default(1)->nullable();
            $table->string('referral_code',50)->nullable();
            $table->string('is_verified')->nullable();
            $table->longText('firebase_token')->nullable();
            $table->unsignedBigInteger("role_id")->nullable();
            $table->index('role_id');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->text('remember_token')->nullable();
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
        Schema::dropIfExists('users');
    }
}
