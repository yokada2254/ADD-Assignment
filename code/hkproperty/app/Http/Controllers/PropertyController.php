<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Area;
use App\Models\Estate;
use App\Models\EstateType;
use App\Models\People;
use App\Models\Property;
use Illuminate\Support\Facades\Redirect;

class PropertyController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    /*
    public function estates(Request $request){
        $data = $request->validate([
            'area_id' => 'int|nullable',
            'district_id' => 'int|nullable',
            'estate_type_id' => 'int|nullable',
            'keyword' => 'string|nullable'
        ]);
        $estates = Estate::with('district.area')->get();
        
        if(isset($data['area_id'])) $estates->where('area_id', $data['area_id']);
        if(isset($data['district_id'])) $estates->where('district_id', $data['district_id']);
        if(isset($data['estate_type_id'])) $estates->where('estate_type_id', $data['estate_type_id']);
        if(isset($data['keyword'])) $estates->where('area_id', 'LIKE', "%{$data['keyword']}%");

        dd($estates->toSql());
        dd($estates->get());

        dd($data);
    }
    */

    public function index(Request $request){
        $owners = [];

        $data = array_filter($request->validate([
            'owner_id.*' => 'int|nullable',
            'area_id' => 'int|nullable',
            'district_id' => 'int|nullable',
            'estate_id.*' => 'int|nullable',
            'estate_type_id' => 'int|nullable',
            'block' => 'string|nullable',
            'floor' => 'string|nullable',
            'flat' => 'string|nullable',
            'room' => 'int|nullable',
            'gross_size_fm' => 'int|nullable',
            'gross_size_to' => 'int|nullable',
        ]));

        $properties = Property::select('properties.*')
            ->with('estate.district.area', 'estate.estateType')
            ->join('estates', 'properties.estate_id', '=', 'estates.id')
            ->join('districts', 'estates.district_id', '=', 'districts.id')
            ->join('areas', 'districts.area_id', '=', 'areas.id');

        if(isset($data['owner_id'])){
            $properties = $properties->whereHas('owners', function($query) use($data){
                $query->whereIn('people_id', $data['owner_id']);
            });
            $owners = People::findMany($data['owner_id'], ['id', 'name']);
        }
        
        if(isset($data['area_id'])) $properties = $properties->where('area_id', $data['area_id']);
        if(isset($data['district_id'])) $properties = $properties->where('district_id', $data['district_id']);
        if(isset($data['estate_id'])) $properties = $properties->whereIn('estate_id', $data['estate_id']);
        if(isset($data['estate_type_id'])) $properties = $properties->where('estate_type_id', $data['estate_type_id']);

        if(isset($data['block'])) $properties = $properties->where('block', $data['block']);
        if(isset($data['floor'])) $properties = $properties->where('floor', $data['floor']);
        if(isset($data['flat'])) $properties = $properties->where('flat', $data['flat']);
        if(isset($data['room'])) $properties = $properties->where('room', $data['room']);
        if(isset($data['gross_size_fm'])) $properties = $properties->where('gross_size', '>=', $data['gross_size_fm']);
        if(isset($data['gross_size_to'])) $properties = $properties->where('gross_size', '<=', $data['gross_size_to']);
        
        $properties = $properties->paginate(10);

        switch($request->header('accept')){
            case "application/json": 
                return $properties;
            default:
                $estates = isset($data['estate_id'])?Estate::findMany($data['estate_id']):[];
                return view('property.index', compact('properties', 'owners', 'estates'));
        }
    }

    public function show(Estate $estate, Property $property){
        $disabled = 'disabled';
        return view('property.show', compact('estate', 'property', 'disabled'));
    }

    public function edit(Request $request, Estate $estate, Property $property){
        $property['owners'] = People::findMany($request->old('people_id', []), ['id', 'name', 'gender']);

        return view('property.edit', compact('estate', 'property'));
    }

    public function property(Request $request){
        $data = $request->validate(['estate_id' => 'int|nullable']);

        $properties = Property::query();
        if(isset($data['estate_id'])) $properties->where('estate_id', $request->has('estate_id'));

        return $properties->get()->toArray();
    }

    public function create(Estate $estate, Request $request){
        $property = new Property();
        $property['owners'] = People::findMany($request->old('people_id', []), ['id', 'name', 'gender']);

        return view('property.create', compact('estate', 'property'));
    }


    private $rules = [
        'block' => 'string|nullable',
        'floor' => 'string|nullable',
        'flat' => 'string|nullable',
        'room' => 'int|required',
        'store_room' => 'int|required',
        'washroom' => 'int|required',
        'gross_size' => 'int|required',
        'roof_size' => 'int|required',
        'balcony_size' => 'int|required',
        'people_id.*' => 'int|nullable'
    ];

    public function store(Estate $estate, Request $request){
        $validator = Validator::make($request->all(), $this->rules);
        if($validator->fails()){
            $request->flash();
            return Redirect::back()
                ->withInput()
                ->withErrors($validator);
        }else{
            $data = $validator->validated();
        }
        // $data = $request->validate($this->rules);
        $data = array_merge($data, [
            'estate_id' => $estate->id,
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
        ]);
        $property = $estate->properties()->create($data);
        if(isset($data['people_id']))
            $property->owners()->sync($data['people_id']);

        return view('estate.show', ['estate' => $estate]);
    }

    public function update(Estate $estate, Property $property, Request $request){
        $validator = Validator::make($request->all(), $this->rules);
        if($validator->fails()){
            $request->flash();
            return Redirect::back()
                ->withInput()
                ->withErrors($validator);
        }else{
            $data = $validator->validated();
        }
        $data = array_merge($data, [
            'updated_by' => auth()->user()->id,
        ]);
        $property->update($data);
        $data['people_id'] = isset($data['people_id'])?$data['people_id']:[];
        $property->owners()->sync($data['people_id']);

        return redirect()->route('property.show', compact('estate', 'property'));
    }
}