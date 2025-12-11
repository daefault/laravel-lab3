<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\character;

class CharacterSeeder extends Seeder
{
    public function run(): void
    {
        $characters = [
            [
                'name' => 'губка боб квадратные штаны',
                'image' => '/images/spongebob.jpg',
                'description' => 'Повар в "Красти Краб". Энергичный и радостный.',
                'type' => 'морская губка'
            ],
            [
                'name' => 'патрик стар',
                'image' => '/images/patrick.jpg', 
                'description' => 'Лучший друг Губки Боба, безработный.',
                'type' => 'морская звезда'
            ],
            [
                'name' => 'юджин крабс',
                'image' => '/images/mrkrabs.jpg',
                'description' => 'Владелец и основатель ресторана «Красти Краб».',
                'type' => 'краб'
            ],
            [
                'name' => 'сквидвард тентаклс',
                'image' => '/images/squidward.jpg',
                'description' => 'Кальмар, работающий кассиром в "Красти Крабе".',
                'type' => 'кальмар'
            ],
            [
                'name' => 'сэнди чикс',
                'image' => '/images/sandy.jpg',
                'description' => 'Белка из Техаса, которая живет под водой.',
                'type' => 'белка'
            ]
        ];

        foreach ($characters as $character) {
            character::create($character);
        }
    }
}