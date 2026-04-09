<?php

use Illuminate\Database\Migrations\Migration;

/**
 * Class AddMainStageSlides
 */
class AddMainStageSlides extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		$order = 1;
		foreach ([
					 [
						 'title' => 'Клубный<br>жилой комплекс<br>бизнес-класса',
						 'description' => 'В Донском районе, вблизи Парка Горького и Ленинского проспекта',
					 ],
					 [
						 'title' => 'Три отдельно<br>стоящие башни',
						 'description' => '21, 16 и 9 этажей',
					 ],
					 [
						 'title' => 'Продуманные<br>планировки',
						 'description' => '1, 2 и 3-комнатные квартиры площадью от 40 м до 128 м',
					 ],
					 [
						 'title' => 'Подземный<br>паркинг',
						 'description' => '2 уровня с вместительностью в 148 машиномест',
					 ],
					 [
						 'title' => 'Различные варианты<br>отделки',
						 'description' => '«Shell&core» или «white box»',
					 ],
					 [
						 'title' => 'Высокие<br>потолки',
						 'description' => 'Высота потолка 3,2 м и 5,1 м',
					 ],
					 [
						 'title' => 'Двухуровневые<br>пентхаусы',
						 'description' => 'С высотой этажа 4,5 метра и собственными террасами',
					 ],
					 [
						 'title' => 'Обустроенная<br>территория',
						 'description' => 'Детский образовательный центр и камерный сквер',
					 ],
				 ] as $imageArr) {
			$image = new \App\Models\MainStageSlide();
			$image->active = true;
			$image->title = $imageArr['title'];
			$image->description = $imageArr['description'];
			$image->order = ++$order;
			$image->save();
		}
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
