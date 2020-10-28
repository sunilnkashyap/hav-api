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
    public function up()
    {
      Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->enum('role', ['Doctor', 'Patient', 'Pathology', 'Admin']);
        $table->string('name');
        $table->string('email');
        $table->string('password')->nullable();
        $table->timestamp('email_verified_at')->nullable();
        $table->rememberToken();
        $table->integer('registration_step')->nullable();
        $table->enum('status', ['Active', 'Pending', 'Processing', 'Deactivated']);
        $table->longText('facebook_id')->nullable();
        $table->longText('google_id')->nullable();
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
