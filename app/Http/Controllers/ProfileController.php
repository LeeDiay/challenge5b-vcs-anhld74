<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Auth\AuthManager;

class ProfileController extends Controller
{
    public function create()
    {
        return view('pages.profile');
    }

    public function update(Request $request)
{
    $user = $request->user();
    $attributes = $request->validate([
        'email' => 'required|email|unique:users,email,'.$user->id,
        'name' => 'required|max:30',
        'phone' => 'required|max:10',
        'about' => 'required|max:150',
        'location' => 'required',
        'avatar' => 'sometimes|image|mimes:jpeg,png,jpg|max:4096' // Thêm 'sometimes' để tệp không bắt buộc phải gửi lên
    ]);

    if ($request->hasFile('avatar')) {  
        $avatar = $request->file('avatar');
        $avatarName = uniqid('avatar_').'.'.$avatar->getClientOriginalExtension();
        $avatar->move(public_path('assets/img/avatar_user'), $avatarName);
        $attributes['avatar'] = 'assets/img/avatar_user/'.$avatarName;
    }

    $user->update($attributes);
    return back()->withStatus('Cập nhật thông tin thành công');
}

    public function index()
    {
        $users = User::all();
        return view('pages.laravel-examples.user-management', ['users' => $users]);
    }
}
