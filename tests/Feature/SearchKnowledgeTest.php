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
    public function can_has_no_knowledges()
    {

        $response = $this->getJson('api/knowledges');

        $this->assertResponseIsOk($response, 'Didn\'t find shit.');

    }

    /**
     * @test
     */
    public function gets_all_knowledges()
    {

       $knowledges = factory(Knowledge::class, 3)->create();

       $response = $this->getJson('api/knowledges');

       $this->assertResponseIsOk($response, 'Behold the knowledge!', $knowledges);

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

        $this->assertResponseIsOk($response, 'Look what I know about this', $knowledge);

    }

    /**
     * @test
     */
    public function finds_nothing_by_searching_for_something_that_does_not_exists()
    {

        $response = $this->getJson('api/knowledges?search=nothing');

        $this->assertResponseIsOk($response, 'I dont\'t know about this', []);

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

        $this->assertResponseIsOk($response, 'Look what I know about this', $knowledges);

    }

    /**
     * Assert if the response is ok.
     *
     * @param $response
     * @param $message
     * @param $knowledges
     */
    protected function assertResponseIsOk($response, $message, $knowledges = [])
    {

        if ($knowledges instanceof Knowledge)
            $knowledges = [$knowledges];

        $results = [];

        foreach ($knowledges as $knowledge) {

            $results[] = [
                'url' => $knowledge->url(),
                'excerpt' => $knowledge->excerpt(),
                'content' => $knowledge->content,
            ];

        }

        $response->assertJson([
            'status' => true,
            'message' => $message,
            'data' => [
                'results' => count($knowledges),
                'knowledges' => $results,
            ]
        ]);

    }

}