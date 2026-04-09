<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApartmentsTable extends Migration
{
    /**
     * Table name
     * @var string
     */
    protected $tableName = 'apartments';

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
            $table->unsignedInteger('block_id');
            $table->foreign('block_id')
                ->references('id')
                ->on('blocks');
            $table->unsignedInteger('floor_id');
            $table->foreign('floor_id')
                ->references('id')
                ->on('floors');
            $table->unsignedInteger('decoration_id');
            $table->foreign('decoration_id')
                ->references('id')
                ->on('decorations');
            $table->string('code');
            $table->string('sectionnumber');
            $table->string('number');
            $table->integer('rooms');
            $table->double('total_area');
            $table->double('bathroom_area');
            $table->double('cost');
            $table->double('price');
            $table->string('images');
            $table->string('kitchen');
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
