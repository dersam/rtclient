<?php
/**
 *
 *
 * @author Sam Schmidt <samuel@dersam.net>
 * @since 2016-02-11
 */

namespace Dersam\RequestTracker\Action;


use Dersam\RequestTracker\Action;

class CommentTicket extends Action
{
    protected $endpoint = '/ticket/{id}/comment';
    protected $requiredParameters = ['id'];
    protected $defaults = [
        'Action' => 'comment'
    ];

    public function processResponse(array $response)
    {
        $response = parent::processResponse($response);
        return key($response) == '# Comments added';
    }
}
