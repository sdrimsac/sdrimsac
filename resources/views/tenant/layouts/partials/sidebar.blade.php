@php
    $path = explode('/', request()->path());
    $path[1] = array_key_exists(1, $path) > 0 ? $path[1] : '';
    $path[2] = array_key_exists(2, $path) > 0 ? $path[2] : '';
    $path[0] = $path[0] === '' ? 'documents' : $path[0];
    $user = auth()->user();
    $config = \App\Models\Tenant\Configuration::first();
@endphp

<div class="menu-container flex-grow-1" style="margin-top:20px; ">
    <ul id="menu" class="menu">

        {{--  <li>
            <a href="{{ route('tenant.dashboard.index') }}" class="{{ $path[0] === 'dashboard' ? 'active' : '' }}">
            <i data-cs-icon="home" class="icon" data-cs-size="18"></i>
            <span class="label">Dashboard</span>
            </a>
        </li>
        <li class="mega">
            <a href="#restaurant" data-bs-toggle="collapse" data-role="button"
              aria-expanded="{{($path[0] === 'persons' && $path[1] === 'customers') ? true:false }}{{ ($path[0] === 'brands') ? true:false }}{{ ($path[0] === 'restaurant') ? true:false }} {{ ($path[0] === 'points') ? true:false }} {{ ($path[0] === 'items') ? true:false }}{{ ($path[0] === 'item-sets') ? true:false }}{{ ($path[0] === 'category') ? true:false }}"
              class="{{($path[0] === 'persons' && $path[1] === 'customers') ? 'active':'' }}{{ ($path[0] === 'brands') ? 'active':'' }}{{ ($path[0] === 'restaurant') ? 'active':'' }}{{ ($path[0] === 'points') ? 'active':'' }}{{ ($path[0] === 'items') ? 'active':'' }}{{ ($path[0] === 'item-sets') ? 'active':'' }}{{ ($path[0] === 'category') ? 'active':'' }}"
              data-clicked="{{($path[0] === 'persons' && $path[1] === 'customers') ? true:false }}{{ ($path[0] === 'brands') ? true:false }}{{ ($path[0] === 'restaurant') ? true:false }} {{ ($path[0] === 'points') ? true:false }}{{ ($path[0] === 'items') ? true:false }}{{ ($path[0] === 'item-sets') ? true:false }}{{ ($path[0] === 'category') ? true:false }}" >
              <i class="icofont-restaurant icon-parent"></i>
              <span class="label">Ventas</span>
            </a>

            <ul id="restaurant"
            class="collapse {{ ($path[0] === 'items') ? 'show':'' }} {{ ($path[0] === 'points') ? 'show':'' }}{{ ($path[0] === 'persons' && $path[1] === 'customers') ? 'show':'' }}{{ ($path[0] === 'brands') ? 'show':'' }}{{ ($path[0] === 'category') ? 'show':'' }}">
                <li>
                    <a class="{{ $path[0] === 'points' ? 'active' : '' }}"
                        href="{{ route('tenant.point.index') }}">
                        <i class="icofont-clip-board"></i> Punto de Caja
                    </a>
                </li>

                <li>
                    <a href="{{ route('restaurant.cash') }}" class="{{ $path[1] === 'cashes' ? 'active' : '' }}">
                        <i class="icofont-pay icon-parent"></i>
                      <span class="label">Apertura - Cierre de Caja</span>
                    </a>
                </li>
                <li>
                <a href="#restaurantComponents"
                data-bs-toggle="collapse" data-role="button"
                aria-expanded="{{($path[0] === 'persons' && $path[1] === 'customers') ? true:false }}{{ ($path[0] === 'brands') ? true:false }}{{ ($path[0] === 'category') ? true:false }}{{ ($path[0] === 'items') ? true:false }}{{ ($path[0] === 'item-sets') ? true:false }} {{ ($path[0] === 'restaurant' && $path[1] === 'workers') ? true:false }}  {{ ($path[0] === 'restaurant' && $path[1] === 'workers-type') ? true:false }}{{ ($path[0] === 'restaurant' && $path[1] === 'areas') ? true:false }}{{ ($path[0] === 'restaurant' && $path[1] === 'tables') ? true:false }}{{ ($path[0] === 'restaurant' && $path[1] === 'status-orden') ? true:false }}{{ ($path[0] === 'restaurant' && $path[1] === 'status-tables') ? true:false }}"
                class="{{($path[0] === 'persons' && $path[1] === 'customers') ?  'active':'' }} {{ ($path[0] === 'brands' ) ? 'active':'' }}{{ ($path[0] === 'category' ) ? 'active':'' }}{{ ($path[0] === 'items' ) ? 'active':'' }}{{ ($path[0] === 'item-sets' ) ? 'active':'' }}{{ ($path[0] === 'restaurant' && $path[1] === 'workers') ? 'active':'' }} {{ ($path[0] === 'restaurant' && $path[1] === 'workers-type') ? 'active':'' }}{{ ($path[0] === 'restaurant' && $path[1] === 'areas') ? 'active':'' }}{{ ($path[0] === 'restaurant' && $path[1] === 'tables') ? 'active':'' }}{{ ($path[0] === 'restaurant'  && $path[1] === 'status-orden') ? 'active':'' }}{{ ($path[0] === 'restaurant' && $path[1] === 'status-tables') ? 'active':'' }}"
                data-clicked="{{($path[0] === 'persons' && $path[1] === 'customers') ? true:false }}{{ ($path[0] === 'brands') ? true:false }}{{ ($path[0] === 'category') ? true:false }}{{ ($path[0] === 'items') ? true:false }}{{ ($path[0] === 'item-sets') ? true:false }} {{ ($path[0] === 'restaurant' && $path[1] === 'workers') ? true:false }} {{ ($path[0] === 'restaurant' && $path[1] === 'workers-type') ? true:false }}{{ ($path[0] === 'restaurant' && $path[1] === 'areas') ? true:false }}{{ ($path[0] === 'restaurant' && $path[1] === 'tables') ? true:false }}{{ ($path[0] === 'restaurant'  && $path[1] === 'status-orden') ? true:false }}{{ ($path[0] === 'restaurant' && $path[1] === 'status-tables') ? true:false }}">
                  <span class="label"><i class="icofont-fix-tools icon-parent"></i> Mantenimiento</span>
                </a>
                <ul id="restaurantComponents" class="collapse {{ ($path[0] === 'items') ? 'show':'' }}{{ ($path[0] === 'persons' && $path[1] === 'customers') ? 'show':'' }}{{ ($path[0] === 'brands') ? 'show':'' }}{{ ($path[0] === 'category') ? 'show':'' }}">
                    <li>
                        <a class="{{ $path[0] === 'restaurant' && $path[1] === 'workers' ? 'active' : '' }}"
                            href="{{ route('restaurant.workers') }}">
                            <i class="icofont-users-alt-1"></i> Usuarios
                        </a>
                    </li>
                    <li>
                        <a class="{{ $path[0] === 'restaurant' && $path[1] === 'workers-type' ? 'active' : '' }}"
                            href="{{ route('restaurant.workers_type') }}">
                            <i class="icofont-company"></i> Tipo Usuario
                        </a>
                    </li>
                    <li>
                        <a class="{{$path[0] === 'items' && $path[1] === ''  ? 'active' : '' }}"
                            href="{{ route('tenant.items.index') }}">
                            <i class="icofont-soft-drinks"></i>  Productos
                        </a>
                    </li>

                    <li>
                        <a class="{{$path[0] === 'item-sets' && $path[1] === ''  ? 'active' : '' }}"
                            href="{{ route('tenant.item_sets.index') }}">
                            <i class="icofont-price"></i> Promocion / Ofertas
                        </a>
                    </li>
                    <li>
                        <a class="{{$path[0] === 'category'  ? 'active' : '' }}"
                            href="{{ route('tenant.categories.index') }}">
                            <i class="icofont-chart-flow"></i> Categorias
                        </a>
                    </li>
                    <li>
                        <a class="{{$path[0] === 'etiqueta'  ? 'active' : '' }}"
                            href="{{ route('etiquetas.index') }}">
                            <i class="icofont-label"></i> Etiquetas
                        </a>
                    </li>
                    <li>
                        <a class="{{ $path[0] === 'brands' ? 'active' : '' }}"
                            href="{{ route('tenant.brands.index') }}">
                            <i class="icofont-xing"></i> Marcas
                        </a>
                    </li>
                    <li>
                        <a class="{{ $path[0] === 'persons' && $path[1] === 'customers' ? 'active' : '' }}"
                            href="{{ route('tenant.persons.index', ['type' => 'customers']) }}">
                            <i class="icofont-business-man"></i> Clientes
                        </a>
                    </li>

                    <li>
                        <a class="{{ $path[0] === 'restaurant' && $path[1] === 'areas' ? 'active' : '' }}"
                            href="{{ route('restaurant.areas') }}">
                            <i class="icofont-billboard"></i> Áreas
                        </a>
                    </li>
                    <li>
                        <a class="{{ $path[0] === 'restaurant' && $path[1] === 'tables' ? 'active' : '' }}"
                            href="{{ route('restaurant.tables') }}">
                            <i class="icofont-dining-table"></i> Mesas
                        </a>
                    </li>
                    <li>
                        <a class="{{ $path[0] === 'restaurant' && $path[1] === 'status-orden' ? 'active' : '' }}"
                            href="{{ route('restaurant.status_orden') }}">
                            <i class="icofont-read-book"></i> Estados de pedidos
                        </a>
                    </li>
                    <li>
                        <a class="{{ $path[0] === 'restaurant' && $path[1] === 'status-tables' ? 'active' : '' }}"
                            href="{{ route('restaurant.status_table') }}">
                            <i class="icofont-dining-table"></i> Estados de mesas
                        </a>
                    </li>

                </ul>
              </li>
          </ul>
    </li> --}}
        @inject('roleService', 'App\Services\RoleService')
        @if (!$roleService->isAccountant($user->worker_type_id))


            <li>
                <a href="#restaurantComponents" data-bs-toggle="collapse" data-role="button"
                    aria-expanded="{{ $path[0] === 'persons' && $path[1] === 'customers' ? true : false }}{{ $path[0] === 'brands' ? true : false }}{{ $path[0] === 'category' ? true : false }}{{ $path[0] === 'item-sets' ? true : false }} {{ $path[0] === 'caja' && $path[1] === 'workers' ? true : false }}  {{ $path[0] === 'caja' && $path[1] === 'workers-type' ? true : false }}{{ $path[0] === 'caja' && $path[1] === 'areas' ? true : false }}{{ $path[0] === 'caja' && $path[1] === 'tables' ? true : false }}{{ $path[0] === 'caja' && $path[1] === 'status-orden' ? true : false }}{{ $path[0] === 'caja' && $path[1] === 'status-tables' ? true : false }}"
                    class="{{ $path[0] === 'persons' && $path[1] === 'customers' ? 'active' : '' }} {{ $path[0] === 'brands' ? 'active' : '' }}{{ $path[0] === 'category' ? 'active' : '' }}{{ $path[0] === 'item-sets' ? 'active' : '' }}{{ $path[0] === 'caja' && $path[1] === 'workers' ? 'active' : '' }} {{ $path[0] === 'caja' && $path[1] === 'workers-type' ? 'active' : '' }}{{ $path[0] === 'caja' && $path[1] === 'areas' ? 'active' : '' }}{{ $path[0] === 'caja' && $path[1] === 'tables' ? 'active' : '' }}{{ $path[0] === 'caja' && $path[1] === 'status-orden' ? 'active' : '' }}{{ $path[0] === 'caja' && $path[1] === 'status-tables' ? 'active' : '' }}"
                    data-clicked="{{ $path[0] === 'persons' && $path[1] === 'customers' ? true : false }}{{ $path[0] === 'brands' ? true : false }}{{ $path[0] === 'category' ? true : false }}{{ $path[0] === 'item-sets' ? true : false }} {{ $path[0] === 'caja' && $path[1] === 'workers' ? true : false }} {{ $path[0] === 'caja' && $path[1] === 'workers-type' ? true : false }}{{ $path[0] === 'caja' && $path[1] === 'areas' ? true : false }}{{ $path[0] === 'caja' && $path[1] === 'tables' ? true : false }}{{ $path[0] === 'caja' && $path[1] === 'status-orden' ? true : false }}{{ $path[0] === 'caja' && $path[1] === 'status-tables' ? true : false }}">
                    <i class="icofont-fix-tools icon-parent"></i>
                    <span class="label"> Mantenimiento</span>
                </a>
                <ul id="restaurantComponents" class="collapse ">

                    @if ($user->type == 'superadmin')
                    @endif

                    <li>
                        <a class="{{ $path[0] === 'caja' && $path[1] === 'workers' ? 'active' : '' }}"
                            href="{{ route('restaurant.workers') }}">
                            <i class="icofont-users-alt-1"></i> Usuarios
                        </a>
                    </li>
                    {{-- <li>
                <a class="{{$path[0] === 'items' && $path[1] === ''  ? 'active' : '' }}"
                    href="{{ route('tenant.documents_identity.index') }}">
                    <i class="icofont-id-card"></i>  Tipo de documentos
                </a>
            </li> --}}
                    <li>
                        <a class="{{ $path[0] === 'registers' ? 'active' : '' }}"
                            href="{{ route('tenant.registers.index') }}">
                            <i class="fas fa-history"></i> Registro de actividades
                        </a>
                    </li>
                    @if ($config->college)
                        <li>
                            <a class="{{ $path[0] === 'items' && $path[1] === '' ? 'active' : '' }}"
                                href="{{ route('tenant.items.index') }}">
                                <i class="icofont-soft-drinks"></i> Productos
                            </a>
                        </li>
                    @endif
                    <li>
                        <a class="{{ $path[0] === 'category' ? 'active' : '' }}"
                            href="{{ route('tenant.categories.index') }}">
                            <i class="icofont-chart-flow"></i> Categorias
                        </a>
                    </li>
                    <li>
                        <a class="{{ $path[0] === 'etiqueta' ? 'active' : '' }}"
                            href="{{ route('etiquetas.index') }}">
                            <i class="icofont-label"></i> Etiquetas
                        </a>
                    </li>
                    <li>
                        <a class="{{ $path[0] === 'brands' ? 'active' : '' }}"
                            href="{{ route('tenant.brands.index') }}">
                            <i class="icofont-xing"></i> Marcas
                        </a>
                    </li>
                    <li>
                        <a class="{{ $path[0] === 'persons' && $path[1] === 'customers' ? 'active' : '' }}"
                            href="{{ route('tenant.persons.index', ['type' => 'customers']) }}">
                            <i class="icofont-business-man"></i> Clientes
                        </a>
                    </li>


                    <li>
                        <a class="{{ $path[0] === 'caja' && $path[1] === 'observations' ? 'active' : '' }}"
                            href="{{ route('restaurant.observations') }}">
                            <i class="icofont-dining-table"></i> Observaciones
                        </a>
                    </li>
                    @if ($config->personal_phone)
                        <li>
                            <a class="{{ $path[0] === 'whatsapp' ? 'active' : '' }}" href="{{ route('whatsapp') }}">
                                <i class="icofont-brand-whatsapp" aria-hidden="true"></i> Whatsapp
                            </a>
                        </li>
                    @endif
                    @if ($user->type == 'superadmin')
                    @endif
                </ul>
            </li>
            {{-- <li >
        <a href="#vips" data-bs-toggle="collapse" data-role="button"
          aria-expanded="{{ ($path[0] === 'vips') ? true:false }}{{ ($path[0] === 'vips' && $path[1] === 'create') ? true:false }}"
          class="{{ ($path[0] === 'vips') ? 'active':'' }}{{ ($path[0] === 'vips' && $path[1] === 'create') ? 'active':'' }}"
          data-clicked="{{ ($path[0] === 'vips') ? true:false }}{{ ($path[0] === 'vips' && $path[1] === 'create') ? true:false }}" >
          <i class="icofont-star icon-parent"></i>
          <span class="label">Vip</span>
        </a>
    
        <ul id="vips" class="collapse ">
            <li>
                <a class="{{ $path[0] === 'vips' && $path[1] === '' ? 'active' : '' }}"
                    href="{{ route('vip.index') }}">
                    <i class="icofont-badge"></i> Clientes VIP
                </a>
            </li>
            <li>
                <a class="{{ $path[0] === 'vips' && $path[1] === 'create' ? 'active' : '' }}"
                    href="{{ route('vip.clients') }}">
                    <i class="icofont-list"></i> Categorias
                </a>
            </li>
    
        </ul>
      </li> --}}
            <li>
                <a href="#compras" data-bs-toggle="collapse" data-role="button"
                    aria-expanded="{{ $path[0] === 'purchases' ? true : false }}{{ $path[0] === 'purchases' && $path[1] === 'create' ? true : false }}"
                    class="{{ $path[0] === 'purchases' ? 'active' : '' }}{{ $path[0] === 'purchases' && $path[1] === 'create' ? 'active' : '' }}"
                    data-clicked="{{ $path[0] === 'purchases' ? true : false }}{{ $path[0] === 'purchases' && $path[1] === 'create' ? true : false }}">
                    <i class="icofont-shopping-cart icon-parent"></i>
                    <span class="label">Compras</span>
                </a>

                <ul id="compras" class="collapse ">
                    <li>
                        <a class="{{ $path[0] === 'purchases' && $path[1] === '' ? 'active' : '' }}"
                            href="{{ route('tenant.purchases.index') }}">
                            <i class="icofont-list"></i> Lista de Compras
                        </a>
                    </li>
                    <li>
                        <a class="{{ $path[0] === 'purchases' && $path[1] === 'create' ? 'active' : '' }}"
                            href="{{ route('tenant.purchases.create') }}">
                            <i class="icofont-credit-card"></i> Nueva Compras
                        </a>
                    </li>

                </ul>
            </li>
            @if (!$config->college)
                <li>
                    <a href="#invetories" data-bs-toggle="collapse" data-role="button"
                        aria-expanded="{{ $path[0] === 'invetories' ? true : false }}{{ $path[0] === 'invetories' && $path[1] === 'create' ? true : false }}{{ $path[0] === 'items' ? true : false }}"
                        class="{{ $path[0] === 'invetories' ? 'active' : '' }}{{ $path[0] === 'invetories' && $path[1] === 'create' ? 'active' : '' }}{{ $path[0] === 'items' ? 'active' : '' }}"
                        data-clicked="{{ $path[0] === 'invetories' ? true : false }}{{ $path[0] === 'invetories' && $path[1] === 'create' ? true : false }}{{ $path[0] === 'items' ? true : false }}">
                        <i class="icofont-box icon-parent"></i>
                        <span class="label">Inventario</span>
                    </a>

                    <ul id="invetories" class="collapse ">
                        <li>
                            <a class="{{ $path[0] === 'items' && $path[1] === '' ? 'active' : '' }}"
                                href="{{ route('tenant.items.index') }}">
                                <i class="icofont-soft-drinks"></i> Productos
                            </a>
                        </li>
                        <li>
                            <a class="{{ $path[0] === 'transfers' && $path[1] === '' ? 'active' : '' }}"
                                href="{{ route('transfers.index') }}">
                                <i class="icofont-list"></i> Traslados
                            </a>
                        </li>
                        <li>
                            <a class="{{ $path[0] === 'transfers_place' && $path[1] === '' ? 'active' : '' }}"
                                href="{{ route('transfers_place.index') }}">
                                <i class="icofont-list"></i> Traslados por aceptar
                            </a>
                        </li>

                        <li>
                            <a class="{{ $path[0] === 'transfers_place' && $path[1] === '' ? 'active' : '' }}"
                                href="{{ route('tenant.dispatches.index') }}">
                                <i class="far fa-file-alt"></i>

                                Guias de remisión
                            </a>
                        </li>
                        <li>
                            <a class="{{ $path[0] === 'itemlots' && $path[1] === '' ? 'active' : '' }}"
                                href="{{ route('itemlots') }}">
                                <i class="icofont-soft-drinks"></i> Series (productos)
                            </a>
                        </li>

                        <li>
                            <a class="{{ $path[0] === 'lotes' && $path[1] === '' ? 'active' : '' }}"
                                href="{{ route('lotes') }}">
                                <i class="icofont-bar-code"></i> Lotes
                            </a>
                        </li>
                        <li>
                            <a class="{{ $path[0] === 'item-sets' && $path[1] === '' ? 'active' : '' }}"
                                href="{{ route('tenant.item_sets.index') }}">
                                <i class="icofont-price"></i> Promocion / Ofertas
                            </a>
                        </li>


                    </ul>
                </li>
            @endif
        @endif
        {{-- consignación --}}
        {{-- <li>
            <a href="#consignment" data-bs-toggle="collapse" data-role="button"
                aria-expanded="{{ $path[0] === 'consignment' ? true : false }}{{ $path[0] === 'summaries' ? true : false }}{{ $path[0] === 'voided' ? true : false }}{{ $path[0] === 'sale-notes' ? true : false }}{{ $path[0] === 'brands' ? true : false }}{{ $path[0] === 'order-notes' ? true : false }}"
                class="{{ $path[0] === 'consignment' ? 'active' : '' }}{{ $path[0] === 'summaries' ? 'active' : '' }}{{ $path[0] === 'voided' ? 'active' : '' }}{{ $path[0] === 'sale-notes' ? 'active' : '' }}{{ $path[0] === 'brands' ? 'active' : '' }}{{ $path[0] === 'order-notes' ? 'active' : '' }}"
                data-clicked="{{ $path[0] === 'consignment' ? true : false }}{{ $path[0] === 'items' ? true : false }}{{ $path[0] === 'persons' && $path[1] === 'customers' ? true : false }}{{ $path[0] === 'summaries' ? true : false }}{{ $path[0] === 'voided' ? true : false }}{{ $path[0] === 'sale-notes' ? true : false }}{{ $path[0] === 'brands' ? true : false }}{{ $path[0] === 'order-notes' ? true : false }}">
                <i class="icofont-files-stack icon-parent"></i>
                <span class="label">Consignación</span>
            </a>
            <ul id="consigment" class="collapse ">
                 <li>
                        <a class="{{ $path[0] === 'consigment' && $path[1] != 'create' && $path[1] != 'not-sent' ? 'active' : '' }}"
                            href="{{ route('tenant.consignment.index') }}">
                            <i class="icofont-list"></i> Listado
                        </a>
                    </li>
            

            </ul>
        </li> --}}
        {{-- ***************** --}}
        <li>
            <a href="#documents" data-bs-toggle="collapse" data-role="button"
                aria-expanded="{{ $path[0] === 'documents' ? true : false }}{{ $path[0] === 'summaries' ? true : false }}{{ $path[0] === 'voided' ? true : false }}{{ $path[0] === 'sale-notes' ? true : false }}{{ $path[0] === 'brands' ? true : false }}{{ $path[0] === 'order-notes' ? true : false }}"
                class="{{ $path[0] === 'documents' ? 'active' : '' }}{{ $path[0] === 'summaries' ? 'active' : '' }}{{ $path[0] === 'voided' ? 'active' : '' }}{{ $path[0] === 'sale-notes' ? 'active' : '' }}{{ $path[0] === 'brands' ? 'active' : '' }}{{ $path[0] === 'order-notes' ? 'active' : '' }}"
                data-clicked="{{ $path[0] === 'documents' ? true : false }}{{ $path[0] === 'items' ? true : false }}{{ $path[0] === 'persons' && $path[1] === 'customers' ? true : false }}{{ $path[0] === 'summaries' ? true : false }}{{ $path[0] === 'voided' ? true : false }}{{ $path[0] === 'sale-notes' ? true : false }}{{ $path[0] === 'brands' ? true : false }}{{ $path[0] === 'order-notes' ? true : false }}">
                <i class="icofont-files-stack icon-parent"></i>
                <span class="label">Comprobante Pago</span>
            </a>
            <ul id="documents" class="collapse ">
                @if (!$roleService->isInterno())
                    @if (!$roleService->isAccountant($user->worker_type_id))
                        <li>
                            <a class="{{ $path[0] === 'documents' && $path[1] === 'create' ? 'active' : '' }}"
                                href="{{ route('tenant.documents.create') }}">
                                <i class="icofont-document-folder"></i> Nuevo comprobante
                            </a>
                        </li>
                    @endif
                    <li>
                        <a class="{{ $path[0] === 'documents' && $path[1] != 'create' && $path[1] != 'not-sent' ? 'active' : '' }}"
                            href="{{ route('tenant.documents.index') }}">
                            <i class="icofont-list"></i> Listado
                        </a>
                    </li>
                    <li>
                        <a class="{{ $path[0] === 'documents' && $path[1] === 'not-sent' ? 'active' : '' }}"
                            href="{{ route('tenant.documents.not_sent') }}">
                            <i class="icofont-send-mail"></i> No enviados
                        </a>
                    </li>
                @endif
                @if (!$roleService->isAccountant($user->worker_type_id))
                    <li>
                        <a class="{{ $path[0] === 'sale-notes' ? 'active' : '' }}"
                            href="{{ route('tenant.sale_notes.index') }}">
                            <i class="icofont-document-folder"></i> Nota de Venta
                        </a>
                    </li>
                @endif

                @if (!$roleService->isAccountant($user->worker_type_id))
                    <li>
                        <a class="{{ $path[0] === 'quotations' ? 'active' : '' }}"
                            href="{{ route('tenant.quotations.index') }}">
                            <i class="icofont-dollar"></i>
                            Cotizaciones
                        </a>
                    </li>
                @endif
                @if (!$roleService->isInterno())
                    <li>
                        <a class="{{ $path[0] === 'summaries' ? 'active' : '' }}"
                            href="{{ route('tenant.summaries.index') }}">
                            <i class="icofont-prescription"></i> Resumenes
                        </a>
                    </li>
                    <li>
                        <a class="{{ $path[0] === 'voided' ? 'active' : '' }}"
                            href="{{ route('tenant.voided.index') }}">
                            <i class="icofont-delete-alt"></i> Anulaciones
                        </a>
                    </li>
                @endif
            </ul>
        </li>
        @if (!$roleService->isAccountant($user->worker_type_id))
            <li>
                <a href="#boxes" data-bs-toggle="collapse" data-role="button"
                    aria-expanded="{{ $path[0] === 'caja' && $path[1] === 'boxes' ? true : false }}"
                    class="{{ $path[0] === 'caja' && $path[1] === 'boxes' ? 'active' : '' }}"
                    data-clicked="{{ $path[0] === 'caja' && $path[1] === 'boxes' ? true : false }}">
                    <i class="icofont-file-alt icon-parent"></i>
                    <span class="label">Arqueo de Caja</span>
                </a>
                <ul id="boxes" class="collapse ">

                    <li>
                        <a href="/incomes" class="{{ $path[0] === 'incomes' ? 'active' : '' }}">
                            <i class="icofont-money icon-parent"></i>
                            <span class="label">Ingresos</span>
                        </a>
                    </li>
                    <li>
                        <a href="/expenses" class="{{ $path[0] === 'expenses' ? 'active' : '' }}">
                            <i class="icofont-spreadsheet icon-parent"></i>
                            <span class="label">Gastos</span>
                        </a>
                    </li>
                    <li>
                        <a class="{{ $path[0] === 'boxes' ? 'active' : '' }}" href="{{ route('boxes') }}">
                            <i class="icofont-patient-file"></i> Reporte de Caja
                        </a>
                    </li>
                    <li>
                        <a class="{{ $path[0] === 'index_report_closed_cash' ? 'active' : '' }}" href="{{ route('reports.cash_closes.index') }}">
                            <i class="icofont-attachment"></i>
                            Reporte de Cierre de Caja
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        <li>
            <a href="#reporte" data-bs-toggle="collapse" data-role="button"
                aria-expanded="{{ $path[0] === 'reports' && $path[1] === 'inventory' ? true : false }}{{ ($path[0] === 'reports' && $path[1] === 'stockmin' ? true : false && $path[1] === 'kardex') ? true : false }}"
                class="{{ $path[0] === 'reports' && $path[1] === 'inventory' ? 'active' : '' }}{{ ($path[0] === 'reports' && $path[1] === 'stockmin' ? 'active' : '' && $path[1] === 'kardex') ? true : false }}"
                data-clicked="{{ $path[0] === 'reports' && $path[1] === 'inventory' ? true : false }}{{ ($path[0] === 'reports' && $path[1] === 'stockmin' ? true : false && $path[1] === 'kardex') ? true : false }}">
                <i class="icofont-file-alt icon-parent"></i>
                <span class="label">Reporte </span>
            </a>
            <ul id="reporte" class="collapse ">
                <li>
                    <a class="{{ $path[0] === 'reports' && $path[1] === 'consignment' ? 'active' : '' }}"
                        href="{{ route('reports.consignment.index') }}">
                        <i class="icofont-file-excel"></i>

                        Consignamiento
                    </a>
                </li>
                <li>
                    <a class="{{ $path[0] === 'reports' && $path[1] === 'credits' ? 'active' : '' }}"
                        href="{{ route('reports.credits.index') }}">
                        <i class="fas fa-credit-card"></i>

                        Créditos
                    </a>
                </li>
                <li>
                    <a class="{{ $path[0] === 'report_cash'? 'active' : '' }}"
                        href="{{ route('reports.cash.index') }}">
                        <i class="icofont-money-bag"></i>
                        Ganancias
                    </a>
                </li>
                <li>
                    <a class="{{ $path[0] === 'reports' && $path[1] === 'inventory' ? 'active' : '' }}"
                        href="{{ route('reports.inventory.index') }}">
                        <i class="icofont-box"></i> Stock Producto
                    </a>
                </li>
                <li>
                    <a class="{{ $path[0] === 'reports' && $path[1] === 'stockmin' ? 'active' : '' }}"
                        href="{{ route('reports.stockmin.index') }}">
                        <i class="fas fa-boxes"> </i> Stock Minimo
                    </a>
                </li>
                <li>
                    <a class="{{ $path[0] === 'reports' && $path[1] === 'kardex' ? 'active' : '' }}"
                        href="{{ route('reports.kardex.index') }}">
                        <i class="icofont-chart-bar-graph"></i> Kardex
                    </a>
                </li>
                <li>
                    <a class="{{ $path[0] === 'reports' && $path[1] === 'series' ? 'active' : '' }}"
                        href="{{ route('reports.series.index') }}">
                        <i class="fas fa-fingerprint"></i> Venta de Series
                    </a>
                </li>

            </ul>
        </li>


        <li>
            <a href="#contabilidad" data-bs-toggle="collapse" data-role="button"
                aria-expanded="{{ $path[0] === 'account' ? true : false }}"
                class="{{ $path[0] === 'account' ? 'active' : '' }}"
                data-clicked="{{ $path[0] === 'account' ? true : false }}">
                <i class="icofont-calculator-alt-2 icon-parent"></i>
                <span class="label"> Contabilidad</span>
            </a>

            <ul id="contabilidad" class="collapse ">
                <li>
                    <a class="{{ $path[0] === 'account' && $path[1] === 'format' ? 'active' : '' }}"
                        href="{{ route('tenant.account_exports') }}">
                        <i class="icofont-file-excel"></i> Exportar formatos
                    </a>
                </li>
            </ul>
        </li>
        @if ($config->college)
            <li>
                <a href="#college" data-bs-toggle="collapse" data-role="button"
                    aria-expanded="{{ $path[0] === 'college' ? true : false }}"
                    class="{{ $path[0] === 'college' ? 'active' : '' }}"
                    data-clicked="{{ $path[0] === 'college' ? true : false }}">
                    <i class="icofont-graduate icon-parent"></i>

                    <span class="label">Suscripción Escolar</span>
                </a>

                <ul id="person" class="collapse ">
                    <li>
                        <a class="{{ $path[0] === 'college' && $path[1] === 'students' ? 'active' : '' }}"
                            href="{{ route('college.students.index') }}">
                            <i class="icofont-people icon-parent"></i>
                            Estudiantes
                        </a>
                    </li>
                    <li>
                        <a class="{{ $path[0] === 'college' && $path[1] === 'classrooms' ? 'active' : '' }}"
                            href="{{ route('college.classrooms.index') }}">
                            <i class="icofont-black-board  icon-parent"></i>
                            Salones
                        </a>
                    </li>
                    <li>
                        <a class="{{ $path[0] === 'college' && $path[1] === 'persons' ? 'active' : '' }}"
                            href="{{ route('college.persons.index') }}">
                            <i class="icofont-group-students icon-parent">
                            </i> Padres/Hijos
                        </a>
                    </li>

                    <li>
                        <a class="{{ $path[0] === 'college' && $path[1] === 'plans' ? 'active' : '' }}"
                            href="{{ route('college.plans.index') }}">
                            <i class="icofont-files-stack icon-parent"></i>
                            Planes
                        </a>
                    </li>
                    <li>
                        <a class="{{ $path[0] === 'college' && $path[1] === 'periods' ? 'active' : '' }}"
                            href="{{ route('college.periods.index') }}">
                            <i class="icofont-ui-timer  icon-parent"></i>
                            Periodos
                        </a>
                    </li>

                    <li>
                        <a class="{{ $path[0] === 'college' && $path[1] === 'penalties' ? 'active' : '' }}"
                            href="{{ route('college.penalties.index') }}">
                            <i class="icofont-exclamation-tringle  icon-parent"></i>
                            Penalidades
                        </a>
                    </li>
                    <li>
                        <a class="{{ $path[0] === 'college' && $path[1] === 'levels' ? 'active' : '' }}"
                            href="{{ route('college.levels.index') }}">
                            <i class="icofont-certificate-alt-1 icon-parent"></i>
                            Niveles/Grados/Secciones/Turnos
                        </a>
                    </li>
                    <li>
                        <a class="{{ $path[0] === 'college' && $path[1] === 'listsuplies' ? 'active' : '' }}"
                            href="{{ route('college.listsuplies.index') }}">
                            <i class="fa fa-pencil-ruler"></i>
                            Almacen de Utiles
                        </a>
                    </li>
                </ul>

            </li>
        @endif
        @if ($config->internet)
            <li>
                <a href="#internetUl" data-bs-toggle="collapse" data-role="button"
                    aria-expanded="{{ $path[0] === 'tasks' ? true : false }} "
                    class="{{ $path[0] === 'tasks' ? 'active' : '' }}"
                    data-clicked="{{ $path[0] === 'tasks' ? true : false }}">
                    <i class="icofont-wifi-router icon-parent"></i>
                    <span class="label">Internet</span>
                </a>

                <ul id="internetUl" class="collapse ">
                    <li>
                        <a class="{{ $path[0] === 'internet' && $path[1] === 'planes' ? 'active' : '' }}"
                            href="{{ route('tenant.internet.planes') }}">
                            <i class="icofont-building-alt"></i> Planes / Conceptos
                        </a>
                    </li>
                    <li>
                        <a class="{{ $path[0] === 'internet' && $path[1] === 'planes' ? 'active' : '' }}"
                            href="{{ route('tenant.internet.workersadmin') }}">
                            <i class="icofont-worker"></i> Trabajadores
                        </a>
                    </li>
                </ul>

            </li>
        @endif
        @if ($user->type == 'superadmin')
            <li>
                <a href="#configuration" data-bs-toggle="collapse" data-role="button"
                    aria-expanded="{{ $path[0] === 'tasks' ? true : false }} {{ $path[0] === 'configurations' && $path[1] === 'pdf_templates' ? true : false }} {{ $path[0] === 'companies' && $path[1] === 'create' ? true : false }}{{ $path[0] === 'catalogs' ? true : false }}{{ $path[0] === 'advanced' ? true : false }}{{ $path[0] === 'pdf_templates' ? true : false }}{{ $path[0] === 'series-configurations' ? true : false }}"
                    class="{{ $path[0] === 'tasks' ? 'active' : '' }}{{ $path[0] === 'configurations' && $path[1] === 'pdf_templates' ? 'active' : '' }}{{ $path[0] === 'companies' && $path[1] === 'create' ? 'active' : '' }}{{ $path[0] === 'catalogs' ? 'active' : '' }}{{ $path[0] === 'advanced' ? 'active' : '' }}{{ $path[0] === 'pdf_templates' ? 'active' : '' }}{{ $path[0] === 'series-configurations' ? 'active' : '' }}"
                    data-clicked="{{ $path[0] === 'tasks' ? true : false }}{{ $path[0] === 'configurations' && $path[1] === 'pdf_templates' ? true : false }}{{ $path[0] === 'companies' && $path[1] === 'create' ? true : false }}{{ $path[0] === 'catalogs' ? true : false }}{{ $path[0] === 'advanced' ? true : false }}{{ $path[0] === 'pdf_templates' ? true : false }}{{ $path[0] === 'series-configurations' ? true : false }}">
                    <i class="icofont-ui-settings icon-parent"></i>
                    <span class="label">Configuración</span>
                </a>

                <ul id="configuration" class="collapse ">
                    <li>
                        <a class="{{ $path[0] === 'companies' && $path[1] === 'create' ? 'active' : '' }}"
                            href="{{ route('tenant.companies.create') }}">
                            <i class="icofont-building-alt"></i> Empresa
                        </a>
                    </li>
                    {{-- <li>
            <a class="{{ $path[0] === 'establishments' ? 'active' : '' }}"
            href="{{ route('tenant.establishments.index') }}">
            <i class="icofont-building"></i> Establecimientos
            </a>
        </li> --}}
                    {{-- <li>
            <a class="{{ $path[0] === 'catalogs' ? 'active' : '' }}"
                href="{{ route('tenant.catalogs.index') }}">
                <i class="icofont-notebook"></i> Catalogos
            </a>
        </li> --}}
                    <li>
                        <a class="{{ $path[0] === 'advanced' ? 'active' : '' }}"
                            href="{{ route('tenant.advanced.index') }}">
                            <i class="icofont-ui-settings"></i> Avanzado
                        </a>
                    </li>
                    <li>
                        <a class="{{ $path[0] === 'tasks' ? 'active' : '' }}"
                            href="{{ route('tenant.tasks.index') }}"><i class="icofont-tasks-alt"></i> Tareas</a>
                    </li>

                    <li>
                        <a class="{{ $path[1] === 'pdf_templates' ? 'active' : '' }}"
                            href="{{ route('tenant.advanced.pdf_templates') }}">
                            <i class="icofont-file-pdf"></i> Plantillas
                        </a>
                    </li>

                    <li>
                        <a class="{{ $path[0] === 'series-configurations' ? 'active' : '' }}"
                            href="{{ route('tenant.series_configurations.index') }}">
                            <i class="icofont-numbered"></i> Numeración
                        </a>
                    </li>
                    <li>
                        <a class="{{ $path[0] === 'caja' && $path[1] === 'workers' ? 'active' : '' }}"
                            href="{{ route('restaurant.workers') }}">
                            <i class="icofont-users-alt-1"></i> Usuarios
                        </a>
                    </li>
                    <li>
                        <a class="{{ $path[0] === 'caja' && $path[1] === 'workers-type' ? 'active' : '' }}"
                            href="{{ route('restaurant.workers_type') }}">
                            <i class="icofont-company"></i> Tipo Usuario
                        </a>
                    </li>
                    <li>
                        <a class="{{ $path[0] === 'caja' && $path[1] === 'tables' ? 'active' : '' }}"
                            href="{{ route('restaurant.tables') }}">
                            <i class="icofont-dining-table"></i> Mesas
                        </a>
                    </li>
                    <li>
                        <a class="{{ $path[0] === 'caja' && $path[1] === 'areas' ? 'active' : '' }}"
                            href="{{ route('restaurant.areas') }}">
                            <i class="icofont-billboard"></i> Áreas
                        </a>
                    </li>
                    <li>
                        <a class="{{ $path[0] === 'caja' && $path[1] === 'status-orden' ? 'active' : '' }}"
                            href="{{ route('restaurant.status_orden') }}">
                            <i class="icofont-read-book"></i> Estados de pedidos
                        </a>
                    </li>
                    <li>
                        <a class="{{ $path[0] === 'caja' && $path[1] === 'status-tables' ? 'active' : '' }}"
                            href="{{ route('restaurant.status_table') }}">
                            <i class="icofont-dining-table"></i> Estados de mesas
                        </a>
                    </li>
                    <li>
                        <a class="{{ $path[0] === 'caja' && $path[1] === 'status-tables' ? 'active' : '' }}"
                            href="{{ route('tenant.items.check_stock') }}">
                            <i class="icofont-search-stock"></i> Verificar Stock
                        </a>
                    </li>

                </ul>
            </li>
        @endif
    </ul>
</div>
