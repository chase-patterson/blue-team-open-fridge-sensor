<?php

require __DIR__ . '/vendor/autoload.php';

use GuzzleHttp\Client;

$client = new Client();
$res = $client->request('POST', 'https =>//hooks.slack.com/services/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', [
    'body' => json_encode([
        'text' => 'Yo fridge open',
        'attachments' => [
            [
                'text' => 'Choose a game to play',
                'fallback' => 'You are unable to choose a game',
                'callback_id' => 'wopr_game',
                'color' => '#3AA3E3',
                'attachment_type' => 'default',
                'actions' => [
                    [
                        'name' => 'game',
                        'text' => "I'll get it!",
                        'style' => 'danger',
                        'type' => 'button',
                        'value' => 'close',
                        'confirm' => [
                            'title' => 'Are you sure?',
                            'text' => 'Are you actually going to close the door?',
                            'ok_text' => 'Yes',
                            'dismiss_text' => 'No',
                        ],
                    ],
                ],
            ],
            'image_url' => 'https://i.pinimg.com/originals/64/bf/3c/64bf3c8cf34b05c222882ffc52a14088.jpg',
        ],
    ]),
    'headers' => ['Content-Type' => 'application/json'],
]);

if ($res->getStatusCode() === 200) {
    echo 'success';
} else {
    echo 'failure';
}
