<?php

require __DIR__ . '/vendor/autoload.php';

use GuzzleHttp\Client;

$client = new Client();
try {
    $res = $client->request('POST', 'https://hooks.slack.com/services/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', [
        'body' => json_encode([
            'text' => 'Yo fridge open',
            'attachments' => [
                [
                    'text' => 'Whatcha gonna do about it?',
                    'fallback' => "We're having trouble responding. Please just send a message in the thread",
                    'callback_id' => 'fridge_status',
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
            ],
        ]),
        'headers' => ['Content-Type' => 'application/json'],
    ]);

    echo 'success';
} catch (Exception $e) {
    echo 'failure';
}
