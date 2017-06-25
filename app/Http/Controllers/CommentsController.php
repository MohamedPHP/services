<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Comment;
use App\Order;
use Auth;

class CommentsController extends Controller
{
    public function AddComment(Request $request)
    {
        $this->validate($request, [
            'comment' => 'required|min:10|max:500',
        ]);
        $order = Order::find($request['order_id']);
        if ($order) {
            if ($order->user_order == Auth::user()->id || $order->user_id == Auth::user()->id) {
                $comment = new Comment();
                $comment->comment = $request['comment'];
                $comment->order_id = $request['order_id'];
                $comment->user_id = Auth::user()->id;
                $comment->save();
                if ($comment) {
                    return Comment::where('id', $comment->id)->with('user')->first();
                }
                return abort(403);
            }
            return abort(403);
        }
        return abort(403);
    }


    public function getAllComments($id)
    {
        $order = Order::find($id);
        if ($order) {
            return Comment::where('order_id', $id)->with('user')->orderBy('id', 'DESC')->get();
        }
        return abort(403);
    }


}
