<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSessionTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::create('transacction_token', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('token');
            $table->unsignedBigInteger('user_id');
            $table->string('recipient_document_number');
            $table->string('value');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('sessions');
    }
}
