<?php

namespace Sabichona\Http\Controllers;

use Sabichona\Http\Requests\StoreKnowledgeRequest;
use Sabichona\Models\Knowledge;

/**
 * Controller that manages knowledges.
 * @package Sabichona\Http\Controllers
 */
class KnowledgesController extends Controller
{

    /**
     * Store a knowledge.
     *
     * @param StoreKnowledgeRequest $request
     * @return array
     */
    public function store(StoreKnowledgeRequest $request)
    {

        $knowledge = Knowledge::create(['content' => $request->get('content')]);

        return [

            'status' => true,
            'message'=> 'You have shown me your knowledge',
            'data' => [
                'id' => $knowledge->id,
                'url' => $knowledge->url(),
            ],

        ];

    }

}