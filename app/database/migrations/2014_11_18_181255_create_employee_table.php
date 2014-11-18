<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Create the `Posts` table
		Schema::create('company_employee', function($table)
		{
                    $table->engine = 'InnoDB';
                    $table->increments('id')->unsigned();
                    $table->string('first_name',50)->nullable();
                    $table->string('middle_name',50)->nullable();
                    $table->string('last_name',50)->nullable();
                    $table->string('nis_number');
                    $table->string('nrn_number');
                    $table->text('address');
                    $table->string('parish');
                    $table->string('tel_number');
                    $table->string('mob_number');
                    $table->string('pay_rate');
                    $table->string('pay_period');
                    $table->string('earning_type');
                    $table->string('emp_start_date');
                    $table->string('emp_end_date');
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
		Schema::drop('company_employee');
	}

}
