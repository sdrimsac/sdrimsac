@extends('tenant.layouts.app')


@section('content')
    <restobar-food-list :categories="{{ $categories }}"
                          :configurations="{{ $configurations }}"
                          :foods="{{ $foods }}"></restobar-food-list>
@endsection
