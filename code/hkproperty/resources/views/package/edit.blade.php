@extends('layouts.app')

@section('content')
<form action="{{ route('package.update', [$package]) }}" method="POST">
    @csrf
    @method('PATCH')
    <package 
        data-state="EDIT"
        data-package="{{ $package }}"
        data-transaction-types="{{ $transactionTypes }}"
    />
</form>
@endsection