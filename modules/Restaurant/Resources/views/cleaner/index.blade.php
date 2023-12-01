@extends('tenant.layouts.worker')
@section('content')
    <worker-cleaner 
    :configuration="{{ $configuration }}" 
    :establishment="{{ $establishment }}" 
        :user="{{ json_encode(Auth::user()) }}">
    </worker-cleaner>
@endsection
