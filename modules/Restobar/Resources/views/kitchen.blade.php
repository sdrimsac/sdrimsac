@extends('tenant.layouts.app')


@section('content')
    <tenant-restobar-kitchen :configuration="{{ $configuration }}"></tenant-restobar-kitchen>
@endsection
