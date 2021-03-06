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
            $table->string('first_name',50);
            $table->string('last_name',50);
            $table->string('password',100);
            $table->string('email',50)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone',20);
            $table->integer('gender')->default('1')->comment = '1 -> Male , 2 -> Female';
            $table->integer('credit')->default('0');
            $table->integer('visit_number')->default('0');
            $table->dateTime('last_visit')->useCurrent();
            $table->foreignId('group_id')->default('1')->constrained('groups')->onUpdate('cascade')->onDelete('cascade');
            $table->string('profile_photo_url',255)->default('images/default_vector.jpg')->nullable();
            $table->rememberToken();
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
