<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		
		Schema::create('clients', function($table)
		{
                    $table->engine = 'InnoDB';
                    $table->increments('id')->unsigned();
                    $table->string('username');
                    $table->string('pass');
                    $table->string('company_name');
                    $table->string('emp_name');
                    $table->string('emp_number');
                    $table->text('address');
                    $table->string('parish');
                    $table->string('contact_number');
                    $table->string('sub_start_date');
                    $table->string('sub_end_date');
                    $table->boolean('is_active');
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
            Schema::drop('clients');
	}

}
