<?php
namespace Dersam\RequestTracker\Tests;

use Dersam\RequestTracker\Action\ReplyTicket;

/**
 *
 *
 * @author Sam Schmidt <samuel@dersam.net>
 * @since 2016-02-09
 */
class ClientTest extends \PHPUnit_Framework_TestCase
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

        $action = new \Dersam\RequestTracker\Action\CreateTicket([
            'Queue'=>'General',
            'Requestor'=>'test@example.com',
            'Subject'=>'Lorem Ipsum',
            'Text'=>'dolor sit amet'
        ]);

        $id = $rt->send($action);

        $this->assertTrue(is_int($id));
    }

    public function testReplyTicket()
    {
        $rt = $this->getRequestTracker();

        $action = new \Dersam\RequestTracker\Action\CreateTicket([
            'Queue'=>'General',
            'Requestor'=>'test@example.com',
            'Subject'=>'Lorem Ipsum',
            'Text'=>'dolor sit amet'
        ]);

        $id = $rt->send($action);

        $action = new ReplyTicket([
            'id' => $id,
            'Text' => 'this is a test reply'
        ]);
        $out = $rt->send($action);

        $this->assertTrue($out);
    }
}
