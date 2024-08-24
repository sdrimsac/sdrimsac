@extends('tenant.layouts.app')

@section('content')
    <tenant-receta-index :type-user="{{json_encode(Auth::user()->type)}}"></tenant-receta-index>
@endsection