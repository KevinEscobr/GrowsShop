<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\Product::firstOrCreate(
            ['name' => 'Sustrato Premium 50L'],
            [
                'description' => 'Retención óptima, aireación equilibrada y mezcla ideal para raíces vigorosas.',
                'price' => 15990,
                'stock' => 20,
                'category' => 'Sustratos',
                'image' => 'assets/img/sustratos.webp',
                'is_featured' => true,
            ]
        );

        \App\Models\Product::firstOrCreate(
            ['name' => 'Fertilizante Bio-Grow 1L'],
            [
                'description' => 'Macronutrientes y microelementos para la fase de crecimiento.',
                'price' => 12500,
                'stock' => 15,
                'category' => 'Nutrientes',
                'image' => 'assets/img/fertilizantes.webp',
                'is_featured' => true,
            ]
        );

        \App\Models\Product::firstOrCreate(
            ['name' => 'Iluminación LED 200W'],
            [
                'description' => 'Espectro completo diseñado para crecimiento y floración con bajo consumo.',
                'price' => 89900,
                'stock' => 5,
                'category' => 'Iluminación',
                'image' => 'assets/img/led.webp',
                'is_featured' => true,
            ]
        );

        \App\Models\Product::firstOrCreate(
            ['name' => 'Maceta de Tela 15L'],
            [
                'description' => 'Poda de raíces por aire, ideal para un crecimiento radicular saludable.',
                'price' => 3500,
                'stock' => 50,
                'category' => 'Accesorios',
                'image' => 'assets/img/maceta1.png',
                'is_featured' => false,
            ]
        );
    }
}
