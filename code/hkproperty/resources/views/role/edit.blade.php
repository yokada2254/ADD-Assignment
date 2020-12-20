@extends('layouts.app')

@section('content')
<form class="container" action="{{ route('role.update', [$role]) }}" method="POST">
    @csrf
    @method('PATCH')
    <div class="d-flex align-items-center justify-content-between">
        <h2 class="font-weight-bold">{{ __('role.title') }} - {{ $role->name }}</h2>
        <div></div>
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