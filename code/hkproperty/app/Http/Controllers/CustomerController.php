<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

use App\Models\Customer;
use App\Models\People;

use App\Models\Estate;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    private $rules = [
        'status_id' => 'int|required',
        'people_id.*' => 'int|required',
        'prefer.*.id' => 'string|nullable',
        'prefer.*.transaction_type_id' => 'int|required',
        'prefer.*.fm' => 'int|required',
        'prefer.*.to' => 'int|required',
        'prefer.*.room' => 'int|nullable',
        'prefer.*.area_district.*.id' => 'int|nullable',
        'prefer.*.area_district.*.area_id' => 'int|nullable',
        'prefer.*.area_district.*.district_id' => 'int|nullable',
        'prefer.*.area_district.*.estate_id.*' => 'int|nullable',
    ];

    private $queryRules = [
        'customer_status_id' => 'int|nullable',
        'name' => 'string|nullable',
        'contact' => 'string|min:4|nullable',
        'transaction_type_id' => 'int|nullable',
        'area_id' => 'int|nullable',
        'district_id' => 'int|nullable',
        'estate_type_id' => 'int|nullable',
        'estate_id.*' => 'int|nullable',
        'room' => 'int|nullable',
        'gross_size_fm' => 'int|nullable',
        'gross_size_to' => 'int|nullable',
    ];

    public function __construct(){
        $this->middleware('auth');
    }

    public function index(Request $request){
        // $customers = Customer::query();
        $customers = Customer::with(
            'people.contacts.contactType', 
            'status',
            'prefers.areaDistricts.estates.estateType',
            'prefers.areaDistricts.area',
            'prefers.areaDistricts.district'
        );

        $data = array_filter($request->validate($this->queryRules));

        if(isset($data["customer_status_id"])){
            $customers->where('status_id', $data['customer_status_id']);
        }

        if(isset($data['name']) || isset($data['contact'])){
            $customers->whereHas('people', function($query) use ($data){
                if(isset($data['name'])){
                    $query->where('name', 'like', '%'.$data['name'].'%');
                }
                if(isset($data['contact'])){
                    $query->whereHas('contacts', function($query) use ($data){
                        $query->where('data', 'like', '%'.$data['contact'].'%');
                    });
                }
            });
        }

        if(array_intersect_key($data, ['transaction_type_id', 'area_id', 'district_id', 'estate_type_id', 'estate_id', 'room', 'gross_size_fm', 'gross_size_to'])){
            $customers->whereHas('prefers', function($query) use ($data){
                forEach(['transaction_type_id', 'area_id', 'district_id', 'estate_type_id'] as $key){
                    if(isset($data[$key]))
                        $query->where($key, $data[$key]);
                }
                if(isset($data['estate_id']))
                    $query->whereHasMorph('estates', function($query) use ($data){
                        $query->whereIn('estate_id', $data['estate_id']);
                    });
            });
        }
        

        $customers = $customers->paginate(10);
        if($request->header('Accept') == 'application/json'){
            return $customers;
        }else{
            $request->flash();
            return view('customer.index', compact('customers'));
        }
    }

    public function create(Request $request){
        $customer = new Customer([
            'status_id' => 1,
            'craeted_by' => 0,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_by' => 0,
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        $old = $request->session()->getOldInput();
        $people = 
            $request->has('people')?[People::find($request->get('people'))]:
            (isset($old["people_id"])?People::findMany($old["people_id"]):[]);
        
        $prefer = isset($old["prefer"])?array_map(function($prefer){
            if(isset($prefer["details"])){
                $prefer["details"] = array_map(function($details){
                    $details["area"] = $details["area_id"];
                    $details["district"] = $details["district_id"];
                    $details["estates"] = isset($details["estate_id"])?
                        Estate::findMany($details["estate_id"], ['id', 'name'])->toArray():[];
                    return $details;
                }, $prefer["details"]);
            }
            return $prefer;
        }, $old["prefer"]):[];

        return view('customer.create', compact('customer', 'people', 'prefer'));
    }

    public function store(Request $request){
        // dd($request->all());
        $validator = Validator::make($request->all(), $this->rules);
        
        if($validator->fails()){
            return redirect()->route('customer.create')
                ->withInput($request->all())
                ->withErrors($validator);
        }
        
        $data = $request->validate($this->rules);
        // dd($data);
        
        $customer = Customer::create([
            'status_id' => $data['status_id'],
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id
        ]);
        $customer->people()->attach($data["people_id"]);

        collect($data["prefer"])->each(function($item) use ($customer){
            $prefer = $customer->prefers()->create($item);
            if(isset($item["area_district"])){
                collect($item["area_district"])->each(function($item) use ($prefer){
                    $areaDistrict = $prefer->areaDistricts()->create($item);
                    if(isset($item["estate_id"])){
                        $areaDistrict->estates()->attach($item["estate_id"]);
                    }
                });
            }
        });
        return redirect()->route('customer.show', compact('customer'));
    }

    public function show(Customer $customer){
        $people = $customer->people;
        $prefer = $customer->prefers()->with('areaDistricts.estates:id,name')->get();
        
        return view('customer.show', compact('customer', 'people', 'prefer'));
    }

    public function edit(Customer $customer){
        $people = $customer->people;
        $prefer = $customer->prefers()->with('areaDistricts.estates:id,name')->get();
        
        return view('customer.edit', compact('customer', 'people', 'prefer'));
    }

    public function update(Customer $customer, Request $request){
        $data = $request->validate($this->rules);

        $ids = collect($data["prefer"])->pluck('id')->toArray();
        $customer->prefers()->each(function($prefer) use ($ids){
            if(!in_array($prefer->id, $ids)){
                $prefer->delete();
            }
        });

        forEach($data["prefer"] as $prefer){
            $updatedPrefer = $customer->prefers()->updateOrCreate(['id' => $prefer['id']], $prefer);
            if(isset($prefer["area_district"])){
                forEach($prefer["area_district"] as $areaDistrict){
                    $areaDistrict["estate_id"] = isset($areaDistrict["estate_id"])?$areaDistrict["estate_id"]:[];

                    $updatedPrefer
                        ->areaDistricts()
                        ->updateOrCreate(['id' => $areaDistrict['id']], $areaDistrict)
                        ->estates()->sync($areaDistrict["estate_id"]);
                }
            }else{
                $updatedPrefer->areaDistricts->each(function($ad){
                    $ad->delete();
                });
            }
        }
        $customer->people()->sync($data["people_id"]);
        $customer->update([ 
            'status_id' => $data['status_id'],
            'updated_by' => auth()->user()->id 
        ]);
        
        return redirect()->route('customer.show', compact('customer'));
    }

    public function delete(){

    }
}
