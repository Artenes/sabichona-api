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

            'status' => true,
            'message' => $this->message(),
            'data' => [
                'results' => count($this->knowledges),
                'knowledges' => $this->knowledges(),
            ],

        ];

    }

    /**
     * Format the knowledges as an array.
     *
     * @return array
     */
    protected function knowledges()
    {

        $results = [];

        foreach ($this->knowledges as $knowledge) {

            $results[] = [
                'url' => $knowledge->url(),
                'excerpt' => $knowledge->excerpt(),
            ];

        }

        return $results;

    }

    /**
     * Decides witch message to use.
     *
     * @return string
     */
    protected function message()
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