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
            'username' => 'required|max:100',
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'phone' => 'required|max:20',
            'password' => 'required|min:8|max:255',
        ]);

        $user = User::create($attributes);
        auth()->login($user);
        
        return redirect('/dashboard');
    } 
}
