@extends('tenant.layouts.app')

@section('content')
    <tenant-ventas-index  :type-user="{{ json_encode(auth()->user()->type) }}"
        :configuration="{{ json_encode($configuration) }}"
        :company="{{ json_encode($company) }}"></tenant-ventas-index>
@endsection