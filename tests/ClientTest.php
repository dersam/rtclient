<?php
namespace Dersam\RequestTracker\Tests;

use Dersam\RequestTracker\Action\CommentTicket;
use Dersam\RequestTracker\Action\ReplyTicket;
use Dersam\RequestTracker\Action\SearchTickets;
use Dersam\RequestTracker\Client;
use Dersam\RequestTracker\Exceptions\ActionException;

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

    public function getConnection()
    {
        $host = $this->getHost();

        return new \Dersam\RequestTracker\Connection(
            "$host",
            'root',
            'password'
        );
    }

    public function getClient()
    {
        return new Client($this->getConnection());
    }

    public function testCreateTicket()
    {
        $id = $this->getClient()->createTicket(
            'General',
            'test@example.com',
            [
                'Subject'=>'Lorem Ipsum',
                'Text'=>'dolor sit amet'
            ]
        );

        $this->assertTrue(is_int($id));
    }

    public function testReplyTicket()
    {
        $client = $this->getClient();

        $id = $client->createTicket(
            'General',
            'test@example.com',
            [
                'Subject'=>'Lorem Ipsum',
                'Text'=>'dolor sit amet'
            ]
        );

        $out = $client->replyTicket($id, [
            'Text' => 'this is a test reply'
        ]);

        $this->assertTrue($out);
    }

    public function testCommentTicket()
    {
        $client = $this->getClient();

        $id = $client->createTicket(
            'General',
            'test@example.com',
            [
                'Subject'=>'Lorem Ipsum',
                'Text'=>'dolor sit amet'
            ]
        );

        $out = $client->commentTicket($id, [
            'Text' => 'this is a test comment'
        ]);

        $this->assertTrue($out);
    }

    public function testSearchTickets()
    {
        $rt = $this->getConnection();
        $action = new SearchTickets([
            'query' => "Owner='Nobody'",
            'orderBy' => '-Created'
        ]);

        $searchResults = $this->getClient()->search(
            "Owner='Nobody'",
            "-Created"
        );

        $this->assertInternalType('array', $searchResults);
        $this->assertEquals('Lorem Ipsum', current($searchResults));
    }

    public function testValidationFail()
    {
        $this->setExpectedException(ActionException::class);

        $rt = $this->getConnection();
        $action = new \Dersam\RequestTracker\Action\CreateTicket([]);
        $id = $rt->send($action);
    }

    public function testActionSet()
    {
        $rt = $this->getConnection();
        $action = new \Dersam\RequestTracker\Action\CreateTicket([]);
        $action->set('Queue', 'General');
        $action->set('Requestor', 'bob@example.com');
        $id = $rt->send($action);

        $this->assertTrue(is_int($id));
    }
}
