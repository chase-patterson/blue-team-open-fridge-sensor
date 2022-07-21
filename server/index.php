<?php

require __DIR__ . '/vendor/autoload.php';

use GuzzleHttp\Client;

$client = new Client();
$res = $client->request('POST', 'https://hooks.slack.com/services/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', [
    'body' => json_encode([
        'text' => 'Yo fridge open',
        'blocks' => [
            [
                'type' => 'section',
                'text' => [
                    'type' => 'mrkdwn',
                    'text' => 'Someone _please_ close the fridge!',
                ],
                'accessory' => [
                    'type' => 'image',
                    'image_url' => 'https://i.pinimg.com/originals/64/bf/3c/64bf3c8cf34b05c222882ffc52a14088.jpg',
                    'alt_text' => 'open fridge door',
                ],
            ],
        ],
    ]),
    'headers' => ['Content-Type' => 'application/json'],
]);

if ($res->getStatusCode() === 200) {
    echo 'success';
} else {
    echo 'failure';
}

