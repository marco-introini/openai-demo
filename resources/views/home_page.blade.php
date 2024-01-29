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
    <form method="POST" action="/generate" class="bg-violet-50 p-6 rounded-3xl">
        @csrf
        <x-input name="topic" label="Insert Topic" placeholder="Text here" icon="o-document-text"
                 hint="Insert the topic description" required/>
        <div class="mx-auto w-fit">
            <x-button name="submit" type="submit" class="mx-auto mt-5">Submit Topic</x-button>
        </div>
    </form>
@endif

</body>
