# php-nchan-client

![CI](https://github.com/marein/php-nchan-client/workflows/CI/badge.svg?branch=master)

__Table of contents__

* [Overview](#overview)
* [Installation and requirements](#installation-and-requirements)
* [Usage](#usage)
  * [Publish a message](#publish-a-message)
  * [Get channel information](#get-channel-information)
  * [Delete a channel](#delete-a-channel)
  * [Nchan status information](#nchan-status-information)
  * [Authorize requests](#authorize-requests)
* [PSR-18 compatibility](#psr-18-compatibility)

## Overview

This is a PHP client for [https://nchan.io](https://nchan.io).

## Installation and requirements

```
composer require marein/php-nchan-client
```

If you want to use the
[PSR-18 adapter](#psr-18-compatibility),
install a library that implements PSR-18 http client
([see here](https://packagist.org/providers/psr/http-client-implementation))
and a library that implements PSR-17 http factories
([see here](https://packagist.org/providers/psr/http-factory-implementation)).

If you want to use the built-in http client (default if you don't set anything),
enable the php configuration
[allow_url_fopen](http://php.net/manual/en/filesystem.configuration.php#ini.allow-url-fopen).

## Usage

The following code examples use the built-in http client.

### Publish a message

<details>
  <summary>Show code</summary>

  ```php
  <?php

  namespace {

      use Marein\Nchan\Api\Model\PlainTextMessage;
      use Marein\Nchan\Nchan;

      include '/path/to/autoload.php';

      $nchan = new Nchan('http://my-nchan-domain');
      $channel = $nchan->channel('/path-to-publisher-endpoint');
      $channelInformation = $channel->publish(
          new PlainTextMessage(
              'my-message-name',
              'my message content'
          )
      );

      // Nchan returns some channel information after publishing a message.
      var_dump($channelInformation);
  }
  ```
</details>

### Get channel information

<details>
  <summary>Show code</summary>

  ```php
  <?php

  namespace {

      use Marein\Nchan\Nchan;

      include '/path/to/autoload.php';

      $nchan = new Nchan('http://my-nchan-domain');
      $channel = $nchan->channel('/path-to-publisher-endpoint');
      $channelInformation = $channel->information();

      var_dump($channelInformation);
  }
  ```
</details>

### Delete a channel

<details>
  <summary>Show code</summary>

  ```php
  <?php

  namespace {

      use Marein\Nchan\Nchan;

      include '/path/to/autoload.php';

      $nchan = new Nchan('http://my-nchan-domain');
      $channel = $nchan->channel('/path-to-publisher-endpoint');
      $channel->delete();
  }
  ```
</details>

### Nchan status information

Endpoints with the `nchan_stub_status` directive can be queried as follows.

<details>
  <summary>Show code</summary>

  ```php
  <?php

  namespace {

      use Marein\Nchan\Nchan;

      include '/path/to/autoload.php';

      $nchan = new Nchan('http://my-nchan-domain');
      $status = $nchan->status('/path-to-status-location');
      $statusInformation = $status->information();

      var_dump($statusInformation);
  }
```
</details>

### Authorize requests

Endpoints with the `nchan_authorize_request` directive must be authorized.
The constructor of the
[built-in http client](/src/HttpAdapter/HttpStreamWrapperClient.php)
takes an implementation of type
[Credentials](/src/HttpAdapter/Credentials.php).
This library comes with 2 built-in implementations,
[BasicAuthenticationCredentials](/src/HttpAdapter/BasicAuthenticationCredentials.php)
and
[BearerAuthenticationCredentials](/src/HttpAdapter/BearerAuthenticationCredentials.php).

<details>
  <summary>Show code</summary>

  ```php
  <?php

  namespace {

      use Marein\Nchan\HttpAdapter\BasicAuthenticationCredentials;
      use Marein\Nchan\HttpAdapter\BearerAuthenticationCredentials;
      use Marein\Nchan\HttpAdapter\HttpStreamWrapperClient;
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
</details>

If you use another http client through the
[PSR-18 adapter](#psr-18-compatibility),
the respective http client has its own extension points to modify the request before it is sent.

## PSR-18 compatibility

This library comes with a PSR-18 compatible
[adapter](/src/HttpAdapter/Psr18ClientAdapter.php).
There are good reasons not to use the built-in client.
It's based on the http stream wrapper and `file_get_contents`.
This closes the TCP connection after each request.
Other clients, see below, can keep the connection open.

The following example uses
[guzzlehttp/guzzle](https://packagist.org/packages/guzzlehttp/guzzle)
and
[guzzlehttp/psr7](https://packagist.org/packages/guzzlehttp/psr7).

<details>
  <summary>Show code</summary>

  ```php
  <?php

  namespace {

      use GuzzleHttp\Client;
      use GuzzleHttp\Psr7\HttpFactory;
      use Marein\Nchan\HttpAdapter\Psr18ClientAdapter;
      use Marein\Nchan\Nchan;

      include '/path/to/autoload.php';

      $nchan = new Nchan(
          'http://my-nchan-domain',
          new Psr18ClientAdapter(
              new Client(),
              new HttpFactory(),
              new HttpFactory()
          )
      );
  }
  ```
</details>

The following code example uses
[symfony/http-client](https://packagist.org/packages/symfony/http-client)
and
[nyholm/psr7](https://packagist.org/packages/nyholm/psr7).

<details>
  <summary>Show code</summary>

  ```php
  <?php

  namespace {

      use Marein\Nchan\HttpAdapter\Psr18ClientAdapter;
      use Marein\Nchan\Nchan;
      use Nyholm\Psr7\Factory\Psr17Factory;
      use Symfony\Component\HttpClient\HttpClient;
      use Symfony\Component\HttpClient\Psr18Client;

      include '/path/to/autoload.php';

      // Symfony itself needs an adapter to be PSR-18 compliant.
      $httpClient = new Psr18Client(
          HttpClient::create(),
          new Psr17Factory(),
          new Psr17Factory()
      );

      $nchan = new Nchan(
          'http://my-nchan-domain',
          new Psr18ClientAdapter(
              $httpClient,
              $httpClient,
              $httpClient
          )
      );
  }
  ```
</details>
