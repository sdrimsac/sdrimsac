@extends('tenant.layouts.app')
@section('content')
    <tenant-cash-transfer-index-report 
    :type-user="{{ json_encode(auth()->user()->type) }}"
    :user="{{ json_encode(auth()->user()) }}"
    :configuration="{{ json_encode($configuration) }}">
    </tenant-cash-transfer-index-report>
@endsection
