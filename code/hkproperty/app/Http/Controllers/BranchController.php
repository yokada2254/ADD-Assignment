<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Branch;

class BranchController extends Controller
{
    private $rules = [
        'name' => 'string|required',
        'manager_id' => 'int|required'
    ];

    public function index(){
        return view('branch.index');
    }
    public function edit(Branch $branch){
        // $branch = $branch->load('manager', 'staff');
        return view('branch.edit', compact('branch'));
    }

    public function update(Branch $branch, Request $request){
        $data = $request->validate($this->rules);
        $branch->update($data);
        return redirect()->route('branch.index');
    }
}
