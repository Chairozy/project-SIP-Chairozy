<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $ar = array('Laki-laki', 'Perempuan');
        $random = array_rand($ar);
        return [
            'role_id' => 2,
            'photo' => '',
            'name' => $this->faker->name,
            'username' => $this->faker->userName,
            'gender' => $ar[$random],
            'phone' => $this->faker->e164PhoneNumber,
            'alamat' => $this->faker->address,
            'kebangsaan' => 'Indonesia',
            'tgl_lahir' => Carbon::createFromFormat('Y-m-d', '2000-10-15')->toDateString(),
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => bcrypt(Str::random(12)),
            'remember_token' => Str::random(10),
        ];
    }
}
