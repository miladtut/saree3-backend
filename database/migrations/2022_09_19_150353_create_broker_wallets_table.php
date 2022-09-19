<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrokerWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('broker_wallets', function (Blueprint $table) {
            $table->id();
            $table->foreignId ('broker_id')->references ('id')->on ('brokers')->onDelete ('cascade');
            $table->double ('total_earning')->default (0);
            $table->double ('total_withdrawn')->default (0);
            $table->double ('pending_withdraw')->default (0);
            $table->double ('collected_cash')->default (0);
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
        Schema::dropIfExists('broker_wallets');
    }
}
