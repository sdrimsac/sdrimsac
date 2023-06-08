@extends('tenant.layouts.app')
@section('content')
    <tenant-restaurant-pos :cash_id="{{ json_encode($cash_id) }}" :company="{{ json_encode($company) }}"
        :configuration="{{ json_encode($configuration) }}" :establishments="{{ json_encode($establishments) }}"
        :desarrollador="{{ json_encode($desarrollador) }}">
    </tenant-restaurant-pos>
@endsection
