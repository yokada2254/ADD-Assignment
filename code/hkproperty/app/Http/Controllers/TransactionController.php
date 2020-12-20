<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Customer;
use App\Models\Estate;
use App\Models\Package;
use App\Models\PackageOffer;
use App\Models\Property;
use App\Models\Transaction;
use App\Models\TransactionType;

class TransactionController extends Controller
{
    private $rules = [
        'package_id' => 'int|required',
        'customer_id' => 'int|required',
        'transaction_type_id' => 'int|required',
        'transaction_amount' => 'int|required',
        'commission' => 'int|required',
        'branch_id' => 'int|required',
        'transaction_date' => 'date|required',
        'facilitated_by' => 'int|required'
    ];

    private $relations = [
        'transactionType',
        'package.properties.estate.estateType', 
        'package.owners.contacts.contactType',
        'customer.people.contacts.contactType',
        'createdBy:id,name',
        'updatedBy:id,name'
    ];

    public function create(Request $request){
        $data = $request->validate(['offer_id' => 'int|required']);
        $offer = PackageOffer::findOrFail($data['offer_id']);
        $package = Package::with('properties.estate.estateType', 'owners')->findOrFail($offer->package_id);

        switch($offer->transaction_type_id){
            case "1":
            case "2":
                $commission = $offer->price * 10000 * 0.02;
            break;

            case "3":
                $commission = $offer->price;
            break;
        }
        $branch = auth()->user()->branch->id;
        $user = auth()->user()->id;

        $transaction = new Transaction([
            'branch_id' => $branch,
            'package_id' => $package->id,
            'transaction_amount' => $offer->price,
            'transaction_type_id' => $offer->transaction_type_id,
            'transaction_date' => date("Y-m-d"),
            'commission' => $commission,
            'faciliated_by' => $user,
            'created_by' => $user,
            'updated_by' => $user,
        ]);
        $transaction->package = $package;
        $transaction->transaction_type = TransactionType::find($offer->transaction_type_id);

        return view('transaction.create', compact('transaction'));
    }
    public function store(Request $request){
        $data = $request->validate($this->rules);

        $data['created_by'] = $data['updated_by'] = auth()->user()->id;
        $transaction = Transaction::create($data);
        $transaction->package->update([
            'status_id' => 2,
            'update_by' => auth()->user()->id
        ]);
        $customer = Customer::find($data['customer_id']);
        $transaction->package->properties->each(function(Property $property) use ($customer){
            $property->owners()->sync($customer->people->pluck('id'));
        });

        return redirect()->route('transaction.show', compact('transaction'));
    }

    public function show(Transaction $transaction){
        $transaction = $transaction->load(...$this->relations);
        return view('transaction.show', compact('transaction'));
    }

    public function edit(Transaction $transaction){
        $transaction = $transaction->load(...$this->relations);
        return view('transaction.edit', compact('transaction'));
    }

    public function update(Request $request, Transaction $transaction){
        $data = $request->validate($this->rules);
        $data['updated_by'] = auth()->user()->id;
        $transaction->update($data);
        $transaction = $transaction->load(...$this->relations);

        return redirect()->route('transaction.show', compact('transaction'));
    }

    public function index(Request $request){
        $transaction_related = [
            'transaction_type_id' => 'int|nullable',
            'transaction_date_fm' => 'date|nullable',
            'transaction_date_to' => 'date|nullable'
        ];

        $people_related = [
            'people_type' => 'string|nullable',
            'people_name' => 'string|nullable',
            'people_contact' => 'string|nullable',
        ];

        $property_related = [
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
        ];
        
        $data = array_filter(
            $request->validate(
                array_merge($transaction_related, $people_related, $property_related)));
        
        // query()//
        $transactions = Transaction::with(...$this->relations)
            ->select('transactions.*')
            ->join('customers', 'customer_id', 'customers.id')
            ->join('packages', 'package_id', 'packages.id')
            ->join('package_property', 'packages.id', 'package_property.package_id')
            ->join('properties', 'property_id', 'properties.id')
            ->join('estates', 'estate_id', 'estates.id')
            ->join('districts', 'district_id', 'districts.id')
            ->join('areas', 'area_id', 'areas.id')
            ->join('related', function($join){
                $join->on(function($join){
                    $join->on('related_id', 'customers.id');
                    $join->where('related_type', "App\\Models\\Customer");
                });
                $join->orOn(function($join){
                    $join->on('related_id', 'packages.id');
                    $join->where('related_type', "App\\Models\\Package");
                });
            })
            ->join('people', 'related.people_id', 'people.id')
            ->leftJoin('contacts', 'people.id', 'contacts.people_id')
            ->groupBy('transactions.id');
            
        if(isset($data['transaction_type_id'])) $transactions->where('transaction_type_id', $data['transaction_type_id']);
        if(isset($data['transaction_date_fm'])) $transactions->where('transaction_date', '>=', $data['transaction_date_fm']);
        if(isset($data['transaction_date_to'])) $transactions->where('transaction_date', '<=', $data['transaction_date_to']);

        if(isset($data['people_type']) && !empty(@$data['people_name'].@$data['people_contact'])){
            $transactions->where('related_type', "App\\Models\\".$data['people_type']);
            if(isset($data['people_name'])) $transactions->where('people.name', 'LIKE', '%'.$data['people_name'].'%');
            if(isset($data['people_contact'])) $transactions->where('contacts.data', '%'.$data['people_contact'].'%');
        }
        
        if(isset($data['area_id'])) $transactions = $transactions->where('area_id', $data['area_id']);
        if(isset($data['district_id'])) $transactions = $transactions->where('district_id', $data['district_id']);
        if(isset($data['estate_type_id'])) $transactions = $transactions->where('estate_type_id', $data['area_id']);
        if(isset($data['estate_id'])) $transactions = $transactions->whereIn('estate_id', $data['estate_id']);
        if(isset($data['block'])) $transactions = $transactions->where('block', $data['block']);
        if(isset($data['floor'])) $transactions = $transactions->where('floor', $data['floor']);
        if(isset($data['flat'])) $transactions = $transactions->where('flat', $data['flat']);
        if(isset($data['room'])) $transactions = $transactions->where('room', $data['room']);
        if(isset($data['gross_size_fm'])) $transactions = $transactions->where('gross_size', '>=', $data['gross_size_fm']);
        if(isset($data['gross_size_to'])) $transactions = $transactions->where('gross_size', '<=', $data['gross_size_to']);


        // DB::enableQueryLog();
        $transactions = $transactions->paginate(10);
        // dd(DB::getQueryLog());

        $estates = isset($data['estate_id'])?Estate::findMany($data['estate_id'], ['id', 'name']):[];
        $request->flash();
        
        return view('transaction.index', compact('transactions', 'estates'));
    }
}