<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Api\BaseController;
use App\Models\Testing;
use Illuminate\Http\Request;

class TestingController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return $this->sendResponse(Testing::latest()->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        return $this->sendResponse(auth()->user()->createdTests()->create($request->all()), 'Test creating success');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Testing $testing
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Testing $testing)
    {
        $testing->update([
            'title' => $request->title,
            'questions' => $request->questions,
            'time' => $request->time
            ]);
        return $this->sendResponse($testing, 'Test updating success!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $data = auth()->user()->createdTests()->findOrFail($id);

        return $data->destroy($id) ? $this->sendResponse('', 'Tests deleted!') : $this->sendError('Test not found!');
    }
}
