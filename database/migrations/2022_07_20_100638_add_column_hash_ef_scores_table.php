<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnHashEfScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ef_scores', function (Blueprint $table) {
            $table->string('transaction_hash')->after('earn_status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ef_scores', function (Blueprint $table) {
            $table->dropColumn('transaction_hash');
        });
    }
}
