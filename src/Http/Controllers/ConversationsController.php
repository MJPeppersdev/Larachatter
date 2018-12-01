<?php

namespace Launcher\Larachatter\Http\Controllers;

use Illuminate\Http\Request;
use Launcher\Larachatter\Repositories\ConversationRepository;
use Launcher\Larachatter\Repositories\UserRepository;

class ConversationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(ConversationRepository $conversation)
    {
        return response $conversation->all());
    }

    public function show($recipient, Request $request, ConversationRepository $conversation, UserRepository $user)
    {
        $request->validate([
            'offset'        => 'required|numeric',
            'pagesize'      => 'required|numeric',
        ]);
        $recipient = $user->find($recipient)->id;

        return response(
            $conversation->get($recipient, $request->offset, $request->pagesize)
        );
    }

    public function destroy($recipient, Request $request, ConversationRepository $conversation, UserRepository $user)
    {
        $owner = $request->user()->id;
        $recipient = $user->find($recipient)->id;

        return response($conversation->delete($owner, $recipient));
    }
}
