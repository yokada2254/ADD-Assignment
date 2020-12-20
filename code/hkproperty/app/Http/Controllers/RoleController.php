<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Privilege;
use App\Models\Role;

class RoleController extends Controller
{
    private $rules = [
        'name' => 'string|min:4|required',
        'privilege_id.*' => 'int|nullable'
    ];

    public function create(){
        $privileges = Privilege::all();
        return view('role.create', compact('privileges'));
    }
    public function store(Request $request){
        $data = $request->validate($this->rules);

        $role = Role::create($data);

        return redirect()->route('role.show', [$role]);
    }
    public function show(Role $role){
        $privileges = Privilege::all();
        return view('role.show', compact('role', 'privileges'));
    }
    public function index(){
        $roles = Role::all();
        return view('role.index', compact('roles'));
    }
    public function edit(Role $role){
        $privileges = Privilege::all();
        return view('role.edit', compact('role', 'privileges'));
    }
    public function update(Role $role, Request $request){
        $data = $request->validate($this->rules);
        $role->update($data);
        $data['privilege_id'] = isset($data['privilege_id'])?$data['privilege_id']:[];
        $role->privileges()->sync($data['privilege_id']);
        
        return redirect()->route('role.show', compact('role'));
    }
}
