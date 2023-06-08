@extends('tenant.layouts.app')


@section('content')
    <tenant-restaurant-workers
    :establishments="{{ $establishments }}"
    ></tenant-restaurant-workers>
@endsection
