@extends('layouts.app')

@section('content')
<form class="container" method="POST" action="{{ route('customer.update', [$customer]) }}">
    @csrf
    @method('PATCH')
    <div class="card">
        <div class="card-header">
            <div class="row justify-content-between align-items-center">
                <h2 class="col-auto font-weight-bold">{{ __('customer.title') }}</h2>
                <div class="col-auto">
                    <div class="row">
                        <div class="col-auto">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">{{ __('common.status') }}</div>
                                </div>
                                <select class="form-control" type="text" name="status_id">
                                @foreach($customer_statuses AS $status)
                                    <option 
                                        value="{{ $status->id }}" 
                                        {{old('status_id', $customer->status->id) == $status->id?'selected="selected"':''}}>
                                        {{$status->name}}
                                    </option>
                                @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="btn-group">
                                <button class="btn btn-sm btn-primary" type="submit">
                                    <i class="fas fa-save"></i>
                                </button>
                                <a class="btn btn-sm btn-danger" href="{{ route('customer.show', $customer) }}">
                                    <i class="fas fa-times"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row align-items-start">
                <div class="card bg-primary col-xl-4 col-md-12">
                    <people data-items="{{ json_encode($people) }}" />
                </div>
                
                <div class="card bg-secondary col-xl-8 col-md-12">
                    <prefer data-items="{{ json_encode($prefer) }}" />
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row d-flex justify-content-between">
                <p class="mx-1 my-0">
                    <strong>{{ __('common.created_by') }}</strong>
                    {{ $customer->createdBy->name }}
                    <strong>@</strong>
                    {{ $customer->created_at }}
                </p>
                <p class="mx-1 my-0">
                    <strong>{{ __('common.updated_by') }}</strong>
                    {{ $customer->updatedBy->name }}
                    <strong>@</strong>
                    {{ $customer->updated_at }}
                </p>
            </div>
        </div>
    </div>
</form>
@endsection