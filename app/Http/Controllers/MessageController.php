<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;

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
            'receiverId' => 'required',
            'message' => 'required',
        ]);

        $message->sender_id = Auth::id();
        $message->receiver_id = $request->input('receiverId');
        $message->content = $request->input('message');
        $message->save();

        return response()->json(['success' => true, 'message' => 'Tin nhắn đã được gửi thành công']);
    }
    public function getMessageHistory(Request $request)
    {
        $userId = $request->userId;

        // Lấy lịch sử tin nhắn từ database, bạn cần thay đổi tên bảng và điều kiện truy vấn
        $messages = Message::where('sender_id', auth()->id())
                           ->where('receiver_id', $userId)
                           ->orWhere('sender_id', $userId)
                           ->where('receiver_id', auth()->id())
                           ->orderBy('created_at', 'asc')
                           ->get();

        // Trả về kết quả dưới dạng JSON
        return response()->json(['messages' => $messages]);
    }
}
