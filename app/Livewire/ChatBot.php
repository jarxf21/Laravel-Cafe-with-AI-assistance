<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\GeminiService;
use Illuminate\Support\Facades\Log;

class ChatBot extends Component
{
    public $isOpen = false;
    public $messages = [];
    public $input = '';
    public $isTyping = false;

    public function mount()
    {
        $this->messages = [
            ['role' => 'model', 'content' => 'Hello! I am your AI Barista. How can I help you choose the perfect coffee today?']
        ];
    }

    public function toggle()
    {
        $this->isOpen = ! $this->isOpen;
    }

  public function sendMessage(GeminiService $gemini)
{
    if (trim($this->input) === '') return;

    $userMessage = $this->input;
    $this->messages[] = ['role' => 'user', 'content' => $userMessage];
    $this->input = '';
    $this->isTyping = true;

    // Construct Prompt with Context
    $systemContext = "You are a friendly and knowledgeable AI Barista for 'Cafe AI'. 
    We sell Coffee (Espresso 18k, Americano 20k, Cappuccino 25k, Latte 28k), 
    Non-Coffee (Chocolate 25k, Matcha 28k), and Snacks. 
    Recommend drinks based on mood or flavor preferences (sweet, strong, creamy).
    Recomended Food in snack and main course  
    Keep answers short and engaging. 
    if you don't know the answer, say I don't know.
    if question out of context, say kalau nanya yang bener dong bos
    if question about price, say with friendly for manual check
    You can answer with bahasa indonesia";

    $fullPrompt = $systemContext . "\n\nUser: " . $userMessage . "\nAI:";

    try {
        // Gunakan kembali service, jangan panggil API langsung
        $response = $gemini->generateText($fullPrompt);
        $this->messages[] = ['role' => 'model', 'content' => $response];
    } catch (\Exception $e) {
        // Kembalikan ke pesan error yang ramah
         $errorMessage = 'Error: ' . $e->getMessage();
    $this->messages[] = ['role' => 'model', 'content' => $errorMessage];
        
        // Simpan error asli di log untuk debugging Anda
        Log::error('Gemini API Error: ' . $e->getMessage());
    }

    $this->isTyping = false;
}

    public function render()
    {
        return view('livewire.chat-bot');
    }
}
