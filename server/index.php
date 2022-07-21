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
