<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Response;
use Sabichona\Models\Knowledge;
use Tests\TestCase;

/**
 * Test suite to see a knowledge.
 * @package Tests\Feature
 */
class SeeAKnowledgeTest extends TestCase
{

    use DatabaseMigrations;

    /**
     * @test
     */
    public function can_not_find_a_knowledge_that_does_not_exists()
    {

        $response = $this->getJson('api/knowledges/69');

        $response->assertStatus(Response::HTTP_NOT_FOUND);

        $response->assertJson([

            'status' => false,
            'message' => 'What the hell are you talking about?',

        ]);

    }

    /**
     * @test
     */
    public function show_knowledge_content()
    {

        $knowledge = factory(Knowledge::class)->create();

        $response = $this->getJson('api/knowledges/' . $knowledge->id);

        $response->assertJson([
            'status' => true,
            'message' => 'Here, have a knowledge.',
            'data' => [
                'url' => $knowledge->url(),
                'content' => $knowledge->content,
            ],
        ]);

    }

}