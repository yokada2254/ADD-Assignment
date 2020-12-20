<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;

class UserController extends Controller
{
    private $rules = [
        'password' => 'alpha_num|min:4|max:20|nullable',
        'role_id' => 'int',
        'branch_id' => 'int'
    ];

    public function password(User $user){
        if(auth()->user()->id == $user->id){
            return view('user.password', compact('user'));
        }
        return redirect()->route('home');
    }

    public function edit(User $user){
        auth()->user()->permitted('System');
        $roles = Role::all();
        return view('user.edit', compact('user', 'roles'));
    }

    public function update(User $user, Request $request){
        $data = $request->validate($request->all());
        if(isset($data['password'])) $data['password'] = Hash::make($data['password']);
        $user->update($data);
        return redirect('user.show', compact('user'));
    }

    public function index(){
        $userlist = User::with('role', 'branch')->get();
        return view('user.index', compact('userlist'));
    }
}