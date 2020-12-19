<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreatePaymentsTable extends Migration {

	public function up()
	{
		Schema::create('payments', function(Blueprint $table) {
			$table->increments('id');
			$table->decimal('restaurant_sales', 8,2);
			$table->decimal('price', 8,2);
			$table->decimal('reminder', 8,2);
			$table->integer('restaurant_id')->unsigned();
			$table->softDeletes();
			$table->timestamps();
			$table->text('notes');
		});
	}

	public function down()
	{
		Schema::drop('payments');
	}
}
