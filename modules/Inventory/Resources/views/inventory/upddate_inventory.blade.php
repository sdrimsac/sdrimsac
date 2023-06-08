@extends('tenant.layouts.app')

@section('content')
    <upddate-inventory-index :typeUser="{{ json_encode(auth()->user()->type) }}"></upddate-inventory-index>
@endsection
