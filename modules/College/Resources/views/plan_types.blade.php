@extends('tenant.layouts.app')
@section('content')
    <college-plan-types :configuration="{{ $configuration }}"></college-plan-types>
@endsection
