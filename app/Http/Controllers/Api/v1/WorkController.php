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
    protected $work;

    public function __construct(Work $work)
    {
        $this->work = $work;
    }

    public function store(Request $request) {

        $this->work = Work::create([
            'title' => $request->title,
            'description' => $request->description,
            'complete_in' => Carbon::parse($request->complete_in)->setTimezone('UTC'),
        ]);


        return $this->sendResponse($this->work, 'Success!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
    }


    public function storeAttach(Course $course, Request $request) {
        $this->store($request);
        $this->work->course()->associate($course);
        $this->work->task()->associate(Testing::find($request->test));
        $this->work->save();

        return $this->sendResponse($this->work, 'Success!');
    }
}
