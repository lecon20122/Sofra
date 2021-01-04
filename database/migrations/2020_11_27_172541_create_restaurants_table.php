<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateRestaurantsTable extends Migration {

	public function up()
	{
		Schema::create('restaurants', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('email');
			$table->string('phone');
			$table->string('password');
			$table->string('image');
			$table->boolean('is_active')->default(1);
			$table->integer('district_id')->unsigned();
			$table->decimal('min_order', 8,2);
			$table->decimal('delivery_fees', 8,2);
			$table->string('contact_phone');
            $table->string('contact_whatsapp');
            $table->string('api_token', 60)->unique()->nullable();
            $table->integer('pin_code')->unsigned()->nullable();
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('restaurants');
	}
}
