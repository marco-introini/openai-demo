<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet"/>

    @vite('resources/css/app.css')

</head>
<body class="antialiased mx-auto max-w-3xl py-12">

@if(session('file'))
    <div class="bg-violet-50 p-6 rounded-3xl">
        <form method="post" action="{{asset(session('file'))}}" class="">
            <div class="mx-auto w-fit">
                <x-button class="mx-auto" type="submit">Download Audio</x-button>
            </div>
        </form>
    </div>
@else
    <div class="p-3">
        <h1 class="text-xl">Generate audio Demo</h1>
    <form method="POST" action="/generate" class="bg-violet-50 p-6 rounded-3xl">
        @csrf
        <x-input name="topic" label="Insert Topic" placeholder="Text here" icon="o-document-text"
                 hint="Insert the topic description" required/>
        <div class="mx-auto w-fit">
            <x-button name="submit" type="submit" class="mx-auto mt-5">Submit Topic</x-button>
        </div>
    </form>
    </div>
@endif

<div class="p-3">
    <h1 class="text-xl">Generate image Demo</h1>
    <form method="POST" action="/image" class="bg-violet-50 p-6 rounded-3xl">
        @csrf
        <x-textarea name="prompt" label="Insert Image prompt" placeholder="Text here" icon="o-document-text"
                 hint="Insert the prompt for image generation" required/>
        <div class="mx-auto w-fit">
            <x-button name="submit" type="submit" class="mx-auto mt-5">Submit Prompt</x-button>
        </div>
    </form>
</div>

<div class="p-3">
    <h1 class="text-xl">Check SPAM</h1>
    <p>This demo demonstrate the JSON response of OpenAI</p>
    <form method="POST" action="/json_response" class="bg-violet-50 p-6 rounded-3xl">
        @csrf
        <x-textarea name="comment" label="Insert Example comment" placeholder="Text here" icon="o-document-text"
                    hint="Insert the prompt for spom checking demo" required/>
        <div class="mx-auto w-fit">
            <x-button name="submit" type="submit" class="mx-auto mt-5">Submit Prompt</x-button>
        </div>
    </form>
</div>

</body>
