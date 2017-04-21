<?php

namespace Sabichona\Http\Controllers;

use Illuminate\Http\Request;
use Sabichona\Formatters\KnowledgeIndexFormatter;
use Sabichona\Http\Requests\StoreKnowledgeRequest;
use Sabichona\Models\Knowledge;

/**
 * Controller that manages knowledges.
 * @package Sabichona\Http\Controllers
 */
class KnowledgesController extends Controller
{

    /**
     * Shows all knowledges or search for them.
     *
     * @param Request $request
     * @return array
     */
    public function index(Request $request)
    {

        $knowledges = Knowledge::remember($request->get('search'));

        $formatter = new KnowledgeIndexFormatter($knowledges, $request->has('search'));

        return $formatter->formatResponse();

    }

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