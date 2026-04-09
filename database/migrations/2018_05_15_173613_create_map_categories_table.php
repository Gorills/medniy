<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateMapCategoriesTable
 */
class CreateMapCategoriesTable extends Migration
{
	/**
	 * @var string
	 */
	protected $tableName = 'map_categories';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create($this->tableName, function (Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->boolean('active')->default(false);
			$table->unsignedInteger('order');
			$table->string('code')->unique();
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
