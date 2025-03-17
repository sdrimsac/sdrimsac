@extends('tenant.layouts.worker')
@section('content')
    <estilista-time-worker :configuration="{{ $configuration }}" :establishment="{{ $establishment }}"
        :user="{{ json_encode(Auth::user()) }}">
    </estilista-time-worker>
@endsection
