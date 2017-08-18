<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function create()
	{
		return view('users.create');
	}

	public function show(User $user)
	{
		return view('users.show', compact('user'));
	}

	public function store(Request $request)
	{
		//表单验证
		$this->validate($request, [
			'name'		=> 'required|min:2|max:6',
			'email'		=> 'required|email|unique:users|max:64',
			'password'	=> 'required|confirmed|min:6'
		]);

		//注册用户
		$user = User::create([
			'name'		=> $request->name,
			'email'		=> $request->email,
			'password'	=> bcrypt($request->password)
		]);

		Auth::login($user);	//自动登录
		session()->flash('success', '欢迎，您将在这里开启一段新的旅程~');
		return redirect()->route('users.show', [$user]);
	}
}
