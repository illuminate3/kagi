<?php

namespace App\Modules\Kagi\Database\Seeds;

use Illuminate\Database\Seeder;
Use DB;
use Schema;


class ModulePermissionsSeeder extends Seeder {

	public function run()
	{

<<<<<<< HEAD

=======
>>>>>>> a9220356c99b2ed72bbd9cafef4cdfe934ff9230
// Permissions -------------------------------------------------------------
		$permissions = array(
			[
				'name'				=> 'Manage Users',
				'slug'				=> 'manage_kagi',
				'description'		=> 'Give permission to user to Manage Users.'
			],
		 );

		if (Schema::hasTable('permissions'))
		{
			DB::table('permissions')->insert( $permissions );
		}

	} // run

}
