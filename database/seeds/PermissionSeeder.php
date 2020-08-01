<?php

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
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
                'name' => 'Create test',
                'slug' => 'create-test'
            ],
            [
                'name' => 'Delete test',
                'slug' => 'delete-test'
            ],
            [
                'name' => 'Update test',
                'slug' => 'update-test'
            ]
        ];

        foreach ($data as $datum) {
            Permission::create($datum);
        }
    }
}
