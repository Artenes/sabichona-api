<?php

namespace Sabichona\Formatters;

/**
 * Formats the response for the index action of the KnowledgesController.
 * @package Sabichona\Formatters
 */
class KnowledgeIndexFormatter
{

    protected $hasSearch;
    protected $knowledges;

    /**
     * KnowledgeIndexFormatter constructor.
     * @param $hasSearch
     * @param $knowledges
     */
    public function __construct($knowledges, $hasSearch = false)
    {

        $this->hasSearch = $hasSearch;
        $this->knowledges = $knowledges;

    }

    /**
     * Formats the response.
     *
     * @return array
     */
    public function formatResponse()
    {

        return [

            'status' => $this->status(),
            'message' => $this->message(),
            'data' => [
                'results' => count($this->knowledges),
                'knowledges' => $this->knowledges(),
            ],

        ];

    }

    /**
     * Get the status for the response.
     *
     * @return bool
     */
    public function status()
    {

        return count($this->knowledges) > 0;

    }

    /**
     * Format the knowledges as an array.
     *
     * @return array
     */
    public function knowledges()
    {

        $results = [];

        foreach ($this->knowledges as $knowledge) {

            $results[] = [
                'content' => $knowledge->content,
                'created_at' => $knowledge->created_at->toDateTimeString(),
            ];

        }

        return $results;

    }

    /**
     * Decides witch message to use.
     *
     * @return string
     */
    public function message()
    {

        $itHasResults = count($this->knowledges) > 0;

        if (!$this->hasSearch && $itHasResults)
            return 'Behold the knowledge!';

        if(!$this->hasSearch && !$itHasResults)
            return 'Didn\'t find shit.';

        if ($itHasResults)
            return 'Look what I know about this';

        return 'I dont\'t know about this';

    }

}