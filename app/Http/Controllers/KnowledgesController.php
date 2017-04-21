<?php

namespace Sabichona\Http\Controllers;

use Illuminate\Http\Request;
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

        $results = [];

        foreach ($knowledges as $knowledge) {

            $results[] = [
                'url' => $knowledge->url(),
                'excerpt' => $knowledge->excerpt(),
            ];

        }

        if (! $request->has('search'))
            $message = 'Behold the knowledge!';
        else if ($knowledges->count() > 0)
            $message = 'Look what I know about this';
        else
            $message = 'I dont\'t know about this';

        return [

            'status' => true,
            'message' => $message,
            'data' => [
                'results' => $knowledges->count(),
                'knowledges' => $results,
            ],

        ];

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