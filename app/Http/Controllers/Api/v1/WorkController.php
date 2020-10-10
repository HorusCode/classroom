<?php


namespace App\Http\Controllers\Api\v1;


use App\Http\Controllers\Api\BaseController;
use App\Models\Course;
use App\Models\Testing;
use App\Models\Work;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WorkController extends BaseController
{

    public function store(Course $course, Request $request) {
        $work = Work::create([
            'title' => $request->title,
            'description' => $request->description,
            'complete_in' => Carbon::parse($request->complete_in)->setTimezone('UTC'),
        ]);
        $work->course()->associate($course);
        $work->task()->associate(Testing::find($request->test));
        $work->save();

        return $this->sendResponse($work, 'Success!');
    }
}
