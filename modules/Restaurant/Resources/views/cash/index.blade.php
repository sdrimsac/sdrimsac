@extends('tenant.layouts.pos')
@section('content')
    <tenant-cash-index
         :userid="{{ json_encode($userid) }}"
         :cajaopen="{{ json_encode($cajaOpen) }}" >
    </tenant-cash-index>
@endsection
