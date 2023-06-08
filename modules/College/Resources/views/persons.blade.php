@extends('tenant.layouts.app')
@section('content')
    <college-persons :configuration="{{ $configuration }}"></college-persons>
@endsection
