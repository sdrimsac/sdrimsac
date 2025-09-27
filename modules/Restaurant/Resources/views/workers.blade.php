@extends('tenant.layouts.app')


@section('content')
    <tenant-restaurant-workers
    :configuration="{{ $configuration }}"   
    :establishments="{{ $establishments }}"
    :type-user='@json(Auth::user()->type)' 
    :user='@json(Auth::user())'
    ></tenant-restaurant-workers>
@endsection
