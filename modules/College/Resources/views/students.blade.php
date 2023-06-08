@extends('tenant.layouts.app')
@section('content')
    <college-students :configuration="{{ $configuration }}"></college-students>
@endsection
