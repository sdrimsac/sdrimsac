@extends('tenant.layouts.app')

@section('content')
    <tenant-shopping-index  {{-- :type-user="{{ json_encode(auth()->user()->type) }}"
        :configuration="{{ json_encode($configuration) }}"
        :company="{{ json_encode($company) }}" --}}></tenant-shopping-index>
@endsection