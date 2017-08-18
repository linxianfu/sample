<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
	public function __construct()
	{
		//除了这几个定义的页面不需要登录就能访问，其它页面都需要登录
		$this->middleware('auth', [
			'except' => ['show', 'create', 'store', 'index']
		]);

		//只让未登录用户访问登录注册页面
		$this->middleware('guest', [
			'only' => ['create']
		]);
	}

	public function index()
	{
		$users = User::paginate(10);
		return view('users.index', compact('users'));
	}

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
			'password'	=> 'required|confirmed|min:6|max:64'
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

	//用户编辑页面
	public function edit(User $user)
	{
		$this->authorize('update', $user);
		return view('users.edit', compact('user'));
	}

	//更新用户信息
	public function update(User $user, Request $request)
	{
		$this->validate($request, [
			'name'		=> 'required|min:2|max:6',
			'password'	=> 'confirmed|max:64'
		]);

		$this->authorize('update', $user);

		$data = [];
		$data['name'] = $request->name;
		if ($request->password)
		{
			$data['password'] = bcrypt($request->password);
		}
		$user->update($data);

		session()->flash('success', '个人资料更新成功！');
		return redirect()->route('users.show', [$user]);
	}

	//删除一个用户
	public function destroy(User $user)
	{
		$this->authorize('destroy', $user);
		$user->delete();
		session()->flash('success', '删除成功！');
		return back();
	}
}
