@extends('layouts.app')

@section('content')
<package 
    data-state="SHOW"
    data-package="{{ $package }}" 
    data-transaction-types="{{ $transactionTypes }}" 
/>
@endsection