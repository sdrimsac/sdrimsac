@extends('tenant.layouts.app')
@section('content')
    <college-classrooms :configuration="{{ $configuration }}"></college-classrooms>
@endsection
