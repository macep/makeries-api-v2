<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMakerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('makers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('address1');
            $table->string('address2')->nullable();
            $table->string('city');
            $table->string('postcode');
            $table->string('email')->nullable();
            $table->string('telephone')->nullable();
            $table->string('website')->nullable();
            $table->string('social1')->nullable();
            $table->string('social2')->nullable();
            $table->string('social3')->nullable();
            $table->string('map_url')->nullable();
            $table->string('admin_email');
            $table->text('brief_description');
            $table->text('long_description');
            $table->string('published');
            $table->string('featured');
            $table->string('subscription');
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
        Schema::dropIfExists('maker');
    }
}
