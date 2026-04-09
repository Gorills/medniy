<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class MainStageSlidesTable
 */
class MainStageSlidesTable extends Migration
{
	/**
	 * Table name
	 * @var string
	 */
	protected $tableName = 'main_stage_slides';

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create($this->tableName, function (Blueprint $table) {
			$table->increments('id');
			$table->boolean('active')->default(false);
			$table->string('title');
			$table->text('description');
			$table->integer('order')->default(9999);
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
		Schema::dropIfExists($this->tableName);
	}
}
