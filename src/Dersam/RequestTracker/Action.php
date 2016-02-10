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

    public function set(string $fieldName, $value)
    {
        $this->parameters[$fieldName] = $value;
        return $this;
    }

    public function getEndpoint() : string
    {
        return $this->endpoint;
    }

    /**
     * @return mixed
     */
    public function getLastValidationError() : string
    {
        return $this->lastValidationError;
    }

    public function validate() : boolean
    {
        $missing = array_diff_key(
            $this->requiredParameters,
            $this->parameters
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

    public function getContent()
    {
        return $this->parameters;
    }

    abstract function processResponse();
}
