@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3 class="font-weight-bold">{{ __('common.branch') }}</h3>
        </div>
        <table class="table table-dark table-striped">
            <thead>
            <tr>
                <th>{{ __('common.branch') }}</th>
                <th>{{ __('branch.manager') }}</th>
                <th class="text-center">{{ __('branch.staff_count') }}</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($branches as $branch)
            <tr>
                <td>{{ $branch->name }}</td>
                <td>{{ $branch->managedBy->name }}</td>
                <td class="text-center">{{ $branch->staff->count() }}</td>
                <td class="text-center">
                    <a href="{{ route('branch.edit', [$branch]) }}" class="btn btn-secondary">
                        <i class="fas fa-info"></i>
                    </a>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        </div>
        <div class="card-footer"></div>
    </div>
</div>
@endsection('content')