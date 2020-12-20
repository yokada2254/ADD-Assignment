@extends('layouts.app')

@section('content')
<div class="container">
    <transaction 
        data-transaction="{{ json_encode($transaction) }}"
        data-disabled="true"
    >
    </transaction>
</div>
@endsection