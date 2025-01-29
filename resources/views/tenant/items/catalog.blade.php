@extends('tenant.layouts.app')

@section('content')
<tenant-catalog-index :type-user="{{json_encode(Auth::user()->type)}}" :user="{{json_encode(Auth::user())}}"></tenant-catalog-index>
@endsection