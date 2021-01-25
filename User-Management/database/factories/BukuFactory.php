<?php

namespace Database\Factories;

use App\Models\Buku;
use Illuminate\Database\Eloquent\Factories\Factory;

class BukuFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Buku::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'userpost_id' => 1,
            'cover' => 'image'.rand(0, 400).'.png',
            'cover_path' => '',
            'pdf' => 'file'.rand(0, 400).'.pdf',
            'pdf_path' => '',
            'judul' => $this->faker->sentence,
            'jumlah' => rand(5, 30),
            'pengarang' => $this->faker->name,
            'penerbit' => $this->faker->name,
            'terbit' => '20'.rand(0, 1).''.rand(0, 9),
            'tebal_buku' => rand(40, 200),
            'harga' => rand(1, 5000).'0000',
            'harga_sebelumnya' => rand(1, 5000).'0000',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
