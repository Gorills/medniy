<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateGalleryPhotosTable
 */
class CreateGalleryPhotosTable extends Migration
{
	/**
	 * Table name
	 * @var string
	 */
	protected $tableName = 'gallery_photos';

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
            $table->unsignedInteger('block_id')->nullable();
            $table->string('image');
            $table->timestamps();

			$table->foreign('block_id')
				->references('id')
				->on('blocks')
				->onDelete('set null')
				->onUpdate('cascade');
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
