<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\PackageOffer;
use App\Models\Property;
use App\Models\Estate;
use App\Models\TransactionType;

class PackageController extends Controller{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(Request $request){
        if($request->has('submit')){
            $data = array_filter($request->validate([
                'transaction_type_id' => 'int|nullable',
                'status_id' => 'int|nullable',
                'area_id' => 'int|nullable',
                'district_id' => 'int|nullable',
                'estate_type_id' => 'int|nullable',
                'estate_id.*' => 'int|nullable',
                'block' => 'string|nullable',
                'floor' => 'string|nullable',
                'flat' => 'string|nullable',
                'room' => 'int|nullable',
                'gross_size_fm' => 'int|nullable',
                'gross_size_to' => 'int|nullable',
                'price_fm' => 'int|nullable',
                'price_to' => 'int|nullable',
            ]));
        }else{
            $data = [
                'status_id' => 1,
            ];
        }

        $packages = Package::with('properties.estate.estateType', 'properties.estate.district.area', 'owners', 'offers.transactionType', 'status')
            ->select('packages.*')
            ->join('package_property', 'packages.id', 'package_id')
            ->join('properties', 'property_id', 'properties.id')
            ->join('estates', 'estate_id', 'estates.id')
            ->join('estate_types', 'estate_type_id', 'estate_types.id')
            ->join('districts', 'district_id', 'districts.id')
            ->join('areas', 'area_id', 'areas.id')
            ->join('package_offers', 'packages.id', 'package_offers.package_id')
            ->join('related', function($join){
                $join->on('packages.id', 'related.related_id')
                    ->where('related_type', 'App\\Models\\Package');
            })
            ->groupBy('packages.id');

        if(isset($data['transaction_type_id'])) $packages->where('transaction_type_id', $data['transaction_type_id']);
        if(isset($data['status_id'])) $packages->where('status_id', $data['status_id']);
        if(isset($data['area_id'])) $packages->where('area_id', $data['area_id']);
        if(isset($data['district_id'])) $packages->where('district_id', $data['district_id']);
        if(isset($data['estate_type_id'])) $packages->where('estate_type_id', $data['estate_type_id']);
        if(isset($data['estate_id'])) $packages->whereIn('estate_id', $data['estate_id']);
        if(isset($data['block'])) $packages->where('block', $data['block']);
        if(isset($data['floor'])) $packages->where('floor', $data['floor']);
        if(isset($data['flat'])) $packages->where('flat', $data['flat']);
        if(isset($data['room'])) $packages->where('room', $data['room']);
        if(isset($data['gross_size_fm'])) $packages->where('gross_size', '>=', $data['gross_size_fm']);
        if(isset($data['gross_size_to'])) $packages->where('gross_size', '<=', $data['gross_size_to']);
        if(isset($data['price_fm'])) $packages->where('price', '>=', $data['price_fm']);
        if(isset($data['price_to'])) $packages->where('price', '<=', $data['price_to']);

        
        $packages = $packages->paginate(20);
        
        $request->flash();
        $estates = isset($data['estate_id'])?Estate::findMany($data['estate_id'], ['id', 'name']):[];

        return view('package.index', compact('packages', 'estates'));
    }

    public function create(){
        $transactionTypes = $this->transactionTypes();
        return view('package.create', compact('transactionTypes'));
    }

    public function store(Request $request){
        $data = $this->validation($request);

        $package = Package::create([
            'status_id' => $data['status_id'],
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id
        ]);

        if(isset($data["offers"])) $package->offers()->createMany($data["offers"]);
        if(isset($data["property_id"])) $package->properties()->attach($data['property_id']);
        if(isset($data["people_id"])) $package->owners()->attach($data['people_id']);

        Property::findMany($data['property_id'])->each(function($property) use ($data){
            $property->owners()->sync($data['people_id']);
        });

        return redirect()->route('package.show', compact('package'));
    }

    public function edit($package){
        $package = Package::with("properties.estate.estateType", "owners", "offers", "createdBy", "updatedBy")->findOrFail($package);
        $transactionTypes = $this->transactionTypes();
        return view('package.edit', compact('package', 'transactionTypes'));
    }

    public function update(Package $package, Request $request){
        $data = $this->validation($request);

        $package->update([
            'status_id' => $data['status_id'],
            'updated_by' => auth()->user()->id
        ]);

        // delete
        $package->offers->each(function($offer) use ($request){
            if(!in_array($offer->id, $request->input('offers.*.id'))){
                $offer->delete();
            }
        });
 
        // add or update
        collect($request->get('offers'))->each(function($offer) use ($package){
            if(preg_match("/^temp\_/", $offer["id"])){
                $package->offers()->create($offer);
            }else{
                PackageOffer::findOrFail($offer["id"])->update($offer);
            }
        });

        $package->properties()->detach($package->properties);
        if(isset($data["property_id"])) $package->properties()->attach($data['property_id']);

        $package->owners()->detach($package->owners);
        if(isset($data["people_id"])) $package->owners()->attach($data['people_id']);
        
        return redirect()->route('package.show', compact('package'));
    }

    public function show($package){
        $transactionTypes = $this->transactionTypes();
        $package = Package::with("properties.estate.estateType", "owners", "offers", "createdBy", "updatedBy")->findOrFail($package);
        
        return view('package.show', compact('package', 'transactionTypes'));
    }

    private function transactionTypes(){
        return TransactionType::orderBy('id', 'asc')->get();
    }

    private function validation(Request $request){
        return $request->validate([
            'status_id' => 'int',
            'property_id.*' => 'int',
            'offers.*.id' => 'string',
            'offers.*.transaction_type_id' => 'int',
            'offers.*.price' => 'numeric',
            'people_id.*' => 'int'
        ]);
    }
}