@extends('tenant.layouts.app')

@section('content')
    <tenant-documents-note-other :user="{{ json_encode(auth()->user()) }}"
        :configuration="{{ \App\Models\Tenant\Configuration::getPublicConfig() }}"></tenant-documents-note-other>
@endsection
