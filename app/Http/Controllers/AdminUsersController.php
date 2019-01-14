<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsersRequest;
use Illuminate\Http\Request;
use App\User as User;
use App\Role;
use App\Photo;

class AdminUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with(['role','photo'])->get();
        foreach ($users as $user) {
            if(!isset($user['photo'])){
                $user['photo'] = new Photo(['file'=>'']);
            }
        }

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name', 'id')->all();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsersRequest $request)
    {
        if(trim($request->password ='')){
            $input = $request->except('password');
        }else{
            $input = $request->all();
            $input['password'] = bcrypt($request->password);
        }


        if($photo = isset($input['photo'])){

            $name = time() . $photo->getClientOriginalName();

            if($file = $request->file('photo')){
                $file->move('images',$name);
                $photo = new Photo(['file'=>$name]);
                $photo->save();
                $input['photo_id'] = $photo->id;
            }
        }

        $input['password'] = bcrypt($request->password);

        User::create($input);

        return redirect('admin/users');
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        if(!$user->photo){
            $user['photo'] = new Photo(['file' => '']);
        }

        $roles = Role::pluck('name','id')->all();

        return view ('admin.users.edit',compact('user','roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UsersRequest $request, $id)
    {
        $user = User::findOrFail($id);
        if(trim($request->password ='')){
            $input = $request->except('password');

        }else{
            $input = $request->all();
            $input['password'] = bcrypt($request->password);
        }

        if($newPhoto = $input['photo']){
            $name = $newPhoto->getClientOriginalName();
            if(($user->photo && ($name !== $user->photo->file)) || !$user->photo){
                    $name= time() . $name;
                    $newPhoto->move('images', $name);
                    $photo = Photo::create(['file'=>$name]);
                    $input['photo_id'] = $photo->id;
            }
        }
            $user->update($input);
            return redirect('admin/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
