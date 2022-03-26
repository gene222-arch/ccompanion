<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Services\ChatService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('app.chat-box', [
            'chats' => Chat::with('user:id,name')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Services\ChatService  $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, ChatService $service)
    {
        $service->create($request->message);

        return response()->json([
            'message' => 'Chat created successfully.'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function show(Chat $chat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Chat $chat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Chat $chat)
    {
        $chatID = $chat->id;
        $chat->delete();
        
        event(new \App\Events\MessageDeletedEvent($chatID));

        return response()->json([
            'message' => 'Chat deleted successfully.'
        ], 200);
    }
}
