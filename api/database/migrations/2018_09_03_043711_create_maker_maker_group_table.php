<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMakerMakerGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maker_maker_group', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('maker_group_id');
            $table->integer('maker_id');
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();              
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
        Schema::dropIfExists('maker_maker_group');
    }
}
