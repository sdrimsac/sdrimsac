@extends('tenant.layouts.app')

@section('content')

    {{-- Use @json to safely inline the document object as a JS expression --}}
    <tenant-documents-note :user='@json(auth()->user())' :document_affected='@json($document_affected)' :configuration='@json($configuration)'></tenant-documents-note>

@endsection
