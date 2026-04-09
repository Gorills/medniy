<?php

use Faker\Generator as Faker;

use App\Models\ConstructionStage;

$factory->define(ConstructionStage::class, function (Faker $faker) {
    return [
        'active' => true,
		'name' => $faker->word,
		'image' => $faker->imageUrl(500, 250),
    ];
});
