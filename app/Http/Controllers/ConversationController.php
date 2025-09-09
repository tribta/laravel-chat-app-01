<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ConversationController extends Controller
{
    public function index(Request $request): Response
    {
        // chứa user mà client gửi request
        $user = $request->user();

        // chứa 1 danh sách các conversations trong db
        $conversations = $user->conversations()
            ->with(['lastMessage.user:id,name'])
            ->orderByDesc('updated_at')
            ->get();

        // chứa 1 danh sách các users trong db
        $users = User::query()
            ->where('id', '<>', $user->id)
            ->select('id', 'name', 'email')
            ->orderBy('name')
            ->limit(50)
            ->get();

        return Inertia::render('Chat/Index', [
            'conversations' => $conversations,
            'users' => $users
        ]);
    }

    public function show(Request $request, Conversation $conversation): Response
    {
        $userId = $request->user()->id;
        abort_unless($conversation->isParticipant($userId), 403);

        $messages = $conversation
            ->messages()
            ->with('user:id,name,email')
            ->orderBy('created_at')
            ->paginate(50);

        $conversations = $request
            ->user()
            ->conversations()
            ->with(['lastMessage.user:id,name'])
            ->orderByDesc('updated_at')
            ->get();

        return Inertia::render('Chat/Show', [
            'conversation' => $conversation->only(['id', 'name', 'is_direct']),
            'messages' => $messages,
            'conversations' => $conversations
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $userId = $request->user()->id;

        $data = $request->validate([
            'user_ids' => ['array', 'required', 'min:1'],
            'user_ids.*' => ['integer', 'exists:users,id', 'different:' . $userId],
            'name' => ['nullable', 'string', 'max:255']
        ]);
        $isDirect = count($data['user_ids']) === 1;

        $conversation = Conversation::create([
            'name' => $isDirect ? null : ($data['name'] ?? null),
            'is_direct' => $isDirect,
            'created_by' => $userId
        ]);

        $conversation
            ->users()
            ->sync(array_unique([...$data['user_ids'], $userId]));

        return redirect()->route('chat.show', $conversation);
    }
}
