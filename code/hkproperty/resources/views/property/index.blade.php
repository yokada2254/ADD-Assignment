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
        <div class="card-header">
            <h3 class="font-weight-bold">{{ __('property.title') }}</h3>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('property.index') }}">
                @csrf

                <owner data-items="{{ json_encode($owners) }}"></owner>

                <property-fields
                    data-area="{{ request()->input('area_id') }}"
                    data-district="{{ request()->input('district_id') }}"
                    data-estate-type="{{ request()->input('estate_type_id') }}"
                    data-estates="{{ json_encode($estates) }}"
                    data-block="{{ request()->input('block') }}"
                    data-floor="{{ request()->input('floor') }}"
                    data-flat="{{ request()->input('flat') }}"
                    data-room="{{ request()->input('room') }}"
                    data-gross-size-fm="{{ request()->input('gross_size_fm') }}"
                    data-gross-size-to="{{ request()->input('gross_size_to') }}"
                ></property-fields>
                
                <div class="form-row d-flex justify-content-center my-2">
                    <button class="btn btn-sm btn-dark mx-2" type="submit" name="submit">
                        <i class="fas fa-search mr-2"></i>
                        {{ __('form.search') }}
                    </button>
                    <a class="btn btn-sm btn-light mx-2" href="{{ route('property.index') }}">
                        <i class="fas fa-undo mr-2"></i>
                        {{ __('form.reset') }}
                    </a>
                </div>
            </form>
        </div>

        <table class="table table-dark table-sm-responsive table-sm">
            <thead>
                <th class="text-center">{{ __('estate.title') }}</th>
                <th class="text-center">{{ __('property.block') }}</th>
                <th class="text-center">{{ __('property.floor') }}</th>
                <th class="text-center">{{ __('property.flat') }}</th>
                <th class="text-right">{{ __('property.size') }}</th>
                <th class="text-center">{{ __('property.room') }}</th>
                <th class="text-center">{{ __('property.store_room') }}</th>
                <th class="text-center">{{ __('property.open_kitchen') }}</th>
                <th class="text-right">{{ __('property.roof') }}</th>
                <th></th>
            </thead>
            <tbody>
                @foreach($properties as $property)
                <tr>
                    <td>{{ $property->estate->name }}</td>
                    <td class="text-center">{{ $property->block }}</td>
                    <td class="text-center">{{ $property->floor }}</td>
                    <td class="text-center">{{ $property->flat }}</td>
                    <td class="text-right">{{ $property->gross_size }} {!! __('property.ft_square') !!}</td>
                    <td class="text-center">{{ $property->room }}</td>
                    <td class="text-center">{{ $property->store_room }}</td>
                    <td class="text-center">{{ $property->open_kitchen }}</td>
                    <td class="text-right">{{ $property->roof_size }} {!! __('property.ft_square') !!}</td>
                    <td class="text-center">
                        <a 
                            href="{{ route('property.show', ['estate' => $property->estate, 'property' => $property]) }}" 
                            class="btn btn-sm btn-secondary"
                        >
                            <i class="fas fa-info-circle"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="card-footer text-center">
            {{ $properties->appends(request()->except('page'))->links() }}
        </div>
    </div>
</div>
@endsection