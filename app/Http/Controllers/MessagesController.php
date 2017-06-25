<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Message;
use App\User;
use Auth;

class MessagesController extends Controller
{
    public function SendMessage(Request $request)
    {
        $this->validate($request, [
            'title' =>  'required|max:30',
            'content'   =>  'required|min:20|max:500',
            'user_id'   =>  'required|integer',
        ]);
        $userReceve = User::find($request['user_id']);
        if ($userReceve) {
            if (Auth::user()->id != $userReceve->id) {
                // `title`, `content`, `seen`, `user_message_you`, `user_id`
                $message = new Message();
                $message->title                 = strip_tags($request['title']);
                $message->content               = strip_tags($request['content']);
                $message->seen                  = 0;
                $message->user_message_you      = Auth::user()->id;
                $message->user_id               = $userReceve->id;
                $message->save();
                if ($message) {
                    return 'done';
                }
                return abort(403);
            }
            return 'useridissame';
        }
        return abort(403);
    }
}
