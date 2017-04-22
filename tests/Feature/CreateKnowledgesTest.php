<?php

namespace Tests\Feature;

use Faker\Factory;
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

    /**
     * @test
     */
    public function content_can_only_be_500_characters_long()
    {

        $data = ['content' => str_random(501)];

        $response = $this->postJson('api/knowledges', $data);

        $response->assertJson([
            'status' => false,
            'message' => 'I didn\'t understood your knowledge',
            'errors' => [
                'content' => ['The content may not be greater than 500 characters.']
            ]
        ]);

    }

}