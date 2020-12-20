@extends('layouts.app')

@section('content')
<form action="{{ route('user.update', [$user]) }}" class="container">
    @method('PATCH')
    <div class="card">
        <div class="card-header">
            <h5 class="font-weight-bold">{{ __('user.title') }} - {{ $user->name }}</h5>
        </div>
        <div class="card-body">
            <div class="form-row">
                <div class="form-group col-4">
                    <label for="">{{ __('user.reset_password') }}</label>
                    <input 
                        class="form-control" type="password" 
                        placeholder="{{ __('user.alphanumeric') }}" 
                        maxlength="20"
                    />
                </div>
                <div class="form-group col-4">
                    <label>{{ __('role.title') }}</label>
                    <select class="form-control" name="role_id">
                        @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ $user->role->id == $role->id?'selected':'' }}>{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-4">
                    <label>{{ __('common.branch') }}</label>
                    <select class="form-control" name="role_id">
                        @foreach($branches as $branch)
                        <option value="{{ $branch->id }}" {{ $user->branch->id == $branch->id?'selected':'' }}>{{ $branch->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        @include('common.form-btns')
    </div>
</form>
@endsection