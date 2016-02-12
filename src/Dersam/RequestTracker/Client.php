<?php
namespace Dersam\RequestTracker;

use Dersam\RequestTracker\Action\ReplyTicket;
use Dersam\RequestTracker\Exceptions\ActionException;
use Dersam\RequestTracker\Exceptions\AuthenticationException;
use Dersam\RequestTracker\Exceptions\HttpException;
use Dersam\RequestTracker\Exceptions\RequestTrackerException;

/**
 *
 *
 * @author Sam Schmidt <samuel@dersam.net>
 * @since 2016-02-09
 *
 * @method int|boolean createTicket($parameters)
 * @method int|boolean replyTicket($parameters)
 */
class Client
{
    protected $user;
    protected $password;
    protected $host;

    public function __construct($host, $user, $password)
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
        return $this->host.'/REST/1.0';
    }

    public function send(Action $action)
    {
        if (!$action->validate()) {
            throw new ActionException('Request validation failed: '.$action->getLastValidationError());
        }

        return
        $action->processResponse(
            $this->post(
                $this->getHost().$action->getEndpoint(),
                $action->buildMessage($this)
            )
        );
    }

    protected function post($destination, array $message)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $destination);
        curl_setopt($ch, CURLOPT_POST, 1);

        array_unshift($message, "");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $message);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = "";
        if ($response===false) {
            $error = curl_error($ch);
        }
        curl_close($ch);

        if ($response === false) {
            throw new RequestTrackerException("A fatal error occurred when communicating with RT :: ".$error);
        }

        if ($code == 401) {
            throw new AuthenticationException("The user credentials were refused.");
        }

        if ($code != 200) {
            throw new HttpException("An error occurred : [$code] :: $response");
        }

        $response =  array('code'=>$code, 'body'=>$response);
        return $response;
    }
}
