@extends('tenant.layouts.worker')
@section('content')
    <worker-maintenance :configuration="{{ $configuration }}" :establishment="{{ $establishment }}"
        :user="{{ json_encode(Auth::user()) }}">
    </worker-maintenance>
@endsection
