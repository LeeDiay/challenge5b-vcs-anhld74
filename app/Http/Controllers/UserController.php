<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(5); // Lấy danh sách người dùng với mỗi trang hiển thị 10 người dùng
        return view('pages.laravel-examples.user-management', ['users' => $users]);
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|min:6|max:20|regex:/^\S*$/',
            'name' => 'required|max:30|string',
            'password' => 'required|min:8|string|max:255',
            'email' => 'required|email',
            'phone' => 'max:11|string',
            'level' => 'required|string|in:User,Admin',
            'avatar' => 'sometimes|image|mimes:jpeg,png,jpg|max:2048', 
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

    public function update(Request $request)
    {
        $request->validate([
            'userId' => 'required|exists:users,id',
            'username' => 'required|string|min:6|max:20|regex:/^\S*$/',
            'name' => 'required|string|max:30',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:11',
            'location' => 'nullable|string|max:255',
            'about' => 'nullable|string',
            'level' => 'required|string|in:User,Admin',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $userData = [
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'location' => $request->location,
            'about' => $request->about,
            'level' => $request->level,
        ];

        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            $file = $request->file('avatar');
            $fileName = uniqid('avatar_') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/img/avatar_user'), $fileName);
            $userData['avatar'] = $fileName;
        }

        $user = User::find($request->userId);
        if ($user) {
            $user->update($userData);
            return response()->json([
                'status' => 200,
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'Không tìm thấy user.',
            ]);
        }
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'userId' => 'required',
        ]);
    
        $user = User::find($request->userId);
    
        if ($user) {
            if ($user->avatar && $user->avatar != 'default-avatar.jpg') {
                $avatarPath = public_path('assets/img/avatar_user/' . $user->avatar);
                if (file_exists($avatarPath)) {
                    unlink($avatarPath);
                }
            }
    
            $user->delete();
            return response()->json([
                'status' => 200,
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'Không tìm thấy người dùng.',
            ]);
        }
    }
    

}
