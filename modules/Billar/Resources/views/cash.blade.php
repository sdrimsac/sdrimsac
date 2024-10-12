@extends('tenant.layouts.app')


@section('content')
<tenant-cash-index
:from-admin=true
:userid="{{ json_encode($userid) }}">
</tenant-cash-index>
@endsection
