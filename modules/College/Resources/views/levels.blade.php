@extends('tenant.layouts.app')
@section('content')
    <college-levels :configuration="{{ $configuration }}"></college-levels>
@endsection
