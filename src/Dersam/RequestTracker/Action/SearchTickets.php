<?php
/**
 *
 *
 * @author Sam Schmidt <samuel@dersam.net>
 * @since 2016-02-11
 */

namespace Dersam\RequestTracker\Action;

use Dersam\RequestTracker\Action;

class SearchTickets extends Action
{
    protected $endpoint = "/search/";
    protected $requiredParameters = ['query', 'orderBy'];
    protected $defaults = [
        'format' => 's',
        'type' => 'ticket'
    ];

    public function getEndpoint()
    {
        return
            $this->endpoint
            ."{$this->parameters['type']}?query="
            .urlencode($this->parameters['query'])
            ."&orderby={$this->parameters['orderBy']}"
            ."&format={$this->parameters['format']}"
        ;
    }
}
