<?php

namespace App\Services;

use OpenAI\Laravel\Facades\OpenAI;

class AIChat
{

    protected array $messages = [];

    public function systemMessage(string $message): static
    {
        $this->addMessage($message,'system');

        return $this;
    }

    public function send(string $message): ?string
    {
        $this->addMessage($message,'user');

        $response = OpenAI::chat()->create([
            "model" => "gpt-3.5-turbo",
            "messages" => $this->messages])
            ->choices[0]->message->content;

        if ($response) {
            $this->addMessage($response,'assistant');
        }

        return $response;
    }

    public function reply(string $message): ?string
    {
        return $this->send($message);
    }

    public function messages(): array
    {
        return $this->messages;
    }

    protected function addMessage(string $message, string $role = 'user'): self
    {
        $this->messages[] = [
            'role'    => $role,
            'content' => $message
        ];

        return $this;
    }

}
