@extends('layouts.app')

@section('content')
<div class="container">
    <form method="POST" action="{{ route('people.contact.update', ['people' => $people, 'contact' => $contact]) }}">
        @csrf
        @method('PATCH')
        <div class="row justify-content-center">
            <div class="col-lg-12 col-md-6">
                <div class="card">
                    <div class="card-header">{{ __('people.people') }}</div>
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