{{-- MENU LOGISTICO --}}
@php
    $path = explode('/', request()->path());
    $path[1] = array_key_exists(1, $path) > 0 ? $path[1] : '';
    $path[2] = array_key_exists(2, $path) > 0 ? $path[2] : '';
    $path[0] = $path[0] === '' ? 'documents' : $path[0];
    $user = auth()->user();
    $cash = \App\Models\Tenant\Cash::where('state', 1)
        ->where('user_id', auth()->user()->id)
        ->get()
        ->last();
    $config = \App\Models\Tenant\Configuration::first();
    $has_series = (bool) \Modules\Item\Models\ItemLot::count();
    $has_lotes = (bool) \Modules\Item\Models\ItemLotsGroup::count();
    $many_establishments = \App\Models\Tenant\Establishment::count() > 1;
    $noIsArcaProduct = $user->getUserTypeArca() !== 'product';
@endphp

<div class="menu-container flex-grow-1" style="margin-top:20px; ">
    <ul id="menu" class="menu">
        @inject('roleService', 'App\Services\RoleService')

        @if (!$roleService->isAccountant($user->worker_type_id))

            @if (!$roleService->isLogistic())
                <li>
                    <a class="{{ $path[0] === 'Dashboard' ? 'active' : '' }}" href="{{ route('tenant.dashboard.index') }}"
                        data-role="button"
                        aria-expanded="{{ $path[0] === 'persons' && $path[1] === 'customers' ? true : false }}{{ $path[0] === 'brands' ? true : false }}{{ $path[0] === 'category' ? true : false }}{{ $path[0] === 'item-sets' ? true : false }} {{ $path[0] === 'caja' && $path[1] === 'workers' ? true : false }}  {{ $path[0] === 'caja' && $path[1] === 'workers-type' ? true : false }}{{ $path[0] === 'caja' && $path[1] === 'areas' ? true : false }}{{ $path[0] === 'caja' && $path[1] === 'tables' ? true : false }}{{ $path[0] === 'caja' && $path[1] === 'status-orden' ? true : false }}{{ $path[0] === 'caja' && $path[1] === 'status-tables' ? true : false }}"
                        class="{{ $path[0] === 'persons' && $path[1] === 'customers' ? 'active' : '' }} {{ $path[0] === 'brands' ? 'active' : '' }}{{ $path[0] === 'category' ? 'active' : '' }}{{ $path[0] === 'item-sets' ? 'active' : '' }}{{ $path[0] === 'caja' && $path[1] === 'workers' ? 'active' : '' }} {{ $path[0] === 'caja' && $path[1] === 'workers-type' ? 'active' : '' }}{{ $path[0] === 'caja' && $path[1] === 'areas' ? 'active' : '' }}{{ $path[0] === 'caja' && $path[1] === 'tables' ? 'active' : '' }}{{ $path[0] === 'caja' && $path[1] === 'status-orden' ? 'active' : '' }}{{ $path[0] === 'caja' && $path[1] === 'status-tables' ? 'active' : '' }}"
                        data-clicked="{{ $path[0] === 'persons' && $path[1] === 'customers' ? true : false }}{{ $path[0] === 'brands' ? true : false }}{{ $path[0] === 'category' ? true : false }}{{ $path[0] === 'item-sets' ? true : false }} {{ $path[0] === 'caja' && $path[1] === 'workers' ? true : false }} {{ $path[0] === 'caja' && $path[1] === 'workers-type' ? true : false }}{{ $path[0] === 'caja' && $path[1] === 'areas' ? true : false }}{{ $path[0] === 'caja' && $path[1] === 'tables' ? true : false }}{{ $path[0] === 'caja' && $path[1] === 'status-orden' ? true : false }}{{ $path[0] === 'caja' && $path[1] === 'status-tables' ? true : false }}">
                        <i class="icofont-dashboard" style="font-size: 5em; color: #ffffff;"></i>
                        {{-- <span class="label" style="font-size: 1em; font-family: 'Arial', sans-serif; color: #007bff;">Dashboard</span> --}}
                    </a>
                </li>
            @endif

            {{-- Boton de Mantenimiento --}}
            <li class="">

                <a href="#restaurantComponents" data-bs-toggle="collapse" data-role="button"
                    aria-expanded="{{ $path[0] === 'persons' && $path[1] === 'customers' ? true : false }}{{ $path[0] === 'brands' ? true : false }}{{ $path[0] === 'category' ? true : false }}{{ $path[0] === 'item-sets' ? true : false }} {{ $path[0] === 'caja' && $path[1] === 'workers' ? true : false }}  {{ $path[0] === 'caja' && $path[1] === 'workers-type' ? true : false }}{{ $path[0] === 'caja' && $path[1] === 'areas' ? true : false }}{{ $path[0] === 'caja' && $path[1] === 'tables' ? true : false }}{{ $path[0] === 'caja' && $path[1] === 'status-orden' ? true : false }}{{ $path[0] === 'caja' && $path[1] === 'status-tables' ? true : false }}"
                    class="{{ $path[0] === 'persons' && $path[1] === 'customers' ? 'active' : '' }} {{ $path[0] === 'brands' ? 'active' : '' }}{{ $path[0] === 'category' ? 'active' : '' }}{{ $path[0] === 'item-sets' ? 'active' : '' }}{{ $path[0] === 'caja' && $path[1] === 'workers' ? 'active' : '' }} {{ $path[0] === 'caja' && $path[1] === 'workers-type' ? 'active' : '' }}{{ $path[0] === 'caja' && $path[1] === 'areas' ? 'active' : '' }}{{ $path[0] === 'caja' && $path[1] === 'tables' ? 'active' : '' }}{{ $path[0] === 'caja' && $path[1] === 'status-orden' ? 'active' : '' }}{{ $path[0] === 'caja' && $path[1] === 'status-tables' ? 'active' : '' }}"
                    data-clicked="{{ $path[0] === 'persons' && $path[1] === 'customers' ? true : false }}{{ $path[0] === 'brands' ? true : false }}{{ $path[0] === 'category' ? true : false }}{{ $path[0] === 'item-sets' ? true : false }} {{ $path[0] === 'caja' && $path[1] === 'workers' ? true : false }} {{ $path[0] === 'caja' && $path[1] === 'workers-type' ? true : false }}{{ $path[0] === 'caja' && $path[1] === 'areas' ? true : false }}{{ $path[0] === 'caja' && $path[1] === 'tables' ? true : false }}{{ $path[0] === 'caja' && $path[1] === 'status-orden' ? true : false }}{{ $path[0] === 'caja' && $path[1] === 'status-tables' ? true : false }}">
                    <i class="icofont-tools" style="font-size: 2em; color: #ffffff; margin-right: 10px;"></i>
                    <span class="label d-none d-lg-inline" style="font-size: 1em; color: #ffffff;">Mantenimiento</span>
                </a>
                <ul id="restaurantComponents" class="collapse ">
                    {{-- Penalidades para Créditos --}}
                    @if ($config->sale_note_credit_penalty && !$roleService->isLogistic())
                        <li>
                            <a class="{{ $path[0] === 'sale-notes' && $path[1] === 'penalties' ? 'active' : '' }}"
                                href="{{ route('tenant.sale_note_credit_penalty.index') }}">
                                <i class="icofont-users-alt-1" style="font-size: 1.5em;  margin-right: 10px;"></i>
                                <span style="font-size: 1em; ">Penalidades - Notas de Venta
                                    Crédito</span>
                            </a>
                        </li>
                    @endif

                    {{-- Usuarios --}}
                    @if ($config->users_views && !$roleService->isLogistic())
                        <li>
                            <a class="{{ $path[0] === 'caja' && $path[1] === 'workers' ? 'active' : '' }}"
                                href="{{ route('restaurant.workers') }}">
                                <i class="icofont-users-alt-1" style="font-size: 1.5em; margin-right: 10px;"></i>
                                <span>Usuarios</span>
                            </a>
                        </li>
                    @endif

                    {{-- Clientes --}}
                    @if ($user->type == 'superadmin' || ($config->clientes && !$roleService->isLogistic()))
                        <li>
                            <a class="{{ $path[0] === 'persons' && $path[1] === 'customers' ? 'active' : '' }}"
                                href="{{ route('tenant.persons.index', ['type' => 'customers']) }}">
                                <i class="icofont-business-man" style="font-size: 1.5em; margin-right: 10px;"></i>
                                <span>Clientes</span>
                            </a>
                        </li>
                    @endif

                    {{-- Proveedores --}}
                    @if ($user->type == 'superadmin' || ($config->provedores && $noIsArcaProduct))
                        <li>
                            <a class="{{ $path[0] === 'persons' && $path[1] === 'suppliers' ? 'active' : '' }}"
                                href="{{ route('tenant.persons.index', ['type' => 'suppliers']) }}">
                                <i class="icofont-business-man" style="font-size: 1.5em; margin-right: 10px;"></i>
                                <span style="font-size: 1em;">Proveedores</span>
                            </a>
                        </li>
                    @endif

                    {{-- Vendedores --}}
                    @if ($user->type == 'superadmin' || ($config->vendedores && !$roleService->isLogistic()))
                        <li>
                            <a class="{{ $path[0] === 'sellers' && $path[1] === '' ? 'active' : '' }}"
                                href="{{ route('tenant.sellers.index') }}">
                                <i class="icofont-id-card" style="font-size: 1.5em; margin-right: 10px;"></i>
                                <span style="font-size: 1em;">Vendedores</span>
                            </a>
                        </li>
                    @endif

                    <li>
                        <hr style="border: 1px solid #021427;">
                    </li>

                    {{-- Cuentas Bancarias --}}
                    @if ($user->type == 'superadmin' || ($config->cuentas_bancarias && !$roleService->isLogistic()))
                        <li>
                            <a class="{{ $path[0] === 'bank_accounts' && $path[1] === '' ? 'active' : '' }}"
                                href="{{ route('tenant.bank_accounts.index') }}">
                                <i class="icofont-bank" style="font-size: 1.5em;  margin-right: 10px;"></i>
                                <span style="font-size: 1em;">Cuentas Bancarias</span>
                            </a>
                        </li>
                    @endif

                    {{-- Bancos --}}
                    @if ($user->type == 'superadmin' || ($config->bancos && !$roleService->isLogistic()))
                        <li>
                            <a class="{{ $path[0] === 'banks' && $path[1] === '' ? 'active' : '' }}"
                                href="{{ route('tenant.banks.index') }}">
                                <i class="icofont-bank-alt" style="font-size: 1.5em; margin-right: 10px;"></i>
                                <span style="font-size: 1em;">Bancos</span>
                            </a>
                        </li>
                        <li>
                            <hr style="border: 1px solid #021427;">
                        </li>
                    @endif


                    {{-- Productos en Logística y Colegio --}}
                    @if ($config->college && !$roleService->isLogistic())
                        <li>
                            <a class="{{ $path[0] === 'items' && $path[1] === '' ? 'active' : '' }}"
                                href="{{ route('tenant.items.index') }}">
                                <i class="icofont-soft-drinks" style="font-size: 1.5em; margin-right: 10px;"></i>
                                <span style="font-size: 1em;">Productos</span>
                            </a>
                        </li>
                    @endif


                    {{-- Categorías Principales --}}
                    @if ($config->health_network && !$roleService->isLogistic() && $noIsArcaProduct)
                        <li>
                            <a class="{{ $path[0] === 'principal_categories' ? 'active' : '' }}"
                                href="{{ route('tenant.principal_categories.index') }}">
                                <i class="fas fa-layer-group" style="font-size: 1.5em; margin-right: 10px;"></i>
                                <span style="font-size: 1em;">Categorías Principales</span>
                            </a>
                        </li>
                    @endif

                    {{-- Categorías --}}
                    @if ($user->type == 'superadmin' || $config->categorias)
                        <li>
                            <a class="{{ $path[0] === 'category' ? 'active' : '' }}"
                                href="{{ route('tenant.categories.index') }}">
                                <i class="icofont-chart-flow" style="font-size: 1.5em; margin-right: 10px;"></i>
                                <span style="font-size: 1em;">Categorías</span>
                            </a>
                        </li>
                    @endif

                    {{-- Marcas --}}
                    @if ($user->type == 'superadmin' || $config->marca)
                        <li>
                            <a class="{{ $path[0] === 'brands' ? 'active' : '' }}"
                                href="{{ route('tenant.brands.index') }}">
                                <i class="icofont-xing" style="font-size: 1.5em;  margin-right: 10px;"></i>
                                <span style="font-size: 1em; ">Marcas</span>
                            </a>
                        </li>
                    @endif

                    {{-- Atributos --}}
                    @if ($user->type == 'superadmin' || $config->atributos)
                        <li>
                            <a class="{{ $path[0] === 'attribute_types' && $path[1] === '' ? 'active' : '' }}"
                                href="{{ route('tenant.attribute_types.index') }}">
                                <i class="fa fa-newspaper" style="font-size: 1.5em;  margin-right: 10px;"></i>
                                <span style="font-size: 1em; ">Atributos</span>
                            </a>
                        </li>
                    @endif

                    {{-- Unidades de Medida --}}
                    @if ($user->type == 'superadmin' || $config->unidad_medida)
                        <li>
                            <a class="{{ $path[0] === 'Unit_types' && $path[1] === '' ? 'active' : '' }}"
                                href="{{ route('tenant.unit_types.index') }}">
                                <i class="fa fa-solid fa-ruler" style="font-size: 1.5em;  margin-right: 10px;"></i>
                                <span style="font-size: 1em; ">Unidades de Medida</span>
                            </a>
                        </li>
                    @endif

                    {{-- Tipo de Transacciones --}}
                    @if ($config->tipo_transacciones_inventario)
                        <li>
                            <a class="{{ $path[0] === 'transactions' ? 'active' : '' }}"
                                href="{{ route('transactions.index') }}">
                                <i class="icofont-exchange" style="font-size: 1.5em;  margin-right: 10px;"></i>
                                <span class="label" style="font-size: 1em; ">Tipo de
                                    transacciones - Inventario</span>
                            </a>
                        </li>
                    @endif
                    <li>
                        <a class="{{ $path[0] === 'transport' && $path[1] === '' ? 'active' : '' }}"
                            href="{{ route('tenant.transport.index') }}">
                            <i class="fa fa-solid fa-ruler" style="font-size: 1.5em;  margin-right: 10px;"></i>
                            <span style="font-size: 1em; ">Transporte Vehiculos</span>
                        </a>
                    </li>
                    <li>
                        <a class="{{ $path[0] === 'driver' && $path[1] === '' ? 'active' : '' }}"
                            href="{{ route('tenant.driver.index') }}">
                            <i class="fa fa-solid fa-ruler" style="font-size: 1.5em;  margin-right: 10px;"></i>
                            <span style="font-size: 1em; ">Conductores</span>
                        </a>
                    </li>

                </ul>
            </li>

            @if (
                $user->type == 'superadmin' ||
                    ((!$roleService->isArca() || ($user->is_arca && $config->lista_compras)) && $config->lista_compras))
                <li>
                    <a href="#compras" data-bs-toggle="collapse" data-role="button"
                        aria-expanded="{{ $path[0] === 'purchases' ? true : false }}{{ $path[0] === 'purchases' && $path[1] === 'create' ? true : false }}"
                        class="{{ $path[0] === 'purchases' ? 'active' : '' }}{{ $path[0] === 'purchases' && $path[1] === 'create' ? 'active' : '' }}"
                        data-clicked="{{ $path[0] === 'purchases' ? true : false }}{{ $path[0] === 'purchases' && $path[1] === 'create' ? true : false }}">
                        <i class="icofont-shopping-cart"
                            style="font-size: 2em; color: #ffffff; margin-right: 10px;"></i>
                        <span style="font-size: 1em; color: #ffffff;">Compras</span>
                    </a>
                    <ul id="compras" class="collapse ">
                        <li>
                            <a class="{{ $path[0] === 'purchases' && $path[1] === '' ? 'active' : '' }}"
                                href="{{ route('tenant.purchases.index') }}">
                                <i class="icofont-list" style="font-size: 1.5em;  margin-right: 10px;"></i>
                                <span style="font-size: 1em; ">Lista de Compras</span>
                            </a>
                        </li>
                        <li>
                            <a class="{{ $path[0] === 'purchases' && $path[1] === 'create' ? 'active' : '' }}"
                                href="{{ route('tenant.purchases.create') }}">
                                <i class="icofont-credit-card" style="font-size: 1.5em;  margin-right: 10px;"></i>
                                <span style="font-size: 1em; ">Nueva Compras</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endif

            {{-- Inventario y Producos --}}
            <li>
                <a href="#invetories" data-bs-toggle="collapse" data-role="button"
                    aria-expanded="{{ $path[0] === 'invetories' ? true : false }}{{ $path[0] === 'invetories' && $path[1] === 'create' ? true : false }}{{ $path[0] === 'items' ? true : false }}"
                    class="{{ $path[0] === 'invetories' ? 'active' : '' }}{{ $path[0] === 'invetories' && $path[1] === 'create' ? 'active' : '' }}{{ $path[0] === 'items' ? 'active' : '' }}"
                    data-clicked="{{ $path[0] === 'invetories' ? true : false }}{{ $path[0] === 'invetories' && $path[1] === 'create' ? true : false }}{{ $path[0] === 'items' ? true : false }}">
                    <i class="icofont-box" style="font-size: 2em; color: #ffffff; margin-right: 10px;"></i>
                    <span class="label" style="font-size: 1em; color: #ffffff;">Inventario</span>
                </a>
                <ul id="invetories" class="collapse ">
                    @if ($user->type == 'superadmin' || $config->listado_productos)
                        <li>
                            <a class="{{ $path[0] === 'items' && $path[1] === '' ? 'active' : '' }}"
                                href="{{ route('tenant.items.index') }}">
                                <i class="icofont-listing-box" style="font-size: 1.5em;  margin-right: 10px;"></i>
                                <span class="label" style="font-size: 1em; ">Productos</span>
                            </a>
                        </li>
                    @endif

                    {{-- Crear Poductos Compuestos --}}
                    @if ($config->promocion_oferta)
                        <li>
                            <a class="{{ $path[0] === 'item-sets' && $path[1] === '' ? 'active' : '' }}"
                                href="{{ route('tenant.item_sets.index') }}">
                                <i class="icofont-gift" style="font-size: 1.5em;  margin-right: 10px;"></i>
                                <span class="label" style="font-size: 1em; ">Productos
                                    Compuestos</span>
                            </a>
                        </li>
                    @endif

                    {{-- Ingreso y Salida de Productos --}}
                    @if ($config->ingreso_salida_productos)
                        <li>
                            <a class="{{ $path[0] === 'tenant' && $path[1] === 'productos' ? 'active' : '' }}"
                                href="{{ route('tenant.productos.index') }}">
                                <i class="icofont-inbox" style="font-size: 1.5em;  margin-right: 10px;"></i>
                                <span class="label" style="font-size: 1em; ">Ingreso y Salida de
                                    Productos</span>
                            </a>
                        </li>
                    @endif

                    {{-- Transforamción de Productos --}}
                    @if (!$roleService->isArca())
                        @if ($user->type == 'superadmin' || $config->transform_item)
                            <li>
                                <a class="{{ $path[0] === 'manufactured' && $path[1] === '' ? 'active' : '' }}"
                                    href="{{ route('tenant.manufactured.index') }}">
                                    <i class="icofont-exchange" style="font-size: 1.5em;  margin-right: 10px;"></i>
                                    <span class="label" style="font-size: 1em; ">Transformación de
                                        Productos</span>
                                </a>
                            </li>
                        @endif

                    @endif
                    <li>
                        <hr style="border: 1px solid #021427;">
                    </li>

                    {{-- Guías de Remisión --}}
                    @if ($user->type == 'superadmin' || $config->guias_remision)
                        <li>
                            <a class="{{ $path[0] === 'transfers_place' && $path[1] === '' ? 'active' : '' }}"
                                href="{{ route('tenant.dispatches.index') }}">
                                <i class="icofont-file-document" style="font-size: 1.5em;  margin-right: 10px;"></i>
                                <span class="label" style="font-size: 1em; ">Guías de
                                    Remisión</span>
                            </a>
                        </li>
                        <li>
                            <hr style="border: 1px solid #021427;">
                        </li>
                    @endif



                    {{-- Traslados --}}
                    @if ($user->type == 'superadmin' || $config->receive_merchandise)
                        {{-- <li>
                            <a class="{{ $path[0] === 'transfers' && $path[1] === '' ? 'active' : '' }}"
                                href="{{ route('transfers.index') }}">
                                <i class="icofont-truck-loaded" style="font-size: 1.5em;  margin-right: 10px;"></i>
                                <span class="label" style="font-size: 1em; ">Traslados</span>
                            </a>
                        </li> --}}
                        <li>
                            <a class="{{ $path[0] === 'transfers_place' && $path[1] === '' ? 'active' : '' }}"
                                href="{{ route('transfers_place.index') }}">
                                <i class="icofont-truck" style="font-size: 1.5em;  margin-right: 10px;"></i>
                                <span class="label" style="font-size: 1em; ">Traslados
                                </span>
                            </a>
                        </li>
                    @endif

                    {{-- <li>
                        <hr style="border: 1px solid #021427;">
                        <span class="label" style="font-size: 1em;  font-weight: bold;">FUNCIONES ESPECIALES</span>
                    </li> --}}

                    @if (!$roleService->isArca())
                        @if (
                            $user->type == 'superadmin' ||
                                ($config->ver_etiqueta_logistica &&
                                    $config->warranty_product &&
                                    $has_series &&
                                    $config->series_enabled &&
                                    $config->lots_enabled &&
                                    $config->color_size_enabled))
                            <li>
                                <hr style="border: 1px solid #021427;">
                                <span class="label" style="font-size: 1em;  font-weight: bold;">FUNCIONES
                                    ESPECIALES</span>
                            </li>
                        @endif

                        {{-- Tratamiento Comercial --}}
                        @if (
                            $config->commercial_treatments ||
                                ($config->commercial_treatment_items && !$roleService->isLogistic() && $noIsArcaProduct))
                            <li>
                                <a class="{{ $path[0] === 'bank_accounts' && $path[1] === '' ? 'active' : '' }}"
                                    href="{{ route('tenant.commercial_treatment.index') }}">
                                    <i class="fas fa-layer-group" style="font-size: 1.5em; margin-right: 10px;"></i>
                                    <span style="font-size: 1em;">Tratamiento Comercial</span>
                                </a>
                            </li>
                        @endif

                        {{-- Productos con Garantía --}}
                        @if ($config->warranty_product)
                            <li>
                                <a class="{{ $path[0] === 'warranty' && $path[1] === '' ? 'active' : '' }}"
                                    href="{{ route('tenant.warranty.index') }}">
                                    <i class="icofont-shield" style="font-size: 1.5em;  margin-right: 10px;"></i>
                                    <span class="label" style="font-size: 1em; ">Productos Con
                                        Garantía</span>
                                </a>
                            </li>
                        @endif
                        {{-- Serie de Productos --}}
                        @if ($user->type == 'superadmin' || ($has_series && $config->series_enabled))
                            <li>
                                <a class="{{ $path[0] === 'itemlots' && $path[1] === '' ? 'active' : '' }}"
                                    href="{{ route('itemlots') }}">
                                    <i class="icofont-barcode" style="font-size: 1.5em;  margin-right: 10px;"></i>
                                    <span class="label" style="font-size: 1em; ">Series de
                                        Productos</span>
                                </a>
                            </li>
                        @endif
                        {{-- Lotes de Productos --}}
                        @if ($user->type == 'superadmin' || $config->lots_enabled)
                            <li>
                                <a class="{{ $path[0] === 'lotes' && $path[1] === '' ? 'active' : '' }}"
                                    href="{{ route('lotes') }}">
                                    <i class="icofont-box" style="font-size: 1.5em;  margin-right: 10px;"></i>
                                    <span class="label" style="font-size: 1em; ">Lotes de
                                        Productos</span>
                                </a>
                            </li>
                        @endif
                        {{-- Tallas y Colores --}}
                        @if ($config->color_size_enabled)
                            <li>
                                <a class="{{ $path[0] === 'item-color-size' ? 'active' : '' }}"
                                    href="{{ route('tenant.item_color_size.index') }}">
                                    <i class="icofont-paint" style="font-size: 1.5em;  margin-right: 10px;"></i>
                                    <span class="label" style="font-size: 1em; ">Color &
                                        Tallas</span>
                                </a>
                            </li>
                        @endif
                        {{-- Promociones por puntos y por precios --}}
                        @if ($user->type == 'superadmin' || $config->is_promotion_document || $config->promotions_by_points)
                            <li>
                                <hr style="border: 1px solid #021427;">
                                <span class="label" style="font-size: 1em;  font-weight: bold;">PROMOCIONES</span>
                            </li>
                            <li>
                                <a href="{{ route('tenant.promotions_document.index') }}">
                                    <i class="icofont-sale-discount"
                                        style="font-size: 1.5em;  margin-right: 10px;"></i>
                                    <span class="label" style="font-size: 1em; ">
                                        @if ($config->is_promotion_document)
                                            Promoción por Documentos
                                        @else
                                            Promoción por Puntos
                                        @endif
                                    </span>
                                </a>
                            </li>
                        @endif

                        @if ($user->type == 'superadmin' || ($config->ver_etiqueta_logistica && $config->catalog))
                            <li>
                                <hr style="border: 1px solid #021427;">
                                <span class="label" style="font-size: 1em;  font-weight: bold;">COMPLEMENTOS</span>
                            </li>
                        @endif



                        {{-- POR HACER --}}
                        {{-- @if ($config->pricing_policy_venta)
                            <li>
                                <a class="{{ $path[0] === 'tenant' && $path[1] === 'productos' ? 'active' : '' }}"
                                    href="{{ route('tenant.productos.index') }}">
                                    <i class="icofont-price"
                                        style="font-size: 1.5em;  margin-right: 10px;"></i>
                                    <span class="label" style="font-size: 1em; ">Listado de Política
                                        de Precios</span>
                                </a>
                            </li>
                        @endif --}}

                        {{-- Crear Catalogos de venta --}}
                        @if ($config->catalog)
                            <li>
                                <a class="{{ $path[0] === 'catalog' ? 'active' : '' }}"
                                    href="{{ route('tenant.catalog.index') }}">
                                    <i class="icofont-book" style="font-size: 1.5em;  margin-right: 10px;"></i>
                                    <span class="label" style="font-size: 1em; ">Crear
                                        Catálogo</span>
                                </a>
                            </li>
                        @endif

                        {{-- Crear Etiquetas --}}
                        @if ($user->type == 'superadmin' || $config->ver_etiqueta_logistica)
                            <li>
                                <a class="{{ $path[0] === 'etiqueta' ? 'active' : '' }}"
                                    href="{{ route('etiquetas.index') }}">
                                    <i class="icofont-label" style="font-size: 1.5em;  margin-right: 10px;"></i>
                                    <span class="label" style="font-size: 1em; ">Etiquetas</span>
                                </a>
                            </li>
                        @endif
                        @if ($user->type == 'superadmin' || $config->unique_code_unit_types)
                            <li>
                                <a class="{{ $path[0] === 'codes' ? 'active' : '' }}"
                                    href="{{ route('codes.index') }}">
                                    <i class="icofont-label" style="font-size: 1.5em;  margin-right: 10px;"></i>
                                    <span class="label" style="font-size: 1em; ">Etiqueta con Códigos familia</span>
                                </a>
                            </li>
                        @endif
                    @endif
                </ul>
            </li>
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
                        <a class="{{ $path[0] === 'consigment' && $path[1] != 'create' && $path[1] != 'not-sent' ? 'active' : '' }}" href="{{ route('tenant.consignment.index') }}">
                            <i class="icofont-list"></i> Listado
                        </a>
                    </li>
                </ul>
        </li> --}}

        {{-- Comprobante de Pagos Electrónicos --}}
        @if (!$roleService->isLogistic())
            <li>
                <a href="#documents" data-bs-toggle="collapse" data-role="button"
                    aria-expanded="{{ $path[0] === 'documents' ? true : false }}{{ $path[0] === 'summaries' ? true : false }}{{ $path[0] === 'voided' ? true : false }}{{ $path[0] === 'sale-notes' ? true : false }}{{ $path[0] === 'brands' ? true : false }}{{ $path[0] === 'order-notes' ? true : false }}"
                    class="{{ $path[0] === 'documents' ? 'active' : '' }}{{ $path[0] === 'summaries' ? 'active' : '' }}{{ $path[0] === 'voided' ? 'active' : '' }}{{ $path[0] === 'sale-notes' ? 'active' : '' }}{{ $path[0] === 'brands' ? 'active' : '' }}{{ $path[0] === 'order-notes' ? 'active' : '' }}"
                    data-clicked="{{ $path[0] === 'documents' ? true : false }}{{ $path[0] === 'items' ? true : false }}{{ $path[0] === 'persons' && $path[1] === 'customers' ? true : false }}{{ $path[0] === 'summaries' ? true : false }}{{ $path[0] === 'voided' ? true : false }}{{ $path[0] === 'sale-notes' ? true : false }}{{ $path[0] === 'brands' ? true : false }}{{ $path[0] === 'order-notes' ? true : false }}">
                    <i class="icofont-file-document" style="font-size: 2em; color: #ffffff; margin-right: 10px;"></i>
                    <span class="label" style="font-size: 1em; color: #ffffff;">C P E</span>
                </a>
                <ul id="documents" class="collapse ">
                    @if (!$roleService->isInterno() && !$roleService->documentsDisabled())
                        <li>
                            <span class="label" style="font-size: 0.9em;  font-weight: bold;">COMPROBANTES
                                ELECTRÓNICOS</span>
                        </li>
                        {{-- Nuevo Comprobante --}}
                        {{-- @if (!$roleService->isAccountant($user->worker_type_id) && !$roleService->isArca())
                            <li>
                                <a class="{{ $path[0] === 'documents' && $path[1] === 'create' ? 'active' : '' }}"
                                    href="{{ route('tenant.documents.create') }}">
                                    <i class="icofont-document-folder"
                                        style="font-size: 1.5em;  margin-right: 10px;"></i>
                                    <span style="font-size: 1em; ">Nuevo comprobante</span>
                                </a>
                            </li>
                        @endif --}}



                        {{-- Boletas y Facturas --}}
                        @if ($user->type == 'superadmin' || $config->listado_boleta_factura_nuevo)
                            <li>
                                <a class="{{ $path[0] === 'documents' && $path[1] != 'create' && $path[1] != 'not-sent' ? 'active' : '' }}"
                                    href="{{ route('tenant.documents.index') }}">
                                    <i class="icofont-list" style="font-size: 1.5em;  margin-right: 10px;"></i>
                                    <span style="font-size: 1em; ">Boletas y Facturas</span>
                                </a>
                            </li>
                        @endif
                    @endif

                    {{-- Notas de venta --}}
                    @if (!$roleService->isAccountant($user->worker_type_id) && $config->nota_venta)
                        <li>
                            <a class="{{ $path[0] === 'sale-notes' ? 'active' : '' }}"
                                href="{{ route('tenant.sale_notes.index') }}">
                                <i class="icofont-document-folder" style="font-size: 1.5em;  margin-right: 10px;"></i>
                                <span style="font-size: 1em; ">Nota de Venta</span>
                            </a>
                        </li>
                    @endif

                    {{-- Notas de Crédito/Débito de otro facturador --}}
                    @if ($user->type == 'superadmin' || $config->nota_credito)
                        <li>
                            <a class="{{ $path[0] === 'documents' && $path[1] == 'note_other' ? 'active' : '' }}"
                                href="{{ route('tenant.documents.note_other') }}">
                                <i class="icofont-document-folder" style="font-size: 1.5em;  margin-right: 10px;"></i>
                                <span style="font-size: 1em; ">Nota Crédito/Débito - Otros</span>
                            </a>
                        </li>
                    @endif

                    {{-- Cotizaciones --}}
                    @if (!$roleService->isAccountant($user->worker_type_id) && $config->cotizaciones)
                        <li>
                            <a class="{{ $path[0] === 'quotations' ? 'active' : '' }}"
                                href="{{ route('tenant.quotations.index') }}">
                                <i class="icofont-dollar" style="font-size: 1.5em;  margin-right: 10px;"></i>
                                <span style="font-size: 1em; ">Cotizaciones</span>
                            </a>
                        </li>
                    @endif

                    @if (!$roleService->isInterno() && !$roleService->documentsDisabled())

                        <li>
                            <hr style="border: 1px solid #021427;">
                            <span class="label" style="font-size: 1em;  font-weight: bold;">PROCESOS SUNAT</span>
                        </li>

                        {{-- Detracciones --}}
                        @if ($user->type == 'superadmin' || $config->detraction)
                            <li>
                                <a class="{{ $path[0] === 'documents_detraction' ? 'active' : '' }}"
                                    href="{{ route('tenant.detractions.index') }}">
                                    <i class="icofont-list" style="font-size: 1.5em;  margin-right: 10px;"></i>
                                    <span style="font-size: 1em; ">Detracciones</span>
                                </a>
                            </li>
                        @endif

                        {{-- No enviados a Sunat --}}
                        @if ($user->type == 'superadmin' || $config->no_enviados)
                            <li>
                                <a class="{{ $path[0] === 'documents' && $path[1] === 'not-sent' ? 'active' : '' }}"
                                    href="{{ route('tenant.documents.not_sent') }}">
                                    <i class="icofont-send-mail" style="font-size: 1.5em;  margin-right: 10px;"></i>
                                    <span style="font-size: 1em; ">No Enviados Sunat</span>
                                </a>
                            </li>
                        @endif
                    @endif


                    @if (!$roleService->isInterno() && !$roleService->documentsDisabled())

                        {{-- Resumenes de las boletas --}}
                        @if ($user->type == 'superadmin' || $config->resumenes)
                            <li>
                                <a class="{{ $path[0] === 'summaries' ? 'active' : '' }}"
                                    href="{{ route('tenant.summaries.index') }}">
                                    <i class="icofont-prescription"
                                        style="font-size: 1.5em;  margin-right: 10px;"></i>
                                    <span style="font-size: 1em; ">Resumenes Sunat</span>
                                </a>
                            </li>
                        @endif

                        {{-- Anulaciones de Boletas --}}
                        @if ($user->type == 'superadmin' || $config->anulaciones)
                            <li>
                                <a class="{{ $path[0] === 'voided' ? 'active' : '' }}"
                                    href="{{ route('tenant.voided.index') }}">
                                    <i class="icofont-delete-alt" style="font-size: 1.5em;  margin-right: 10px;"></i>
                                    <span style="font-size: 1em; ">Anulados Sunat</span>
                                </a>
                            </li>
                        @endif
                    @endif
                </ul>
            </li>
        @endif

        {{-- Arqueo de Caja --}}
        @if (!$roleService->isAccountant($user->worker_type_id) && !$roleService->isLogistic() && $noIsArcaProduct)
            <li>
                <a href="#boxes" data-bs-toggle="collapse" data-role="button"
                    aria-expanded="{{ $path[0] === 'caja' && $path[1] === 'boxes' ? true : false }}"
                    class="{{ $path[0] === 'caja' && $path[1] === 'boxes' ? 'active' : '' }}"
                    data-clicked="{{ $path[0] === 'caja' && $path[1] === 'boxes' ? true : false }}">
                    <i class="icofont-file-alt" style="font-size: 2em; color: #ffffff; margin-right: 10px;"></i>
                    <span class="label" style="font-size: 1em; color: #ffffff;">Arqueo de Caja</span>
                </a>
                <ul id="boxes" class="collapse ">
                    @if ($roleService->isArca() || $user->is_arca)
                        @if ($config->hotels)
                            <li>
                                <a class="{{ $path[0] === 'rooms' && $path[1] === 'reports' ? 'active' : '' }}"
                                    href="{{ route('hotels.reports.rooms') }}">
                                    <i class="icofont-hotel" style="font-size: 1.5em;  margin-right: 10px;"></i>
                                    <span class="label" style="font-size: 1em; ">Reporte de Habitaciones</span>
                                </a>
                            </li>
                        @endif
                        <li>
                            <a href="/cash/main_cash"
                                class="{{ $path[0] === 'cash' && $path[1] == 'main_cash' ? 'active' : '' }}">
                                <i class="icofont-bank" style="font-size: 1.5em;  margin-right: 10px;"></i>
                                <span class="label" style="font-size: 1em; ">Caja Principal</span>
                            </a>
                        </li>
                        @if ($user->type == 'superadmin' || $config->credit_list)
                            <li>
                                <a class="{{ $path[0] === 'reports' && $path[1] === 'credit_list' ? 'active' : '' }}"
                                    href="{{ route('tenant.credit_list.index') }}">
                                    <i class="icofont-list" style="font-size: 1.5em;  margin-right: 10px;"></i>
                                    <span class="label" style="font-size: 1em; ">Lista de Créditos</span>
                                </a>
                            </li>
                        @endif

                        <li>
                            <hr style="border: 1px solid #021427;">
                        </li>

                    @endif

                    <li>
                        @if ($cash)
                            <a href="/incomes" class="{{ $path[0] === 'incomes' ? 'active' : '' }}">
                                <i class="icofont-money" style="font-size: 1.5em;  margin-right: 10px;"></i>
                                <span class="label" style="font-size: 1em; ">Ingresos</span>
                            </a>
                        @else
                            <a href="/report_closed_cash">
                                <i class="icofont-money" style="font-size: 1.5em;  margin-right: 10px;"></i>
                                <span class="label text-danger" style="font-size: 1em; color: #f80303;">
                                    Ingresos - Abrir Caja
                                </span>
                            </a>
                        @endif
                    </li>
                    <li>
                        @if ($cash)
                            <a href="/expenses" class="{{ $path[0] === 'expenses' ? 'active' : '' }}">
                                <i class="icofont-calculator" style="font-size: 1.5em;  margin-right: 10px;"></i>
                                <span class="label" style="font-size: 1em; ">Gastos</span>
                            </a>
                        @else
                            <a href="/report_closed_cash">
                                <i class="icofont-calculator" style="font-size: 1.5em;  margin-right: 10px;"></i>
                                <span class="label text-danger" style="font-size: 1em; color: #ea0d0d;">
                                    Gastos - Abrir Caja
                                </span>
                            </a>
                        @endif
                    <li>
                        <hr style="border: 1px solid #021427;">
                    </li>
            </li>
            @if ($user->type == 'superadmin' || $config->reporte_caja)
                <li>
                    <a class="{{ $path[0] === 'boxes' ? 'active' : '' }}" href="{{ route('boxes') }}">
                        <i class="icofont-file-document" style="font-size: 1.5em;  margin-right: 10px;"></i>
                        <span class="label" style="font-size: 1em; ">Reporte de Caja</span>
                    </a>
                </li>
            @endif
            @if ($user->type == 'superadmin' || $config->reporte_cierre_caja)
                <li>
                    <a class="{{ $path[0] === 'index_report_closed_cash' ? 'active' : '' }}"
                        href="{{ route('reports.cash_closes.index') }}">
                        <i class="icofont-close-circled" style="font-size: 1.5em;  margin-right: 10px;"></i>
                        <span class="label" style="font-size: 1em; ">Reporte de Cierre de Caja</span>
                    </a>
                </li>
            @endif
            {{-- Reporte Globalizado Red de Salud --}}
            @if ($user->type == 'superadmin' || $config->reporte_globalizado)
                <li>
                    <a class="{{ $path[0] === 'index_report_closed_cash' ? 'active' : '' }}"
                        href="{{ route('tenant.reportincomebox.global_index') }}">
                        <i class="icofont-globe" style="font-size: 1.5em;  margin-right: 10px;"></i>
                        <span class="label" style="font-size: 1em; ">Reporte Globalizado</span>
                    </a>
                </li>
            @endif
    </ul>
    </li>
    @endif

    {{-- Reportes --}}

    @if (!$roleService->isArca() || $user->is_arca)
        <li>
            <a href="#reporte" data-bs-toggle="collapse" data-role="button"
                aria-expanded="{{ $path[0] === 'reports' && $path[1] === 'inventory' ? true : false }}{{ ($path[0] === 'reports' && $path[1] === 'stockmin' ? true : false && $path[1] === 'kardex') ? true : false }}"
                class="{{ $path[0] === 'reports' && $path[1] === 'inventory' ? 'active' : '' }}{{ ($path[0] === 'reports' && $path[1] === 'stockmin' ? 'active' : '' && $path[1] === 'kardex') ? true : false }}"
                data-clicked="{{ $path[0] === 'reports' && $path[1] === 'inventory' ? true : false }}{{ ($path[0] === 'reports' && $path[1] === 'stockmin' ? true : false && $path[1] === 'kardex') ? true : false }}">
                <i class="icofont-file-alt" style="font-size: 2em; color: #ffffff; margin-right: 10px;"></i>
                <span class="label" style="font-size: 1em; color: #ffffff;">Reportes</span>
            </a>
            <ul id="reporte" class="collapse" style="max-height: calc(100vh - 200px); overflow-y: auto;">
                <!-- Rest of the menu items remain the same -->
                <!-- Just added max-height and overflow-y to create a scrollable container -->

                {{-- <ul id="contabilidad" class="collapse "> --}}
                @if ($user->type == 'superadmin' || !$roleService->isLogistic())
                    <li>
                        <a class="{{ $path[0] === 'account' && $path[1] === 'format' ? 'active' : '' }}"
                            href="{{ route('tenant.account_exports') }}">
                            <i class="icofont-file-excel"
                                style="font-size: 1.5em; color: #108514; margin-right: 10px;"></i>
                            <span style="font-size: 1em; ">Reporte Contable</span>
                        </a>
                    </li>
                @endif

                <!-- ... rest of the existing menu items ... -->
                @if (!$roleService->isAccountant($user->worker_type_id))
                    @if (
                        $user->type == 'superadmin' ||
                            ($config->reporte_metodos_pago &&
                                $noIsArcaProduct &&
                                !$roleService->isLogistic() &&
                                !$roleService->isAccountant($user->worker_type_id)))
                        <li>
                            <a class="{{ $path[0] === 'reports' && $path[1] === 'methods' ? 'active' : '' }}"
                                href="{{ route('reports.methods.index') }}">
                                <i class="icofont-credit-card" style="font-size: 1.5em;  margin-right: 10px;"></i>
                                <span class="label" style="font-size: 1em; ">Reporte de Métodos de Pago</span>
                            </a>
                        </li>
                    @endif
                    {{-- Reporte de Habitaciones --}}
                    @if ($config->hotels && !$roleService->isLogistic() && !$roleService->isAccountant($user->worker_type_id))
                        <li>
                            <a class="{{ $path[0] === 'rooms' && $path[1] === 'reports' ? 'active' : '' }}"
                                href="{{ route('hotels.reports.rooms') }}">
                                <i class="icofont-hotel" style="font-size: 1.5em;  margin-right: 10px;"></i>
                                <span class="label" style="font-size: 1em; ">Reporte de habitaciones</span>
                            </a>
                        </li>
                    @endif

                    {{-- Reporte Global de Salud --}}
                    @if ($config->health_network && !$roleService->isLogistic() && !$roleService->isAccountant($user->worker_type_id))
                        <li>
                            <a class="{{ $path[0] === 'health-global' ? 'active' : '' }}"
                                href="{{ route('tenant.health_global.index') }}">
                                <i class="icofont-heart-beat" style="font-size: 1.5em;  margin-right: 10px;"></i>
                                <span class="label" style="font-size: 1em; ">Reporte Global de Salud</span>
                            </a>
                        </li>
                    @endif

                    {{-- Reporte de Consinagiones --}}
                    @if ($config->consignment && !$roleService->isLogistic() && !$roleService->isAccountant($user->worker_type_id))
                        <li>
                            <a class="{{ $path[0] === 'reports' && $path[1] === 'consignment' ? 'active' : '' }}"
                                href="{{ route('reports.consignment.index') }}">
                                <i class="icofont-handshake-deal" style="font-size: 1.5em;  margin-right: 10px;"></i>
                                <span class="label" style="font-size: 1em; ">Reporte de Consignaciones</span>
                            </a>
                        </li>
                    @endif

                    {{-- Reporte de Promociones --}}
                    @if (
                        $config->is_promotion_document ||
                            ($config->promotions_by_points && !$roleService->isAccountant($user->worker_type_id)))
                        <li>
                            <a class="{{ $path[0] === 'reports' && $path[1] === 'promotions' ? 'active' : '' }}"
                                href="{{ route('reports.promotions.index') }}">
                                <i class="icofont-sale-discount" style="font-size: 1.5em;  margin-right: 10px;"></i>
                                <span class="label" style="font-size: 1em; ">Reporte Promociones</span>
                            </a>
                        </li>
                    @endif

                    {{-- Reporte de Créditos --}}
                    @if (
                        $user->type == 'superadmin' ||
                            ($config->credits && !$roleService->isLogistic() && !$roleService->isAccountant($user->worker_type_id)))
                        <li>
                            <hr style="border: 1px solid #021427;">
                            <span class="label"
                                style="font-size: 1em;  text-align: center; font-weight: bold;">Créditos</span>
                        </li>
                        <li>
                            <a class="{{ $path[0] === 'reports' && $path[1] === 'credits' ? 'active' : '' }}"
                                href="{{ route('reports.credits.index') }}">
                                <i class="icofont-money-bag" style="font-size: 1.5em;  margin-right: 10px;"></i>
                                <span class="label" style="font-size: 1em; ">Reporte de Créditos</span>
                            </a>
                        </li>
                        @if ($user->type == 'superadmin' || ($config->diary && !$roleService->isLogistic()))
                            <li>
                                <a class="{{ $path[0] === 'reports' && $path[1] === 'credits' && $path[2] === 'daily_credit' ? 'active' : '' }}"
                                    href="{{ route('reports.credits.daily_index') }}">
                                    <i class="icofont-calendar" style="font-size: 1.5em;  margin-right: 10px;"></i>
                                    <span class="label" style="font-size: 1em; ">Reporte Diario - Crédito</span>
                                </a>
                            </li>
                        @endif
                        @if ($user->type == 'superadmin' || ($config->house && !$roleService->isLogistic()))
                            <li>
                                <a class="{{ $path[0] === 'sale-notes' && $path[1] === 'consolidated' ? 'active' : '' }}"
                                    href="{{ route('tenant.sale_notes.consolidated') }}">
                                    <i class="icofont-home" style="font-size: 1.5em;  margin-right: 10px;"></i>
                                    <span class="label" style="font-size: 1em; ">Consolidado de Créditos</span>
                                </a>
                            </li>
                        @endif
                        @if ($user->type == 'superadmin' || $config->house)
                            <li>
                                <a class="{{ $path[0] === 'reports' && $path[1] === 'credits' && $path[2] === 'cash_credit' ? 'active' : '' }}"
                                    href="{{ route('reports.credits.credit_index') }}">
                                    <i class="icofont-cash-on-delivery"
                                        style="font-size: 1.5em;  margin-right: 10px;"></i>
                                    <span class="label" style="font-size: 1em; ">Ganancias Hogar / Efectivo</span>
                                </a>
                            </li>
                        @endif

                    @endif

                    <li>
                        <hr style="border: 1px solid #021427;">
                        <span class="label"
                            style="font-size: 1em;  text-align: center; font-weight: bold;">Productos</span>
                    </li>
                    {{-- Reporte de Ganancias --}}
                    @if (
                        !$roleService->isLogistic() &&
                            !$config->sale_note_credit_confirm &&
                            !$roleService->isLogistic() &&
                            !$roleService->isAccountant($user->worker_type_id))
                        @if ($user->type == 'superadmin' || $config->reporte_ganancias)
                            <li>
                                <a class="{{ $path[0] === 'report_cash' ? 'active' : '' }}"
                                    href="{{ route('reports.cash.index') }}">
                                    <i class="icofont-chart-line" style="font-size: 1.5em;  margin-right: 10px;"></i>
                                    <span class="label" style="font-size: 1em; ">Reporte de Ganancias</span>
                                </a>
                            </li>
                        @endif
                    @endif

                    <li>
                        <a class="{{ $path[0] === 'report_cash_document' ? 'active' : '' }}"
                            href="{{ route('reports.cash.report_exportable') }}">
                            <i class="icofont-chart-line" style="font-size: 1.5em;  margin-right: 10px;"></i>
                            <span class="label" style="font-size: 1em; ">Reporte de Ganancias Exportable</span>
                        </a>
                    </li>

                    {{-- Reporte Stock Valorizado de Productos --}}
                    @if ($user->type == 'superadmin' || ($config->stock_valorizado && !$roleService->isLogistic()))
                        <li>
                            <a class="{{ $path[0] === 'reports' && $path[1] === 'valued' ? 'active' : '' }}"
                                href="{{ route('reports.valued.index') }}">
                                <i class="icofont-dollar" style="font-size: 1.5em;  margin-right: 10px;"></i>
                                <span class="label" style="font-size: 1em; ">Stock Valorizado de Productos</span>
                            </a>
                        </li>
                    @endif

                    @if ($user->type == 'superadmin' || $config->reporte_productos)
                        <li>
                            <a class="{{ $path[0] === 'report_product_client' ? 'active' : '' }}"
                                href="{{ route('reports.products-clients.index') }}">
                                <i class="icofont-users" style="font-size: 1.5em;  margin-right: 10px;"></i>
                                <span class="label" style="font-size: 1em; ">Reporte de Productos x Clientes</span>
                            </a>
                        </li>
                    @endif
                    @if ($user->type == 'superadmin' || $config->stock_minino)
                        <li>
                            <a class="{{ $path[0] === 'reports' && $path[1] === 'stockmin' ? 'active' : '' }}"
                                href="{{ route('reports.stockmin.index') }}">
                                <i class="icofont-box" style="font-size: 1.5em;  margin-right: 10px;"></i>
                                <span class="label" style="font-size: 1em; ">Stock Minimo</span>
                            </a>
                        </li>
                    @endif
                    @if ($config->stock_producto)
                        <li>
                            <a class="{{ $path[0] === 'reports' && $path[1] === 'inventory' ? 'active' : '' }}"
                                href="{{ route('reports.inventory.index') }}">
                                <i class="icofont-box" style="font-size: 1.5em;  margin-right: 10px;"></i>
                                <span class="label" style="font-size: 1em; ">Stock de Producto</span>
                            </a>
                        </li>
                    @endif
                    @if ($user->type == 'superadmin' || ($config->kardex && $noIsArcaProduct))
                        <li>
                            <a class="{{ $path[0] === 'reports' && $path[1] === 'kardex' ? 'active' : '' }}"
                                href="{{ route('reports.kardex.index') }}">
                                <i class="icofont-chart-bar-graph" style="font-size: 1.5em;  margin-right: 10px;"></i>
                                <span class="label" style="font-size: 1em; ">Kardex</span>
                            </a>
                        </li>
                    @endif
                    {{-- Reporte de productos por serie --}}
                    @if ($user->type == 'superadmin' || ($has_series && $config->reporte_series_vendidas))
                        <li>
                            <a class="{{ $path[0] === 'reports' && $path[1] === 'series' ? 'active' : '' }}"
                                href="{{ route('reports.series.index') }}">
                                <i class="icofont-barcode" style="font-size: 1.5em;  margin-right: 10px;"></i>
                                <span class="label" style="font-size: 1em; ">Venta de Series</span>
                            </a>
                        </li>
                    @endif
                    {{-- Reporte de productos Madera --}}
                    @if ($config->maderera && !$roleService->isLogistic())
                        <li>
                            <a class="{{ $path[0] === 'madera' ? 'active' : '' }}"
                                href="{{ route('tenant.madera.index') }}">
                                <i class="icofont-tree" style="font-size: 1.5em;  margin-right: 10px;"></i>
                                <span class="label" style="font-size: 1em; ">Reporte de Madera</span>
                            </a>
                        </li>
                    @endif

                    {{-- Reporte Lista de Crédito REVISAR --}}
                    @if ($config->credit_list && !$roleService->isLogistic())
                        <li>
                            <a class="{{ $path[0] === 'reports' && $path[1] === 'credit_list' ? 'active' : '' }}"
                                href="{{ route('tenant.credit_list.index') }}">
                                <i class="icofont-list" style="font-size: 1.5em;  margin-right: 10px;"></i>
                                <span class="label" style="font-size: 1em; ">Lista de crédito</span>
                            </a>
                        </li>
                    @endif

                    <li>
                        <hr style="border: 1px solid #021427;">
                        <span class="label"
                            style="font-size: 1em;  text-align: center; font-weight: bold;">Comprobantes</span>
                    </li>

                    @if ($user->type == 'superadmin' || ($config->productos_vendidos && !$roleService->isLogistic()))
                        <li>
                            <a class="{{ $path[0] === 'documents_ventas' ? 'active' : '' }}"
                                href="{{ route('tenant.ventas.index') }}">
                                <i class="icofont-list" style="font-size: 1.5em;  margin-right: 10px;"></i>
                                <span class="label" style="font-size: 1em; ">Productos Vendidos Boletas Y
                                    Facturas</span>
                            </a>
                        </li>
                    @endif
                    @if ($user->type == 'superadmin' || ($config->sale_note_venta && !$roleService->isLogistic()))
                        <li>
                            <a class="{{ $path[0] === 'notaventa' ? 'active' : '' }}"
                                href="{{ route('tenant.notaventa.index') }}">
                                <i class="icofont-list" style="font-size: 1.5em;  margin-right: 10px;"></i>
                                <span class="label" style="font-size: 1em; ">Productos Vendidos Nota de Venta</span>
                            </a>
                        </li>
                    @endif
                    @if ($config->purchases_sales)
                        <li>
                            <a class="{{ $path[0] === 'purchases' ? 'active' : '' }}"
                                href="{{ route('tenant.shopping.index') }}">
                                <i class="icofont-shopping-cart" style="font-size: 1.5em;  margin-right: 10px;"></i>
                                <span class="label" style="font-size: 1em; ">Productos Comprados</span>
                            </a>
                        </li>
                    @endif
                    @if ($config->dishes_sold)
                        <li>
                            <a class="{{ $path[0] === 'foods' ? 'active' : '' }}"
                                href="{{ route('tenant.foods.index') }}">
                                <i class="icofont-shopping-cart" style="font-size: 1.5em;  margin-right: 10px;"></i>
                                <span class="label" style="font-size: 1em; ">Reporte Platos Vendidos</span>
                            </a>
                        </li>
                    @endif
                @endif

            </ul>
        </li>

    @endif

    {{-- MODO de Créditos  --}}
    @if ($config->credits && $user->is_arca)
        <li>
            <a href="#compras" data-bs-toggle="collapse" data-role="button"
                aria-expanded="{{ $path[0] === 'purchases' ? true : false }}{{ $path[0] === 'purchases' && $path[1] === 'create' ? true : false }}"
                class="{{ $path[0] === 'purchases' ? 'active' : '' }}{{ $path[0] === 'purchases' && $path[1] === 'create' ? 'active' : '' }}"
                data-clicked="{{ $path[0] === 'purchases' ? true : false }}{{ $path[0] === 'purchases' && $path[1] === 'create' ? true : false }}">
                <i class="icofont-shopping-cart" style="font-size: 2em; color: #ffffff; margin-right: 10px;"></i>
                <span class="label" style="font-size: 1em; color: #ffffff;">Cartera Presupuestaria</span>
            </a>

            <ul id="compras" class="collapse ">
                <li>
                    <a class="{{ $path[0] === 'purchases' && $path[1] === '' ? 'active' : '' }}"
                        href="{{ route('caja.cash_transfer') }}">
                        <i class="icofont-list" style="font-size: 1.5em;  margin-right: 10px;"></i>
                        <span style="font-size: 1em; ">Traslados (Desembolso de Efectivo S/)</span>
                    </a>
                </li>
                <li>
                    <a class="{{ $path[0] === 'purchases' && $path[1] === 'create' ? 'active' : '' }}"
                        href="{{ route('caja.cash_transfer_report') }}">
                        <i class="icofont-credit-card" style="font-size: 1.5em;  margin-right: 10px;"></i>
                        <span style="font-size: 1em; "> Reporte de Traslados</span>

                    </a>
                </li>

            </ul>
        </li>
    @endif

    {{-- Contabilidad --}}
    {{-- @if (!$roleService->isArca() && !$roleService->isLogistic() && $config->accounting_mode)
            <li>
                <a href="#contabilidad" data-bs-toggle="collapse" data-role="button"
                    aria-expanded="{{ $path[0] === 'account' ? true : false }}"
                    class="{{ $path[0] === 'account' ? 'active' : '' }}"
                    data-clicked="{{ $path[0] === 'account' ? true : false }}">
                    <i class="icofont-calculator-alt-2" style="font-size: 2em; color: #ffffff; margin-right: 10px;"></i>
                    <span class="label" style="font-size: 1em; color: #ffffff;">Contabilidad</span>
                </a>

                <ul id="contabilidad" class="collapse ">
                    <li>
                        <a class="{{ $path[0] === 'account' && $path[1] === 'format' ? 'active' : '' }}"
                            href="{{ route('tenant.account_exports') }}">
                            <i class="icofont-file-excel"  style="font-size: 2em; color: #108514; margin-right: 10px;"></i> 
                            <span style="font-size: 1em; ">Exportar formatos</span>
                        </a>
                    </li>
                </ul>
            </li>
        @endif --}}

    {{-- Colegios --}}
    @if ($config->college)
        <li>
            <a href="#college" data-bs-toggle="collapse" data-role="button"
                aria-expanded="{{ $path[0] === 'college' && $path[1] == 'students' ? true : false }}{{ $path[0] === 'college' && $path[1] == 'classrooms' ? true : false }}{{ $path[0] === 'college' && $path[1] == 'persons' ? true : false }}{{ $path[0] === 'college' && $path[1] == 'plans' ? true : false }}{{ $path[0] === 'college' && $path[1] == 'periods' ? true : false }}{{ $path[0] === 'college' && $path[1] == 'penalties' ? true : false }}{{ $path[0] === 'college' && $path[1] == 'levels' ? true : false }}{{ $path[0] === 'college' && $path[1] == 'listsuplies' ? true : false }}"
                class="{{ $path[0] === 'college' && $path[1] == 'students' ? 'active' : '' }}{{ $path[0] === 'college' && $path[1] == 'classrooms' ? 'active' : '' }}{{ $path[0] === 'college' && $path[1] == 'persons' ? 'active' : '' }}{{ $path[0] === 'college' && $path[1] == 'plans' ? 'active' : '' }}{{ $path[0] === 'college' && $path[1] == 'periods' ? 'active' : '' }}{{ $path[0] === 'college' && $path[1] == 'penalties' ? 'active' : '' }}{{ $path[0] === 'college' && $path[1] == 'levels' ? 'active' : '' }}{{ $path[0] === 'college' && $path[1] == 'listsuplies' ? 'active' : '' }}"
                data-clicked="{{ $path[0] === 'college' && $path[1] == 'students' ? true : false }}{{ $path[0] === 'college' && $path[1] == 'classrooms' ? true : false }}{{ $path[0] === 'college' && $path[1] == 'persons' ? true : false }}{{ $path[0] === 'college' && $path[1] == 'plans' ? true : false }}{{ $path[0] === 'college' && $path[1] == 'periods' ? true : false }}{{ $path[0] === 'college' && $path[1] == 'penalties' ? true : false }}{{ $path[0] === 'college' && $path[1] == 'levels' ? true : false }}{{ $path[0] === 'college' && $path[1] == 'listsuplies' ? true : false }}">
                <i class="icofont-graduate" style="font-size: 2em; color: #ffffff; margin-right: 10px;"></i>
                <span class="label" style="font-size: 1em; color: #ffffff;">Suscripción Escolar</span>
            </a>

            <ul id="college" class="collapse">
                <li>
                    <a class="{{ $path[0] === 'college' && $path[1] === 'students' ? 'active' : '' }}"
                        href="{{ route('college.students.index') }}">
                        <i class="icofont-people" style="font-size: 1.5em;  margin-right: 10px;"></i>
                        <span style="font-size: 1em; ">Estudiantes</span>
                    </a>
                </li>
                <li>
                    <a class="{{ $path[0] === 'college' && $path[1] === 'classrooms' ? 'active' : '' }}"
                        href="{{ route('college.classrooms.index') }}">
                        <i class="icofont-black-board" style="font-size: 1.5em;  margin-right: 10px;"></i>
                        <span style="font-size: 1em; ">Salones</span>
                    </a>
                </li>
                <li>
                    <a class="{{ $path[0] === 'college' && $path[1] === 'persons' ? 'active' : '' }}"
                        href="{{ route('college.persons.index') }}">
                        <i class="icofont-group-students" style="font-size: 1.5em;  margin-right: 10px;"></i>
                        <span style="font-size: 1em; ">Padres/Hijos</span>
                    </a>
                </li>
                <li>
                    <a class="{{ $path[0] === 'college' && $path[1] === 'plans' ? 'active' : '' }}"
                        href="{{ route('college.plans.index') }}">
                        <i class="icofont-files-stack" style="font-size: 1.5em;  margin-right: 10px;"></i>
                        <span style="font-size: 1em; ">Planes</span>
                    </a>
                </li>
                <li>
                    <a class="{{ $path[0] === 'college' && $path[1] === 'periods' ? 'active' : '' }}"
                        href="{{ route('college.periods.index') }}">
                        <i class="icofont-ui-timer" style="font-size: 1.5em;  margin-right: 10px;"></i>
                        <span style="font-size: 1em; ">Periodos</span>
                    </a>
                </li>
                <li>
                    <a class="{{ $path[0] === 'college' && $path[1] === 'penalties' ? 'active' : '' }}"
                        href="{{ route('college.penalties.index') }}">
                        <i class="icofont-exclamation-tringle" style="font-size: 1.5em;  margin-right: 10px;"></i>
                        <span style="font-size: 1em; ">Penalidades</span>
                    </a>
                </li>
                <li>
                    <a class="{{ $path[0] === 'college' && $path[1] === 'levels' ? 'active' : '' }}"
                        href="{{ route('college.levels.index') }}">
                        <i class="icofont-certificate-alt-1" style="font-size: 1.5em;  margin-right: 10px;"></i>
                        <span style="font-size: 1em; ">Niveles/Grados/Secciones/Turnos</span>
                    </a>
                </li>
                <li>
                    <a class="{{ $path[0] === 'college' && $path[1] === 'listsuplies' ? 'active' : '' }}"
                        href="{{ route('college.listsuplies.index') }}">
                        <i class="fa fa-pencil-ruler" style="font-size: 1.5em;  margin-right: 10px;"></i>
                        <span style="font-size: 1em; ">Almacén de Utiles</span>
                    </a>
                </li>
            </ul>

        </li>
    @endif
    {{-- Internet --}}
    @if ($config->internet)
        <li>
            <a href="#internetUl" data-bs-toggle="collapse" data-role="button"
                aria-expanded="{{ $path[0] === 'tasks' ? true : false }} "
                class="{{ $path[0] === 'tasks' ? 'active' : '' }}"
                data-clicked="{{ $path[0] === 'tasks' ? true : false }}">
                <i class="icofont-wifi-router" style="font-size: 2em; color: #ffffff; margin-right: 10px;"></i>
                <span class="label" style="font-size: 1em; color: #ffffff;">Internet</span>
            </a>

            <ul id="internetUl" class="collapse ">
                <li>
                    <a class="{{ $path[0] === 'internet' && $path[1] === 'planes' ? 'active' : '' }}"
                        href="{{ route('tenant.internet.planes') }}">
                        <i class="icofont-wifi" style="font-size: 1.5em;  margin-right: 10px;"></i>
                        <span style="font-size: 1em; ">Planes / Conceptos</span>
                    </a>
                </li>
                <li>
                    <a class="{{ $path[0] === 'internet' && $path[1] === 'workersadmin' ? 'active' : '' }}"
                        href="{{ route('tenant.internet.workersadmin') }}">
                        <i class="icofont-worker" style="font-size: 1.5em;  margin-right: 10px;"></i>
                        <span style="font-size: 1em; ">Trabajadores</span>
                    </a>
                </li>
            </ul>
        </li>
    @endif

    {{-- Restaurant --}}
    @if ($config->restaurant && !$roleService->isAccountant($user->worker_type_id))

        <li>
            <a href="#restaurantUl" data-bs-toggle="collapse" data-role="button"
                aria-expanded="{{ $path[0] === 'tasks' ? true : false }} "
                class="{{ $path[0] === 'tasks' ? 'active' : '' }}"
                data-clicked="{{ $path[0] === 'tasks' ? true : false }}">
                <i class="icofont-restaurant" style="font-size: 2em; color: #ffffff; margin-right: 10px;"></i>
                <span class="label" style="font-size: 1em; color: #ffffff;">Restaurante</span>
            </a>

            <ul id="restaurantUl" class="collapse">
                @if ($config->restaurant && !$roleService->isLogistic())
                    <li>
                        <a class="{{ $path[0] === 'caja' && $path[1] === 'tables' ? 'active' : '' }}"
                            href="{{ route('restaurant.tables') }}">
                            <i class="icofont-dining-table" style="font-size: 1.5em;  margin-right: 10px;"></i>
                            <span style="font-size: 1em; ">Mesas</span>
                        </a>
                    </li>
                    <li>
                        <a class="{{ $path[0] === 'caja' && $path[1] === 'status-orden' ? 'active' : '' }}"
                            href="{{ route('restaurant.status_orden') }}">
                            <i class="icofont-read-book" style="font-size: 1.5em;  margin-right: 10px;"></i>
                            <span style="font-size: 1em; ">Estados de pedidos</span>
                        </a>
                    </li>
                    <li>
                        <a class="{{ $path[0] === 'caja' && $path[1] === 'status-tables' ? 'active' : '' }}"
                            href="{{ route('restaurant.status_table') }}">
                            <i class="icofont-ui-settings" style="font-size: 1.5em;  margin-right: 10px;"></i>
                            <span style="font-size: 1em; ">Estados de mesas</span>
                        </a>
                    </li>
                    <li>
                        <a class="{{ $path[0] === 'caja' && $path[1] === 'observations' ? 'active' : '' }}"
                            href="{{ route('restaurant.observations') }}">
                            <i class="icofont-comment" style="font-size: 1.5em;  margin-right: 10px;"></i>
                            <span style="font-size: 1em; ">Observaciones</span>
                        </a>
                    </li>
                @endif
                <li>
                    <a class="{{ $path[0] === 'receta' && $path[1] === '' ? 'active' : '' }}"
                        href="{{ route('tenant.receta.index') }}">
                        <i class="icofont-book" style="font-size: 1.5em;  margin-right: 10px;"></i>
                        <span style="font-size: 1em; ">Receta</span>
                    </a>
                </li>
                @if ($config->restaurant && !$roleService->isLogistic())
                    <li>
                        <a class="{{ $path[0] === 'mozo' && $path[1] === '' ? 'active' : '' }}"
                            href="{{ route('tenant.mozo.index') }}">
                            <i class="icofont-waiter" style="font-size: 1.5em;  margin-right: 10px;"></i>
                            <span style="font-size: 1em; ">Mozo vendedores</span>
                        </a>
                    </li>
                @endif
            </ul>
        </li>
    @endif


    {{-- Hotel --}}
    @if (
        ($config->hotels || $config->mod_renta) &&
            !$roleService->isLogistic() &&
            !$roleService->isAccountant($user->worker_type_id))
        <li>
            <a href="#hotelUl" data-bs-toggle="collapse" data-role="button"
                aria-expanded="{{ $path[0] === 'tasks' ? true : false }} "
                class="{{ $path[0] === 'tasks' ? 'active' : '' }}"
                data-clicked="{{ $path[0] === 'tasks' ? true : false }}">
                <i class="icofont-hotel" style="font-size: 2em; color: #ffffff; margin-right: 10px;"></i>
                <span class="label" style="font-size: 1em; color: #ffffff;">
                    {{ $config->mod_renta ? 'Renta' : 'Hotel' }}
                </span>
            </a>
            <ul id="hotelUl" class="collapse">
                <li>
                    <a class="{{ $path[0] === 'caja' && $path[1] === 'rooms' ? 'active' : '' }}"
                        href="{{ route('restaurant.rooms') }}">
                        <i class="fas fa-bed" style="font-size: 1.5em;  margin-right: 10px;"></i>
                        <span style="font-size: 1em; ">Habitaciones</span>


                    </a>
                </li>
            </ul>
        </li>
    @endif

    {{-- Billar --}}
    @if ($config->modo_billar && !$roleService->isLogistic())
        <li>
            <a href="#billarUl" data-bs-toggle="collapse" data-role="button"
                aria-expanded="{{ $path[0] === 'tasks' ? true : false }} "
                class="{{ $path[0] === 'tasks' ? 'active' : '' }}"
                data-clicked="{{ $path[0] === 'tasks' ? true : false }}">
                <i class="icofont-billiard-ball" style="font-size: 2em; color: #ffffff; margin-right: 10px;"></i>
                <span class="label" style="font-size: 1em; color: #ffffff;">Billar/Casino</span>
            </a>
            <ul id="billar" class="collapse">
                <li>
                    <a class="{{ $path[0] === 'billar' && $path[1] === 'billar' ? 'active' : '' }}"
                        href="{{ route('billar.billar') }}">
                        <i class="icofont-billiard-ball" style="font-size: 1.5em;  margin-right: 10px;"></i>
                        <span style="font-size: 1em; ">Mesas Billar</span>
                    </a>
                </li>
                <li>
                    <a class="{{ $path[0] === 'billar' && $path[1] === 'tarifa' ? 'active' : '' }}"
                        href="{{ route('tenant.billar.tarifa') }}">
                        <i class="icofont-price" style="font-size: 1.5em;  margin-right: 10px;"></i>
                        <span style="font-size: 1em; ">Tarifas Por Tiempo</span>
                    </a>
                </li>
            </ul>
        </li>
    @endif

    {{-- Taller Mecánico --}}
    @if ($config->workshop && !$roleService->isLogistic())
        <li>
            <a href="#workshopUl" data-bs-toggle="collapse" data-role="button"
                aria-expanded="{{ $path[0] === 'tasks' ? true : false }} "
                class="{{ $path[0] === 'tasks' ? 'active' : '' }}"
                data-clicked="{{ $path[0] === 'tasks' ? true : false }}">
                {{-- <i class="icofont-billiard-ball icon-parent"></i> --}}
                <i class="icofont-tools-alt-2" style="font-size: 2em; color: #ffffff; margin-right: 10px;"></i>
                <span class="label" style="font-size: 1em; color: #ffffff;">Mecánica</span>
            </a>
            <ul id="workshop" class="collapse">
                <li>
                    <a class="{{ $path[0] === 'workshop' && $path[1] === 'workshop' ? 'active' : '' }}"
                        href="{{ route('tenant.workshop.mecanico') }}">
                        <i class="icofont-worker" style="font-size: 1.5em;  margin-right: 10px;"></i>
                        <span style="font-size: 1em; ">Personal Mecánica</span>
                    </a>
                </li>
                <li>
                    <a class="{{ $path[0] === 'workshop' && $path[1] === 'workshop' ? 'active' : '' }}"
                        href="{{ route('tenant.workshop.vehiculo') }}">
                        <i class="icofont-car-alt-1" style="font-size: 1.5em;  margin-right: 10px;"></i>
                        <span style="font-size: 1em; ">Vehiculos</span>
                    </a>
                </li>
                <li>
                    <a class="{{ $path[0] === 'workshop' && $path[1] === 'workshop' ? 'active' : '' }}"
                        href="{{ route('tenant.workshop.tipo') }}">
                        <i class="icofont-car" style="font-size: 1.5em;  margin-right: 10px;"></i>
                        <span style="font-size: 1em; ">Tipos Vehiculos</span>
                    </a>
                </li>
                <li>
                    <a class="{{ $path[0] === 'workshop' && $path[1] === 'workshop' ? 'active' : '' }}"
                        href="{{ route('tenant.workshop.servicesdetails') }}">
                        <i class="icofont-tools" style="font-size: 1.5em;  margin-right: 10px;"></i>
                        <span style="font-size: 1em; ">Servicios Mecanica</span>
                    </a>
                </li>
                <li>
                    <a class="{{ $path[0] === 'workshop' && $path[1] === 'workshop' ? 'active' : '' }}"
                        href="{{ route('tenant.workshop.exportar') }}">
                        <i class="icofont-file-document" style="font-size: 1.5em;  margin-right: 10px;"></i>
                        <span style="font-size: 1em; ">Reporte Mecanica</span>
                    </a>
                </li>
            </ul>
        </li>
    @endif

    {{-- Odontología --}}
    @if ($config->odontologia && !$roleService->isLogistic())
        <li>
            <a href="#dentalUl" data-bs-toggle="collapse" data-role="button"
                aria-expanded="{{ $path[0] === 'tasks' ? true : false }} "
                class="{{ $path[0] === 'tasks' ? 'active' : '' }}"
                data-clicked="{{ $path[0] === 'tasks' ? true : false }}">
                {{-- <i class="icofont-billiard-ball icon-parent"></i> --}}
                <i class="fa fas fa-tooth" style="font-size: 2em; color: #ffffff; margin-right: 10px;"></i>
                <span class="label" style="font-size: 1em; color: #ffffff;">Dental</span>
            </a>
            <ul id="dental" class="collapse">
                <li>
                    <a class="{{ $path[0] === 'dental' && $path[1] === 'dental' ? 'active' : '' }}"
                        href="{{ route('tenant.dental.specialties') }}">
                        <i class="icofont-tooth" style="font-size: 1.5em;  margin-right: 10px;"></i>
                        <span style="font-size: 1em; ">Especialidades</span>
                    </a>
                </li>
                <li>
                    <a class="{{ $path[0] === 'dental' && $path[1] === 'dental' ? 'active' : '' }}"
                        href="{{ route('tenant.dental.tariffs') }}">
                        <i class="icofont-money" style="font-size: 1.5em;  margin-right: 10px;"></i>
                        <span style="font-size: 1em; ">Tarifas</span>
                    </a>
                </li>
                <li>
                    <a class="{{ $path[0] === 'dental' && $path[1] === 'dental' ? 'active' : '' }}"
                        href="{{ route('tenant.dental.medic') }}">
                        <i class="icofont-doctor" style="font-size: 1.5em;  margin-right: 10px;"></i>
                        <span style="font-size: 1em; ">Medicos</span>
                    </a>
                </li>
            </ul>
        </li>
    @endif

    {{-- Configuración --}}
    @if ($user->type == 'superadmin' || ($roleService->isArca() && $config->hotels))

        <li>
            <a href="#configuration" data-bs-toggle="collapse" data-role="button"
                aria-expanded="{{ $path[0] === 'tasks' ? true : false }} {{ $path[0] === 'configurations' && $path[1] === 'pdf_templates' ? true : false }} {{ $path[0] === 'companies' && $path[1] === 'create' ? true : false }}{{ $path[0] === 'catalogs' ? true : false }}{{ $path[0] === 'advanced' ? true : false }}{{ $path[0] === 'pdf_templates' ? true : false }}{{ $path[0] === 'series-configurations' ? true : false }}"
                class="{{ $path[0] === 'tasks' ? 'active' : '' }}{{ $path[0] === 'configurations' && $path[1] === 'pdf_templates' ? 'active' : '' }}{{ $path[0] === 'companies' && $path[1] === 'create' ? 'active' : '' }}{{ $path[0] === 'catalogs' ? 'active' : '' }}{{ $path[0] === 'advanced' ? 'active' : '' }}{{ $path[0] === 'pdf_templates' ? 'active' : '' }}{{ $path[0] === 'series-configurations' ? 'active' : '' }}"
                data-clicked="{{ $path[0] === 'tasks' ? true : false }}{{ $path[0] === 'configurations' && $path[1] === 'pdf_templates' ? true : false }}{{ $path[0] === 'companies' && $path[1] === 'create' ? true : false }}{{ $path[0] === 'catalogs' ? true : false }}{{ $path[0] === 'advanced' ? true : false }}{{ $path[0] === 'pdf_templates' ? true : false }}{{ $path[0] === 'series-configurations' ? true : false }}">
                <i class="icofont-ui-settings" style="font-size: 2em; color: #ffffff; margin-right: 10px;"></i>
                <span class="label" style="font-size: 1em; color: #ffffff;">Configuración</span>
            </a>

            <ul id="configuration" class="collapse ">
                {{-- Configuración de Empresas --}}
                @if (!$roleService->isArca())
                    <li>
                        <a class="{{ $path[0] === 'companies' && $path[1] === 'create' ? 'active' : '' }}"
                            href="{{ route('tenant.companies.create') }}">
                            <i class="icofont-building-alt" style="font-size: 1.5em;  margin-right: 10px;"></i>
                            <span style="font-size: 1em; ">Empresa</span>
                        </a>
                    </li>
                @endif

                {{-- Configuración Avanzada de Negocio --}}
                <li>
                    <a class="{{ $path[0] === 'advanced' ? 'active' : '' }}"
                        href="{{ route('tenant.advanced.index') }}">
                        <i class="icofont-ui-settings" style="font-size: 1.5em;  margin-right: 10px;"></i>
                        <span style="font-size: 1em; ">Personalización Avanzada</span>
                    </a>
                </li>
                {{-- @if ($config->download_all_files) --}}
                @if (!$roleService->isArca())
                    <li>
                        <a class="{{ $path[0] === 'tasks' ? 'active' : '' }}"
                            href="{{ route('tenant.download_files.index') }}">
                            <i class="icofont-download" style="font-size: 1.5em;  margin-right: 10px;"></i>
                            <span style="font-size: 1em; ">Descargar Archivos CPE</span>
                        </a>
                    </li>
                    {{-- @endif --}}

                    <li>
                        <a class="{{ $path[0] === 'tasks' ? 'active' : '' }}"
                            href="{{ route('tenant.tasks.index') }}">
                            <i class="icofont-tasks-alt" style="font-size: 1.5em;  margin-right: 10px;"></i>
                            <span style="font-size: 1em; ">Tareas Programadas SUNAT</span>
                        </a>
                    </li>

                    <li>
                        <a class="{{ $path[1] === 'pdf_templates' ? 'active' : '' }}"
                            href="{{ route('tenant.advanced.pdf_templates') }}">
                            <i class="icofont-file-pdf" style="font-size: 1.5em;  margin-right: 10px;"></i>
                            <span style="font-size: 1em; ">Plantillas CPE</span>
                        </a>
                    </li>

                    <li>
                        <a class="{{ $path[0] === 'series-configurations' ? 'active' : '' }}"
                            href="{{ route('tenant.series_configurations.index') }}">
                            <i class="icofont-numbered" style="font-size: 1.5em;  margin-right: 10px;"></i>
                            <span style="font-size: 1em; ">Numeración Serie de Documentos</span>
                        </a>
                    </li>
                    <li>
                        <a class="{{ $path[0] === 'caja' && $path[1] === 'workers' ? 'active' : '' }}"
                            href="{{ route('restaurant.workers') }}">
                            <i class="icofont-users-alt-1" style="font-size: 1.5em;  margin-right: 10px;"></i>
                            <span style="font-size: 1em; ">Usuarios</span>
                        </a>
                    </li>
                    <li>
                        <a class="{{ $path[0] === 'caja' && $path[1] === 'workers-type' ? 'active' : '' }}"
                            href="{{ route('restaurant.workers_type') }}">
                            <i class="icofont-company" style="font-size: 1.5em;  margin-right: 10px;"></i>
                            <span style="font-size: 1em; ">Tipos de Usuario</span>
                        </a>
                    </li>
                    <li>
                        <a class="{{ $path[0] === 'caja' && $path[1] === 'areas' ? 'active' : '' }}"
                            href="{{ route('restaurant.areas') }}">
                            <i class="icofont-billboard" style="font-size: 1.5em;  margin-right: 10px;"></i>
                            <span style="font-size: 1em; ">Áreas de Trabajo</span>
                        </a>
                    </li>
                    <li>
                        <a class="{{ $path[0] === 'caja' && $path[1] === 'status-tables' ? 'active' : '' }}"
                            href="{{ route('tenant.items.check_stock') }}">
                            <i class="icofont-search-stock" style="font-size: 1.5em;  margin-right: 10px;"></i>
                            <span style="font-size: 1em; ">Herramientas de Prueba</span>
                        </a>
                    </li>
                @endif

            </ul>
        </li>
    @endif
    </ul>
</div>
