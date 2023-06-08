@extends('tenant.layouts.app')
@section('content')
    <tenant-boxes-expenses-index
        :groupid="{{ json_encode($groupid) }}"
        :userid="{{ json_encode($userid) }}"
        :subcategoryid="{{ json_encode($subcategoryid) }}"
        :soaptypeid="{{ json_encode($soaptypeid) }}"
        :categoryid="{{ json_encode($categoryid) }}"
        :cashid ="{{ json_encode($cashid) }}"
        >
    </tenant-boxes-expenses-index>
@endsection
