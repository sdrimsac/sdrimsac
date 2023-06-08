@extends('tenant.layouts.app')
@section('content')
    <college-plans :configuration="{{ $configuration }}"></college-plans>
@endsection
