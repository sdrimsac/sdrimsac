@extends('tenant.layouts.app')

@section('content')

    <tenant-persons-index 
    :is-arca="{{ json_encode($is_arca)}}"
    :type-user="{{json_encode(Auth::user()->type)}}" :type="{{ json_encode($type) }}"
                            ></tenant-persons-index>

@endsection