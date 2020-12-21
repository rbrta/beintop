<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceParametersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_parameters', function (Blueprint $table) {
            $table->id();
            $table->integer('service_id');
            $table->string('key');
            $table->text('value')->nullable();
            $table->timestamps();
        });

        $migratingColumns = ['likes', 'posts', 'views', 'igtv_unlim', 'bonus'];

        $services = \App\Service::all();
        $services->each(function ($service) use ($migratingColumns) {
            foreach ($migratingColumns as $column) {
                \App\ServiceParameter::create([
                    'service_id' => $service->id,
                    'key' => $column,
                    'value' => $service->{$column}
                ]);
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_params');
    }
}
