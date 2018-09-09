<?php

namespace App\Http\Controllers;

use App\Conversation;
use App\Events\NewMessage;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    public function store()
    {
        $conversation = Conversation::create([
            'message' => request('message'),
            'group_id' => request('group_id'),
            'user_id' => auth()->user()->id,
        ]);

        broadcast(new NewMessage($conversation))->toOthers();

        return response()->json($conversation->load('user'));
    }

    public function load($group_id) {
        $conversations = Conversation::with(array('user' => function($query) {
            $query->select('id', 'name');
        }))
            ->where('group_id', '=', $group_id)
            ->select('message', 'user_id')
            ->get();


        return response()->json($conversations);
    }
}
