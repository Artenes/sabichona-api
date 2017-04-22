<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Response;
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

        $response->assertStatus(Response::HTTP_NOT_FOUND);

        $this->assertResponseHasRightStructure($response, 'Didn\'t find shit.');

    }

    /**
     * @test
     */
    public function gets_all_knowledges()
    {

       $knowledges = factory(Knowledge::class, 3)->create();

       $response = $this->getJson('api/knowledges');

       $this->assertResponseHasRightStructure($response, 'Behold the knowledge!', $knowledges);

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

        $this->assertResponseHasRightStructure($response, 'Look what I know about this', $knowledge);

    }

    /**
     * @test
     */
    public function finds_nothing_by_searching_for_something_that_does_not_exists()
    {

        $response = $this->getJson('api/knowledges?search=nothing');

        $response->assertStatus(Response::HTTP_NOT_FOUND);

        $this->assertResponseHasRightStructure($response, 'I dont\'t know about this', []);

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

        $this->assertResponseHasRightStructure($response, 'Look what I know about this', $knowledges);

    }

    /**
     * Assert if the response has the right structure.
     *
     * @param $response
     * @param $message
     * @param $knowledges
     */
    protected function assertResponseHasRightStructure($response, $message, $knowledges = [])
    {

        if ($knowledges instanceof Knowledge)
            $knowledges = [$knowledges];

        $results = [];

        foreach ($knowledges as $knowledge) {

            $results[] = [
                'content' => $knowledge->content,
                'created_at' => $knowledge->created_at->toDateTimeString(),
            ];

        }

        $response->assertJson([
            'status' => count($knowledges) > 0,
            'message' => $message,
            'data' => [
                'results' => count($knowledges),
                'knowledges' => $results,
            ]
        ]);

    }

}