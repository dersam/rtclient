<?php
namespace Dersam\RequestTracker\Action\Ticket;

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

    function processResponse()
    {
        // TODO: Implement processResponse() method.
    }
}
