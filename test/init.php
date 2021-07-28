<?php

error_reporting(E_ALL);
set_error_handler(function (int $code, string $message, string $file, int $line, $ctx) {
    echo "BEGIN ERROR CONTEXT\n\n";
    var_dump($ctx);
    echo "\nEND ERROR CONTEXT\n\n";
    $type = [
        E_DEPRECATED => 'E_DEPRECATED',
        E_NOTICE => 'E_NOTICE',
        E_RECOVERABLE_ERROR => 'E_RECOVERABLE_ERROR',
        E_WARNING => 'E_WARNING',
        E_USER_ERROR => 'E_USER_ERROR',
        E_USER_DEPRECATED => 'E_USER_DEPRECATED',
        E_USER_NOTICE => 'E_USER_NOTICE',
        E_USER_WARNING => 'E_USER_WARNING',
    ][$code];
    throw new ErrorException("{$type}: {$message}", $code, 1, $file, $line);
});

require_once '../vendor/autoload.php';

use Helix\Shopify\Api;

$domain = getenv('SHOPIFY_API_DOMAIN');
$key = getenv('SHOPIFY_API_KEY');
$password = getenv('SHOPIFY_API_PASSWORD');

$api = new Api($domain, $key, $password);
$api->setLogger(function (string $event, string $path, ?string $payload) {
    echo "{$event} {$path} => {$payload}\n\n";
});