<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreRequestUser;
use App\Http\Requests\UpdateRequestUser;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth:sanctum', 'verified']);
        $this->authorizeResource(User::class,'user');
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
            $users = User::with('roles')->orderBy('lastname')->paginate(config('app.paginazione'));
            $roles = Role::get();
            
            return Inertia::render('users/index',['users'=>$users,'roles' => $roles]);
        }
        else
            Abort('403');
    }

    public function index2()
    {
        if(Gate::allows('manage-users'))
        {
            $users = User::with('roles')->orderBy('lastname')->paginate(config('app.paginazione'));
            
            return $users;
        }
        else
            Abort('403');
    }

    public function search($txtsearch = '')
    {
        if(Gate::allows('manage-users'))
        {
            $users = User::with('roles')->where('lastname','like',$txtsearch . '%')->orWhere('name','like',$txtsearch . '%')->orderBy('lastname')->paginate(config('app.paginazione'));
            
            return $users;
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequestUser $request)
    {
        
        $user = new User;
        $user->lastname = $request['lastname'];
        $user->name = $request['name'];
        $user->cfiscale =  $request['cfiscale'];
        $user->email = $request['email'];
        $user->address = $request["address"];
        $user->cap = $request["cap"];
        $user->city = $request["city"];
        $user->prov = $request["prov"];
        $user->phone = $request["phone"];
        $user->birth = $request["birth"];
        $user->natoa = $request["natoa"];
        $user->agree = 1;
        $user->email_verified_at =  date("Y-m-d H:i:s");
        $user->password =  Hash::make($request['password']);
        $user->save();
        $user->roles()->sync($request["role_id"]);
        
        return "Dati salvati correttamente";

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequestUser $request, User $user)
    {
        $user->lastname = $request->lastname;
        $user->name = $request->name;
        $user->email = $request["email"];
        $user->address = $request["address"];
        $user->cap = $request["cap"];
        $user->city = $request["city"];
        $user->prov = $request["prov"];
        $user->phone = $request["phone"];
        $user->birth = $request["birth"];
        $user->natoa = $request["natoa"];
        $user->cfiscale = $request["cfiscale"];
        $user->email_verified_at = date("Y-m-d H:i:s");
        if(isset($request['password']) && !is_null($request["password"]) && !empty($request["password"]))
            $user->password = Hash::make($request['password']);
        $user->save();
        $user->roles()->sync($request["role_id"]);
        return 'ok';

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        User::destroy($user['id']);
        return "Record eliminato correttamente!";
    }
}
