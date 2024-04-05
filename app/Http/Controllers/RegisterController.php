<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends Controller
{
    public function create()
    {
        return view('register.create');
    }

    public function store(){

        $attributes = request()->validate([
            'username' => 'required|max:20|min:6|regex:/^[a-zA-Z0-9_]+$/',
            'name' => 'required|max:30|regex:/^[a-zA-Z\sàáảãạăắằẳẵặâấầẩẫậèéẻẽẹêếềểễệđìíỉĩịòóỏõọôốồổỗộơớờởỡợùúủũụưứừửữựỳỹỷỵÀÁẢÃẠĂẮẰẲẴẶÂẤẦẨẪẬÈÉẺẼẸÊẾỀỂỄỆĐÌÍỈĨỊÒÓỎÕỌÔỐỒỔỖỘƠỚỜỞỠỢÙÚỦŨỤƯỨỪỬỮỰỲỸỶỴ\s]+$/u',
            'email' => 'required|email|max:255|unique:users,email',
            'phone' => 'required|max:15',
            'password' => 'required|min:8|max:255',
        ]);
        $attributes['avatar'] = 'default-avatar.jpg';
        $user = User::create($attributes);
        return redirect('/sign-in')->withStatus('Đăng kí tài khoản thành công');
    } 
}
