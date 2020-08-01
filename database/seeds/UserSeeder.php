<?php

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $student = Role::whereSlug('student')->first();
        $teacher = Role::whereSlug('teacher')->first();

        $createTest = Permission::whereSlug('create-test')->first();
        $deleteTest = Permission::whereSlug('delete-test')->first();
        $updateTest = Permission::whereSlug('update-test')->first();

        $data = [
            'students' => [
                [
                    'firstname' => 'student1',
                    'lastname' => 'student1',
                    'patronymic' => 'student1',
                    'phone' => '89061220840',
                    'email' => 'student1@mail.ru',
                    'password' => Hash::make('1234'),
                ],
                [
                    'firstname' => 'student2',
                    'lastname' => 'student2',
                    'patronymic' => 'student2',
                    'phone' => '89061220841',
                    'email' => 'student2@mail.ru',
                    'password' => Hash::make('1234'),
                ],
                [
                    'firstname' => 'student3',
                    'lastname' => 'student3',
                    'patronymic' => 'student3',
                    'phone' => '89061220842',
                    'email' => 'student3@mail.ru',
                    'password' => Hash::make('1234'),
                ],
            ],
            'teachers' => [
                [
                    'firstname' => 'teacher',
                    'lastname' => 'teacher',
                    'patronymic' => 'teacher',
                    'phone' => '89061220843',
                    'email' => 'teacher@mail.ru',
                    'password' => Hash::make('1234'),
                ]
            ]
        ];

        foreach ($data as $datum) {
            foreach ($datum as $item) {
                switch (key($datum)) {
                    case 'students':
                        $user = User::create($item);
                        $user->roles()->attach($student);
                        $user->permissions()->attach($createTest);
                        break;
                    case 'teachers':
                        $user = User::create($item);
                        $user->roles()->attach($teacher);
                        $user->permissions()->attach([$createTest, $updateTest, $deleteTest]);
                        break;

                }
            }
        }

    }
}
