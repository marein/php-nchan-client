# php-nchan-client

__Note: This project is under development. The api (class and method names) might change.__

This is a PHP client for [https://nchan.io](https://nchan.io).

## Roadmap to 1.0.0

* Unit tests
* Implement the group api
* Renaming things and code documentation

## Installation

```
composer require marein/php-nchan-client
```

## Usage

### Publish a message

```php
<?php

namespace {

    use Marein\Nchan\Message;
    use Marein\Nchan\Nchan;

    include '/path/to/autoload.php';

    $nchan = new Nchan('http://my-nchan-domain');  
    $channelInformation = $nchan->channel('/path-to-publisher-endpoint')->publish(new Message(
        'message-name',
        'payload'
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

### Basic nchan information

First you have to create a location with the "nchan_stub_status;" directive. Then you can query it.

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

## Extend with another HTTP Client library

Sometimes, the shipped client is not enough and you want to use features from other libraries like guzzle.
You can change the http client easily because of the \Marein\Nchan\Http\Client interface. I created a guzzle adapter
for those who want to use guzzle. This is also a good example to look at, if you want to use another library. The
guzzle adapter lives at
[marein/php-nchan-client-guzzle-adapter](https://github.com/marein/php-nchan-client-guzzle-adapter).