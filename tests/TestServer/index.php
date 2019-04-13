<?php
declare(strict_types=1);

namespace {

    if (isset($_GET['statusCode'])) {
        http_response_code((int)$_GET['statusCode']);
    }

    echo serialize([
        'GET'    => $_GET,
        'POST'   => $_POST,
        'SERVER' => $_SERVER
    ]);
}
