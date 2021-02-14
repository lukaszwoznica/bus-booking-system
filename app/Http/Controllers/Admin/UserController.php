<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\UsersDataTable;
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

    public function index(UsersDataTable $dataTable)
    {
        Auth::user()->load('roles');

        return $dataTable->render('admin.users.index');
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

        return redirect()->route('admin.users.index')
            ->withToastSuccess('The user has been successfully created!');
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

        return redirect()->route('admin.users.index')
            ->withToastSuccess('The user has been successfully updated!');
    }

    public function destroy(User $user)
    {
        try {
            $user->delete();
        } catch (\Exception $e) {
            return redirect()->route('admin.users.index')
                ->withToastError('An error occurred while deleting the user.');
        }

        return redirect()->route('admin.users.index')
            ->withToastSuccess('The user has been successfully deleted!');
    }
}
