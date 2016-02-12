<?php
/**
 * Convenience class- wraps the specific functionality of the api in a
 * friendlier interface.
 *
 * @author Sam Schmidt <samuel@dersam.net>
 * @since 2016-02-11
 */

namespace Dersam\RequestTracker;


class Client
{
    protected $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }
}
