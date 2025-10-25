@extends('tenant.layouts.app')

@section('content')
    <tenant-staff-index :type-user="{{ json_encode(auth()->user()->type) }}">
    </tenant-staff-index>
@endsection
