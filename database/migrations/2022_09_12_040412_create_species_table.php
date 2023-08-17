<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpeciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('species', function (Blueprint $table) {
            $table->id();
            $table->integer('species_id')->nullable();
            $table->string('name');
            $table->string('kingdom')->nullable();
            $table->string('phylum')->nullable();
            $table->string('shell_class')->nullable();
            $table->string('order')->nullable();
            $table->string('family')->nullable();
            $table->string('genus')->nullable();
            $table->string('species')->nullable();
            $table->string('common_name')->nullable();
            $table->text('local_name')->nullable();
            $table->string('country')->nullable();
            $table->string('environment')->nullable();
            $table->text('general_description')->nullable();
            $table->string('iucn_status')->nullable();
            $table->string('threats_to_humans')->nullable();
            $table->string('economic_value_uses')->nullable();
            $table->text('references')->nullable();
            $table->string('ext_col_1')->nullable();
            $table->string('ext_col_2')->nullable();
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
        Schema::dropIfExists('species');
    }
}
