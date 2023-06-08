@extends('tenant.layouts.app')

@section('content')
    <tenant-client-zone-index :type-user="{{ json_encode(Auth::user()->type) }}">
    </tenant-client-zone-index>
@endsection
