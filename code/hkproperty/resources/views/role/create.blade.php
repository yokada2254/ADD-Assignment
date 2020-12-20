@extends('layouts.app')

@section('content')
<form class="container" action="{{ route('role.store') }}">
    @method('PATCH')
    <div class="d-flex align-items-center justify-content-between">
        <h2 class="font-weight-bold">{{ __('role.title') }} - {{ $role->name }}</h2>
        <a href="{{  route('role.edit', [$role]) }}" class="btn btn-dark">
            <i class="fas fa-edit"></i>
        </a>
    </div>
    
    @include('role.fields')

    <div class="form-row">
        <div class="col-6">
            @include('role.privileges')
        </div>
        <div class="col-6">
            @include('role.users')
        </div>
    </div>
    @include('common.form-btns')
</div>
@endsection