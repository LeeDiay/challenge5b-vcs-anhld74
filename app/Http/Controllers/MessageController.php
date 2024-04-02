<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::latest()->get();
        return view('messages.index', compact('messages'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'receiverId' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        $message = new Message();
        $message->sender_id = Auth::user()->id;
        $message->receiver_id = $request->receiverId;
        $message->content = $request->message;
        $message->save();

        return response()->json([
            'status' => 200,
        ]);
    }

    public function getMessageHistory(Request $request)
    {
        $receiverId = $request->receiverId;

        $messages = Message::where('sender_id', auth()->id())
                           ->where('receiver_id', $receiverId)
                           ->orWhere('sender_id', $receiverId)
                           ->where('receiver_id', auth()->id())
                           ->orderBy('created_at', 'asc')
                           ->get();

        return response()->json(['messages' => $messages]);
    }

    public function getNewMessagesCount()
    {
        $receiverId = Auth::user()->id; 

        $newMessagesCount = Message::where('receiver_id', $receiverId)
                                    ->whereDate('created_at', Carbon::today())
                                    ->count();

        return response()->json(['new_messages_count' => $newMessagesCount]);
    }

}
