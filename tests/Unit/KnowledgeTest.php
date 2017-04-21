<?php

namespace Tests\Unit;

use Sabichona\Models\Knowledge;
use Tests\TestCase;

/**
 * Test suite for the Knowledge model
 * @package Tests\Unit
 */
class KnowledgeTest extends TestCase
{

    /**
     * @test
     */
    public function knowledge_has_an_excerpt()
    {

        $knowledge = new Knowledge();

        $knowledge->content = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore';

        $excerpt = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut lab...';

        $this->assertEquals($excerpt, $knowledge->excerpt());

        $knowledge->content = 'Too short to excerpt';

        $this->assertEquals('Too short to excerpt', $knowledge->excerpt());

    }

}