@extends('tenant.layouts.app')

@section('content')
   <!-- <tenant-report-kardex-index></tenant-report-kardex-index> -->
    <tenant-report-kardex-master 
    :establecimiento="{{json_encode($establecimiento)}}"
    
    
    
    ></tenant-report-kardex-master>


@endsection

@push('scripts')
    <script></script>
@endpush
