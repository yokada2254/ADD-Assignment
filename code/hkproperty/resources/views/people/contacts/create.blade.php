@extends('layouts.app')

@section('content')
<div class="container">
    <form method="POST" action="{{ route('people.contact.store', ['people' => $people]) }}">
        @csrf
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('people.title') }}</div>
                    <div class="card-body">
                        @include('people.contacts.fields')
                    </div>
                    @include('common.form-btns', ['url' => route('people.show', ['people' => $people])])
                </div>
            </div>
        </div>
    </form>
</div>
@endsection