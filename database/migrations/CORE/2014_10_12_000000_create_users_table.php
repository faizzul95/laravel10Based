<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255)->nullable();
            $table->string('user_preferred_name', 35)->nullable();
            $table->string('email', 255)->unique();
            $table->string('user_contact_no', 20)->nullable();
            $table->tinyInteger('user_gender')->nullable()->comment('1-Male, 2-Female');
            $table->date('user_dob')->nullable()->default(NULL);
            $table->tinyInteger('user_marital_status')->nullable()->default(1)->comment('1-Single, 2-Merried, 3-Divorce, 4-Others');
            $table->string('username', 20)->nullable();
            $table->string('password', 255)->nullable();
            $table->string('social_id')->nullable();
            $table->string('social_type')->nullable();
            $table->string('two_factor_recovery_codes')->nullable();
            $table->string('two_factor_secret')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = "InnoDB";
        });

        Schema::create('laravel_sessions', function (Blueprint $table) {
            $table->integer('sessions_id');
            $table->id();
            $table->text('payload')->nullable();
            $table->integer('last_activity')->nullable();
            $table->unsignedBigInteger('user_id')->nullable()->comment('Refer table users');
            $table->string('ip_address', 200)->nullable();
            $table->string('user_agent', 200)->nullable();
            $table->timestamps();
            $table->engine = "InnoDB";
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
        Schema::dropIfExists('laravel_sessions');
    }
};
