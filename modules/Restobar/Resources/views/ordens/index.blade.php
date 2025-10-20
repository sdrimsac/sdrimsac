@extends('tenant.layouts.pos')


@section('content')
    <restobar-ordens-index :configuration="{{ $configuration }}" :user="{{ json_encode(Auth::user()) }}">
    </restobar-ordens-index>
@endsection
