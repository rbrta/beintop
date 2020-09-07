<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeAccountNameColumnToAccountIdInOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', static function (Blueprint $table) {
            $table->dropColumn('account_name');
            $table->bigInteger('account_id')->after('service_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', static function (Blueprint $table) {
            $table->dropColumn('account_id');
            $table->string('account_name')->nullable();
        });
    }
}
