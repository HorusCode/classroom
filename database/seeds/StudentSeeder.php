<?php

use App\Models\Group;
use App\Models\User;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $students = User::whereHas('roles', function ($q) {
            $q->whereSlug('student');
        })->get();

        $groups = Group::all();
        foreach ($students as $student) {
            $group = $groups->random();
            $student->group()->attach($group);
        }

    }
}
