<?php

use Illuminate\Database\Seeder;
use Sabichona\Models\Knowledge;

class DatabaseSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        factory(Knowledge::class, 10)->create();

    }

}