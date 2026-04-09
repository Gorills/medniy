<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFloorsTable extends Migration
{
    /**
     * Table name
     * @var string
     */
    protected $tableName = 'floors';

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
            $table->unsignedInteger('number');
            $table->unsignedInteger('scheme_id');
            $table->foreign('scheme_id')
                ->references('id')
                ->on('schemes');
            $table->unsignedInteger('block_id');
            $table->foreign('block_id')
                ->references('id')
                ->on('blocks');
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
