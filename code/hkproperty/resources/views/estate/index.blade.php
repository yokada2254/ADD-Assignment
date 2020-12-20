@extends('layouts.app')

@section('content')
<form action="{{ route('estate.index') }}" class="container">
    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center justify-content-between">
                <h5 class="font-weight-bold">{{ __('estate.title') }}</h5>
                <a href="{{ route('estate.create') }}" class="btn btn-sm btn-dark">
                    <i class="fas fa-plus mr-2"></i>
                    {{ __('form.add') }}
                </a>
            </div>
        </div>
        <div class="card-body">
            <property-fields 
                data-fields="{{ json_encode(['area', 'district', 'estate_type', 'estate']) }}"
                data-area="{{ old('area_id') }}"
                data-district="{{ old('district_id') }}"
                data-estate-type="{{ old('estate_type_id') }}"
                data-estates="{{ json_encode($selectedEstates) }}"
            ></property-fields>
        </div>
        <div class="card-footer">
            <div class="d-flex align-items-center justify-content-center">
                <button class="btn btn-primary btn-sm mx-1" type="submit" name="submit">
                    <i class="fas fa-search mr-2"></i>
                    {{ __('form.search') }}
                </button>
    
                <a class="btn btn-sm btn-dark mx-1" href="{{ route('estate.index') }}">
                    <i class="fas fa-undo"></i>
                    {{ __('form.reset') }}
                </a>
            </div>
        </div>
    </div>

    <div class="card my-2">
        <div class="card-header"></div>
        <table class="table-sm table-striped table-dark table-responsive-md">
            <thead>
            <tr>
                <th>{{ __('estate.type') }}</th>
                <th>{{ __('estate.area') }}</th>
                <th>{{ __('estate.district') }}</th>
                <th>{{ __('estate.name') }}</th>
                <th class="text-right">{{ __('estate.unit_count') }}</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($estates as $estate)
            <tr>
                <td>{{ @$estate->estateType->name }}</td>
                <td>{{ $estate->district->area->name }}</td>
                <td>{{ $estate->district->name }}</td>
                <td>{{ $estate->name }}</td>
                <td class="text-right">{{ $estate->properties->count() }}</td>
                <td class="text-center">
                    <a class="btn btn-sm btn-secondary" href="{{ route('estate.show', [$estate]) }}">
                        <i class="fas fa-info-circle"></i>
                    </a>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        <div class="card-footer">
            <div class="d-flex align-items-center justify-content-center">
                {{ $estates->appends(request()->except('page'))->links() }}
            </div>
        </div>
    </div>
</form>
@endsection