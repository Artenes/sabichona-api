<?php

namespace Sabichona\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * Validates a request to store a Knowledge.
 * @package Sabichona\Http\Requests
 */
class StoreKnowledgeRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {

        return true;

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'content' => 'required|max:500',
        ];

    }

    /**
     * Generates a response in the api standard.
     *
     * @param array $errors
     * @return JsonResponse
     */
    public function response(array $errors)
    {

        $response = [

            'status' => false,
            'message' => 'I didn\'t understood your knowledge',
            'errors' => $errors,

        ];

        return new JsonResponse($response, Response::HTTP_UNPROCESSABLE_ENTITY);

    }

}