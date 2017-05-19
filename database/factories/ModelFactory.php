<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(\Sabichona\Models\Location::class, function () {

    return [

        'label' => 'Santarém, PA - Brasil',
        'city' => 'Santarém',

    ];

});

$factory->define(Sabichona\Models\User::class, function (Faker\Generator $faker) {

    return [

        'location_uuid' => function () {
            return factory(Sabichona\Models\Location::class)->create()->uuid;
        },
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'picture' => 'images/thumbnail_example.png',

    ];

});

$factory->define(Sabichona\Models\Knowledge::class, function (Faker\Generator $faker) {

    return [

        'user_uuid' => function () {
            return factory(\Sabichona\Models\User::class)->create()->uuid;
        },
        'user_name' => $faker->name,
        'location_uuid' => function () {
            return factory(\Sabichona\Models\Location::class)->create()->uuid;
        },
        'image' => 'images/example.png',
        'image_medium' => 'images/example_medium.png',
        'image_small' => 'images/example_small.png',
        'content' => $faker->text(500),
        'attachment' => 'attachments/example.pdf',
        'useful_count' => $faker->randomNumber(2),
        'useless_count' => $faker->randomNumber(2),
        'share_count' => $faker->randomNumber(2),

    ];

});