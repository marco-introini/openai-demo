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
    protected $signature = 'chat {--system=}';

    protected $description = 'Chat with OpenAI';

    #[NoReturn]
    public function handle(): void
    {
        $chat = new AIChat();

        if ($this->option('system')) {
            $chat->systemMessage($this->option('system'));
        }

        $question = text(
            label: 'What is your question for AI?',
            required: true
        );

        info(
            spin(fn() => $chat->send($question), 'Sending request...')
        );

        while ($question = text('Do you want to respond? (return to exit)')) {
            info(
                spin(fn() => $chat->send($question), 'Sending request...')
            );
        }

        outro('Conversation over.');

    }
}
