<?php

use App\Models\Testing;
use App\Models\User;
use Illuminate\Database\Seeder;

class TestingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $creatorId = User::whereHas('roles', function ($q) {
            $q->whereSlug('teacher');
        })->first()->id;

        for ($i = 0; $i < 3; $i++) {
            Testing::create([
                'title' => "Тест $i",
                'creator_id' => $creatorId,
                'questions' => '[{"name":"Вопрос 1","answers":[{"text":"Answer Text1","answer":false},{"text":"Answer Text1","answer":false}]}]',
            ]);
        }
    }
}
