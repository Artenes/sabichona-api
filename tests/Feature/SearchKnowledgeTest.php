<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Sabichona\Models\Knowledge;
use Tests\TestCase;

/**
 * Test suite for searching a knowledge.
 * @package Tests\Feature
 */
class SearchKnowledgeTest extends TestCase
{

    use DatabaseMigrations;

    /**
     * @test
     */
    public function gets_all_knowledges()
    {

       $knowledges = factory(Knowledge::class, 3)->create();

       $response = $this->getJson('api/knowledges');

       $response->assertJson([
           'status' => true,
           'message' => 'Behold the knowledge!',
           'data' => [
               'results' => 3,
               'knowledges' => [
                   [
                       'url' => $knowledges->first()->url(),
                       'excerpt' => $knowledges->first()->excerpt(),
                   ],
                   [
                       'url' => $knowledges->get(1)->url(),
                       'excerpt' => $knowledges->get(1)->excerpt(),
                   ],
                   [
                       'url' => $knowledges->get(2)->url(),
                       'excerpt' => $knowledges->get(2)->excerpt(),
                   ]
               ],
           ]
       ]);

    }

    /**
     * @test
     */
    public function can_search_a_knowledge_by_content()
    {

        $knowledge = factory(Knowledge::class)->create([
            'content' => 'I am selling a pair of shoes',
        ]);

        $response = $this->getJson('api/knowledges?search=shoes');

        $response->assertJson([
            'status' => true,
            'message' => 'Look what I know about this',
            'data' => [
                'results' => 1,
                'knowledges' => [
                    [
                        'url' => $knowledge->url(),
                        'excerpt' => $knowledge->excerpt(),
                    ]
                ],
            ]
        ]);

    }

    /**
     * @test
     */
    public function finds_nothing_by_searching_for_something_that_does_not_exists()
    {

        $response = $this->getJson('api/knowledges?search=nothing');

        $response->assertJson([
            'status' => true,
            'message' => 'I dont\'t know about this',
            'data' => [
                'results' => 0,
                'knowledges' => [],
            ]
        ]);

    }

    /**
     * @test
     */
    public function finds_multiple_results()
    {

        $knowledges = factory(Knowledge::class, 3)->create([
            'content' => 'I am selling a pair of shoes',
        ]);

        $response = $this->getJson('api/knowledges?search=shoes');

        $response->assertJson([
            'status' => true,
            'message' => 'Look what I know about this',
            'data' => [
                'results' => 3,
                'knowledges' => [
                    [
                        'url' => $knowledges->first()->url(),
                        'excerpt' => $knowledges->first()->excerpt(),
                    ],
                    [
                        'url' => $knowledges->get(1)->url(),
                        'excerpt' => $knowledges->get(1)->excerpt(),
                    ],
                    [
                        'url' => $knowledges->get(2)->url(),
                        'excerpt' => $knowledges->get(2)->excerpt(),
                    ]
                ],
            ]
        ]);

    }

}