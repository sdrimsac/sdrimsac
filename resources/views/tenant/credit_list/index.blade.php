@extends('tenant.layouts.app')

@section('content')
    <tenant-credit-list-index :type-user="{{ json_encode(auth()->user()->type) }}">
    </tenant-credit-list-index>
@endsection
