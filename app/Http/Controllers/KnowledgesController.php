<?php

namespace Sabichona\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
     * @return array|JsonResponse
     */
    public function index(Request $request)
    {

        $knowledges = Knowledge::remember($request->get('search'));

        $formatter = new KnowledgeIndexFormatter($knowledges, $request->has('search'));

        $response = $formatter->formatResponse();

        if ($formatter->status() === false)
            return new JsonResponse($response, Response::HTTP_NOT_FOUND);

        return $response;

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