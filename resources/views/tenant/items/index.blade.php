@extends('tenant.layouts.app')

@section('content')
<tenant-items-index :type-user="{{json_encode(Auth::user()->type)}}" :user="{{json_encode(Auth::user())}}"></tenant-items-index>
@endsection
