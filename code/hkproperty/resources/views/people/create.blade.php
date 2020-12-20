@extends('layouts.app')

@section('content')
<div class="container">
    <form method="POST" action="{{ route('people.store') }}">
        @csrf
        @method('PATCH')
        <div class="row justify-content-center">
            <div class="col-lg-12 col-md-6">
                <div class="card">
                    <div class="card-header">{{ __('people.people') }}</div>
                    <div class="card-body">@include('people.fields')</div>
                </div>
                @include('common.form-btns', ['url' => route('people.index')])
            </div>
        </div>
    </form>
</div>
@endsection