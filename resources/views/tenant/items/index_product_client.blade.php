@extends('tenant.layouts.app')

@section('content')
<tenant-items-client :type-user="{{json_encode(Auth::user()->type)}}" :user="{{json_encode(Auth::user())}}"></tenant-items-client>
@endsection
