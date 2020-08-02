<?php

use App\Models\Group;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'Б-1-13',
            ],
            [
                'name' => 'ИС-12',
            ],
            [
                'name' => 'М-13',
            ]
        ];

        foreach ($data as $datum) {
            Group::create($datum);
        }
    }
}
