@extends('layouts.app')

@section('content')
<div class="container">
    @foreach($errors->all() as $error)
    {{ $error }}
    @endforeach
    <form method="POST" action="{{ route('transaction.store') }}">
        @csrf
        <transaction data-transaction="{{ json_encode($transaction) }}"></transaction>
    </form>
</div>
@endsection