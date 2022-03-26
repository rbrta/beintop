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
        $currentOrders = \App\Order::all();

        Schema::table('orders', static function (Blueprint $table) {
            $table->dropColumn('account_name');
            $table->bigInteger('account_id')->after('service_id');
        });

        $currentOrders->each(static function($order) {
            $account = \App\Account::updateOrCreate([
                'account_name' => $order->account_name,
                'user_id' => $order->user_id
            ], [

            ]);

            $newOrder = \App\Order::find($order->id);
            $newOrder->account_id = $account->id;
            $newOrder->save();
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
