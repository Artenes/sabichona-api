<?php

namespace Sabichona\Http\Responses;

use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Sabichona\Http\ApiResponse;
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
            'knowledges' => []
        ];

        $pagination = [
            'total' => 0,
            'per_page' => config('pagination.per_page'),
            'current_page' => 1,
            'next_page_url' => null,
            'prev_page_url' => null,
        ];

        return ApiResponse::paginated('first', trans('setences.this_is_the_first_time'), $data, $pagination);

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

        $data = [ 'knowledges' => [ $knowledge->present()] ];

        $pagination = [

            'total' => 0,
            'per_page' => config('pagination.per_page'),
            'current_page' => 1,
            'next_page_url' => null,
            'prev_page_url' => null,

        ];

        return ApiResponse::paginated('random', trans('setences.i_dont_know_what_you_want'), $data, $pagination);

    }

    /**
     * Response for when nothing is found.
     *
     * @return JsonResponse
     */
    public function foundNothing()
    {

        $data = [ 'knowledges' => [] ];

        $pagination = [

            'total' => 0,
            'per_page' => config('pagination.per_page'),
            'current_page' => 1,
            'last_page' => 1,
            'next_page_url' => null,
            'prev_page_url' => null,
            'from' => 1,
            'to' => 1,

        ];

        return ApiResponse::paginated('nothing', trans('setences.couldnt_find_something'), $data, $pagination);

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

        $data = [ 'knowledges' => [] ];

        $pagination = [

            'total' => $knowledges->total(),
            'per_page' => config('pagination.per_page'),
            'current_page' => $knowledges->currentPage(),
            'next_page_url' => $knowledges->appends($append)->nextPageUrl(),
            'prev_page_url' => $knowledges->appends($append)->previousPageUrl(),

        ];

        foreach ($knowledges as $knowledge)
            $data['knowledges'][] = $knowledge->present();

        return ApiResponse::paginated('found', trans('setences.have_some_knowledge'), $data, $pagination);

    }

}