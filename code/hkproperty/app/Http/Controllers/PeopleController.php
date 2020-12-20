<?php

namespace App\Http\Controllers;

use App\Models\People;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class PeopleController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = array_filter($request->validate([
            'name' => 'string|nullable',
            'contact' =>'string|nullable'
        ]));

        $people = People::with('createdBy', 'updatedBy')->select('people.*');

        if(isset($data['name'])) $people = $people->where('name', 'like', "%{$data['name']}%");
        if(isset($data['contact'])){
            $people = $people->join('contacts', 'people.id', 'people_id');
            $people = $people->where('data', 'LIKE', '%'.$data['contact'].'%');
            $people = $people->groupby('people.id');
        }
        
        $people = $people
            ->orderBy('people.updated_by', 'desc')
            ->paginate(15);
        
        switch($request->header('accept')){
            case "application/json": 
                return $people;
            default: 
                return view('people.index', compact('people'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $people = new People([
            'name' => '',
            'hkid' => '',
            'created_by' => auth()->user()->id
        ]);

        return view('people.create', compact('people'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validation($request);
        $data = array_merge($data, [
            'created_by' => auth()->user()->id
        ]);
        $people = People::create($data);
        return redirect()->route("people.show", ["people" => $people]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\People  $people
     * @return \Illuminate\Http\Response
     */
    public function show(People $people)
    {
        $people->load('contacts.contactType');
        return view('people.show', compact('people'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\People  $people
     * @return \Illuminate\Http\Response
     */
    public function edit(People $people)
    {
        return view('people.edit', compact('people'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\People  $people
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, People $people)
    {
        // dd($request->all());
        $data = $this->validation($request);
        $data = array_merge($data, [
            'updated_by' => auth()->user()->id
        ]);
        // dd($data);
        $people->update($data);
        return redirect()->route('people.show', ['people' => $people]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\People  $people
     * @return \Illuminate\Http\Response
     */
    public function destroy(People $people)
    {
        //
    }

    public function validation($request){
        return $request->validate([
            'name' => 'string|min:2|max:255|required',
            'gender' => ['required', Rule::in('M', 'F')],
            'hkid' => 'string|min:0|max:255|nullable',
        ]);
    }
}
