@extends('tenant.layouts.restaurant')
@section('content')
    <restobar-worker-dashboard :configuration="{{ $configuration }}" :areas="{{ $areas }}"
        :company="{{ $company }}"
        :tables_area="{{ $tables_area }}"
        :categories="{{ $categories }}" 
        :status_table="{{ $status_table }}"
        :user="{{ json_encode(Auth::user()) }}">
    </restobar-worker-dashboard>
@endsection
