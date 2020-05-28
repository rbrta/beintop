<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id('id');
            $table->integer('category_id');
            $table->string('name');
            $table->integer('periodindays');
            $table->decimal('price');
            $table->integer('likes');
            $table->integer('posts');
            $table->integer('views');
            $table->integer('bonus_comments');
            $table->integer('bonus_posts');
            $table->integer('igtv_unlim')->default(1);
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
        Schema::dropIfExists('services');
    }
}
