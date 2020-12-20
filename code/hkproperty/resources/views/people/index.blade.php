@extends('layouts.app')

@section('style')
<style>
.pagination{
    display: inline-flex !important;
}
</style>
@endsection

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="font-weight-bold">{{ __('people.title') }}</h3>
            <a class="btn btn-sm btn-dark" href="{{ route('people.create') }}">
                <i class="fas fa-plus mr-2"></i>{{ __('form.add') }}
            </a>
        </div>
        
        <form class="card-body" action="{{ route('people.index') }}">
            @csrf
            <div class="form-row">
                <div class="col-md-6">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">{{ __('people.name') }}</div>
                        </div>
                        <input 
                            class="form-control" type="text" 
                            name="name" value="{{ old('name') }}" 
                        />
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">{{ __('people.contact') }}</div>
                        </div>
                        <input 
                            class="form-control" type="text" 
                            name="contact" value="{{ old('contact') }}" 
                        />
                    </div>
                </div>
            </div>
            <div class="form-row d-flex justify-content-center my-2">
                <button class="btn btn-sm btn-dark mx-2" type="submit" name="submit">
                    <i class="fas fa-search mr-2"></i>
                    {{ __('form.search') }}
                </button>
                <a class="btn btn-sm btn-light mx-2" href="{{ route('people.index') }}">
                    <i class="fas fa-undo mr-2"></i>
                    {{ __('form.reset') }}
                </a>
            </div>
        </form>
        
        <div class="table-responsive">
            <table class="table table-sm table-striped table-dark table-hover">
                <thead>
                <tr>
                    <th>{{ __('people.name') }}</th>
                    <th>{{ __('form.created_by') }}</th>
                    <th>{{ __('form.created_at') }}</th>
                    <th>{{ __('form.updated_by') }}</th>
                    <th>{{ __('form.updated_at') }}</th>
                    <th>&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                @foreach($people as $person)
                <tr>
                    <td>{{ $person->name }}</td>
                    <td>{{ @$person->createdBy->name }}</td>
                    <td>{{ $person->created_at }}</td>
                    <td>{{ @$person->updatedBy->name }}</td>
                    <td>{{ $person->updated_at }}</td>
                    <td>
                        <a class="btn btn-sm btn-secondary" href="{{ route('people.show', ['people' => $person]) }}">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="card-footer text-center">
            {{ $people->links() }}
        </div>
    </div>
</div>
@endsection