<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('pages.laravel-examples.user-management', ['users' => $users]);
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|min:6|max:20',
            'name' => 'required|max:30|string',
            'password' => 'required|min:8|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|max:11|string',
            'avatar' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);

        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            $file = $request->file('avatar');
            $fileName = uniqid('avatar_') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/img/avatar_user'), $fileName);
        } else {
            $fileName = 'default-avatar.jpg';
        }

        $userData = [
            'username' => $request->username,
            'name' => $request->name,
            'password' => $request->password,
            'email' => $request->email,
            'phone' => $request->phone,
            'level' => $request->level,
            'avatar' => $fileName,
        ];

        $user = User::create($userData);

        if ($user) {
            // thêm thành công
            return response()->json([
                'status' => 200,
            ]);
        } else {
            // lỗi
            return response()->json([
                'status' => 500,
            ]);
        }
    }

}
