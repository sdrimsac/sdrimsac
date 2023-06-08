@extends('tenant.layouts.app')

@push('styles')
    <style type="text/css">
        .v-modal {
            opacity: 0.2 !important;
        }
        .border-custom {
            border-color: rgba(0,136,204, .5) !important;
        }
        @media only screen and (min-width: 768px) { 
        	.inner-wrapper {
			    padding-top: 60px !important;
			}
        }
       
    </style>
@endpush

@section('content')
    <tenant-documents-invoicetensu :is_contingency="{{ json_encode($is_contingency) }}"></tenant-documents-invoicetensu>
@endsection

 