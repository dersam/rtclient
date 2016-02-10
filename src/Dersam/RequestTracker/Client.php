<?php
namespace Dersam\RequestTracker;

/**
 *
 *
 * @author Sam Schmidt <samuel@dersam.net>
 * @since 2016-02-09
 */
class Client
{
    protected $user;
    protected $password;
    protected $host;

    public function __construct(string $user, string $password, string $host)
    {
        $this->user = $user;
        $this->password = $password;
        $this->host = $host;
    }

    /**
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    public function send(Action $action): Response
    {
        $message = $action->buildMessage($this);
    }
}
