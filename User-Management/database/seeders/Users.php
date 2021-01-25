<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Users extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::factory(50)->create();
        foreach($user as $a){
            $a->assignRole('User');
        }

        $user = User::create([
            'role_id' => 2,
            'photo' => '',
            'name' => 'Ryanta',
            'username' => 'Ryanta',
            'gender' => 'Laki-laki',
            'phone' => '089612341234',
            'alamat' => 'Bandung, Jl. Kuningan',
            'kebangsaan' => 'Indonesia',
            'tgl_lahir' => Carbon::createFromFormat('Y-m-d', '2000-02-02')->toDate(),
            'email' => 'ry@mail.id',
            'email_verified_at' => now(),
            'password' => bcrypt('kerjajam6'),
            'remember_token' => Str::random(10),
        ]);

        $user->assignRole('User');
    }
}
