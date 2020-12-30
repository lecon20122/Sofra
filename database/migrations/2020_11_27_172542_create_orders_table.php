<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateOrdersTable extends Migration {

	public function up()
	{
		Schema::create('orders', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('restaurant_id')->unsigned();
			$table->integer('client_id')->unsigned();
			$table->decimal('total', 8,2)->default(0);
			$table->decimal('price', 8,2)->default(0);
			$table->decimal('delivery_fees', 8,2)->default(0);
			$table->decimal('commission', 8,2)->default(0);
			$table->text('notes');
			$table->enum('state', array('pending...', 'accepted', 'rejected', 'delivered'))->default('pending');
            $table->enum('type', array('cash-on-delivery', 'online'));
            $table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('orders');
	}
}
