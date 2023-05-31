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
            $table->id();
            $table->string('user_code_no', 30)->nullable();
            $table->string('name', 255)->nullable();
            $table->string('user_preferred_name', 30)->nullable();
            $table->string('email', 255)->unique();
            $table->string('user_contact_no', 20)->nullable();
            $table->tinyInteger('user_gender')->nullable()->comment('1-Male, 2-Female');
            $table->date('user_dob')->nullable()->default(NULL);
            $table->string('user_username', 20)->nullable();
            $table->string('user_password', 255);
            $table->string('social_id')->nullable();
            $table->string('social_type')->nullable();
            $table->string('two_factor_recovery_codes')->nullable();
            $table->string('two_factor_secret')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->tinyInteger('user_status')->nullable()->default(4)->comment('0-Inactive, 1-Active, 2-Suspended, 3-Deleted, 4-Unverified');
            $table->unsignedBigInteger('role_id')->nullable()->comment('Refer table master_roles');
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
