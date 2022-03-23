<?php 
namespace App\Services;

use App\Models\Chat;
use Illuminate\Support\Facades\Auth;

class ChatService
{
    public function create(string $message)
    {   
        $chat = Auth::user()->chats()->create(['message' => $message]);
        event(new \App\Events\NewChatMessageEvent(Auth::user(), $chat));
    }
}