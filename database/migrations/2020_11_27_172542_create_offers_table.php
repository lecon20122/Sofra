<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateOffersTable extends Migration {

	public function up()
	{
		Schema::create('offers', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->text('short_describtion');
			$table->string('image')->nullable();
			$table->date('start_date');
			$table->date('end_date');
            $table->integer('restaurant_id')->unsigned();
            $table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('offers');
	}
}
