<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateDistrictsTable extends Migration {

	public function up()
	{
		Schema::create('districts', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
			$table->integer('city_id')->unsigned();
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('districts');
	}
}
