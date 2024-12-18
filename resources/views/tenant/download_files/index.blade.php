@extends('tenant.layouts.app')

@section('content')
    <tenant-download-files-index :type-user="{{ json_encode(auth()->user()->type) }}" :company-number="{{ json_encode($company_number) }}">
    </tenant-download-files-index>
@endsection
