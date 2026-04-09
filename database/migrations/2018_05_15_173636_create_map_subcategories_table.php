<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateMapSubcategoriesTable
 */
class CreateMapSubcategoriesTable extends Migration
{
	/**
	 * @var string
	 */
	protected $tableName = 'map_subcategories';

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
			$table->unsignedInteger('map_category_id')->nullable();
			$table->foreign('map_category_id')
				->references('id')
				->on('map_categories')
				->onDelete('set null')
				->onUpdate('cascade');
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
