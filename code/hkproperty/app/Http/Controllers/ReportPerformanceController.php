<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Branch;
use App\Models\Transaction;

class ReportPerformanceController extends Controller
{
    private $rules = [
        'branch_id.*' => 'int|required',
        'transaction_type_id.*' => 'int|required',
        'date_fm' => 'date|nullable',
        'date_to' => 'date|nullable'
    ];

    public function index(Request $request){
        
        $result = [];

        if($request->has('submit')){
            $data = Validator::make($request->all(), $this->rules);
            if ($data->fails()) {
                return redirect()->route('report.performance.index')->withErrors($data->errors())->withInput();
            }else{
                $data = array_filter($data->validated());
            }
            
            $result = Branch::with([
                'transactions' => function($query) use ($data){
                    if(isset($data['transaction_type_id']))
                        $query->whereIn('transaction_type_id', $data['transaction_type_id']);

                    if(isset($data['date_fm']))
                        $query->where('transaction_date', '>=', $data['date_fm']);
                    
                    if(isset($data['date_to']))
                        $query->where('transaction_date', '<=', $data['date_to']);
                },
                'transactions.transactionType',
                'transactions.facilitatedBy',
            ]);
            
            if(isset($data['branch_id']))
                $result = $result->findMany($data['branch_id']);
            else
                $result = $result->get();
        }
        return view('report.performance', compact('result'));
    }
}