<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\PostUserRequest;
use App\Http\Requests\Admin\User\PutUserRequest;
use App\Role;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    public function index()
    {
        $users = User::with('roles')->paginate(15);
        Auth::user()->load('roles');

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();

        return view('admin.users.create', compact('roles'));
    }

    public function store(PostUserRequest $request)
    {
        $requestData = $request->validated();
        $requestData['password'] = Hash::make($requestData['password']);

        $user = User::create($requestData);
        $user->roles()->attach($requestData['roles']);
        $user->markEmailAsVerified();

        flash('The user has been successfully created.')->success();

        return redirect()->route('admin.users.index');
    }

    public function edit(User $user)
    {
        $roles = Role::all();

        return view('admin.users.edit', compact('user','roles'));
    }

    public function update(PutUserRequest $request, User $user)
    {
        $requestData = $request->validated();

        if (!empty($requestData['password'])) {
            $requestData['password'] = Hash::make($requestData['password']);
        } else {
            unset($requestData['password']);
        }

        $user->update($requestData);
        $user->roles()->sync($requestData['roles']);

        flash('The user has been successfully updated.')->success();

        return redirect()->route('admin.users.index');
    }

    public function destroy(User $user)
    {
        try {
            $user->delete();
            flash('The user has been successfully deleted.')->success();
        } catch (\Exception $e) {
            flash('An error occurred while deleting the user.')->error();
        }

        return redirect()->route('admin.users.index');
    }
}
