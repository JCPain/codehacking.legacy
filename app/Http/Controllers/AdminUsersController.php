<?php

namespace App\Http\Controllers;

use App\User;

use App\Role;

use App\Photo;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;

use App\Http\Requests;

use App\Http\Requests\UsersRequest;

use App\Http\Requests\UsersEditRequest;

class AdminUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users = User::all();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $roles = Role::pluck('name', 'id')->all();

        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsersRequest $request)
    {
        //

        // User::create($request->all());

        $input = $request->all();

        // if there is a photo in the request, do this
        if($file = $request->file('photo_id')) {

            $name = time() . $file->getClientOriginalName();

            $file->move('images', $name);

            $photo = Photo::create(['file' => $name]);

            $input['photo_id'] = $photo->id;

        }

        $input['password'] = bcrypt($request->password);

        User::create($input);

        Session::flash('msg-created', 'New user ' . $input['name'] . ' has been created.');

        return redirect('/admin/users');

        // return $request->all();
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
        return view('admin.users.show');
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
        $user = User::findOrFail($id);

        $roles = Role::pluck('name', 'id')->all();

        return view('admin.users.edit', compact('user','roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UsersEditRequest $request, $id)
    {
        //
        $user = User::findOrFail($id);

        // Do not deal with the password if the password field is empty
        if(trim($request->password) == '') {

            $input = $request->except('password');

        } else {

            $input = $request->all();

            $input['password'] = bcrypt($request->password);

        }

        if($file = $request->file('photo_id')) {

            $name = time() . $file->getClientOriginalName();

            $file->move('images', $name);

            $photo = Photo::create(['file' => $name]);

            $input['photo_id'] = $photo->id;
            
            //Finds the old picture and deletes it
            #Finds the old picture and deletes it
            if($user->photo_id != null)
            {
                $photo = Photo::findOrFail($user->photo_id);
    
                unlink(public_path() . $photo->file);

                $photo->delete();
            }

        }

        $user->update($input);

        Session::flash('msg-updated', 'User named ' . $user->name . ' has been updated.');

        return redirect('/admin/users');

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
        $user = User::findOrFail($id);

        // Delete the photo in the directory
        // unlink(public_path() . $user->photo->file);

        // Delete photo path from the photo table and the public directory as well
        if($user->photo_id)
        {
            $photo = Photo::findOrFail($user->photo_id);

            unlink(public_path() . $photo->file);

            $photo->delete();
        }
        
        $user->delete();

        Session::flash('msg-deleted', 'User named ' . $user->name . ' has been deleted.');

        return redirect('admin/users');
    }
}
