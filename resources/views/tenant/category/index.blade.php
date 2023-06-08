@extends('tenant.layouts.app')
@section('content')
    <tenant-categories-index
    :configuration="{{$configuration}}"
    ></tenant-categories-index>
@endsection
