@extends('layouts.app')

@section('content')

<form class="container" action="{{ route('report.performance.index') }}" method="GET">
    @csrf
    @foreach ($errors->all() as $error)
    <div class="alert alert-danger" role="alert">{{ $error }}</div>
    @endforeach
    
    <div class="card">
        <div class="card-header">
            <h5 class="font-weight-blod">{{ __('report.title') }} - {{ __('report.performance') }}</h5>
        </div>
        <div class="card-body">
            <div class="form-row">
                <div class="form-group col-lg-3 col-md-6">
                    <label>{{ __('common.branch') }}</label>
                    @foreach($branches as $branch)
                    <div class="form-check">
                        <input 
                            class="form-check-input" type="checkbox" 
                            value="{{ $branch->id }}" name="branch_id[]" 
                            id="branch_id_{{ $branch->id }}" 
                            {{ is_array(request()->input('branch_id')) &&in_array($branch->id, request()->input('branch_id'))?'checked':'' }}
                        />
                        <label class="form-check-label" for="branch_id_{{ $branch->id }}">{{ $branch->name }}</label>
                    </div>
                    @endforeach
                </div>
                

                <div class="form-group col-lg-3 col-md-6">
                    <label>{{ __('transaction.transaction_type') }}</label>
                    @foreach($transaction_types as $type)
                    <div class="form-check">
                        <input 
                            class="form-check-input" type="checkbox" 
                            value="{{ $type->id }}" name="transaction_type_id[]" 
                            id="transaction_type_id_{{ $type->id }}" 
                            {{ is_array(request()->input('transaction_type_id')) && in_array($type->id, request()->input('transaction_type_id'))?'checked':'' }}
                        />
                        <label class="form-check-label" for="transaction_type_id_{{ $type->id }}">{{ $type->name }}</label>
                    </div>
                    @endforeach
                </div>

                
                <div class="form-group col-lg-6">
                    <label>{{ __('transaction.date') }}</label>
                    <div class="input-group input-group-sm">
                        <input type="date" class="form-control" name="date_fm" value="{{ request()->input('date_fm') }}">
                        <div class="input-group-prepend input-group-append">
                            <div class="input-group-text">{{ __('form.to') }}</div>
                        </div>
                        <input type="date" class="form-control" name="date_to" value="{{ request()->input('date_to') }}">
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer d-flex justify-content-center">
            <button class="btn btn-sm btn-primary m-1" type="submit" name="submit" value="1">
                <i class="fas fa-search mr-1"></i>{{ __('form.search') }}
            </button>
            <a class="btn btn-sm btn-secondary m-1" href="{{ route('report.performance.index') }}">
                <i class="fas fa-redo-alt mr-1"></i>{{ __('form.reset') }}
            </a>
        </div>
    </div>

    @if(sizeof($result) > 0)
    @foreach($result as $branch)
    <div class="card my-2">
        <div class="card-header">
            <h5>{{ __('common.branch') }} - {{ $branch->name }}</h5>
        </div>
        <table class="table table-response-md table-dark table-sm">
            <thead>
            <tr>
                <td class="text-center">{{ __('transaction.faciliatedby') }}</td>
                <td class="text-center">{{ __('transaction.date') }}</td>
                <td class="text-center">{{ __('transaction.transaction_type') }}</td>
                <td class="text-right">{{ __('transaction.amount') }}</td>
                <td class="text-right">{{ __('transaction.commission') }}</td>
                <td></td>
            </tr>
            </thead>
            <tbody>
            @foreach($branch->transactions as $transaction)
            <tr>
                <td class="text-center">{{ @$transaction->facilitatedBy->name }}</td>
                <td class="text-center">{{ $transaction->transaction_date }}</td>
                <td class="text-center">{{ @$transaction->transactionType->name }}</td>
                <td class="text-right">{{ $transaction->transaction_type_id == 3?'$':__('common.ten_thousand') }} {{ number_format($transaction->transaction_amount, 0) }}</td>
                <td class="text-right">$ {{ number_format($transaction->commission, 0) }}</td>
                <td class="text-center">
                    <a class="btn btn-sm btn-secondary" href="{{ route('transaction.show', [$transaction]) }}" target="_blank">
                        <i class="fas fa-info-circle"></i>
                    </a>
                </td>
            </tr>
            @endforeach
            </tbody>
            <tfooter>
            <tr>
                <td class="text-right">{{ __('common.count') }}:</td>
                <td class="text-left">{{ number_format($branch->transactions->count(), 0) }}</td>
                <td></td>
                <td class="text-right">{{ __('common.total') }}:</td>
                <td class="text-right">$ {{ number_format($branch->transactions->sum('commission'), 0) }}</td>
                <td></td>
            </tr>
            </tfooter>
        </table>
        <div class="card-footer"></div>
    </div>
    @endforeach
    @endif
</form>
@endsection