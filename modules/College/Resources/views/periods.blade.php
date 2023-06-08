@extends('tenant.layouts.app')
@section('content')
    <college-periods :configuration="{{ $configuration }}"></college-periods>
@endsection
