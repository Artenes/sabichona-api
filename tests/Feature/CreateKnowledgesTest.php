<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

/**
 * Test suite for the creation of a knowledge.
 * @package Tests\Feature
 */
class CreateKnowledgesTest extends TestCase
{

    use DatabaseMigrations;

    /**
     * @test
     */
    public function can_create_a_knowledge()
    {

        $response = $this->postJson('api/knowledges', ['content' => 'My new piece of knowledge']);

        $response->assertJson([
            'status' => true,
            'message'=> 'You have shown me your knowledge',
            'data' => [
                'id' => 1,
                'url' => url('api/knowledges/1'),
            ],
        ]);

    }

    /**
     * @test
     */
    public function can_not_create_a_knowledge_without_content()
    {

        $response = $this->postJson('api/knowledges');

        $response->assertJson([
            'status' => false,
            'message'=> 'I didn\'t understood your knowledge',
            'errors' => [
                'content' => ['The content field is required.'],
            ],
        ]);

    }

}