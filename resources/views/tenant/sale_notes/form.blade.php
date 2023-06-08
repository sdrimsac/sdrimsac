@extends('tenant.layouts.app')

@section('content')

    <tenant-sale-notes-form :id="{{ json_encode($id) }}" 
                            :configuration="{{json_encode($configuration)}}"
                            :type-user="{{json_encode(Auth::user()->type)}}" :configuration="{{ $configuration }}"></tenant-sale-notes-form>

@endsection
