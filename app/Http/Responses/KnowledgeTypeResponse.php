<?php

namespace Sabichona\Http\Responses;

use Illuminate\Database\Eloquent\Collection;
use Sabichona\Http\ApiResponse;
use Sabichona\Models\Knowledge;

/**
 * Generate responses for knowledge types.
 *
 * @package Sabichona\Http\Responses
 */
class KnowledgeTypeResponse
{

    /**
     * Response for the latest knowledges.
     *
     * @param Collection $knowledges
     * @return ApiResponse
     */
    public function haveTheLatest(Collection $knowledges)
    {

        $data = [
            'knowledges' => [],
        ];

        if ($knowledges->isEmpty())
            return ApiResponse::make('nothing', trans('setences.excuse_me_but_latests_are_late'), $data);

        foreach ($knowledges as $knowledge)
            $data['knowledges'][] = $knowledge->present();

        return ApiResponse::make('latest', trans('setences.here_have_the_latest_knowledges'), $data);

    }

    /**
     * Response for the most useful knowledges.
     *
     * @param Collection $knowledges
     * @return ApiResponse
     */
    public function haveTheMostUsefulOnes(Collection $knowledges)
    {

        $data = [
            'knowledges' => [],
        ];

        if ($knowledges->isEmpty())
            return ApiResponse::make('nothing', trans('setences.excuse_me_but_useful_is_full'), $data);

        foreach ($knowledges as $knowledge)
            $data['knowledges'][] = $knowledge->present();

        return ApiResponse::make('useful', trans('setences.these_are_the_most_useful'), $data);

    }

    /**
     * Response the when an invalid knowledege type is provided.
     *
     * @param Knowledge $knowledge
     * @return ApiResponse
     */
    public function haveRandomKnowledge(Knowledge $knowledge)
    {

        $data = [
            'knowledges' => [$knowledge->present()],
        ];

        return ApiResponse::make('random', trans('setences.cannot_put_finger_on_knowledge_type'), $data);

    }

}