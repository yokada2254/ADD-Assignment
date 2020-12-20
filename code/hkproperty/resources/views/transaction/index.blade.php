@extends('layouts.app')

@section('style')
<style>
.pagination{
    justify-content: center;
}
</style>
@endsection('style')

@section('content')
<form class="container" href="{{ route('transaction.index') }}" method="GET">
    <h3 class="font-weight-bold">{{ __('transaction.title') }}</h3>

    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center justify-content-between">
                <h5>{{ __('form.search') }}</h5>
                <a href="{{ route('transaction.create') }}" class="btn btn-dark btn-sm">
                    <i class="fas fa-plus mr-2"></i>
                    {{ __('form.add') }}
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="form-row my-2">
                <div class="col-3">
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <div class="input-group-text">{{ __('transaction.transaction_type') }}</div>
                        </div>
                        <select class="form-control" name="transaction_type_id">
                            <option value=""></option>
                            @foreach($transaction_types as $type)
                            <option value="{{ $type->id }}" {{ old('transaction_type_id') == $type->id?'selected':'' }}>{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-5">
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <div class="input-group-text">{{ __('transaction.date') }}</div>
                        </div>
                        <input class="form-control" type="date" name="transaction_date_fm" value={{ old('transaction_date_fm') }} />
                        <div class="input-group-prepend input-group-append">
                            <div class="input-group-text">{{ __('form.to') }}</div>
                        </div>
                        <input class="form-control" type="date" name="transaction_date_to" value={{ old('transaction_date_to') }} />
                    </div>
                </div>
            </div>

            <div class="form-row my-2">
                <div class="col-5">
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <div class="input-group-text">{{ __('people.title') }}</div>
                        </div>
                        <select class="form-control" name="people_type">
                            <option value=""></option>
                            <option value="Customer" {{ old('people_type') == 'Customer'?'selected':'' }} >{{ __('transaction.buyer') }}</option>
                            <option value="Package" {{ old('people_type') == 'Package'?'selected':'' }} >{{ __('transaction.seller') }}</option>
                        </select>
                        <input type="text" class="form-control" name="people_name" value="{{ old('people_name') }}" placeholder="{{ __('people.name') }}">
                        <input type="text" class="form-control" name="people_contact" value="{{ old('people_contact') }}" placeholder="{{ __('people.contact') }}">
                    </div>
                </div>
            </div>

            <property-fields
                data-area="{{ old('area_id') }}"
                data-district="{{ old('district_id') }}"
                data-estate-type="{{ old('estate_type_id') }}"
                data-estates="{{ json_encode($estates) }}"
                data-block="{{ old('block') }}"
                data-floor="{{ old('floor') }}"
                data-flat="{{ old('flat') }}"
                data-room="{{ old('room') }}"
                data-gross-size-fm="{{ old('gross_size_fm') }}"
                data-gross-size-to="{{ old('gross_size_to') }}"
            >
            </property-fields>
        </div>
        <div class="card-footer">
            <div class="d-flex align-items-center justify-content-center">
                <button type="submit" name="submit" class="btn btn-sm btn-primary mx-2">
                    <i class="fas fa-search mr-1"></i>
                    {{ __('form.search') }}
                </button>
                <a class="btn btn-sm btn-dark mx-2" href="{{ route('transaction.index') }}">
                    <i class="fas fa-undo mr-1"></i>
                    {{ __('form.reset') }}
                </a>
            </div>
        </div>
    </div>

    @if(sizeof($transactions) > 0)
    <div class="card">
        <table class="table table-sm table-dark table-responsive-md table-hover">
            <thead>
                <tr>
                    <th>{{ __('transaction.date') }}</th>
                    <th></th>
                    <th class="text-center">{{ __('property.block') }}</th>
                    <th class="text-center">{{ __('property.floor') }}</th>
                    <th class="text-center">{{ __('property.flat') }}</th>
                    <th class="text-center">{{ __('property.room') }}</th>
                    <th class="text-center">{{ __('property.size') }}</th>
                    <th>{{ __('transaction.transaction_type') }}</th>
                    <th>{{ __('transaction.amount') }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $transaction)
                    @foreach($transaction->package->properties as $count => $property)
                        @if($count == 0)
                <tr>
                    <td>{{ $transaction->transaction_date }}</td>
                    <td>{{ $property->estate->name }}</td>
                    <td class="text-center">{{ $property->block??'-' }}</td>
                    <td class="text-center">{{ $property->floor??'-' }}</td>
                    <td class="text-center">{{ $property->flat }}</td>
                    <td class="text-center">{{ $property->room }}</td>
                    <td class="text-center">{{ $property->gross_size }} {!! __('property.ft_square') !!}</td>
                    <td class="text-center">{{ $transaction->transactionType->name }}</td>
                    <td class="text-right">{{ $transaction->transaction_amount }}</td>
                    <td class="text-center">
                        <a class="btn btn-sm btn-info" href="{{ route('transaction.show', $transaction) }}">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                        @else
                <tr>
                    <td>&nbsp;</td>
                    <td>{{ $property->estate->name }}</td>
                    <td class="text-center">{{ $property->block??'-' }}</td>
                    <td class="text-center">{{ $property->floor??'-' }}</td>
                    <td class="text-center">{{ $property->flat }}</td>
                    <td class="text-center">{{ $property->room }}</td>
                    <td class="text-center">{{ $property->gross_size }} {!! __('property.ft_square') !!}</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                        @endif
                    @endforeach
                @endforeach
            </tbody>
        </table>
        <div class="container">
            {{ $transactions->links() }}
        </div>
    </div>
    @endif
</form>
@endsection