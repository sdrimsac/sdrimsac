@extends('tenant.layouts.app')

@section('content')
    <items-stock :user="{{json_encode(Auth::user())}}"></items-stock>
@endsection
