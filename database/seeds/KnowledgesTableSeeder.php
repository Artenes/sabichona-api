<?php

use Illuminate\Database\Seeder;
use Sabichona\Models\Knowledge;
use Sabichona\Models\Location;
use Sabichona\Models\User;

class KnowledgesTableSeeder extends Seeder
{

    protected $profiles = [
        'test/tumblr_o55n7mzzmk1s8pr92o1_1280.jpg',
        'test/tumblr_o55n7mzzmk1s8pr92o2_1280.jpg',
        'test/tumblr_o55n7mzzmk1s8pr92o3_1280.jpg',
        'test/tumblr_o55n7mzzmk1s8pr92o4_1280.jpg',
        'test/tumblr_o55n7mzzmk1s8pr92o5_1280.jpg',
        'test/tumblr_o55n7mzzmk1s8pr92o6_1280.jpg',
        'test/tumblr_o55n7mzzmk1s8pr92o7_1280.jpg',
        'test/tumblr_o55n7mzzmk1s8pr92o8_1280.jpg',
        'test/tumblr_o55n7mzzmk1s8pr92o9_1280.jpg',
        'test/tumblr_o55n7mzzmk1s8pr92o10_1280.jpg',
    ];

    protected $images = [
        'test/images766080_Sugimoto.9.phunutoday.vn.jpg',
        'test/images766082_Sugimoto.1.phunutoday.vn.jpg',
        'test/images766088_Sugimoto.4.phunutoday.vn.jpg',
        'test/images766091_Sugimoto.5.phunutoday.vn.jpg',
        'test/tumblr_njzpy07uyU1s8pr92o1_540.jpg',
        'test/tumblr_njzpy07uyU1s8pr92o2_1280.jpg',
        'test/tumblr_njzpy07uyU1s8pr92o3_400.jpg',
        'test/tumblr_njzpy07uyU1s8pr92o4_250.jpg',
        'test/tumblr_njzpy07uyU1s8pr92o5_1280.jpg',
        'test/tumblr_njzpy07uyU1s8pr92o6_1280.jpg',
    ];

    protected $location;

    public function __construct()
    {

        $this->location = factory(Location::class)->create(['uuid' => 'ChIJ1UqwPCH5iJIRR9Zn150_voA']);

    }


    public function run()
    {

        $this->createKnowledge(5);
        $this->createKnowledge(5, false);
        $this->createKnowledge(5, false, false);
        $this->createKnowledge(5, true, false);
        $this->createKnowledge(5, false, true);

    }

    protected function createKnowledge($amount = 1, $withImage = true, $withAttachment = true)
    {

        factory(Knowledge::class, $amount)->create([

            'user_uuid' => function () {
                return $this->createUser()->uuid;
            },
            'location_uuid' => $this->location->uuid,
            'image_medium' => function () use ($withImage) {
                return $withImage ? $this->images[array_rand($this->images)] : null;
            },
            'attachment' => function () use ($withAttachment) {
                return $withAttachment ? 'attachments/example.pdf' : null;
            }

        ]);

    }

    protected function createUser()
    {

        $profile = $this->profiles[array_rand($this->profiles)];

        return factory(User::class)->create([
            'location_uuid' => $this->location->uuid,
            'picture' => $profile,
        ]);

    }

}