@extends('tenant.layouts.app')

@section('content')

    <tenant-registers-index
    :user_type="{{ json_encode($user_type)}}"
    :configuration="{{json_encode($configuration)}}"
    ></tenant-registers-index>

@endsection