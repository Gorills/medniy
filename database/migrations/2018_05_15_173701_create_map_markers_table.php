<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateMapMarkersTable
 */
class CreateMapMarkersTable extends Migration
{
	/**
	 * @var string
	 */
	protected $tableName = 'map_markers';

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
			$table->unsignedInteger('map_category_id')->nullable();
			$table->foreign('map_category_id')
				->references('id')
				->on('map_categories')
				->onDelete('set null')
				->onUpdate('cascade');
			$table->unsignedInteger('map_subcategory_id')->nullable();
			$table->foreign('map_subcategory_id')
				->references('id')
				->on('map_subcategories')
				->onDelete('set null')
				->onUpdate('cascade');
			$table->double('lat');
			$table->double('lon');
			$table->string('address');
			$table->integer('distance');
			$table->integer('time');
			$table->string('image')->nullable();
			$table->integer('transport');
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
