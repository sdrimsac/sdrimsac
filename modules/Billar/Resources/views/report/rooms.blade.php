@extends('tenant.layouts.app')
@section('content')
    <tenant-hotels-room-report :configuration="{{ json_encode($configurations) }}"></tenant-hotels-room-report>
@endsection
