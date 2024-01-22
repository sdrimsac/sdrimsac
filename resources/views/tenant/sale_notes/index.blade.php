
 @extends('tenant.layouts.app')
 @inject('roleService', 'App\Services\RoleService')
 @php
$just_sale_notes = !$roleService->isInterno()&&!$roleService->documentsDisabled();
@endphp
@section('content')
    <tenant-sale-notes-index
        :just_sale_notes="{{ json_encode($just_sale_notes) }}"
        :soap-company="{{ json_encode($soap_company) }}"
        :company="{{ json_encode($company) }}"
        :user_type="{{ json_encode($user_type)}}"
         :configuration="{{json_encode($configuration)}}"
         >
    </tenant-sale-notes-index>
@endsection
