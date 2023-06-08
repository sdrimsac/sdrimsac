@extends('tenant.layouts.app')

@section('content')

    <tenant-establishments-index
    :company ="{{json_enconde($company)}}"
    :type-user="{{ json_encode(auth()->user()->type) }}"></tenant-establishments-index>

@endsection