<?php

namespace App\Services;

use Gemini\Laravel\Facades\Gemini;
use Gemini\Data\Content;
use Gemini\Enums\Role;

class GeminiService
{
    /**
     * Generate text from a simple prompt.
     */
    public function generateText(string $prompt): string
    {
          // Gunakan model yang baru
        $result = Gemini::generativeModel(model: 'gemini-flash-latest')->generateContent($prompt);
        return $result->text();
    }

    /**
     * Chat with history.
     */
    public function chat(array $history, string $message): string
    {
        // Example structure for history:
        // [Content::parse(part: 'Hello', role: Role::USER)]
        
        $chat = Gemini::chat()->startChat(history: $history);
        $response = $chat->sendMessage($message);
        
        return $response->text();
    }
}
