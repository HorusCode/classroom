<?php

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
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
                'name' => 'Teacher',
                'slug' => 'teacher'
            ],
            [
                'name' => 'Student',
                'slug' => 'student'
            ]
        ];

        foreach ($data as $datum) {
            Role::create($datum);
        }
    }
}
