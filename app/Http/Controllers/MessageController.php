<?php

namespace App\Http\Controllers;

use App\Events\MessageCreated;
use App\Models\Conversation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $userId = $request->user()->id;

        $data = $request->validate([
            'conversation_id' => ['required', 'exists:conversations,id'],
            'body' => ['nullable', 'string', 'max:255']
        ]);

        $conversation = Conversation::findOrFail($data['conversation_id']);
        abort_unless($conversation->isParticipant($userId), 403);

        $created = $conversation->messages()->create([
            'user_id' => $userId,
            'body' => $data['body'] ?? '',
        ]);
        $created->load('user:id,name');
        MessageCreated::dispatch($created);
        $conversation->touch();

        return to_route('chat.show', $conversation)->setStatusCode(303);
    }
}
