@extends('tenant.layouts.app')

@section('content')
    <tenant-quotations-form :type-user="{{json_encode(Auth::user()->type)}}" :configuration="{{json_encode($configuration)}}" :sale-opportunity-id="{{json_encode($saleOpportunityId)}}"></tenant-quotations-form>
@endsection
