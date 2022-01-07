<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $usuarioadmin = new User();
        $usuarioadmin->name = 'Arnaldo';
        $usuarioadmin->email = 'arnaldo@learclass.com';
        $usuarioadmin->password = bcrypt('arnaldo@learclass.com');
        $usuarioadmin->save();
    }
}
