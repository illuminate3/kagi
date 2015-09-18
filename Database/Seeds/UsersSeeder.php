<?php

namespace App\Modules\Kagi\Database\Seeds;

use Illuminate\Database\Seeder;

use Caffeinated\Shinobi\Models\Role as Role;
use App\Modules\Kagi\Http\Models\User as User;

use Config;
use DB;


class UsersSeeder extends Seeder
{

	public function __construct(
			User $user,
			Role $role
		)
	{
		$this->user = $user;
		$this->role = $role;
	}

	public function run()
	{


		$csv = dirname(__FILE__) . '/data/' . 'shorter.csv';
		$file_handle = fopen($csv, "r");

		while (!feof($file_handle)) {

			$line = fgetcsv($file_handle);
			if (empty($line)) {
				continue; // skip blank lines
			}

			$c = array();
			$c['id']				= $line[0];
			$c['name']				= $line[3];
			$c['email']				= $line[4];
			$c['confirmed']			= 1;
			$c['activated']			= 1;

			DB::table('users')->insert($c);


// Attach role to user
		$user = User::find($line[0]);
		$user->roles()->attach(2);


		}

		fclose($file_handle);

	}

}
