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
                'group' => 'Б-1-13',
            ],
            [
                'group' => 'ИС-12',
            ],
            [
                'group' => 'М-13',
            ]
        ];

        foreach ($data as $datum) {
            Group::create($datum);
        }
    }
}
