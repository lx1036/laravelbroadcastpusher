<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class ChatController extends Controller
{
    var $pusher;
    var $user;
    var $chatChannel;

    const DEFAULT_CHAT_CHANNEL = 'private-chat';

    public function __construct()
    {
        $this->pusher = App::make('pusher');
        $this->user = Session::get('user');
        $this->chatChannel = self::DEFAULT_CHAT_CHANNEL;
    }

    public function getIndex()
    {
        if(!$this->user)
        {
            return redirect('auth/github?redirect=/chat');
        }

        return view('pusher.chat', ['chatChannel' => $this->chatChannel]);
    }

    public function postMessage(Request $request)
    {
        $message = [
            'text' => e($request->input('chat_text')),
            'username' => $this->user->getNickname(),
            'avatar' => $this->user->getAvatar(),
            'timestamp' => (time()*1000)
        ];
        $this->pusher->trigger($this->chatChannel, 'new-message', $message);
    }

    public function postAuth(Request $request)
    {
        if(!$this->user)
        {
            return '401 Unauthorized';
        }

        $socketId    = $request->input('socket_id');
        $channelName = $request->input('channel_name');
        $auth        = $this->pusher->socket_auth($socketId, $channelName);
        return $auth;
    }
}
