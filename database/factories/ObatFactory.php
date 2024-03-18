<?php

namespace Database\Factories;

use App\Models\Obat;
use Illuminate\Database\Eloquent\Factories\Factory;

class ObatFactory extends Factory
{
    protected $model = Obat::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'satuan_id' => $this->faker->randomNumber(),
            'kode_obat' => $this->faker->randomNumber(5),
            'nama_obat' => $this->faker->words(),
            'kategori_obat' => $this->faker->word(),
            'jenis_obat' => $this->faker->word(),
            'merk' => $this->faker->word(),
            'stok_terkini' => $this->faker->randomNumber(5),
            'harga_beli' => $this->faker->randomNumber(5),
            'harga_jual' => $this->faker->randomNumber(5),
        ];
    }
}
