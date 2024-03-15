@extends('tenant.layouts.app')

@section('content')
    <tenant-principal-categories-index :type-user="{{ json_encode(Auth::user()->type) }}">
    </tenant-principal-categories-index>
@endsection
