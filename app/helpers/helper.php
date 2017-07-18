<?php



function getAllNotifications($user_id)
{
    return \App\Notification::where('user_id', $user_id)->where('seen', 0)->count();
}

function getCountWishlistItems($user_id)
{
    return \App\Wishlist::where('user_id', $user_id)->count();
}


function getCountInboxMessages($user_id)
{
    return \App\Message::where('user_id', $user_id)->where('seen', 0)->count();
}


function getCountIncomingOrders($user_id)
{
    return \App\Order::where('user_id', $user_id)->where('status', 0)->count();
}

function getNotificationObjects()
{
    // return \App\Notification::where('user_id', Auth::user()->id)->where('seen', 0)->orderBy('id', 'DESC')->with('getSender')->get();
    return \App\Notification::where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->limit(20)->with('getSender')->get();
}

function MakeNotificationSeen($notify_id, $type, $user_id)
{
    $notification = \App\Notification::where('notify_id', $notify_id)->where('type', $type)->where('seen', 0)->where('user_id', $user_id)->get();
    if (count($notification) > 0) {
        if (count($notification) == 1) {
            $notification[0]->seen = 1;
            $notification[0]->save();
        }else {
            for ($i=0; $i < count($notification); $i++) {
                $notification[$i]->seen = 1;
                $notification[$i]->save();
            }
        }
    }
}
