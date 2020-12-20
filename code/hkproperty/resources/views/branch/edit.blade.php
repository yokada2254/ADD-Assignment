@extends('layouts.app')

@section('content')
<form action="{{ route('branch.update', [$branch]) }}" class="container">
    <div class="card">
        <div class="card-header">
            <h3 class="font-weight-bold">{{ __('common.branch') }} - {{ $branch->name }}</h3>
        </div>
        <div class="card-body">
            <div class="form-row">
                <div class="form-group col-6">
                    <label>{{ __('branch.name') }}</label>
                    <input type="text" class="form-control" name="name" value="{{ old('name', $branch->name) }}">
                </div>
                <div class="form-group col-6">
                    <label>{{ __('branch.manager') }}</label>
                    <select name="manager_id" class="form-control">
                        @foreach($users as $user)
                            @if(is_null($user->manage))
                            <option value="{{ $user->id }}" {{ $branch->managedBy->id == $user->id?'selected':'' }}>{{ $user->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        @include('common.form-btns')
    </div>
</form>
@endsection