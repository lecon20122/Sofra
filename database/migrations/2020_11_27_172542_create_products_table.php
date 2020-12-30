<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateProductsTable extends Migration {

	public function up()
	{
		Schema::create('products', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->text('short_describtion');
			$table->string('image');
			$table->decimal('price', 8,2);
			$table->decimal('offer', 8,2);
			$table->string('ready_in');
            $table->integer('restaurant_id')->unsigned();
            $table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('products');
	}
}
