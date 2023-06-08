@extends('tenant.layouts.app')

@section('content')
    <cash-index-closed
    :configuration="{{json_encode($configuration)}}"
    :users="{{json_encode($users)}}"
    ></cash-index-closed>
           
@endsection

 