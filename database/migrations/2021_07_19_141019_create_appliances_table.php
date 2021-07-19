<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppliancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appliances', function (Blueprint $table) {
            $table->id();
            $table->string('site'); //telephely
            $table->string('location'); //készenléti helye
            $table->string('type'); //készüléktípus
            $table->string('serial_number'); //gyári száma
            $table->date('production_date'); //gyártás dátuma
            $table->text('description')->nullable(); //megjegyzés
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
        Schema::dropIfExists('appliances');
    }
}
