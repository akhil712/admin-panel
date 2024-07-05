<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helpers\Helper;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['projects'] = Project::get();
        return view('projects.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['leaders'] = User::where('role_id', config('constants.roles.business_analyst.id'))->get();
        $data['developers'] = User::where('role_id', config('constants.roles.developer.id'))->get();
        $data['testers'] = User::where('role_id', config('constants.roles.tester.id'))->get();
        $data['clients'] = User::where('role_id', config('constants.roles.client.id'))->get();
        return view('projects.createEdit', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:50',
            'leader_id' => 'required|exists:users,id',
            'client_ids.*' => 'required|exists:users,id',
            'developer_ids.*' => 'required|exists:users,id',
            'tester_ids.*' => 'required|exists:users,id',
            'date' => 'required|date_format:Y-m-d',
            'deadline_date' => 'required|date_format:Y-m-d'
        ]);
        $data = $request->all();

        DB::beginTransaction();

        try {
            $project = Project::updateOrCreate([
                'id' => $data['id']
            ],$data);
            ProjectUser::where('project_id',$project->id)->delete();
            foreach ($data['client_ids'] as $value) {
                ProjectUser::create([
                    'role_id' => config('constants.roles.client.id'),
                    'project_id' => $project->id,
                    'user_id' => $value
                ]);
            }
            foreach ($data['developer_ids'] as $value) {
                ProjectUser::create([
                    'role_id' => config('constants.roles.developer.id'),
                    'project_id' => $project->id,
                    'user_id' => $value
                ]);
            }
            foreach ($data['tester_ids'] as $value) {
                ProjectUser::create([
                    'role_id' => config('constants.roles.tester.id'),
                    'project_id' => $project->id,
                    'user_id' => $value
                ]);
            }
            DB::commit();
            return Helper::returnResponse(true, 'Permissions saved successfully', [], route('projects.index'));
        } catch (\Exception $e) {
            DB::rollBack();

            return Helper::returnResponse(false, 'Failed to save permissions', ['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['current'] = Project::find(base64_decode(urldecode($id)));
        $data['leaders'] = User::where('role_id', config('constants.roles.business_analyst.id'))->get();
        $data['developers'] = User::where('role_id', config('constants.roles.developer.id'))->get();
        $data['testers'] = User::where('role_id', config('constants.roles.tester.id'))->get();
        $data['clients'] = User::where('role_id', config('constants.roles.client.id'))->get();
        return view('projects.createEdit', $data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return Helper::deleteRecord(base64_decode(urldecode($id)), 'projects');
    }
}
