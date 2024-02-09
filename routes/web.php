<?php

use App\Services\AIChat;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use OpenAI\Laravel\Facades\OpenAI;

Route::get('/', function () {
    return view('home_page');
});


Route::post('/generate', function () {
    $validated = request()->validate([
        'topic' => ['required', 'string', 'min:2', 'max:50']
    ]);

    $chat = new AIChat();

    $response = $chat->send('Tell me something about '.$validated['topic'].' in about 30 words');

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

Route::post('/image', function (){
    $validated = request()->validate([
        'prompt' => ['required', 'string']
    ]);

    $prompt = $validated['prompt'];

    $response = OpenAI::images()->create([
        'prompt' => $prompt,
        'model' => 'dall-e-3',
    ]);

    $imageUrl = $response->data[0]->url;

    return view('show-image',[
        'imageUrl' => $imageUrl,
    ]);
});

Route::post('/json_response', function (){
    $validated = request()->validate([
        'comment' => ['required', 'string']
    ]);

    $prompt = $validated['comment'];

    $response = OpenAI::chat()->create([
        'model' => 'gpt-3.5-turbo-1106',
        'messages' => [
            ['role' => 'system', 'content' => 'You are a forum moderator who always respond using JSON'],
            [
                'role' => 'user',
                'content' => <<<EOT
Please inspect the following text and determine if it is spam.
{$prompt}
Expected Response Example:
{
    "is_spam": true|false
    "message": "explanation"
}
EOT
            ]

        ],
        'response_format' => ['type' => 'json_object']
    ]);

    dd($response->choices[0]->message->content);
});
