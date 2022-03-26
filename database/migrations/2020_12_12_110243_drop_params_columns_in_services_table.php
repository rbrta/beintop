<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropParamsColumnsInServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('likes');
            $table->dropColumn('posts');
            $table->dropColumn('views');
            $table->dropColumn('igtv_unlim');
            $table->dropColumn('bonus');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('services', function (Blueprint $table) {
            $table->integer('likes');
            $table->integer('posts');
            $table->integer('views');
            $table->integer('igtv_unlim')->default(1);
            $table->text('bonus', 1000)->after('igtv_unlim')->nullable();
        });
    }
}
