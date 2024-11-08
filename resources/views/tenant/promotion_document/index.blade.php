@extends('tenant.layouts.app')

@section('content')
    <tenant-promotions-document-index
    :type-user="{{json_encode(Auth::user()->type)}}"
    :configuration="{{json_encode($configuration)}}"
    ></tenant-promotions-document-index>
@endsection
