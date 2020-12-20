@extends('layouts.app')

@section('content')
<div class="container">
    
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="font-weight-bold">{{ __('people.title') }}</h3>
                    <a class="btn btn-sm btn-dark" href="{{ route('people.edit', ['people' => $people]) }}"><i class="fas fa-edit"></i>{{ __('form.edit') }}</a>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-4 col-form-label text-md-right">{{ __('Name') }}</label>
                        <div class="col-6 d-flex align-items-center">{{ $people->name }}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-4 col-form-label text-md-right">{{ __('Gender') }}</label>
                        <div class="col-6 d-flex align-items-center">{{ $people->gender }}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-4 col-form-label text-md-right">{{ __('HKID') }}</label>
                        <div class="col-6 d-flex align-items-center">{{ $people->hkid }}</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-6 col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="font-weight-bold">{{ __('people.contact') }}</h3>
                    <a class="btn btn-sm btn-dark" href="{{ route('people.contact.create', ['people' => $people]) }}"><i class="fas fa-plus"></i>{{ __('form.add') }}</a>
                </div>
                <div class="card-body">
                    @foreach($people->contacts as $contact)
                    <div class="row py-1">
                        <div class="col-3">{{ $contact->contactType->name }}</div>
                        <div class="col-6">{{ $contact->data }}</div>
                        <div class="col-3 d-flex align-items-center justify-content-center">
                            <div class="btn-group">
                                <a class="btn btn-sm btn-success" href="{{ route('people.contact.edit', ['people' => $people, 'contact' => $contact]) }}"><i class="fas fa-edit"></i></a>
                                <a class="btn btn-sm btn-danger" href="{{ route('people.contact.destroy', ['people' => $people, 'contact' => $contact]) }}"><i class="fas fa-trash"></i></a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="row d-flex align-items-center justify-content-center my-2">
            <a 
                class="btn btn-sm btn-success" 
                href="{{ route('customer.create', ['people' => $people]) }}"
            >
                {{ __('people.add_customer') }}
            </a>
        </div>

    </div>

</div>
@endsection