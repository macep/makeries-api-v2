<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMakerGroupBusinessType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maker_group_business_type', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('business_type_id');
            $table->integer('maker_group_id');
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
        //
    }
}
