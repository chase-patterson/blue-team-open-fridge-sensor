<?php

require __DIR__ . '/vendor/autoload.php';

use GuzzleHttp\Client;

try {
    $client = new Client();
    $res = $client->request('POST', 'https://hooks.slack.com/services/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', [
        'body' => json_encode([
            'text' => $_GET['status'] === 'closed'
                ? 'The fridge is closed ―Purple People-Eaters'
                : 'The fridge is open ―Purple People-Eaters',
        ]),
        'headers' => ['Content-Type' => 'application/json'],
    ]);

    echo 'success';
} catch (Exception $e) {
    echo 'failure';
}
