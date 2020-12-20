@extends('layouts.app')

@section('content')
<div class="container">
    <form method="POST" action="{{ route('estate.store') }}">
        @csrf
        <div class="card">
            <div class="card-header">{{ __('estate.title') }}</div>
            @include('estate.form')
            
            @foreach($errors->all() as $error)
            <span class="invalid-feedback" role="alert">
                <strong>{{ $error }}</strong>
            </span>
            @endforeach
            
            @include('common.form-btns', ['url' => route('estate.index')])
        </div>
    </form>
</div>
@endsection