@extends('tenant.layouts.app')

@section('content')
    <div class="row">
       <div class="col-md-12">
       <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
              <div class="row">
                <div class="col-sm-6">
                  <h6><span>Configuración</span></h6>
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active"><span class="text-muted">Configuración</span></li>
                     <li class="breadcrumb-item active"><span class="text-muted">Avanzado</span></li>
                  </ol>
                </div>
               
              </div>
            </div>
          </div>
      
          <!-- Container-fluid starts-->
       
       </div>
       @inject('roleService', 'App\Services\RoleService')
       <div class="col-lg-8 col-md-12">
            <tenant-configurations-form 
            :is-arca="{{json_encode($roleService->isArca())}}"
            :type-user="{{ json_encode(auth()->user()->type) }}"></tenant-configurations-form>
        </div>
        @if(!$roleService->isArca())
        <div class="col-lg-4 col-md-12">
            <tenant-options-form></tenant-options-form>
        </div>
        @endif
    </div>
@endsection
