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

    public function SendMessage(Request $request) {
        $this->validate($request, [
            'title' =>  'required|max:10',
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
                abort(403);
            }
            return 'useridissame';
        }
        abort(403);
    }

    public function getUserMessages() {
        $messages = Message::where('user_id', Auth::user()->id)->with('getSender')->orderBy('id', 'DESC')->get();
        return ['messages' => $messages];
    }

    public function SentMessages() {
        $messages = Message::where('user_message_you', Auth::user()->id)->with('getReceiver')->orderBy('id', 'DESC')->get();
        return ['messages' => $messages];
    }

    public function UnreadMessages() {
        $messages = Message::where('user_id', Auth::user()->id)->where('seen', 0)->with('getReceiver')->orderBy('id', 'DESC')->get();
        return ['messages' => $messages];
    }

    public function ReadMessages() {
        $messages = Message::where('user_id', Auth::user()->id)->where('seen', 1)->with('getReceiver')->orderBy('id', 'DESC')->get();
        return ['messages' => $messages];
    }

    public function GetMessageById($id) {
        $message = Message::where('id', $id)->with('getSender', 'getReceiver')->first();
        if ($message) {
            if (Auth::user()->id == $message->user_id || Auth::user()->id == $message->user_message_you) {
                if ($message->seen == 0 && Auth::user()->id == $message->user_id) {
                    // لو السين يساوي صفر والي عامل لوج ان هو الي مستلم يبقي لو دخل شاف الخدمه يبقي كده صح و زي الفل
                    $message->seen = 1;
                    $message->save();
                }
                return ['message' => $message];
            }
            abort(403);
        }
        abort(403);
    }
}
