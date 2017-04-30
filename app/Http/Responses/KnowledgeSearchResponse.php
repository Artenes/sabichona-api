<?php

namespace Sabichona\Http\Responses;

use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Sabichona\Models\Knowledge;

/**
 * Generate responses for knowledge search.
 * @package Sabichona\Http\Responses
 */
class KnowledgeSearchResponse
{

    /**
     * Response for when nothing is found at a location.
     *
     * @return JsonResponse
     */
    public function thereIsNothingInThisLocation()
    {

        $data = [

            'she_said' => trans('setences.this_is_the_first_time'),
            'state' => 'first',
            'total' => 0,
            'per_page' => config('pagination.per_page'),
            'current_page' => 1,
            'next_page_url' => null,
            'prev_page_url' => null,
            'knowledges' => []

        ];

        return response()->json($data);

    }

    /**
     * Response form when a search is made with
     * an empty search parameter. A random
     * knowledge is returned.
     *
     * @param Knowledge $knowledge
     * @return JsonResponse
     */
    public function randomKnowledge(Knowledge $knowledge)
    {

        $data = [

            'she_said' => trans('setences.i_dont_know_what_you_want'),
            'state' => 'random',
            'total' => 0,
            'per_page' => config('pagination.per_page'),
            'current_page' => 1,
            'next_page_url' => null,
            'prev_page_url' => null,
            'knowledges' => [
                $knowledge->present()
            ]

        ];

        return response()->json($data);

    }

    /**
     * Response for when nothing is found.
     *
     * @return JsonResponse
     */
    public function foundNothing()
    {

        $data = [

            'she_said' => trans('setences.couldnt_find_something'),
            'state' => 'nothing',
            'total' => 0,
            'per_page' => config('pagination.per_page'),
            'current_page' => 1,
            'last_page' => 1,
            'next_page_url' => null,
            'prev_page_url' => null,
            'from' => 1,
            'to' => 1,
            'knowledges' => []

        ];

        return response()->json($data);

    }

    /**
     * Response for when something is found.
     *
     * @param Paginator $knowledges
     * @param $search
     * @return JsonResponse
     */
    public function foundSomething(LengthAwarePaginator $knowledges, $search)
    {

        $append = ['search' => $search];

        $data = [

            'she_said' => trans('setences.have_some_knowledge'),
            'state' => 'found',
            'total' => $knowledges->total(),
            'per_page' => config('pagination.per_page'),
            'current_page' => $knowledges->currentPage(),
            'next_page_url' => $knowledges->appends($append)->nextPageUrl(),
            'prev_page_url' => $knowledges->appends($append)->previousPageUrl(),
            'knowledges' => []

        ];

        foreach ($knowledges as $knowledge)
            $data['knowledges'][] = $knowledge->present();

        return response()->json($data);

    }

}