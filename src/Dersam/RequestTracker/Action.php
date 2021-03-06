<?php
namespace Dersam\RequestTracker;

/**
 *
 *
 * @author Sam Schmidt <samuel@dersam.net>
 * @since 2016-02-09
 */
abstract class Action
{
    protected $endpoint;
    protected $lastValidationError;
    protected $requiredParameters = [];
    protected $parameters = [];
    protected $defaults = [];

    public function __construct(array $parameters)
    {
        $this->parameters($parameters);
    }

    public function set($fieldName, $value)
    {
        $this->parameters[$fieldName] = $value;
        return $this;
    }

    public function parameters(array $parameters)
    {
        $this->parameters = $parameters;
    }

    public function getEndpoint()
    {
        $endpoint = $this->endpoint;

        if (isset($this->parameters['id'])) {
            $endpoint = str_replace(
                '{id}',
                $this->parameters['id'],
                $endpoint
            );
        }

        return $endpoint;
    }

    /**
     * @return mixed
     */
    public function getLastValidationError()
    {
        return $this->lastValidationError;
    }

    public function validate()
    {
        $missing = array_diff_key(
            $this->requiredParameters,
            array_keys($this->parameters)
        );

        $valid = true;

        if (count($missing) > 0) {
            $valid = false;

            $e = 'Missing required fields: ';
            foreach ($missing as $key) {
                $e .= $key.' ';
            }

            $this->lastValidationError = $e;
        }

        return $valid;
    }

    public function buildMessage(Connection $client)
    {
        $message = [
            'user' => $client->getUser(),
            'pass' => $client->getPassword()
        ];

        if (!empty($this->parameters)) {
            $message['content'] = $this->compileParameters();
        }

        return $message;
    }

    private function compileParameters()
    {
        $content = "";
        foreach ($this->parameters as $key => $value) {
            $content .= "$key: $value".chr(10);
        }
        return $content;
    }

    /**
     * @param array $response
     * @return mixed
     */
    public function processResponse(array $response)
    {
        $response = explode(chr(10), $response['body']);
        array_shift($response); //skip RT status response
        array_shift($response); //skip blank line
        array_pop($response); //remove empty blank line in the end
        array_pop($response); //remove empty blank line in the end

        $parsedResponseData = array();
        $lastkey = null;
        foreach ($response as $line) {
            //RT will always preface a multiline with at least one space
            if (substr($line, 0, 1)==' ') {
                $parsedResponseData[$lastkey] .= "\n".trim($line);
                continue;
            }
            $parts = explode(':', $line);
            $key = array_shift($parts);
            $value = implode(':', $parts);
            $parsedResponseData[$key] = trim($value);
            $lastkey=$key;
        }

        return $parsedResponseData;
    }

    public function prepare()
    {
        $this->parameters = array_merge(
            $this->defaults,
            $this->parameters
        );
    }
}
