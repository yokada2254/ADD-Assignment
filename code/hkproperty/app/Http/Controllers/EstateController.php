<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estate;

class EstateController extends Controller
{
    private $rules = [
        'district_id' => 'int|required',
        'estate_type_id' => 'int|required',
        'name' => 'string|required',
        'address' => 'string|nullable'
    ];

    public function __construct(){
        $this->middleware('auth');
    }

    public function create(){
        $estate = new Estate();
        return view('estate.create', compact('estate'));
    }

    public function store(Request $request){
        $data = $request->validate($this->rules);
        $data['created_by'] = auth()->user()->name;

        $estate = Estate::create($data);

        return redirect()->route('estate.show', ['estate' => $estate->id]);
    }

    public function show($estate){
        $estate = Estate::with('properties', 'district.area')->findOrFail($estate);
        return view('estate.show', compact('estate'));
    }

    public function edit($estate){
        $estate = Estate::with('properties', 'district.area')->findOrFail($estate);
        // dd($estate);
        return view('estate.edit', compact('estate'));
    }

    public function update(Estate $estate, Request $request){
        $data = $request->validate($this->rules);
        $data['updated_by'] = auth()->user()->name;
        $estate->update($data);

        // dd($estate);
        return view('estate.show', compact('estate'));
    }

    public function index(Request $request){
        $data = array_filter($request->validate([
            'area_id' => 'int|nullable',
            'district_id' => 'int|nullable',
            'estate_type_id' => 'int|nullable',
            'keyword' => 'string|nullable',
            'estate_id.*' => 'int|nullable'
        ]));
        // dd($data);

        $estates = Estate::select('estates.*');
        $estates->join('districts', 'districts.id', '=', 'estates.district_id');
        $estates->join('areas', 'areas.id', '=', 'districts.area_id');
        // dd($estates);
        if(isset($data['area_id'])) $estates->where('area_id', $data['area_id']);
        if(isset($data['district_id'])) $estates->where('district_id', $data['district_id']);
        if(isset($data['estate_type_id'])) $estates->where('estate_type_id', $data['estate_type_id']);
        if(isset($data['estate_id'])) $estates->whereIn('estates.id', $data['estate_id']);
        if(isset($data['keyword'])){
            $estates->where(function($q) use ($data){
                $q->where('estates.name', 'LIKE', '%' . $data['keyword'] . '%');
                $q->orWhere('estates.address', 'LIKE', '%' . $data['keyword'] . '%');
            });
        }
        
        $estates = $estates->paginate(15);

        switch($request->header('accept')){
            case "application/json": 
                return $estates;
            default:
                $request->flash();
                $selectedEstates = isset($data['estate_id'])?Estate::findMany($data['estate_id'], ['id', 'name']):[];
                return view('estate.index', compact('estates', 'selectedEstates'));
        }
    }
}