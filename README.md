# php-nchan-client

__Note: This project is under development. The api (class and method names) will change.
A stable version (1.0.0) will exist in the next weeks.__

__Table of contents__

* [Overview](#overview)
* [Installation](#installation)
* [Usage](#usage)
  * [Publish a message](#publish-a-message)
  * [Get channel information](#get-channel-information)
  * [Delete a channel](#delete-a-channel)
  * [Nchan status information](#nchan-status-information)
  * [Use with authentication](#use-with-authentication)
* [Extend with another HTTP Client library](#extend-with-another-http-client-library)

## Overview

This is a PHP client for [https://nchan.io](https://nchan.io).

This library comes with a simple http client with some authentication features. If you need more, you can for sure
change this library with another like guzzle. Take a look below at
"[Extend with another HTTP Client library](#extend-with-another-http-client-library)".

## Installation

```
composer require marein/php-nchan-client
```

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
The shipped php client supports basic and bearer authentication. It needs to be setup as follows.

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

## Extend with another HTTP Client library

Sometimes, the shipped client is not enough and you want to use features from other libraries like guzzle.
You can change the http client easily because of the \Marein\Nchan\Http\Client interface. I've created a guzzle adapter
for those who want to use guzzle. This is also a good example to look at, if you want to use another library. The
guzzle adapter lives at
[marein/php-nchan-client-guzzle-adapter](https://github.com/marein/php-nchan-client-guzzle-adapter).