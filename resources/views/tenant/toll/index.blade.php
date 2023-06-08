@extends('tenant.layouts.worker')
@section('content')
    <toll-index :user="{{ json_encode(auth()->user()) }}" :configuration="{{ json_encode($configuration) }}"></toll-index>
@endsection
