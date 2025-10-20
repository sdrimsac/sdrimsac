@extends('tenant.layouts.app')


@section('content')
    <tenant-restobar-workers
    :configuration="{{ $configuration }}"   
    :establishments="{{ $establishments }}"
    :type-user='@json(Auth::user()->type)' 
    :user='@json(Auth::user())'
    ></tenant-restobar-workers>
@endsection
