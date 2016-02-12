<?php
/**
 * Convenience class- wraps the specific functionality of the api in a
 * friendlier interface.
 *
 * @author Sam Schmidt <samuel@dersam.net>
 * @since 2016-02-11
 */

namespace Dersam\RequestTracker;


use Dersam\RequestTracker\Action\CommentTicket;
use Dersam\RequestTracker\Action\CreateTicket;
use Dersam\RequestTracker\Action\ReplyTicket;
use Dersam\RequestTracker\Action\SearchTickets;

class Client
{
    protected $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param $queue
     * @param $requestor
     * @param array $parameters
     * @return int
     * @throws Exceptions\ActionException
     */
    public function createTicket($queue, $requestor, $parameters = [])
    {
        $parameters['Queue'] = $queue;
        $parameters['Requestor'] = $requestor;

        return $this->connection->send(new CreateTicket($parameters));
    }

    /**
     * @param $id
     * @param array $parameters
     * @return boolean
     * @throws Exceptions\ActionException
     */
    public function replyTicket($id, $parameters = [])
    {
        $parameters['id'] = $id;

        return $this->connection->send(new ReplyTicket($parameters));
    }

    public function commentTicket($id, $parameters = [])
    {
        $parameters['id'] = $id;

        return $this->connection->send(new CommentTicket($parameters));
    }

    public function search($query, $orderBy, $type = 'ticket', $format = 's')
    {
        return $this->connection->send(new SearchTickets([
            'type' => $type,
            'query' => $query,
            'orderBy' => $orderBy,
            'format' => $format
        ]));
    }
}
