<?php

use App\Services\AIChat;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home_page');
});


Route::post('/generate', function () {
    $validated = request()->validate([
        'topic' => ['required', 'string', 'min:2', 'max:50']
    ]);

    $chat = new AIChat();

    $response = $chat->send('Tell me something about '.$validated['topic']);

    $mp3 = $chat->speech($response);

    $filename = 'audio/'.md5($mp3).".mp3";
    Storage::disk('public')->put($filename, $mp3);
    return redirect('/')->with([
        'file' => $filename,
        'flash' => 'Audio generated!'
    ]);
});

Route::get('/simple', function () {
    // simple interaction
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

    if (is_null($jsonResponse)) {
        dd($response->json());
    }

    dd($jsonResponse);
});
