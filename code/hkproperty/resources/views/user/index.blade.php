@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3 class="font-weight-bold">{{ __('user.title') }}</h3>
        </div>
        <table class="table table-dark table-stiped">
            <thead>
            <tr>
                <th>{{ __('user.id') }}</th>
                <th>{{ __('common.branch') }}</th>
                <th>{{ __('role.title') }}</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($userlist as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->branch->name }}</td>
                <td>{{ $user->role->name }}</td>
                <td class="text-center">
                    <a href="{{ route('user.edit', [$user]) }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-info"></i>
                    </a>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        <div class="card-footer"></div>
    </div>
</div>
@endsection