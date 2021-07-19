<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateControlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('controls', function (Blueprint $table) {
            $table->id();
            $table->string('maintenance'); //karbantartás
            $table->date('date'); //dátum
            $table->text('description')->nullable(); //megjegyzés
            $table->unsignedBigInteger('appliance_id');
            $table->timestamps();

            $table->foreign('appliance_id')->references('id')->on('appliances');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('controls');
    }
}
