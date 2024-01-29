<?php

namespace App\Console\Commands;

use App\Services\AIChat;
use Illuminate\Console\Command;
use JetBrains\PhpStorm\NoReturn;
use function Laravel\Prompts\outro;
use function Laravel\Prompts\spin;
use function Laravel\Prompts\text;
use function Laravel\Prompts\info;

class ChatCommand extends Command
{
    protected $signature = 'chat';

    protected $description = 'Chat with OpenAI';

    #[NoReturn]
    public function handle(): void
    {

        $chat = new AIChat();

        $question = text(
            label: 'What is your question for AI?',
            required: true
        );

        info(
            spin(fn() => $chat->send($question), 'Sending request...')
        );

        while ($question = text('Do you want to respond?')) {
            info(
                spin(fn() => $chat->send($question), 'Sending request...')
            );
        }

        outro('Conversation over.');

    }
}
