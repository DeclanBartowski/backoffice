<?php

namespace Database\Seeders;

use App\Models\Tariffs;
use Illuminate\Database\Seeder;

class TariffsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $params = [
            [
                'name' => 'Тариф 1',
                'limit' => [
                    'document' => [
                        'title' => 'Документы',
                        'value' => 1
                    ],
                    'pages' => [
                        'title' => 'Страниц в документе',
                        'value' => 5
                    ],
                    'block' => [
                        'title' => 'Блоков',
                        'value' => 30
                    ],
                    'variant_block' => [
                        'title' => 'Вариантов блоков',
                        'value' => 50
                    ],
                ],
                'price' => 0,
                'default' => true
            ],
            [
                'name' => 'Тариф 2',
                'limit' => [
                    'document' => [
                        'title' => 'Документы',
                        'value' => 3
                    ],
                    'pages' => [
                        'title' => 'Страниц в документе',
                        'value' => 7
                    ],
                    'block' => [
                        'title' => 'Блоков',
                        'value' => 30
                    ],
                    'variant_block' => [
                        'title' => 'Вариантов блоков',
                        'value' => 120
                    ],
                ],
                'price' => 500,
                'default' => false
            ],
            [
                'name' => 'Тариф 3',
                'limit' => [
                    'document' => [
                        'title' => 'Документы',
                    ],
                    'pages' => [
                        'title' => 'Страниц в документе',
                    ],
                    'block' => [
                        'title' => 'Блоков',
                        'value' => 30
                    ],
                    'variant_block' => [
                        'title' => 'Вариантов блоков',
                        'value' => 250
                    ],
                ],
                'price' => 750,
                'default' => false
            ]
        ];
        foreach ($params as $item) {
            $tariffs = new Tariffs();
            $tariffs->fill($item);
            $tariffs->save();
        }
    }
}
