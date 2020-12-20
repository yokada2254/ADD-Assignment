@extends('layouts.app')

@section('content')
<div class="container">
    <form method="POST" action="{{ route('property.store', ['estate' => $estate]) }}">
        @csrf
        <div class="card">
            <div class="card-header"><h3 class="font-weight-bold">{{ __('property.title') }}</h3></div>
            <div class="card-body">@include('property.fields')</div>
            @include('common.form-btns')
        </div>
        
        @if($errors->any())
        <div class="container py-2">
            @foreach($errors->all() as $error)
                @include('common.error')
            @endforeach
        </div>
        @endif
    </form>
</div>
@endsection