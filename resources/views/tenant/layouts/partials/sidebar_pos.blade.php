@php
$path = explode('/', request()->path());
$path[0] = $path[0] === '' ? 'documents' : $path[0];
$path[1] = array_key_exists(1, $path) > 0 ? $path[1] : '';
$path[2] = array_key_exists(2, $path) > 0 ? $path[2] : '';
@endphp

                <div class="menu-container ">
                    <ul id="menu" class="menu">
                      
                        <li >
                          <h1 style=" color: white; font-size: 300%; font-weight: bold; margin-top: 12px ">MODULO DE CAJA </h1>
                        </li>
                     
                      
                    
                     
                      {{--  
                      <li>
                        <a href="{{ route('restaurant.cash.index') }}" class="{{ $path[0] === 'restaurant' && $path[1] === 'worker' && $path[2] === 'cash' ? 'active' : '' }}">
                            <i class="icofont-pay icon-parent"></i>
                          <span class="label">Apertura - Cierre de Caja</span>
                        </a>
                      </li>  --}}
                        {{-- <li>
                            <a href="{{ route('restaurant.documents.index') }}" class="{{ $path[0] === 'restaurant' && $path[1] === 'documents'  ? 'active' : '' }}">
                                <i class="icofont-file-alt icon-parent"></i>
                              <span class="label">Comprobantes Emitidas</span>
                            </a>
                        </li>
                        <li>
                            <a class="{{ $path[0] === 'sale-notes' ? 'active' : '' }}"
                                href="{{ route('pos.sale_notes.index') }}">
                                <i class="icofont-document-folder"></i>
                                <span class="label">
                                    Nota de Venta
                                </span>
                            </a>
                        </li> --}}
                        {{-- <li>
                            <a href="{{ route('restaurant.ordens') }}" class="{{ $path[0] === 'restaurant' && $path[1] === 'ordens'  ? 'active' : '' }}">
                                <i class="icofont-alarm icon-parent"></i>
                              <span class="label">Comandas Realizadas </span>
                            </a>
                        </li> --}}
                            {{-- <li>
                                <a href="{{ route('restaurant.incomes.index') }}" class="{{ $path[0] === 'restaurant' && $path[1] === 'worker' && $path[2] === 'incomes' ? 'active' : '' }}">
                                  <i class="icofont-money icon-parent"></i>
                                  <span class="label">Registro de Ingresos</span>
                                </a>

                            <li>
                              <a href="{{ route('restaurant.expenses.index') }}" class="{{ $path[0] === 'restaurant' && $path[1] === 'worker' && $path[2] === 'expenses' ? 'active' : '' }}">
                                <i class="icofont-spreadsheet icon-parent"></i>
                                <span class="label">Registro de Gastos</span>
                              </a>
                            </li> --}}
                            {{-- <li>
                                <a  href="{{ route('restaurant.report.boxes') }}" class="{{ $path[0] === 'restaurant' && $path[1] === 'report-boxes' ? 'active' : '' }}">
                                    <i class="icofont-data icon-parent"></i>
                                  <span class="label"> Reporte Arqueo de Caja</span>
                                </a>
                            </li> --}}
                    </ul>

                
            </div>
