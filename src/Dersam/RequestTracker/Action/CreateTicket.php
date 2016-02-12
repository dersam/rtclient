<?php
namespace Dersam\RequestTracker\Action;

use Dersam\RequestTracker\Action;

/**
 *
 *
 * @author Sam Schmidt <samuel@dersam.net>
 * @since 2016-02-09
 */
class CreateTicket extends Action
{
    protected $endpoint = "/ticket/new";
    protected $requiredParameters = [];

    public function processResponse(array $response)
    {
        $response = parent::processResponse($response);
        $matches = [];

        return preg_match('/^# Ticket\b (\d+)\b created\.$/', key($response), $matches) ? (int) $matches[1] : false;
    }
}
