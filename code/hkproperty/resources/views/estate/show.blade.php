@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="font-weight-bold">{{ __('form.infomation') }}</h3>
            <a href="{{ route('estate.edit', ['estate' => $estate->id]) }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-edit"></i>
            </a>
        </div>
        @include('estate.form', ['disabled' => 'disabled'])
    </div>

    <div class="card mt-2">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="font-weight-bold">{{ __('estate.property') }}</h3>
            <a href="{{ route('property.create', ['estate' => $estate]) }}" class="btn btn-sm btn-dark">
                <i class="fas fa-plus"></i>
            </a>
        </div>
        <table class="table table-dark table-striped m-0">
            <thead>
            <tr>
                <td class="text-center">{{ __('property.block') }}</td>
                <td class="text-center">{{ __('property.floor') }}</td>
                <td class="text-center">{{ __('property.flat') }}</td>
                <td class="text-center">{{ __('property.gross_size') }}</td>
                <td class="text-center">{{ __('property.room') }}</td>
                <td class="text-center">{{ __('property.washroom') }}</td>
                <td class="text-center">{{ __('property.store_room') }}</td>
                <td class="text-center">{{ __('property.roof') }}</td>
                <td class="text-center">{{ __('property.balcony') }}</td>
                <td class="text-center">{{ __('property.open_kitchen') }}</td>
                <td></td>
            </tr>
            </thead>
            <tbody>
            @foreach($estate->properties as $property)
            <tr>
                <td class="text-center">{{ $property->block??'-' }}</td>
                <td class="text-center">{{ $property->floor??'-' }}</td>
                <td class="text-center">{{ $property->flat??'-' }}</td>
                <td class="text-center">{{ $property->gross_size }}</td>
                <td class="text-center">{{ $property->room??'-' }}</td>
                <td class="text-center">{{ $property->washroom??'-' }}</td>
                <td class="text-center">{{ $property->store_room??'-' }}</td>
                <td class="text-center">{{ $property->root_size??'-' }}</td>
                <td class="text-center">{{ $property->balcony_size??'-' }}</td>
                <td class="text-center">{{ $property->open_kitchen == '1'?'<i class="fas fa-check"></i>':'-' }}</td>
                <td class="text-center">
                    <a class="btn btn-sm btn-secondary" href="{{ route('property.show', [$estate, $property]) }}">
                        <i class="fas fa-info-circle"></i>
                    </a>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        <div class="card-footer">

        </div>
    </div>
</div>
@endsection