@extends('layouts.app')

@section('content')
<form action="{{ route('package.store') }}" method="POST">
    @csrf
    <package data-transaction-types="{{ $transactionTypes }}" />
</form>
@endsection