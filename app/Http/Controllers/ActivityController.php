<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class ActivityController extends Controller
{
    public $pusher, $user;

    public function __construct()
    {

        $this->pusher = App::make('pusher');
        $this->user = Session::get('user');
    }

    /**
     * Serve the example activities view
     */
    public function getIndex()
    {
        // If there is no user, redirect to GitHub login
        if(!$this->user)
        {
            return redirect('auth/github?redirect=/activities');
        }

        // TODO: provide some useful text
        $activity = [
            'text' => $this->user->getNickname().' has visited the page',
            'username' => $this->user->getNickname(),
            'avatar' => $this->user->getAvatar(),
            'id' => 1,
        ];

        // TODO: trigger event
        $this->pusher->trigger('activities', 'user-visit', $activity);


        return view('pusher.activities');
    }

    /**
     * A new status update has been posted
     * @param Request $request
     */
    public function postStatusUpdate(Request $request)
    {
        $statusText = e($request->input('status_text'));

        // TODO: provide some useful text
        $activity = [
            'text' => $statusText,
            'username' => $this->user->getNickname(),
            'avatar' => $this->user->getAvatar(),
            'id' => str_random()
        ];
        // TODO: trigger event
        $this->pusher->trigger('activities', 'new-status-update', $activity);
    }

    /**
     * Like an exiting activity
     * @param $id The ID of the activity that has been liked
     */
    public function postLike($id)
    {
        // TODO: trigger event
        $activity = [
            // Other properties...

            'text' => '',
            'username' => $this->user->getNickname(),
            'avatar' => $this->user->getAvatar(),
            'id' => $id,
            'likedActivityId' => $id,
        ];
        // TODO: trigger event
        $this->pusher->trigger('activities', 'status-update-liked', $activity);
    }
}
