
@extends('tenant.layouts.app')


@section('content')
    <tenant-consignment-index :configuration="{{ $configuration }}"></tenant-consignment-index>
@endsection
