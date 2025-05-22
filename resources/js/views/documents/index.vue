<!-- Listado de Comprobante de Pago -->
<template>
    <div>
        <!-- Container-fluid starts-->
        <div class="container-fluid p-l-0 p-r-0">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card mb-0">
                        <div
                            class="card-header bg-primary d-flex align-items-center"
                            style="padding: 15px;"
                        >
                            <h4
                                class="my-0 text-white d-flex align-items-center"
                                style="font-size: 1.5rem; font-weight: bold;"
                            >
                                <i
                                    class="fas fa-file-invoice-dollar"
                                    style="font-size: 2rem; margin-right: 0.5rem;"
                                ></i>
                                Boletas y Facturas
                            </h4>
                        </div>

                        <!-- Botones  del Titulo -->
                        <div class="data-table-visible-columns">
                            <div class="d-flex align-items-center">
                                <el-button
                                    type="button"
                                    class="btn_buscar"
                                    style="margin-right: 5px;"
                                    href="javascript:void(0)"
                                    @click.prevent="clickNuevo()"
                                >
                                    <i
                                        class="fas fa-file-alt fa-lg icon-style"
                                    ></i>
                                    Nuevo CPE
                                </el-button>

                                <el-button
                                    type="button"
                                    class="btn_buscar"
                                    v-if="configuration.health_network"
                                    style="margin-right: 5px;"
                                    @click.prevent="clickDocumentSalud()"
                                >
                                    <i class="fas fa-user-nurse icon-style"></i>
                                    <span>CPE Farmacia</span>
                                </el-button>

                                <el-button
                                    type="button"
                                    class="btn_buscar"
                                    data-bs-offset="0,3"
                                    data-bs-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false"
                                    data-submenu
                                >
                                    <i data-cs-icon="more-horizontal"></i>
                                </el-button>

                                <div class="dropdown-menu dropdown-menu-end">
                                    <button
                                        class="dropdown-item text-primary"
                                        type="button"
                                        @click.prevent="clickResume()"
                                    >
                                        <i class="fas fa-file-alt"></i> Generar
                                        Resumen
                                    </button>
                                    <button
                                        class="dropdown-item text-success"
                                        type="button"
                                        @click.prevent="checkResume()"
                                    >
                                        <i class="fas fa-search"></i> Consultar
                                        Resumen
                                    </button>
                                    <button
                                        class="dropdown-item text-warning"
                                        type="button"
                                        @click.prevent="clickValidate()"
                                    >
                                        <i class="fas fa-check-circle"></i>
                                        Validar CPE
                                    </button>
                                    <button
                                        class="dropdown-item text-info"
                                        type="button"
                                        @click.prevent="
                                            clickDownloadReportPagos('excel')
                                        "
                                    >
                                        <i class="fas fa-file-excel"></i>
                                        Reporte de Pagos (Créditos)
                                    </button>

                                    <!-- POR REVISAR -->
                                    <!-- <button
                                        class="dropdown-item text-danger"
                                        type="button"
                                        @click.prevent="clickImport()"
                                        v-if="import_documents == true"
                                    >
                                        <i class="fas fa-upload"></i> Importar Formato 1
                                    </button>
                                    <button
                                        class="dropdown-item text-secondary"
                                        type="button"
                                        @click.prevent="clickImportSecond()"
                                        v-if="import_documents_second == true"
                                    >
                                        <i class="fas fa-upload"></i> Importar Formato 2
                                    </button> -->
                                </div>
                            </div>
                        </div>

                        <div class="data-table-visible-columns">
                            <el-dropdown
                                v-if="columns.length"
                                :hide-on-click="false"
                            >
                                <el-dropdown-menu slot="dropdown">
                                    <el-dropdown-item
                                        v-for="(column, index) in columns"
                                        :key="index"
                                    >
                                        <el-checkbox v-model="column.visible">{{
                                            column.title
                                        }}</el-checkbox>
                                    </el-dropdown-item>
                                </el-dropdown-menu>
                            </el-dropdown>
                        </div>

                        <div class="card-body">
                            <data-table
                                :resource="resource"
                                class="table-striped"
                            >
                                <tr slot="heading" class="bg-primary rounded">
                                    <th class="text-white rounded-start">#</th>
                                    <th
                                        class="text-white text-left "
                                        v-if="typeUser != 'integrator'"
                                    >
                                        Acciones
                                    </th>
                                    <th
                                        class="text-white"
                                        v-if="columns.user_name.visible"
                                    >
                                        Usuario
                                    </th>
                                    <th class="text-white text-center">
                                        Fecha Emisión
                                    </th>
                                    <th
                                        class="text-white text-center"
                                        v-if="columns.date_of_due.visible"
                                    >
                                        Fecha Vencimiento
                                    </th>
                                    <th class="text-white ">
                                        <span>Cliente / Empresa</span>
                                        <br />
                                        <span>Serie y Némro de CPE </span>
                                    </th>
                                    <!-- <th class="text-white">CPE Número</th> -->
                                    <th
                                        class="text-white text-center"
                                        v-if="columns.sale_note.visible"
                                    >
                                        <span>Nota de</span>
                                        <br />
                                        <span>Venta</span>
                                    </th>
                                    <th
                                        class="text-white"
                                        v-if="columns.dispatch.visible"
                                    >
                                        <span>Guía de</span>
                                        <br />
                                        <span>Remisión</span>
                                    </th>
                                    <th
                                        class="text-white"
                                        v-if="columns.notes.visible"
                                    >
                                        <span>Nota de</span>
                                        <br />
                                        <span>Crédito</span>
                                    </th>
                                    <th class="text-white text-center">
                                        <img
                                            src="status_images/Sunat.png"
                                            alt="Estado Sunat"
                                            style="width:70px; height: 40px; margin-left: 5px;"
                                        />
                                    </th>
                                    <th
                                        class="text-white"
                                        v-if="typeUser == 'superadmin'"
                                    >
                                        Estado Sire
                                    </th>
                                    <th class="text-white text-center">
                                        Moneda
                                    </th>
                                    <th
                                        class="text-white text-left"
                                        v-if="columns.total_exportation.visible"
                                    >
                                        T.Exportación
                                    </th>
                                    <th
                                        class="text-white text-left"
                                        v-if="columns.total_free.visible"
                                    >
                                        T.Gratuita
                                    </th>
                                    <th
                                        class="text-white text-left"
                                        v-if="columns.total_unaffected.visible"
                                    >
                                        T.Inafecta
                                    </th>
                                    <th
                                        class="text-white text-left"
                                        v-if="columns.total_exonerated.visible"
                                    >
                                        T.Exonerado
                                    </th>
                                    <th
                                        class="text-white text-left"
                                        v-if="columns.total_value.visible"
                                    >
                                        T.Gravado
                                    </th>
                                    <th class="text-white text-left">IGV</th>
                                    <th class="text-white text-center">
                                        <span>Saldo</span>
                                        <br />
                                        <span>Pendiente</span>
                                    </th>
                                    <th class="text-white text-left">Total</th>
                                    <th class="text-white text-center">
                                        Estado
                                    </th>
                                    <th
                                        class="text-white text-center rounded-end"
                                        style="text-align: center; font-size: 1.5rem;"
                                    >
                                        <i class="fas fa-download"></i>
                                    </th>
                                </tr>
                                <tr
                                    style="height: 10px; background-color: white;"
                                ></tr>

                                <tr></tr>
                                <tr
                                    slot-scope="{ index, row }"
                                    :class="{
                                        'text-danger':
                                            row.state_type_id === '11',
                                        'border border-secondary':
                                            row.state_type_id === '01',
                                        'border border-warning':
                                            row.state_type_id === '03',
                                        'border border-primary':
                                            row.state_type_id === '05',
                                        'border border-info':
                                            row.state_type_id === '07',
                                        'border border-dark':
                                            row.state_type_id === '09',
                                        'border border-danger':
                                            row.state_type_id === '11',
                                        'border border-warnnig':
                                            row.state_type_id === '13'
                                    }"
                                >
                                    <!-- Index -->
                                    <td
                                        :class="{
                                            'text-dark':
                                                row.state_type_id === '11'
                                        }"
                                    >
                                        {{ index }}
                                    </td>

                                    <!-- Menú de Acciones -->
                                    <td
                                        :class="{
                                            'text-dark':
                                                row.state_type_id === '11'
                                        }"
                                        class="text-left"
                                        v-if="typeUser != 'integrator'"
                                    >
                                        <div
                                            class="dropdown-as-select d-inline-block"
                                            data-childselector="span"
                                        >
                                            <button
                                                class="btn p-0"
                                                type="button"
                                                data-bs-toggle="dropdown"
                                                aria-haspopup="true"
                                                aria-expanded="false"
                                            >
                                                <span
                                                    class="btn btn-primary dropdown-toggle"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-placement="top"
                                                    data-bs-delay="0"
                                                    title=""
                                                    data-bs-original-title="Item Count"
                                                    aria-label="Item Count"
                                                    >Acciones</span
                                                >
                                            </button>
                                            <div
                                                class="dropdown-menu dropdown-menu-end px-3"
                                                style="background-color: #4a4a4a;"
                                            >
                                                <template
                                                    v-if="
                                                        row.state_type_id !=
                                                            '11'
                                                    "
                                                >
                                                    <div
                                                        class="d-flex flex-column gap-2"
                                                    >
                                                        <!-- Anulado Interno -->
                                                        <button
                                                            :disabled="row.deleting || row.isProcessing"
                                                            type="button"
                                                            class="btn btn-info text-white rounded w-100 d-flex align-items-center"
                                                            style="height: 40px;"
                                                            @click.prevent="handleDelete(row)"
                                                            v-if="
                                                            row.state_type_id == '01' &&
                                                                    !isAccountant &&
                                                                    configuration.internal_voided
                                                            "
                                                        >
                                                            <i
                                                                class="fas fa-ban me-2"
                                                            ></i>
                                                            <span
                                                                >Anulado
                                                                Interno</span
                                                            >
                                                        </button>

                                                        <!-- Cambiar a estado registrado -->
                                                        <button
                                                            type="button"
                                                            class="btn btn-warning text-dark rounded w-100 d-flex align-items-center"
                                                            style="height: 40px;"
                                                            @click.prevent="
                                                                clickChangeToRegisteredStatus(
                                                                    row.id
                                                                )
                                                            "
                                                            v-if="
                                                                row.btn_change_to_registered_status
                                                            "
                                                        >
                                                            <i
                                                                class="fas fa-sync-alt me-2"
                                                            ></i>
                                                            <span
                                                                >Cambiar a
                                                                estado
                                                                registrado</span
                                                            >
                                                        </button>

                                                        <!-- Volver a recrear -->
                                                        <button
                                                            type="button"
                                                            class="btn btn-secondary text-white rounded w-100 d-flex align-items-center"
                                                            style="height: 40px;"
                                                            @click.prevent="
                                                                clickReStore(
                                                                    row.id
                                                                )
                                                            "
                                                        >
                                                            <i
                                                                class="fas fa-redo me-2"
                                                            ></i>
                                                            <span
                                                                >Volver a
                                                                Recrear</span
                                                            >
                                                        </button>

                                                        <!-- Anular Sunat -->
                                                        <button
                                                            type="button"
                                                            class="btn btn-danger text-white rounded w-100 d-flex align-items-center"
                                                            style="height: 40px;"
                                                            @click.prevent="
                                                                clickVoided(
                                                                    row.id
                                                                )
                                                            "
                                                            v-if="
                                                                row.btn_voided &&
                                                                    !isAccountant &&
                                                                    configuration.anulate_sunat
                                                            "
                                                        >
                                                            <i
                                                                class="fas fa-times-circle me-2"
                                                            ></i>
                                                            <span
                                                                >Anular
                                                                Sunat</span
                                                            >
                                                        </button>

                                                        <!-- Guia de Remisión -->
                                                        <a
                                                            :href="
                                                                `/dispatches/create_new/document/${row.id}`
                                                            "
                                                            class="btn btn-primary text-white rounded w-100 d-flex align-items-center"
                                                            style="height: 40px;"
                                                            v-if="
                                                                (row.btn_guide &&
                                                                    typeUser ==
                                                                        'admin') ||
                                                                    typeUser ==
                                                                        'superadmin'
                                                            "
                                                        >
                                                            <i
                                                                class="fas fa-truck me-2"
                                                            ></i>
                                                            <span
                                                                >Guía de
                                                                Remisión</span
                                                            >
                                                        </a>

                                                        <!-- Nota de Credito -->
                                                        <a
                                                            type="button"
                                                            :href="
                                                                `/${resource}/note/${row.id}`
                                                            "
                                                            class="btn btn-light text-dark rounded w-100 d-flex align-items-center"
                                                            style="height: 40px; background-color: #d2b48c;"
                                                            v-if="
                                                                row.btn_note &&
                                                                    !isAccountant
                                                            "
                                                        >
                                                            <i
                                                                class="fas fa-sticky-note me-2"
                                                            ></i>
                                                            <span
                                                                >Nota de Crédito
                                                                CPE</span
                                                            >
                                                        </a>

                                                        <!-- Modificar CPE -->
                                                        <button
                                                            type="button"
                                                            class="btn btn-info text-white rounded w-100 d-flex align-items-center" 
                                                            style="height: 40px;"
                                                            @click.prevent="
                                                                clickEdit(
                                                                    row.id
                                                                )
                                                            "
                                                            v-if="
                                                                (row.state_type_id ===
                                                                    '01' ||
                                                                    row.state_type_id ===
                                                                        '14') &&
                                                                    !isAccountant &&
                                                                    !configuration.send_auto
                                                            "
                                                        >
                                                            <i
                                                                class="fas fa-edit me-2"
                                                            ></i>
                                                            <span
                                                                >Modificar
                                                                CPE</span
                                                            >
                                                        </button>

                                                        <!-- Validar CPE -->
                                                        <button
                                                            type="button"
                                                            class="btn btn-warning text-dark rounded w-100 d-flex align-items-center"
                                                            style="height: 40px;"
                                                            v-if="
                                                                !(
                                                                    row.state_type_id ==
                                                                        '13' &&
                                                                    row.document_type_id ==
                                                                        '03'
                                                                )
                                                            "
                                                            @click.prevent="
                                                                clickValidarCpe(
                                                                    row.id
                                                                )
                                                            "
                                                        >
                                                            <i
                                                                class="fas fa-check-circle me-2"
                                                            ></i>
                                                            <span
                                                                >Validar
                                                                CPE</span
                                                            >
                                                        </button>

                                                        <!-- Reenviar CPE -->
                                                        <button
                                                            type="button"
                                                            class="btn btn-primary text-white rounded w-100 d-flex align-items-center"
                                                            style="height: 40px;"
                                                            @click.prevent="
                                                                clickResend(
                                                                    row.id
                                                                )
                                                            "
                                                            v-if="
                                                                row.btn_resend &&
                                                                    !isClient &&
                                                                    row.document_type_id !=
                                                                        '03'
                                                            "
                                                        >
                                                            <i
                                                                class="fas fa-paper-plane me-2"
                                                            ></i>
                                                            <span
                                                                >Reenviar</span
                                                            >
                                                        </button>

                                                        <!-- Enviar Servidor -->
                                                        <button
                                                            type="button"
                                                            class="btn btn-success text-white rounded w-100 d-flex align-items-center"
                                                            style="height: 40px;"
                                                            @click.prevent="
                                                                clickSendOnline(
                                                                    row.id
                                                                )
                                                            "
                                                            v-if="
                                                                isClient &&
                                                                    !row.send_server
                                                            "
                                                        >
                                                            <i
                                                                class="fas fa-server me-2"
                                                            ></i>
                                                            <span
                                                                >Enviar
                                                                Servidor</span
                                                            >
                                                        </button>

                                                        <!-- Consultar Servidor -->
                                                        <button
                                                            type="button"
                                                            class="btn btn-info text-white rounded w-100 d-flex align-items-center"
                                                            style="height: 40px;"
                                                            @click.prevent="
                                                                clickCheckOnline(
                                                                    row.id
                                                                )
                                                            "
                                                            v-if="
                                                                isClient &&
                                                                    row.send_server &&
                                                                    (row.state_type_id ===
                                                                        '01' ||
                                                                        row.state_type_id ===
                                                                            '03')
                                                            "
                                                        >
                                                            <i
                                                                class="fas fa-search me-2"
                                                            ></i>
                                                            <span
                                                                >Consultar
                                                                Servidor</span
                                                            >
                                                        </button>

                                                        <!-- Pagos CPE -->
                                                        <button
                                                            v-if="row.is_credit"
                                                            type="button"
                                                            class="btn btn-secondary text-white rounded w-100 d-flex align-items-center"
                                                            style="height: 40px;"
                                                            @click.prevent="
                                                                clickPayment(
                                                                    row.id
                                                                )
                                                            "
                                                        >
                                                            <i
                                                                class="fas fa-money-bill-wave me-2"
                                                            ></i>
                                                            <span
                                                                >Pagos CPE</span
                                                            >
                                                        </button>
                                                    </div>
                                                </template>

                                                <button
                                                    type="button"
                                                    class="btn btn-success text-white rounded w-100 mt-2 d-flex align-items-center"
                                                    style="height: 40px;"
                                                    @click.prevent="
                                                        clickOptions(
                                                            row.id,
                                                            false
                                                        )
                                                    "
                                                >
                                                    <i
                                                        class="fas fa-print me-2"
                                                    ></i>
                                                    <span>Imprimir</span>
                                                </button>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- <td> 
                                        <el-button 
                                            type="primary" 
                                            @click="clickView(row.id)"
                                         
                                         >
                                            Ver Movimiento
                                        </el-button>
                                    </td> -->
                                    <!-- <td class="text-center">
                                        <div
                                            v-if="
                                                row.last_register &&
                                                    row.last_register.user &&
                                                    row.last_register.ip
                                            "
                                        >
                                            <strong
                                                v-if="
                                                    row.last_register.ip !=
                                                        'SERVIDOR'
                                                "
                                                >Usuario:
                                                {{
                                                    row.last_register.user
                                                }}</strong
                                            >
                                            <strong>SERVIDOR</strong>
                                            <br />
                                            <span class="text-primary">{{
                                                row.last_register.description
                                            }}</span>
                                            <br />
                                            <span
                                                :class="{
                                                    'text-danger':
                                                        row.last_register
                                                            .date_time.is24Hours
                                                }"
                                            >
                                                 {{
                                                    formatDateTime(
                                                        row.last_register
                                                            .date_time
                                                    )
                                                }} -->
                                    <!-- {{
                                                    row.last_register.created_at
                                                }}
                                            </span> -->
                                    <!-- </div>
                                    </td> -->

                                    <!-- Usuario y  Area de trabajo -->
                                    <td
                                        :class="{
                                            'text-dark':
                                                row.state_type_id === '11'
                                        }"
                                        v-if="columns.user_name.visible"
                                    >
                                        <template
                                            v-if="row.user_name.includes(' - ')"
                                        >
                                            <span>{{
                                                row.user_name.split(" - ")[0]
                                            }}</span>
                                            <br />
                                            <span>{{
                                                row.user_name.split(" - ")[1]
                                            }}</span>
                                            <br />
                                            <small class="text-muted">{{
                                                row.establishment_name
                                            }}</small>
                                        </template>
                                        <template v-else>
                                            {{ row.user_name }}
                                            <br />
                                            <small class="text-muted">{{
                                                row.establishment_name
                                            }}</small>
                                        </template>
                                        <br />
                                        <!-- <small v-text="row.user_email"></small> -->
                                    </td>

                                    <!-- Fecha de Emisión -->
                                    <td
                                        class="text-center"
                                        :class="{
                                            'text-dark':
                                                row.state_type_id === '11'
                                        }"
                                    >
                                        {{ row.date_of_issue }}
                                        <br />
                                        {{ row.time_of_issue }}
                                    </td>

                                    <td
                                        class="text-center"
                                        v-if="columns.date_of_due.visible"
                                        :class="{
                                            'text-dark':
                                                row.state_type_id === '11'
                                        }"
                                    >
                                        {{ row.date_of_due }}
                                    </td>

                                    <!-- Ruc/Dni-Cliente-Documento-Numero de documento -->
                                    <td
                                        :class="{
                                            'text-dark':
                                                row.state_type_id === '11'
                                        }"
                                    >
                                        <span
                                            class="font-weight-bold"
                                            style="font-weight: bold; font-size: 0.8rem; background-color: #333; color: #fff; padding: 2px 5px; border-radius: 3px;"
                                            v-text="row.customer_number"
                                        >
                                        </span>
                                        <br />
                                        <template
                                            v-if="row.customer_name.length > 35"
                                        >
                                            {{
                                                row.customer_name.substring(
                                                    0,
                                                    row.customer_name.lastIndexOf(
                                                        " ",
                                                        35
                                                    )
                                                )
                                            }}
                                            <br />
                                            {{
                                                row.customer_name.substring(
                                                    row.customer_name.lastIndexOf(
                                                        " ",
                                                        35
                                                    ) + 1
                                                )
                                            }}
                                        </template>
                                        <template v-else>
                                            {{ row.customer_name }}
                                        </template>
                                        <br />
                                        <div style="margin-bottom: 10px;"></div>
                                        <small
                                            class="badge bg-success"
                                            style="border-radius: 2px; font-size: 0.9rem;"
                                            v-text="
                                                row.document_type_description
                                            "
                                        ></small>
                                        <br />
                                        <span
                                            style="font-weight: bold; color: navy; font-size: 0.9rem;"
                                        >
                                            {{ row.number }}
                                        </span>
                                        <br />
                                        <small
                                            class="badge bg-dark"
                                            style="border-radius: 3px;"
                                            v-if="row.affected_document"
                                            v-text="row.affected_document"
                                        ></small>
                                    </td>
                                    <!-- <td
                                        :class="{
                                            'text-dark':
                                                row.state_type_id === '11'
                                        }"
                                     >
                                        {{ row.number }}<br />
                                        <small
                                            class="badge bg-dark"
                                            v-text="
                                                row.document_type_description
                                            "
                                        ></small
                                        ><br />
                                        <small
                                            class="badge bg-dark"
                                            v-if="row.affected_document"
                                            v-text="row.affected_document"
                                        ></small>
                                    </td> -->

                                    <!-- Vinculación con Notas de Venta -->
                                    <td v-if="columns.sale_note.visible">
                                        <div
                                            v-for="(row,
                                            index) in row.sale_note_related"
                                            :key="index"
                                        >
                                            <small
                                                class="d-block"
                                                style="color: brown; font-weight: bold; font-size: 0.9rem;"
                                            >
                                                {{ row.number }}
                                            </small>
                                        </div>
                                    </td>

                                    <!-- Vinculacion con Guia de Remision -->
                                    <td v-if="columns.dispatch.visible">
                                        <div
                                            v-for="(row,
                                            index) in row.dispatches"
                                            :key="index"
                                        >
                                            <small
                                                class="d-block"
                                                style="color: navy; font-weight: bold; font-size: 0.9rem;"
                                            >
                                                {{ row.description }}
                                            </small>
                                        </div>
                                    </td>
                                    <td
                                        :class="{
                                            'text-dark':
                                                row.state_type_id === '11'
                                        }"
                                        v-if="columns.notes.visible"
                                    >
                                        <div
                                            v-for="(row, index) in row.notes"
                                            :key="index"
                                        >
                                            <label class="d-block"
                                                >{{
                                                    row.note_type_description
                                                }}: {{ row.description }}</label
                                            >
                                        </div>
                                    </td>

                                    <!-- <td>
                                        {{ row.document_type_id == '07' ?  row.number : ''}}
                                    </td> -->

                                    <td class="text-center">
                                        <el-tooltip
                                            v-if="tooltip(row, false)"
                                            class="item"
                                            effect="dark"
                                            placement="bottom"
                                        >
                                            <div slot="content">
                                                {{ tooltip(row) }}
                                            </div>
                                            <span
                                                class="badge"
                                                :class="{
                                                    'bg-danger':
                                                        row.state_type_id ===
                                                        '11',
                                                    'badge bg-warning':
                                                        row.state_type_id ===
                                                        '13',
                                                    'badge bg-dark':
                                                        row.state_type_id ===
                                                        '01',
                                                    'bg-warning':
                                                        row.state_type_id ===
                                                        '03',
                                                    'bg-success':
                                                        row.state_type_id ===
                                                        '05',
                                                    'bg-info':
                                                        row.state_type_id ===
                                                        '07',
                                                    'bg-dark':
                                                        row.state_type_id ===
                                                        '09'
                                                }"
                                                style="font-size: 0.8rem; padding: 5px 10px; border-radius: 3px;"
                                            >
                                                {{ row.state_type_description }}
                                            </span>
                                        </el-tooltip>
                                        <span
                                            v-else
                                            class="badge"
                                            :class="{
                                                'bg-danger':
                                                    row.state_type_id === '11',
                                                'badge bg-warning':
                                                    row.state_type_id === '13',
                                                'badge bg-dark':
                                                    row.state_type_id === '01',
                                                'bg-warning':
                                                    row.state_type_id === '03',
                                                'bg-success':
                                                    row.state_type_id === '05',
                                                'bg-info':
                                                    row.state_type_id === '07',
                                                'bg-dark':
                                                    row.state_type_id === '09'
                                            }"
                                            style="font-size: 0.8rem; padding: 5px 10px; border-radius: 3px;"
                                        >
                                            <template
                                                v-if="row.state_type_id == '11'"
                                            >
                                                <span
                                                    v-if="row.internal_voided"
                                                >
                                                    Anulado Interno
                                                </span>
                                                <span v-else>
                                                    Anulado Sunat</span
                                                >
                                            </template>
                                            <template v-else>
                                                {{ row.state_type_description }}
                                            </template>
                                        </span>
                                        <template
                                            v-if="
                                                row.regularize_shipping &&
                                                    row.state_type_id === '01'
                                            "
                                        >
                                            <el-tooltip
                                                class="item"
                                                effect="dark"
                                                :content="
                                                    row.message_regularize_shipping
                                                "
                                                placement="top-start"
                                            >
                                                <i
                                                    class="fas fa-exclamation-triangle fa-lg"
                                                    style="color: #d2322d !important"
                                                ></i>
                                            </el-tooltip>
                                        </template>
                                    </td>

                                    <td v-if="typeUser == 'superadmin'">
                                        {{ row.state_sunat }}
                                    </td>
                                    <td
                                        :class="{
                                            'text-dark':
                                                row.state_type_id === '11'
                                        }"
                                        class="text-center"
                                    >
                                        {{ row.currency_type_id }}
                                    </td>
                                    <td
                                        :class="{
                                            'text-dark':
                                                row.state_type_id === '11'
                                        }"
                                        class="text-left"
                                        v-if="columns.total_exportation.visible"
                                    >
                                        {{ row.total_exportation }}
                                    </td>

                                    <td
                                        :class="{
                                            'text-dark':
                                                row.state_type_id === '11'
                                        }"
                                        class="text-left"
                                        v-if="columns.total_free.visible"
                                    >
                                        {{ row.total_free }}
                                    </td>

                                    <td
                                        :class="{
                                            'text-dark':
                                                row.state_type_id === '11'
                                        }"
                                        class="text-left"
                                        v-if="columns.total_unaffected.visible"
                                    >
                                        {{ row.total_unaffected }}
                                    </td>

                                    <td
                                        :class="{
                                            'text-dark':
                                                row.state_type_id === '11'
                                        }"
                                        class="text-left"
                                        v-if="columns.total_exonerated.visible"
                                    >
                                        {{ row.total_exonerated }}
                                    </td>
                                    <td
                                        :class="{
                                            'text-dark':
                                                row.state_type_id === '11'
                                        }"
                                        class="text-left"
                                        v-if="columns.total_value.visible"
                                    >
                                        {{ row.total_taxed }}
                                    </td>

                                    <!-- Total IGV -->
                                    <td
                                        :class="{
                                            'text-dark':
                                                row.state_type_id === '11'
                                        }"
                                        class="text-left"
                                    >
                                        {{ row.total_igv }}
                                    </td>
                                    <!-- Saldo Pendiente -->
                                    <td
                                        :class="{
                                            'text-warning text-center':
                                                row.remain > 0,
                                            'text-primary text-center':
                                                row.remain === 0
                                        }"
                                    >
                                        <span>
                                            {{
                                                row.remain > 0
                                                    ? row.remain.toFixed(2)
                                                    : "0.00"
                                            }}
                                        </span>
                                    </td>

                                    <!-- <td v-if="columns.boxes.visible">
                                        <div
                                            class="justify-content-center d-flex flex-column"
                                        >
                                            <el-tag
                                                style="margin-top:5px;"
                                                v-for="(data, idx) in row.boxes"
                                                :key="idx"
                                                type="primary"
                                            >
                                                <b
                                                    >{{ data.method }} S/{{
                                                        data.amount
                                                    }}</b
                                                >
                                            </el-tag>
                                        </div>
                                    </td> -->

                                    <!-- Monto Total CPE -->
                                    <td
                                        :class="{
                                            'text-dark':
                                                row.state_type_id === '11'
                                        }"
                                        class="text-left"
                                    >
                                        {{ row.total }}
                                    </td>

                                    <!-- Estado  del Documento -->
                                    <template>
                                        <td class="text-center">
                                            <span
                                                v-if="row.remain == 0"
                                                class="badge bg-success text-white"
                                                style="font-size: 0.8rem; padding: 5px 10px;"
                                            >
                                                Pagado
                                            </span>
                                            <span
                                                v-else
                                                class="badge bg-warning text-white"
                                                style="font-size: 0.8rem; padding: 5px 10px;"
                                            >
                                                Pendiente
                                            </span>
                                        </td>
                                    </template>

                                    <!-- Descargas  -->
                                    <td
                                        :class="{
                                            'text-dark':
                                                row.state_type_id === '11'
                                        }"
                                        class="text-left"
                                        v-if="typeUser != 'integrator'"
                                    >
                                        <template
                                            v-if="row.state_type_id != '11'"
                                        >
                                            <!-- Descargar Archivos -->
                                            <div class="d-flex flex-column">
                                                <button
                                                    type="button"
                                                    class="btn btn-sm btn-success hover-outline w-100 my-1"
                                                    @click.prevent="
                                                        clickDownload(
                                                            row.download_xml
                                                        )
                                                    "
                                                    v-if="row.has_xml"
                                                >
                                                    <i
                                                        class="fas fa-download"
                                                    ></i>
                                                    XML
                                                </button>
                                                <button
                                                    type="button"
                                                    class="btn btn-sm btn-danger hover-outline w-100 my-1"
                                                    @click.prevent="
                                                        clickDownload(
                                                            row.download_pdf
                                                        )
                                                    "
                                                    v-if="row.has_pdf"
                                                >
                                                    <i
                                                        class="fas fa-download"
                                                    ></i>
                                                    PDF
                                                </button>
                                                <button
                                                    type="button"
                                                    class="btn btn-sm btn-info hover-outline w-100 my-1"
                                                    @click.prevent="
                                                        clickDownload(
                                                            row.download_cdr
                                                        )
                                                    "
                                                    v-if="row.has_cdr"
                                                >
                                                    <i
                                                        class="fas fa-download"
                                                    ></i>
                                                    CDR
                                                </button>
                                            </div>
                                        </template>
                                    </td>
                                </tr>
                            </data-table>
                        </div>

                        <documents-voided
                            :showDialog.sync="showDialogVoided"
                            :recordId="recordId"
                        ></documents-voided>

                        <items-import
                            :showDialog.sync="showImportDialog"
                        ></items-import>

                        <document-import-second
                            :showDialog.sync="showImportSecondDialog"
                        ></document-import-second>

                        <document-options
                            :showDialog.sync="showDialogOptions"
                            :editDocument="editDocument"
                            :configuration="configuration"
                            :recordId="recordId"
                            :print="print"
                            :company="company"
                            :showClose="true"
                        ></document-options>
                        <document-payments
                            :showDialog.sync="showDialogPayments"
                            :documentId="recordId"
                        ></document-payments>
                        <document-salud-modal
                            :showDialog.sync="showDialogDocumentSalud"
                        ></document-salud-modal>
                        <report-payment
                            :showDialog.sync="showDialogReportPayment"
                        ></report-payment>
                        <DocumentValidate
                            :showDialogValidate.sync="showDialogValidate"
                        ></DocumentValidate>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
.table-striped tr:nth-child(even) {
    background-color: #f2f2f2;
}
</style>

<script>
import DocumentSaludModal from "./partials/document_salud_modal.vue";
import DocumentsVoided from "./partials/voided.vue";
import DocumentValidate from "./partials/validate.vue";
import DocumentOptions from "./partials/options.vue";
import DocumentPayments from "./partials/payments.vue";
import DocumentImportSecond from "./partials/import_second.vue";
import DataTable from "../../components/DataTableDocuments.vue";
import ItemsImport from "./import.vue";
import { deletable } from "../../mixins/deletable";
import ReportPayment from "./partials/report_payment.vue";
import Swal from "sweetalert2";

export default {
    mixins: [deletable],
    props: [
        "company",
        "isAccountant",
        "isClient",
        "typeUser",
        "import_documents",
        "import_documents_second",
        "configuration",
    ],
    components: {
        DocumentSaludModal,
        DocumentsVoided,
        ItemsImport,
        DocumentImportSecond,
        DocumentOptions,
        DocumentPayments,
        DataTable,
        ReportPayment,
        DocumentValidate
    },
    data() {
        return {
            showDialogDocumentSalud: false,
            showDialogReportPayment: false,
            showDialogVoided: false,
            showImportDialog: false,
            showDialogCDetraction: false,
            showDialogValidate: false,
            showImportSecondDialog: false,
            resource: "documents",
            recordId: null,
            showDialogOptions: false,
            showDialogPayments: false,
            closeBox: false,
            showDialogEdit: false,
            loading_data: false,
            editDocument: false,
            print: false,
            columns: {
                sale_note: {
                    title: "Nota de venta",
                    visible: true
                },
                dispatch: {
                    title: "Guia de remisión",
                    visible: true
                },
                igv: {
                    title: "T.Igv",
                    visible: false
                },
                total_value: {
                    title: "T. Gravado",
                    visible: false
                },
                boxes: {
                    title: "Metodo de pago",
                    visible: true
                },
                notes: {
                    title: "Notas C/D",
                    visible: false
                },
                user_name: {
                    title: "Usuario",
                    visible: true
                },
                total_exportation: {
                    title: "T.Exportación",
                    visible: false
                },
                total_free: {
                    title: "T.Gratuito",
                    visible: false
                },
                total_unaffected: {
                    title: "T.Inafecto",
                    visible: false
                },
                total_exonerated: {
                    title: "T.Exonerado",
                    visible: false
                },
                date_of_due: {
                    title: "F. Vencimiento",
                    visible: false
                }
            }
        };
    },
    created() {
        // this.$http.get(`/${this.resource}/tables`)
        //         .then(response => {
        //           this.closeBox=response.data.closebox
        //         })
    },
    methods: {
        formatDateTime(date) {
            let days = date.days;
            let hours = date.hours;
            let minutes = date.minutes;
            let text = "Hace: ";
            if (days > 0) {
                text += `${days} días`;
            } else if (hours > 0) {
                text += `${hours} horas`;
            }
            if (days == 0 && hours == 0) {
                if (minutes == 0) {
                    text += `Recientemente`;
                } else {
                    text += `${minutes} minutos`;
                }
            }

            return text;
        },
        clickDocumentSalud() {
            this.showDialogDocumentSalud = true;
        },
        teclasInit() {
            document.onkeydown = e => {
                const key = e.key;
                if (key == "F3") {
                    //Agregar cliente
                    location.href = `/${this.resource}/create`;
                }
            };
        },

        clickVoided(recordId = null) {
            this.recordId = recordId;
            this.showDialogVoided = true;
        },
        clickNuevo() {
            if (this.$cashId) {
                location.href = `/${this.resource}/create`;
            } else {
                Swal.fire({
                    title: "Caja Cerrada ",
                    text:
                        "No se puede Realizar esa Accion debido a que su caja esta cerrado",
                    icon: "error",
                    timer: 2000
                }).then(() => {
                    location.href = "/report_closed_cash";
                    Swal.fire("abra su caja aqui");
                });
            }
        },
        clickDownload(download) {
            window.open(download, "_blank");
        },
        clickResend(document_id) {
            this.$http
                .get(`/${this.resource}/send/${document_id}`)
                .then(response => {
                    if (response.data.success) {
                        this.$toast.success(response.data.message);
                        this.$eventHub.$emit("reloadData");
                    } else {
                        this.$toast.error(response.data.message);
                    }
                })
                .catch(error => {
                    this.$toast.error(error.response.data.message);
                });
        },
        clickSendOnline(document_id) {
            this.$http
                .get(`/${this.resource}/send_server/${document_id}/1`)
                .then(response => {
                    if (response.data.success) {
                        this.$toast.success(
                            "Se envio satisfactoriamente el comprobante."
                        );
                        this.$eventHub.$emit("reloadData");

                        this.clickCheckOnline(document_id);
                    } else {
                        this.$toast.error(response.data.message);
                    }
                })
                .catch(error => {
                    this.$toast.error(error.response.data.message);
                });
        },
        clickCheckOnline(document_id) {
            this.$http
                .get(`/${this.resource}/check_server/${document_id}`)
                .then(response => {
                    if (response.data.success) {
                        this.$toast.success("Consulta satisfactoria.");
                        this.$eventHub.$emit("reloadData");
                    } else {
                        this.$toast.error(response.data.message);
                    }
                })
                .catch(error => {
                    this.$toast.error(error.response.data.message);
                });
        },
        clickCDetraction(recordId) {
            this.recordId = recordId;
            this.showDialogCDetraction = true;
        },
        async checkResume() {
            try {
                this.loading_data = true;
                const response = await this.$http.get(
                    `/documents/check_summarie`
                );
                if (response.data.success) {
                    this.$toast.success(response.data.message);
                    this.$eventHub.$emit("reloadData");
                } else {
                    this.$toast.error(response.data.message);
                }
            } catch (e) {
                this.$toast.error(e.response.data.message);
            } finally {
                this.loading_data = false;
            }
        },
        async clickResume() {
            try {
                this.loading_data = true;
                const response = await this.$http.get(
                    `/documents/create_summarie`
                );
                if (response.data.success) {
                    this.$toast.success(response.data.message);
                    this.$eventHub.$emit("reloadData");
                } else {
                    this.$toast.error(response.data.message);
                }
            } catch (e) {
                this.$toast.error(e.response.data.message);
            } finally {
                this.loading_data = false;
            }
        },
        clickValidarCpe(document_id) {
            this.loading_data = false;
            this.$http
                .get(`/${this.resource}/validate/${document_id}`)
                .then(response => {
                    if (response.data.success) {
                        this.$toast.success(response.data.message);
                        this.$eventHub.$emit("reloadData");
                    } else {
                        this.$toast.error(response.data.message);
                    }
                    this.loading_data = false;
                })
                .catch(error => {
                    this.$toast.error(error.response.data.message);
                    this.loading_data = false;
                });
            this.loading_data = false;
        },
        clickEdit(recordId = null) {
            location.href = `/${this.resource}/create/${recordId}`;
        },
        clickOptions(recordId = null, printer) {
            this.recordId = recordId;
            this.showDialogOptions = true;
            this.print = printer;
        },
        clickReStore(document_id) {
            this.$http
                .get(`/${this.resource}/re_store/${document_id}`)
                .then(response => {
                    if (response.data.success) {
                        this.$toast.success(response.data.message);
                        this.$eventHub.$emit("reloadData");
                    } else {
                        this.$toast.error(response.data.message);
                    }
                })
                .catch(error => {
                    this.$toast.error(error.response.data.message);
                });
        },
        tooltip(row, message = true) {
            if (message) {
                if (row.shipping_status) return row.shipping_status.message;

                if (row.sunat_shipping_status)
                    return row.sunat_shipping_status.message;

                if (row.query_status) return row.query_status.message;
            }

            if (
                row.shipping_status ||
                row.sunat_shipping_status ||
                row.query_status
            )
                return true;

            return false;
        },
        clickPayment(recordId) {
            this.recordId = recordId;
            this.showDialogPayments = true;
        },
        clickChangeToRegisteredStatus(document_id) {
            this.$http
                .get(
                    `/${this.resource}/change_to_registered_status/${document_id}`
                )
                .then(response => {
                    if (response.data.success) {
                        this.$toast.success(response.data.message);
                        this.$eventHub.$emit("reloadData");
                    } else {
                        this.$toast.error(response.data.message);
                    }
                })
                .catch(error => {
                    this.$toast.error(error.response.data.message);
                });
        },
        clickImport() {
            this.showImportDialog = true;
        },
        clickValidate() {
            this.showDialogValidate = true;
        },
        clickDownloadReportPagos(type) {
            window.open(`/${this.resource}/payments/${type}`, "_blank");
        },
        clickImportSecond() {
            this.showImportSecondDialog = true;
        },
        async clickDeleteDocument(document_id) {
            await this.destroy(
                `/${this.resource}/delete_document/${document_id}`
            );
            this.$eventHub.$emit("reloadData");
        },
        clickReportPayments() {
            this.showDialogReportPayment = true;
        },
        handleDelete(row) {
            if (row.isProcessing) return;

            this.$set(row, 'isProcessing', true);
            this.$set(row, 'deleting', true);

            this.clickDeleteDocument(row.id)
                .finally(() => {
                    this.$set(row, 'deleting', false);
                    this.$set(row, 'isProcessing', false);
                });
        }
    },
    mounted() {
        this.teclasInit();
        //prueba haber
        //nada
    }
};
</script>
