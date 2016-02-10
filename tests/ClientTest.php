<?php

/**
 *
 *
 * @author Sam Schmidt <samuel@dersam.net>
 * @since 2016-02-09
 */
class ClientTest extends PHPUnit_Framework_TestCase
{
    private function getHost()
    {
        $host = getenv('RT_ENDPOINT');

        if (!empty($host)) {
            return "http://$host:8080";
        }

        return 'http://localhost:8080';
    }

    public function getRequestTracker()
    {
        $host = $this->getHost();

        return new \Dersam\RequestTracker\Client(
            "$host",
            'root',
            'password'
        );
    }

    public function testCreateTicket()
    {
        $rt = $this->getRequestTracker();

        $id = $rt->createTicket([
            'Queue'=>'General',
            'Requestor'=>'test@example.com',
            'Subject'=>'Lorem Ipsum',
            'Text'=>'dolor sit amet'
        ]);

        $this->assertTrue(is_int($id));
    }
}
