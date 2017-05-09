<?php

namespace Sabichona\Http;

use Illuminate\Http\JsonResponse;
use InvalidArgumentException;

/**
 * Formats the response as json.
 *
 * @package App\Http
 */
class ApiResponse extends JsonResponse
{

    /**
     * The message to use in the response.
     *
     * @var string
     */
    protected $sheSaid;

    /**
     * The data of the response.
     *
     * @var
     */
    protected $responseData;

    /**
     * The errors array.
     *
     * @var array
     */
    protected $errors;

    /**
     * The additional envelopes that will
     * be appended in the response.
     *
     * @var array
     */
    protected $envelopes;

    /**
     * The state of the response in readable string.
     *
     * @var string
     */
    protected $state;

    /**
     * ApiResponse constructor.
     *
     * @param string $message
     * @param array $data
     * @param array $errors
     * @param int $statusCode
     * @param array $headers
     * @param array $envelopes
     * @param int $options
     * @param string $state
     */
    public function __construct($state = '', $message = '', $data = [], $errors = [], $statusCode = 200, $headers = [], $envelopes = [], $options = 0)
    {

        $this->sheSaid = $message;
        $this->responseData = $data;
        $this->errors = $errors;
        $this->envelopes = $envelopes;
        $this->state = $state;

        parent::__construct([], $statusCode, $headers, $options);

        $this->refreshData();

    }

    /**
     * Make a new instance of the class.
     *
     * @param string $state
     * @param string $message
     * @param array $data
     * @param array $errors
     * @param int $statusCode
     * @param array $headers
     * @param array $envelopes
     * @param int $options
     * @return ApiResponse
     */
    public static function make($state = '', $message = '', $data = [], $errors = [], $statusCode = 200, $headers = [], $envelopes = [], $options = 0)
    {

        return new static($state, $message, $data, $errors, $statusCode, $headers, $envelopes, $options);

    }

    /**
     * Returns a response with pagination.
     *
     * @param string $state
     * @param string $sheSaid
     * @param array $data
     * @param array $pagination
     * @return static
     */
    public static function paginated($state = '', $sheSaid = '', $data = [], $pagination = [])
    {

        return new static($state, $sheSaid, $data, [], 200, [], ['pagination' => $pagination]);

    }

    /**
     * Creates an unauthorized response.
     *
     * @param string $message
     * @return ApiResponse
     */
    public static function unauthorized($message = '')
    {

        return new static('', $message, [], [], static::HTTP_UNAUTHORIZED);

    }

    /**
     * Creates a failed validation response.
     *
     * @param string $message
     * @param array $errors
     * @return static
     */
    public static function failedValidation($message = '', $errors = [])
    {

        return new static('', $message, [], $errors, static::HTTP_UNPROCESSABLE_ENTITY);

    }

    /**
     * Sets the message.
     *
     * @param $message
     * @return $this
     */
    public function setWhatSheSaid($message)
    {

        $this->sheSaid = $message;
        $this->refreshData();

        return $this;

    }

    /**
     * Sets the data for the response.
     *
     * @param $data
     * @return $this
     */
    public function setResponseData($data = [])
    {

        $this->responseData = $data;
        $this->refreshData();

        return $this;

    }

    /**
     * Add an error.
     *
     * @param $code
     * @param $message
     * @return $this
     */
    public function addError($code, $message)
    {

        $this->errors[] = [
            'code' => $code,
            'message' => $message,
        ];
        $this->refreshData();

        return $this;

    }

    /**
     * Sets the error array.
     *
     * @param $errors
     * @return $this
     */
    public function setErrors($errors) {

        $this->errors = $errors;
        $this->refreshData();

        return $this;

    }

    /**
     * Set an envelope to the response.
     *
     * @param $envelope
     * @param $data
     * @return $this
     */
    public function setEnvelope($envelope, $data)
    {

        $this->envelopes[$envelope] = $data;
        $this->refreshData();

        return $this;

    }

    /**
     * Changes the current state.
     *
     * @param $state
     * @return $this
     */
    public function setState($state)
    {

        $this->state = $state;
        $this->refreshData();

        return $this;

    }

    /**
     * Gets the content formatted as an array.
     *
     * @return ApiResponse
     */
    protected function refreshData()
    {

        $response = [
            'response' => [
                'she_said' => $this->sheSaid,
                'status' => $this->statusCode,
                'state' => $this->state,
            ],
        ];

        if (!empty($this->responseData))
            $response['data'] = $this->responseData;

        if (!empty($this->errors))
            $response['errors'] = $this->errors;

        if (!empty($this->envelopes))
            $response = array_merge($response, $this->envelopes);

        $this->data = json_encode($response);

        return $this->update();

    }

}