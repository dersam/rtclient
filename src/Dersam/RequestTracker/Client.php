<?php
namespace Dersam\RequestTracker;

use Dersam\RequestTracker\Exceptions\AuthenticationException;
use Dersam\RequestTracker\Exceptions\HttpException;
use Dersam\RequestTracker\Exceptions\RequestTrackerException;

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

    public function send(Action $action): array
    {
        return
        $action->processResponse(
            $this->post(
                $action->buildMessage($this)
            )
        );
    }

    protected function post($data)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->requestUrl);
        curl_setopt($ch, CURLOPT_POST, 1);

        if (!empty($contentType)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: $contentType"));
        }

        array_unshift($data, "");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
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
