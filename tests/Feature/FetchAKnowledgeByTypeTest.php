<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestResponse;
use Tests\TestCase;

/**
 * Test suite to fetch a knowledge by type (latest, popular, etc.).
 *
 * @package Tests\Feature
 */
class FetchAKnowledgeByTypeTest extends TestCase
{

    use DatabaseMigrations;

    /**
     * @test
     */
    public function give_me_the_three_latest_knowledges()
    {

        $now = Carbon::now();

        $firstUuid = $this->createKnowledge(['created_at' => $now])->uuid;
        $secondUuid = $this->createKnowledge(['created_at' => $now->copy()->subDay(1)])->uuid;
        $thirdUuid = $this->createKnowledge(['created_at' => $now->copy()->subDay(2)])->uuid;

        $response = $this->makeRequest();

        $response->assertJson([

            'response' => ['state' => 'latest'],
            'data' => [

                'knowledges' => [

                    ['uuid' => $firstUuid],
                    ['uuid' => $secondUuid],
                    ['uuid' => $thirdUuid],

                ],

            ],

        ]);

    }

    /**
     * @test
     */
    public function or_do_not_give_me_the_latest_if_nothing_is_found()
    {

        $response = $this->makeRequest();

        $response->assertJson([

            'response' => ['state' => 'nothing'],
            'data' => [

                'knowledges' => [],

            ],

        ]);

    }

    /**
     * @test
     */
    public function give_me_the_three_most_useful_knowledges()
    {

        $veryUsefulUuid = $this->createKnowledge(['useful_count' => 80, 'useless_count' => 32])->uuid;
        $usefulUuid = $this->createKnowledge(['useful_count' => 40, 'useless_count' => 0])->uuid;
        $notSoUsefulUuid = $this->createKnowledge(['useful_count' => 5, 'useless_count' => 90])->uuid;
        $response = $this->makeRequest('useful');

        $response->assertJson([

            'response' => [
                'state' => 'useful',
            ],
            'data' => [
                'knowledges' => [

                    ['uuid' => $veryUsefulUuid],
                    ['uuid' => $usefulUuid],
                    ['uuid' => $notSoUsefulUuid],

                ],
            ],

        ]);

    }

    /**
     * @test
     */
    public function or_just_give_me_nothing_if_it_can_handle_useful_knowledge()
    {

        $response = $this->makeRequest('useful');

        $response->assertJson([

            'response' => ['state' => 'nothing'],
            'data' => [

                'knowledges' => [],

            ],

        ]);

    }

    /**
     * @test
     */
    public function shows_me_random_knowledge_if_invalid_type_is_given()
    {

        $randomUuid = $this->createKnowledge()->uuid;

        $response = $this->makeRequest('lolcatstype');

        $response->assertJson([

            'response' => ['state' => 'random'],
            'data' => [
                'knowledges' => [
                    ['uuid' => $randomUuid],
                ]
            ]

        ]);

    }

    /**
     * Makes a request to the uri being tested.
     *
     * @param null $type
     * @return TestResponse
     */
    protected function makeRequest($type = null)
    {

        $uri = $this->setLocation('api/knowledges/type');

        if (!empty($type))
            $uri .= "?type={$type}";

        return $this->getJson($uri);

    }

}