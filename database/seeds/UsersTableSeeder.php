<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$users = factory(User::class)->times(50)->make();
		User::insert($users->makeVisible(['password', 'remember_token'])->toArray());

		$user			= User::find(1);
		$user->name		= 'Andy';
		$user->email	= 'linxianfu928@qq.com';
		$user->password = bcrypt('123456');
		$user->is_admin = true;
		$user->activated= true;
		$user->save();
	}
}
