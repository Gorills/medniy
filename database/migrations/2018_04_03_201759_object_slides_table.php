<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class ObjectSlidesTable
 */
class ObjectSlidesTable extends Migration
{
	/**
	 * Table name
	 * @var string
	 */
	protected $tableName = 'object_slides';

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
			$table->string('name');
			$table->text('description');
			$table->integer('order');
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
