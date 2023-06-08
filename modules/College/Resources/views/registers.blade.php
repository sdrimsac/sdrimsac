@extends('tenant.layouts.app')
@section('content')
    <college-registers :configuration="{{ $configuration }}"></college-registers>
@endsection
