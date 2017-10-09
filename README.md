# php-nchan-client

__Note: This project is under development. The api (class and method names) will change.
We are close to [milestone 1.0.0](https://github.com/marein/php-nchan-client/milestone/1).__

[![Build Status](https://travis-ci.org/marein/php-nchan-client.svg?branch=master)](https://travis-ci.org/marein/php-nchan-client)
[![Coverage Status](https://coveralls.io/repos/github/marein/php-nchan-client/badge.svg?branch=master)](https://coveralls.io/github/marein/php-nchan-client?branch=master)

__Table of contents__

* [Overview](#overview)
* [Installation and requirements](#installation-and-requirements)
* [Usage](#usage)
  * [Publish a message](#publish-a-message)
  * [Get channel information](#get-channel-information)
  * [Delete a channel](#delete-a-channel)
  * [Nchan status information](#nchan-status-information)
  * [Use with authentication](#use-with-authentication)
* [Exchange the provided http client](#exchange-the-provided-http-client)

## Overview

This is a PHP client for [https://nchan.io](https://nchan.io).

This library provides a http client which has some authentication features. If you need more, you can for sure
exchange this library with another like guzzle. Take a look below to
"[Exchange the provided http client](#exchange-the-provided-http-client)".

## Installation and requirements

```
composer require marein/php-nchan-client
```

If you use the provided http client (default if you don't set anything),
you must enable the php configuration
[allow_url_fopen](http://php.net/manual/en/filesystem.configuration.php#ini.allow-url-fopen).

## Usage

### Publish a message

```php
<?php

namespace {

    use Marein\Nchan\Api\Model\PlainTextMessage;
    use Marein\Nchan\Nchan;

    include '/path/to/autoload.php';

    $nchan = new Nchan('http://my-nchan-domain');  
    $channelInformation = $nchan->channel('/path-to-publisher-endpoint')->publish(new PlainTextMessage(
        'my-message-name',
        'my message content'
    ));

    // Nchan returns some channel information after publishing a message.
    var_dump($channelInformation);
}
```

### Get channel information

```php
<?php

namespace {

    use Marein\Nchan\Nchan;

    include '/path/to/autoload.php';

    $nchan = new Nchan('http://my-nchan-domain');
    $channelInformation = $nchan->channel('/path-to-publisher-endpoint')->information();

    var_dump($channelInformation);
}
```

### Delete a channel

```php
<?php

namespace {

    use Marein\Nchan\Nchan;

    include '/path/to/autoload.php';

    $nchan = new Nchan('http://my-nchan-domain');
    $isDeleted = $nchan->channel('/path-to-publisher-endpoint')->delete();
}
```

### Nchan status information

First you have to create a location with the "nchan_stub_status" directive. Then you can query it.

```php
<?php

namespace {

    use Marein\Nchan\Nchan;

    include '/path/to/autoload.php';

    $nchan = new Nchan('http://my-nchan-domain');
    $statusInformation = $nchan->status('/path-to-status-location')->information();

    var_dump($statusInformation);
}
```

### Use with authentication

Nchan gives you the possibility to authenticate endpoints with the "nchan_authorize_request" directive.
The provided http client supports basic and bearer authentication. It needs to be setup as follows.

```php
<?php

namespace {

    use Marein\Nchan\HttpAdapter\HttpStreamWrapperClient;
    use Marein\Nchan\HttpAdapter\BasicAuthenticationCredentials;
    use Marein\Nchan\HttpAdapter\BearerAuthenticationCredentials;
    use Marein\Nchan\Nchan;

    include '/path/to/autoload.php';

    // Client with basic authentication
    $adapter = new HttpStreamWrapperClient(
        new BasicAuthenticationCredentials('nchan', 'password')
    );

    // Client with bearer authentication
    $adapter = new HttpStreamWrapperClient(
        new BearerAuthenticationCredentials('my-token')
    );

    $nchan = new Nchan('http://my-nchan-domain', $adapter);
}
```

The \Marein\Nchan\HttpAdapter\HttpStreamWrapperClient class constructor takes an implementation of type
\Marein\Nchan\HttpAdapter\Credentials. As long as you implement that interface, you can build your own authentication
method. Take a look at \Marein\Nchan\HttpAdapter\BasicAuthenticationCredentials to see how this works.

## Exchange the provided http client

Sometimes, the provided client is not enough and you want to use features from other libraries like guzzle.
You can exchange the http client easily because of the \Marein\Nchan\Http\Client interface. I've created a guzzle adapter
for those who want to use guzzle. This is also a good example to look at, if you want to use another library. The
guzzle adapter lives at
[marein/php-nchan-client-guzzle-adapter](https://github.com/marein/php-nchan-client-guzzle-adapter).

Another good reason to exchange the provided client is to gain performance, since the client uses the http stream wrapper
from php. There is a little overhead because the tcp connection gets closed after each request. Other implementations,
like guzzle, can keep the connection alive.