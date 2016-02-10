#rtclient
[![Build Status](https://travis-ci.org/dersam/RTPHPLib.svg?branch=master)](https://travis-ci.org/dersam/RTPHPLib)

Provides a PHP client library for the Request Tracker API.

##Requirements
* PHP 7.0+
* curl

##Contributing
* Fork the repository.
* Make your changes (Adding tests makes you a good person!).
* Submit pull requests against master.

##Tests
Running `phpunit` from the project root will run the tests. The tests currently 
expect an RT instance running on `localhost:8080`.  You can easily get a local 
instance by using the `netsandbox/request-tracker` docker container. If your
instance is not at localhost, you can specify a different uri by setting the
`RT_ENDPOINT` environment variable.
