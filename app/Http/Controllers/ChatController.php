<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $conversations = Conversation::with(['user','partner'])
            ->where(function($q) use ($user) {
                $q->where('user_id', $user->id)->orWhere('partner_id', $user->id);
            })
            ->latest()
            ->get();

        $active = null;
        $messages = collect();

        if ($request->filled('user')) {
            $partnerId = (int) $request->input('user');
            if ($partnerId && $partnerId !== $user->id && User::find($partnerId)) {
                $active = Conversation::firstOrCreate(
                    ['user_id' => min($user->id, $partnerId), 'partner_id' => max($user->id, $partnerId)]
                );
            }
        } elseif ($request->filled('conversation')) {
            $active = Conversation::find($request->input('conversation'));
        }

        if ($active) {
            $messages = Message::with('sender')
                ->where('conversation_id', $active->id)
                ->orderBy('created_at')
                ->get();
        }

        return view('chat.index', compact('conversations','active','messages'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'body' => ['required','string','max:2000'],
            'conversation_id' => ['nullable','integer'],
            'user' => ['nullable','integer'],
        ]);

        $me = Auth::id();
        $conversation = null;

        if ($request->filled('conversation_id')) {
            $conversation = Conversation::findOrFail((int)$request->input('conversation_id'));
        } else {
            $partnerId = (int)$request->input('user');
            if (!$partnerId || $partnerId === $me) {
                return back()->with('status','Partner tidak valid');
            }
            $conversation = Conversation::firstOrCreate(
                ['user_id' => min($me, $partnerId), 'partner_id' => max($me, $partnerId)]
            );
        }

        Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $me,
            'body' => $request->input('body'),
        ]);

        return redirect()->route('chat.index', ['conversation' => $conversation->id]);
    }
}
