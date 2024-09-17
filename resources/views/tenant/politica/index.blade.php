@extends('tenant.layouts.app')

@section('content')
<tenant-politica-index :type-user="{{json_encode(Auth::user()->type)}}" :user="{{json_encode(Auth::user())}}"></tenant-politica-index>
@endsection
