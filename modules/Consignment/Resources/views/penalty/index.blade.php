
@extends('tenant.layouts.app')


@section('content')
    <tenant-consignment-penalty-index :configuration="{{ $configuration }}"></tenant-consignment-penalty-index>
@endsection
