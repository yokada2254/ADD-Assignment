@extends('layouts.app')

@section('content')
<form class="container" action="{{ route('customer.index') }}" method="GET">
    @csrf
    <h2 class="font-weight-bold">{{ __('customer.title') }}</h2>
    <div class="card">

        <div class="card-header">
            <div class="d-flex align-items-center justify-content-between">
                <h5 class="font-weight-bold">{{ __('form.search') }}</h5>
                <a class="btn btn-sm btn-dark" href="{{ route('customer.create') }}">
                    <i class="fas fa-plus mr-2"></i>{{ __('form.add') }}
                </a>
            </div>
        </div>

        <div class="card-body">
            <div class="form-row my-1">
                <div class="col-lg-2">
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <div class="input-group-text">{{ __('common.status') }}</div>
                        </div>
                        <select class="form-control" name="customer_status_id">
                            <option value="">{{ __('form.all') }}</option>
                            @foreach($customer_statuses as $status)
                            <option value="{{ $status->id }}" {{ old('customer_status_id') == $status->id?'selected':'' }}>{{ $status->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <div class="input-group-text">{{ __('people.name') }}</div>
                        </div>
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                    </div>
                </div>
                

                <div class="col-lg-3">
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <div class="input-group-text">{{ __('people.contact') }}</div>
                        </div>
                        <input type="text" class="form-control" name="contact" value="{{ old('contact') }}">
                    </div>
                </div>

            </div>

            <div class="form-row">
                <div class="col-12">
                    <h5>{{ __('prefer_offer.prefer') }}</h5>
                </div>
            </div>

            <property-fields></property-fields>
        </div>

        <div class="card-footer">
            <div class="form-row d-flex justify-content-center my-2">
                <button class="btn btn-sm btn-dark mx-2" type="submit" name="submit">
                    <i class="fas fa-search mr-2"></i>
                    {{ __('form.search') }}
                </button>
                <a class="btn btn-sm btn-secondary mx-2" href="{{ route('customer.index') }}">
                    <i class="fas fa-undo mr-2"></i>
                    {{ __('form.reset') }}
                </a>
            </div> 
        </div>
    </div>

    <div class="form-row mt-2">
        @foreach($customers as $customer)
        <div class="col-12 my-1">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="font-weight-bold">{{ $customer->people->implode('name', ', ') }}</h5>
                        <a class="btn btn-sm btn-success" href="{{ route('customer.show', [$customer]) }}">
                            <i class="fas fa-info-circle"></i>
                        </a>
                    </div>
                </div>
                <prefer data-items="{{ json_encode($customer->prefers) }}" data-disabled="true" />
            </div>
        </div>
        @endforeach
    </div>

    <div class="form-row">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-center">
                {{ $customers->links() }}
            </div>
        </div>
    </div>
</form>
@endsection