@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">{{ __('role.title') }}</div>
        <div class="card-body">
        @foreach($roles as $role) 
        <a href="{{ route('role.show', [$role]) }}" class="btn btn-dark">
            {{ $role->name }} <span class="badge badge-light">{{ $role->users->count() }}</span>
        </a>
        @endforeach
        </div>
        <div class="card-footer"></div>
    </div>
</div>
@endsection