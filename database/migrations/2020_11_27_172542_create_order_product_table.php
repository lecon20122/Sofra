<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateOrderProductTable extends Migration {

	public function up()
	{
		Schema::create('order_product', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('product_id')->unsigned();
			$table->integer('order_id')->unsigned();
			$table->integer('qty')->unsigned();
			$table->text('notes');
            $table->decimal('price', 8,2);
            $table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('order_product');
	}
}
