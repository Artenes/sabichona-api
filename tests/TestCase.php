<?php

namespace Tests;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Sabichona\Models\Knowledge;
use Sabichona\Models\Location;

/**
 * Base test class.
 *
 * @package Tests
 */
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * This is the locations where
     * the tests will take place.
     *
     * @var Location
     */
    private $santarem;

    /**
     * @return Location
     */
    private function createSantarem()
    {

        $this->santarem = factory(Location::class)->create(['uuid' => 'ChIJ1UqwPCH5iJIRR9Zn150_voA']);
        return $this->santarem;

    }

    /**
     * @return Location
     */
    protected function getSantarem()
    {

        if (empty($this->santarem))
            return $this->createSantarem();

        return $this->santarem;

    }

    /**
     * @param array $data
     * @param int $amount
     * @return Collection|Knowledge
     */
    protected function createKnowledge($data = [], $amount = 1)
    {

        $default = ['location_uuid' => $this->getSantarem()->uuid];

        $default = array_merge($default, $data);

        if ($amount == 1)
            return factory(Knowledge::class)->create($default);

        return factory(Knowledge::class, $amount)->create($default);

    }

    /**
     * Sets the location to the given uri.
     *
     * @param $uri
     * @return string
     */
    protected function setLocation($uri)
    {

        return rtrim($uri, '/') . '/' . $this->getSantarem()->uuid;

    }

}