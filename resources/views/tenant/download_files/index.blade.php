@extends('tenant.layouts.app')

@section('content')
    <tenant-download-files-index :type-user="{{ json_encode(auth()->user()->type) }}">
    </tenant-download-files-index>
@endsection
