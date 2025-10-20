@extends('tenant.layouts.worker')
@section('content')
    <restobar-kitchen-dashboard :areas="{{ $areas }}" :area_id="{{ $area_id }}" :foods="{{ $foods }}"
        :configuration="{{ $configuration }}" :categories="{{ $categories }}" :status_table="{{ $status_table }}"
        :user="{{ json_encode(Auth::user()) }}">
    </restobar-kitchen-dashboard>
@endsection
