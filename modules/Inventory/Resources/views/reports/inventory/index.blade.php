@extends('tenant.layouts.app')
@section('content')
    <inventory-index :type-user="{{ json_encode(Auth::user()->type) }}"></inventory-index>
@endsection
