@extends('tenant.layouts.app')

@section('content')
    <tenant-foods-index :type-user="{{json_encode(Auth::user()->type)}}"></tenant-foods-index>
@endsection