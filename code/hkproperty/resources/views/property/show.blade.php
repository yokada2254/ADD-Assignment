@extends('layouts.app')

@section('content')
<div class="container">
    <form method="POST" action="{{ route('property.update', ['estate' => $estate, 'property' => $property]) }}">
        @csrf
        @method('PATCH')
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="font-weight-bold">{{ __('property.title') }}</h5>
                    <a class="btn btn-sm btn-dark" href="{{ route('property.edit', [$estate, $property]) }}">
                        <i class="fas fa-edit"></i>
                    </a>
                </div>
            </div>
            <div class="card-body">@include('property.fields')</div>
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