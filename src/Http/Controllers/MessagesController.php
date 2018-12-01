<?php

namespace Launcher\Larachatter\Http\Controllers;

use Illuminate\Http\Request;
use Launcher\Larachatter\Facades\Larachatter;
use Launcher\Larachatter\Repositories\MessageRepository;
use Launcher\Larachatter\Repositories\UserRepository;

class MessagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function send(Request $request, MessageRepository $msg, UserRepository $user)
    {
        $request->validate([
            'recipient'     => 'required|string',
            'message'       => 'required|string',
        ]);
        $from = $request->user();
        $receiver = $user->find($request->recipient);
        $message = $request->message;

        return response($msg->send($from, $receiver, $message));
    }

    public function destroy($message, MessageRepository $repo, Request $request, UserRepository $user)
    {
        $msg = Larachatter::model('message')->findOrFail($message);

        return $repo->delete($msg, $request->user()->id);
    }
}
