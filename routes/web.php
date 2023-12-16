<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $response = Http::withToken(config('services.openai.secret'))
        ->post('https://api.openai.com/v1/chat/completions', [
            'model' => "gpt-3.5-turbo",
            "messages" => [
                [
                    'role' => 'system',
                    'content' => 'you are are PHP programmer'
                ],
                [
                    'role' => 'user',
                    'content' => 'what is the most used programming language?'
                ]
            ]
        ]);

    $jsonResponse = $response->json('choices.0.message.content');

    if (is_null($jsonResponse)){
        dd($response->json());
    }

    dd($jsonResponse);
});
