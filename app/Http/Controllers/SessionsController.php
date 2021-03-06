<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionsController extends Controller
{
	public function __construct()
	{
		//只让未登录用户访问登录注册页面
		$this->middleware('guest', [
			'only' => ['create']
		]);
	}

	public function create()
	{
		return view('sessions.create');
	}

	//登录
	public function store(Request $request)
	{
		$this->validate($request, [
			'email' => 'required|email|max:255',
			'password' => 'required|min:6'
		]);

		$credentials = [
			'email'		=> $request->email,
			'password'	=> $request->password
		];

		if (Auth::attempt($credentials, $request->has('remember')))	//登录成功，记住我
		{
			if (Auth::user()->activated)
			{
				session()->flash('success', '欢迎回来！');
				return redirect()->intended(route('users.show', [Auth::user()]));
			}
			else
			{
				Auth::logout();
				session()->flash('warning', '你的账号未激活，请检查邮箱中的注册邮件进行激活。');
				return redirect('/');
			}
		}
		else	//登录失败
		{
			session()->flash('danger', '很抱歉，您的邮箱和密码不匹配');
			return redirect()->back();
		}
	}

	//登出
	public function destroy()
	{
		Auth::logout();
		session()->flash('success', '您已成功登出');
		return redirect('login');
	}
}
