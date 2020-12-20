@extends('layouts.app')

@section('content')
<form class="container" method="POST" action="{{ route('customer.store') }}">
    @csrf
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="font-weight-bold">{{ __('customer.title') }}</h2>
                <div class="col-auto">
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <div class="input-group-text">{{ __('common.status') }}</div>
                        </div>
                        <select class="form-control" type="text" name="status_id">
                        @foreach($customer_statuses AS $status)
                            <option 
                                value="{{ $status->id }}" 
                                {{old('status_id') == $status->id?'selected="selected"':''}}>
                                {{$status->name}}
                            </option>
                        @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            @foreach ($errors->all() as $error)
            <div class="alert alert-danger">{{ $error }}</div>
            @endforeach
            <div class="row align-items-start">
                <div class="card bg-primary col-xl-4 col-md-12">
                    <people data-items="{{ json_encode($people) }}" />
                </div>
                
                <div class="card bg-secondary col-xl-8 col-md-12">
                    <prefer data-items="{{ json_encode($prefer) }}" />
                </div>
            </div>
        </div>
        @include('common.form-btns')
    </div>
</form>
@endsection