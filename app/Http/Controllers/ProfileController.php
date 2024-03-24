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


    public function update(Request $request){
        $user = $request->user();
        $attributes = $request->validate([
            'email' => 'required|email|unique:users,email,' . $user->id,
            'name' => 'required|max:30',
            'phone' => 'required|max:10',
            'about' => 'max:150',
            'location' => 'max:300',
            'avatar' => 'sometimes|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            
            // Kiểm tra xem tệp có phải là hình ảnh hay không
            if ($avatar->isValid() && in_array($avatar->getClientOriginalExtension(), ['jpg', 'jpeg', 'png'])) {
                $avatarName = uniqid('avatar_') . '.' . $avatar->getClientOriginalExtension();
                $avatar->move(public_path('assets/img/avatar_user'), $avatarName);
                $attributes['avatar'] =  $avatarName;
            } else {
                // Nếu tệp không phải là hình ảnh, trả về thông báo lỗi
                return back()->withErrors(['avatar' => 'Ảnh tải lên không hợp lệ, phải có định dạng: jpg, jpeg, png.']);
            }
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
