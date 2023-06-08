@extends('tenant.layouts.app')

@section('content')

    <tenant-users-index :type-user="{{ json_encode(auth()->user()->type) }}" :type="{{ json_encode($type) }}"></tenant-users-index>

@endsection