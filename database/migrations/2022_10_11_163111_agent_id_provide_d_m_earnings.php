<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AgentIdProvideDMEarnings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('provide_d_m_earnings', function (Blueprint $table) {
            $table->foreignId ('agent_id')->nullable ()->references ('id')->on ('agents')->nullOnDelete ();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('provide_d_m_earnings', function (Blueprint $table) {
            //
        });
    }
}
