<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->foreignId ('parent_id')->nullable ()->references ('id')->on ('agents')->nullOnDelete ();
            $table->string ('f_name','100')->nullable ();
            $table->string ('l_name','100')->nullable ();
            $table->string ('phone','20')->unique ();
            $table->string ('email','100')->unique ();
            $table->timestamp('email_verified_at')->nullable ();
            $table->string ('password','100');
            $table->string ('remember_token','100')->nullable ();
            $table->string ('bank_name')->nullable ();
            $table->string ('branch')->nullable ();
            $table->string ('holder_name')->nullable ();
            $table->string ('account_no')->nullable ();
            $table->string ('image')->nullable ();
            $table->string ('status')->nullable ();
            $table->string ('firebase_token')->nullable ();
            $table->string ('auth_token')->nullable ();
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
        Schema::dropIfExists('agents');
    }
}
