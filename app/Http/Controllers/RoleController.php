<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequestRole;
use App\Http\Requests\UpdateRequestRole;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Role;
use Inertia\Inertia;
use Illuminate\Http\Request;

class RoleController extends Controller
{


    public function __construct()
    {
        $this->middleware(['auth:sanctum', 'verified']);
        $this->authorizeResource(Role::class,'role');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::allows('manage-users'))
        {
            $roles = Role::orderBy('rolename')->paginate(config('app.paginazione'));
            
            
            return Inertia::render('roles/index',['roles'=>$roles]);
        }
        else
            Abort('403');
    }


    public function index2()
    {
        if(Gate::allows('manage-users'))
        {
            $roles = User::orderBy('rolename')->paginate(config('app.paginazione'));
            
            return $roles;
        }
        else
            Abort('403');
    }


    public function search($txtsearch = '')
    {
        if(Gate::allows('manage-users'))
        {
            $roles = Role::where('rolename','like',$txtsearch . '%')->orderBy('rolename')->paginate(config('app.paginazione'));
            
            return $roles;
        }
        else
            Abort('403');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequestRole $request)
    {
        $role = new Role;
        $role->rolename = $request['rolename'];
        $role->save();
        return "Dati salvati correttamente";
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequestRole $request, Role $role)
    {
        $role->rolename = $request->rolename;
        $role->save();
        return "Dati salvati correttamente";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        Role::destroy($role['id']);
        return "Record eliminato correttamente!";
    }
}
