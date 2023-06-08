@extends('tenant.layouts.app')

@section('content')
    <tenant-dispatches-index :configuration="{{ $configuration }}" :type-user="{{ json_encode(auth()->user()->type) }}">
    </tenant-dispatches-index>
@endsection
