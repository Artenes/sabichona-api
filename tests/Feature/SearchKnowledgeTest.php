<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Sabichona\Models\Knowledge;
use Sabichona\Models\Location;
use Tests\TestCase;

/**
 * Test suite for searching a knowledge.
 * @package Tests\Feature
 */
class SearchKnowledgeTest extends TestCase
{

    use DatabaseMigrations;

    protected $santarem = 'ChIJ1UqwPCH5iJIRR9Zn150_voA';

    /**
     * @test
     */
    public function returns_recommendation_when_there_is_no_knowledge_in_location()
    {

        $response = $this->search();

        $response->assertJson(['response' => ['state' => 'first']]);

    }

    /**
     * @test
     */
    public function do_not_find_knowledge()
    {

        $location = factory(Location::class)->create(['uuid' => $this->santarem]);
        factory(Knowledge::class)->create(['content' => 'dont_find_this', 'location_uuid' => $location->uuid]);

        $response = $this->search('do_not_exist');

        $response->assertJson(['response' => ['state' => 'nothing']]);

    }

    /**
     * @test
     */
    public function returns_random_knowledge_when_search_arg_is_not_provided()
    {

        $location = factory(Location::class)->create(['uuid' => $this->santarem]);
        factory(Knowledge::class, 5)->create(['location_uuid' => $location->uuid]);

        $response = $this->search();

        $response->assertJson(['response' => ['state' => 'random']]);

    }

    /**
     * @test
     */
    public function search_knowledge_by_content()
    {

        $location = factory(Location::class)->create(['uuid' => $this->santarem]);
        $knowledge = factory(Knowledge::class, 20)->create(['content' => 'find me!', 'location_uuid' => $location->uuid]);

        $response = $this->search('find me!');

        $response->assertJson([
            'response' => ['state' => 'found'],
            'pagination' => ['total' => 20]
        ]);

    }

    /**
     * Make a search.
     *
     * @param null $content
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function search($content = null)
    {

        $url = 'api/knowledges/search/' . $this->santarem;

        if ($content !== null)
            $url .= '?search=' . $content;

        return $this->getJson($url);

    }

}