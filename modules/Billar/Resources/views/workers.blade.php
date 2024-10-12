@extends('tenant.layouts.app')


@section('content')
    <tenant-restaurant-workers
    :configuration="{{ $configuration }}"   
    :establishments="{{ $establishments }}"
    ></tenant-restaurant-workers>
@endsection
