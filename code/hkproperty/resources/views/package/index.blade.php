@extends('layouts.app')

@section('style')
<style>
.pagination{
    display: inline-flex !important;
}
</style>
@endsection

@section('content')
<form action="{{ route('package.index') }}" method="GET">
    @csrf
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center justify-content-between">
                    <h3 class="font-weight-bold">{{ __('package.title') }}</h3>
                    <a class="btn btn-dark btn-sm" href="{{ route('package.create') }}">
                        <i class="fas fa-plus mr-2"></i>{{ __('form.add') }}
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="col-lg-2 col-sm-6">
                        <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                                <div class="input-group-text">{{ __('package.status') }}</div>
                            </div>
                            <select class="form-control form-control-sm" name="status_id">
                                <option value="">{{ __('form.all') }}</option>
                                @foreach($package_statuses as $status)
                                <option class="{{ ColorForStatus($status->id) }}" value="{{ $status->id }}" {{ old('status_id', '1') == $status->id?'selected="selected"':'' }}>{{ $status->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-6">
                        <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                                <div class="input-group-text">{{ __('transaction.transaction_type') }}</div>
                            </div>
                            <select class="form-control form-control-sm" name="transaction_type_id">
                                <option value="">{{ __('form.all') }}</option>
                                @foreach($transaction_types as $type)
                                <option value="{{ $type->id }}" {{ old('transaction_type_id', '') == $type->id?'selected="selected"':'' }}>{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    

                    <div class="col-lg-3 col-sm-12">
                        <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                                <div class="input-group-text">{{ __('prefer_offer.price') }}</div>
                            </div>
                            <input type="text" class="form-control" name="price_fm" value="{{ old('price_fm') }}">
                            <div class="input-group-prepend input-group-append">
                                <div class="input-group-text">{{ __('form.to') }}</div>
                            </div>
                            <input type="text" class="form-control" name="price_to" value="{{ old('price_to') }}">
                        </div>
                    </div>
                </div>

                <property-fields 
                    data-area="{{ old('area_id', '') }}"
                    data-district="{{ old('district_id', '') }}"
                    data-estate-type="{{ old('estate_type_id', '') }}"
                    data-estates="{{ json_encode($estates) }}"
                    data-block="{{ old('block', '') }}"
                    data-floor="{{ old('floor', '') }}"
                    data-flat="{{ old('flat', '') }}"
                    data-room="{{ old('room', '') }}"
                    data-gross-size-fm="{{ old('gross_size_fm', '') }}"
                    data-gross-size-to="{{ old('gross_size_to', '') }}"
                ></property-fields>
                
                <div class="form-row d-flex justify-content-center my-2">
                    <button class="btn btn-sm btn-dark mx-2" type="submit" name="submit">
                        <i class="fas fa-search mr-2"></i>
                        {{ __('form.search') }}
                    </button>
                    <a class="btn btn-sm btn-light mx-2" href="{{ route('package.index') }}">
                        <i class="fas fa-undo mr-2"></i>
                        {{ __('form.reset') }}
                    </a>
                </div>
            </div>
            @if(sizeof($packages) > 0)
            <div class="card m-1 text-white bg-secondary">
                <div class="card-body p-1">
                    <div class="form-row">
                        <div class="col-4">
                            <div class="form-row">
                                <div class="col-7">{{ __('prefer.transaction_type') }}</div>
                                <div class="col-5">{{ __('prefer.price') }}</div>
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="form-row">
                                <div class="col-4">{{ __('estate.title') }}</div>
                                <div class="col-2 text-center">{{ __('property.block') }}</div>
                                <div class="col-2 text-center">{{ __('property.floor') }}</div>
                                <div class="col-1 text-center">{{ __('property.flat') }}</div>
                                <div class="col-1 text-center">{{ __('property.room') }}</div>
                                <div class="col-2 text-right">{{ __('property.gross_size') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @forelse($packages AS $package)
            <a class="card m-1 text-reset text-decoration-none" href="{{ route('package.show', [$package]) }}">
                <div class="card-body p-1">
                    <div class="form-row">
                        <div class="col-4">
                            <div class="form-row">
                                @foreach($package->offers as $offer)
                                <div class="col-7 my-1">{{ $offer->transactionType->name }}</div>
                                <div class="col-5 my-1">
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">{{ $offer->transactionType->id == 3?'$':__('common.ten_thousand') }}</div>
                                        </div>
                                        <input class="form-control text-right {{ ColorForStatus($package->status_id) }}" value="{{ $offer->price }}" reaonly>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-8">
                            @foreach($package->properties as $property)
                            <div class="form-row">
                                <div class="col-4 my-1">{{ $property->estate->name }}</div>
                                <div class="col-2 my-1 text-center">{{ $property->block }}</div>
                                <div class="col-2 my-1 text-center">{{ $property->floor }}</div>
                                <div class="col-1 my-1 text-center">{{ $property->flat }}</div>
                                <div class="col-1 my-1 text-center">{{ $property->room }}</div>
                                <div class="col-2 my-1 text-right">{{ $property->gross_size }} {!! __('property.ft_square') !!}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </a>
            @empty
            <div class="alert alert-danger" role="alert">
                <h3 class="font-weight-bold text-center">{{ __('common.norecord') }}</h3>
            </div>
            @endforelse
            <div class="card-footer text-center">{{ $packages->appends(Request::except('page'))->links() }}</div>
        </div>
    </div>
</form>
@endsection