@extends('tenant.layouts.app')

@section('content')
    <tenant-commercial-treatment-index :type-user="{{ json_encode(Auth::user()->type) }}">
    </tenant-commercial-treatment-index>
@endsection
