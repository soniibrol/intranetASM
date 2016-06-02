<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Action;
use App\Menu;
use App\Role;

use DB;
use App\Ibrol\Libraries\MenuLibrary;
use App\Ibrol\Libraries\Recursive;

class RoleController extends Controller
{
    protected $searchPhrase;
    protected $menulibrary;

    public function __construct(){
        $this->menulibrary = new MenuLibrary;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('vendor.material.master.role.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $data = array();
        $data['actions'] = Action::where('active','1')->get();
        $data['menus'] = $this->menulibrary->generateListModule();
        return view('vendor.material.master.role.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'role_name' => 'required|max:100',
            'role_desc' => 'required',
        ]);

        $role = new Role;

        $role->role_name = $request->input('role_name');
        $role->role_desc = $request->input('role_desc');
        $role->active = '1';
        $role->created_by = $request->user()->user_id;

        $role->save();

        $request->session()->flash('status', 'Data has been saved!');

        return redirect('master/role');
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
        $data = array();
        $data['actions'] = Action::where('active','1')->get();
        $data['role'] = Role::where('active','1')->find($id);
        return view('vendor.material.master.role.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $module = $this->menulibrary->generateListModule();

        $data = array();
        $data['actions'] = Action::where('active','1')->get();
        $data['role'] = Role::where('active','1')->find($id);
        $data['menus'] = $this->menulibrary->generateListModule();
        return view('vendor.material.master.role.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $this->validate($request, [
            'role_name' => 'required|max:100',
            'role_desc' => 'required',
        ]);

        $role = Role::find($id);

        $role->role_name = $request->input('role_name');
        $role->role_desc = $request->input('role_desc');
        $role->updated_by = $request->user()->user_id;

        $role->save();

        $request->session()->flash('status', 'Data has been updated!');

        return redirect('master/role');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function apiList(Request $request)
    {
        $current = $request->input('current') or 1;
        $rowCount = $request->input('rowCount') or 5;
        $skip = ($current==1) ? 0 : (($current - 1) * $rowCount);
        $this->searchPhrase = $request->input('searchPhrase') or '';
        
        $sort_column = 'role_id';
        $sort_type = 'asc';

        if(is_array($request->input('sort'))) {
            foreach($request->input('sort') as $key => $value)
            {
                $sort_column = $key;
                $sort_type = $value;
            }
        }

        $data = array();
        $data['current'] = intval($current);
        $data['rowCount'] = $rowCount;
        $data['searchPhrase'] = $this->searchPhrase;
        $data['rows'] = Role::where('active','1')
                            ->where(function($query) {
                                $query->where('role_name','like','%' . $this->searchPhrase . '%')
                                        ->orWhere('role_desc','like','%' . $this->searchPhrase . '%');
                            })
                            ->skip($skip)->take($rowCount)
                            ->orderBy($sort_column, $sort_type)->get();
        $data['total'] = Role::where('active','1')
                                ->where(function($query) {
                                    $query->where('role_name','like','%' . $this->searchPhrase . '%')
                                            ->orWhere('role_desc','like','%' . $this->searchPhrase . '%');
                                })->count();

        return response()->json($data);
    }

    public function apiEdit(Request $request)
    {
        $role_id = $request->input('role_id');

        $role = Role::find($role_id);

        $role->active = '0';
        $role->updated_by = $request->user()->user_id;

        if($role->save())
        {
            return response()->json(100); //success
        }else{
            return response()->json(200); //failed
        }
    }
}
