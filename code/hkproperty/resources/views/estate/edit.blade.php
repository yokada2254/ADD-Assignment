@extends('layouts.app')

@section('content')
<div class="container">
    <form method="POST" action="{{ route('estate.update', ['estate' => $estate]) }}">
        @csrf
        @method('patch')
        <div class="card">
            <div class="card-header">{{ __('estate.title') }}</div>
            @include('estate.form')
            
            @foreach ($errors->all() as $error)
            <div class="alert alert-danger">{{ $error }}</div>
            @endforeach
            
            @include('common.form-btns', ['url' => route('estate.show', [$estate])])
        </div>
    </form>
</div>
@endsection