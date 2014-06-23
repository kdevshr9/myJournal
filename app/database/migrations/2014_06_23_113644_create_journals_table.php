<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJournalsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('journals', function($table) {
            $table->increments('id');
            $table->tinyInteger('type');
            $table->date('date');
            $table->date('date_from');
            $table->date('date_to');
            $table->string('title');
            $table->text('description');
            $table->timestamps();
            $table->integer('created_by');
            $table->integer('updated_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('journals');
    }

}
