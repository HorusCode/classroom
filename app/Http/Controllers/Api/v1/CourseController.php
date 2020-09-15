<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\CourseRequest;
use App\Models\Course;
use Illuminate\Http\Request;
use Str;

class CourseController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if($request->with) {
            $data = Course::with($request->with)->get();
        } else {
            $data = Course::all();
        }
        return $this->sendResponse($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CourseRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CourseRequest $request)
    {
        $data = Course::create([
            'course' => $request->course,
            'slug' => Str::slug($request->course)
        ]);
        if($request->groups) {
            $data->groups()->attach($request->groups);
        }
        return $this->sendResponse($data);
    }

    /**
     * Display the specified resource.
     *
     * @param Course $course
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Course $course)
    {
        return $this->sendResponse($course->load('groups'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CourseRequest $request
     * @param Course $course
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CourseRequest $request, Course $course)
    {
        $course->update(['course'=>$request->course]);
        return $this->sendResponse($course);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        return Course::destroy($id) ? $this->sendResponse('', 'Course deleted!') : $this->sendError('Course not found!');
    }

    public function detachGroups(CourseRequest $request, Course $course)
    {
        return $this->sendResponse($course->groups()->detach($request->groups));
    }

    public function attachGroups(CourseRequest $request, Course $course)
    {
        return $this->sendResponse($course->groups()->syncWithoutDetaching($request->groups));
    }
}
