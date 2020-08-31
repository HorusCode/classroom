<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\GroupRequest;
use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Group::withCount('users')->get();
        return $this->sendResponse($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param GroupRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(GroupRequest $request)
    {
        $data = [];
        foreach ($request->groups as $group) {
            $data[] = array_merge(Group::create($group)->toArray(), ['users_count' => 0]);

        }
        return $this->sendResponse($data, 'Groups created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        return Group::destroy($id) ? $this->sendResponse('', 'Group deleted!') : $this->sendError('Group not found!');
    }


    /**
     * Search groups by group name field.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request) {
        $data = Group::where('group', 'LIKE', "%{$request->group}%")->withCount('users')->get();
        return $this->sendResponse($data);
    }


    public function getStudents(Group $group)
    {
        return $this->sendResponse($group->users);
    }


}
