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
    protected $requiredParameters = [];

    abstract function validate();
    abstract function getEndpoint();
    abstract function processResponse();
}
