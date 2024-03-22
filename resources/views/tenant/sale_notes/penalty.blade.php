
@extends('tenant.layouts.app')

@section('content')
   <tenant-sale-notes-credit-penalty
       :company="{{ json_encode($company) }}"
        :configuration="{{json_encode($configuration)}}"
        >
   </tenant-sale-notes-credit-penalty>
@endsection
