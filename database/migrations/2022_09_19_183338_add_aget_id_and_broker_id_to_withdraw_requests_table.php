<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAgetIdAndBrokerIdToWithdrawRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('withdraw_requests', function (Blueprint $table) {
            $table->foreignId ('agent_id')->nullable ()->references ('id')->on ('agents')->nullOnDelete ();
            $table->foreignId ('broker_id')->nullable ()->references ('id')->on ('brokers')->nullOnDelete ();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('withdraw_requests', function (Blueprint $table) {
            //
        });
    }
}
