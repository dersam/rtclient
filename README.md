#rtclient

[![Build Status](https://travis-ci.org/dersam/rtclient.svg?branch=master)](https://travis-ci.org/dersam/rtclient)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/dersam/rtclient/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/dersam/rtclient/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/dersam/rtclient/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/dersam/rtclient/?branch=master)

Provides a PHP client library for the Request Tracker API.

##Requirements
* PHP 5.5+
* curl

rtclient will only ever officially support current (non-EOL) versions of PHP.

##Contributing
* Fork the repository.
* Make your changes. Include PHPUnit tests to cover your changes. Pull requests
without tests will not be merged as quickly, as it will take more time to review.
* Submit pull requests against master.

##Tests
TODO: Improve documentation on setting up test environment.

Running `phpunit` from the project root will run the tests. The tests currently 
expect an RT instance running on `localhost:8080`.  You can easily get a local 
instance by using the `netsandbox/request-tracker` docker container. If your
instance is not at localhost, you can specify a different uri by setting the
`RT_ENDPOINT` environment variable.
