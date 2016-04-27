<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\App;

class NotificationController extends Controller
{
    public function getIndex()
    {
        return view('pusher.notification');
    }

    public function postNotify(Request $request, $socketId)
    {
        $notifyText = e($request->input('notify_text'));

        // TODO: Get Pusher instance from service container
        $pusher = App::make('pusher');
        // TODO: The notification event data should have a property named 'text'

        // TODO: On the 'notifications' channel trigger a 'new-notification' event
        $pusher->trigger('notifications', 'new-notification', $notifyText, $socketId);
    }
}
