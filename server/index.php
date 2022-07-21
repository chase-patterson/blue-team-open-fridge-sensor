<?php

require __DIR__ . '/vendor/autoload.php';

use GuzzleHttp\Client;

$client = new Client();
$res = $client->request('POST', 'https://hooks.slack.com/services/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', [
    'body' => json_encode([
        'text' => 'Test message',
    ]),
    'headers' => ['Content-Type' => 'application/json'],
]);

if ($res->getStatusCode() === 200) {
    echo 'success';
} else {
    echo 'failure';
}
