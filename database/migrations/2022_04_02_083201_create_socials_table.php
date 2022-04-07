<?php

use App\Social;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSocialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('socials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
        });

        $socials = [
            ['name' => 'Instagram', 'code' => 'instagram'],
            ['name' => 'ВКонтакте', 'code' => 'vk'],
            ['name' => 'Telegram', 'code' => 'tg']
        ];


        foreach($socials as $social) {
            Social::create($social);
        }

        Schema::table('services', function (Blueprint $table) {
           $table->integer('social_id')->nullable()->after('id');
        });

        \App\Service::query()->update(['social_id' => 1]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('socials');
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('social_id');
        });
    }
}
