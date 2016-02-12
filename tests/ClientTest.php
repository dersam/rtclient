<?php
namespace Dersam\RequestTracker\Tests;

use Dersam\RequestTracker\Action\CommentTicket;
use Dersam\RequestTracker\Action\ReplyTicket;
use Dersam\RequestTracker\Action\SearchTickets;

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

        return new \Dersam\RequestTracker\Connection(
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

    public function testCommentTicket()
    {
        $rt = $this->getRequestTracker();

        $action = new \Dersam\RequestTracker\Action\CreateTicket([
            'Queue'=>'General',
            'Requestor'=>'test@example.com',
            'Subject'=>'Lorem Ipsum',
            'Text'=>'dolor sit amet'
        ]);

        $id = $rt->send($action);

        $action = new CommentTicket([
            'id' => $id,
            'Text' => 'this is a test comment'
        ]);
        $out = $rt->send($action);

        $this->assertTrue($out);
    }

    public function testSearchTickets()
    {
        $rt = $this->getRequestTracker();
        $action = new SearchTickets([
            'query' => "Owner='Nobody'",
            'orderBy' => '-Created'
        ]);

        $searchResults = $rt->send($action);

        $this->assertInternalType('array', $searchResults);
        $this->assertEquals('Lorem Ipsum', current($searchResults));
    }
}
