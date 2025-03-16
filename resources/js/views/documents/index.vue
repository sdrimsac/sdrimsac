<!-- Listado de Comprobante de Pago -->
<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h6><span>Comprobantes</span></h6>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <span class="text-muted"
                                    >Facturas - Boletas</span
                                >
                            </li>
                        </ol>
                    </div>
                    <div
                        class="col-12 col-md-6 d-flex align-items-start justify-content-end"
                    >
                        <template v-if="configuration.health_network">
                            <button
                                type="button"
                                class="btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto"
                                @click.prevent="clickDocumentSalud()"
                            >
                                <i class="icofont-plus-circle"></i>
                                <span>Documentos farmacia</span>
                            </button>
                        </template>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid p-l-0 p-r-0">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card mb-0">
                        <div class="card-header bg-primary rounded-top">
                            <h4 class="my-0  text-white">
                                <i class="fas fa-file-alt"></i>
                                Listado de Comprobante de Pago (Boletas y
                                Facturas)
                            </h4>
                        </div>
                        <div class="data-table-visible-columns">
                            <el-button
                                type="primary"
                                class=""
                                href="javascript:void(0)"
                                @click.prevent="clickNuevo()"
                            >
                                <i class="fas fa-file-alt fa-lg"></i>
                                <i class="fa fa-plus"></i>
                                Nuevo Comprobante
                            </el-button>
                            <el-button
                                type="button"
                                class="btn btn-primary btn-icon btn-icon-only"
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
                                    class="dropdown-item"
                                    type="button"
                                    @click.prevent="clickResume()"
                                >
                                    Generar resumen
                                </button>
                                <button
                                    class="dropdown-item"
                                    type="button"
                                    @click.prevent="checkResume()"
                                >
                                    Consultar resumen
                                </button>
                                <button
                                    class="dropdown-item"
                                    type="button"
                                    @click.prevent="clickValidate()"
                                >
                                    Validar CPE
                                </button>
                                <button
                                    class="dropdown-item"
                                    type="button"
                                    @click.prevent="
                                        clickDownloadReportPagos('excel')
                                    "
                                >
                                    Reporte de Pagos
                                </button>
                                <button
                                    class="dropdown-item"
                                    type="button"
                                    @click.prevent="clickImport()"
                                    v-if="import_documents == true"
                                >
                                    Importar Formato 1
                                </button>
                                <button
                                    class="dropdown-item"
                                    type="button"
                                    @click.prevent="clickImportSecond()"
                                    v-if="import_documents_second == true"
                                >
                                    Importar Formato 2
                                </button>
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
                                <tr slot="heading" class="bg-primary">
                                    <th
                                        class="text-white text-left"
                                        v-if="typeUser != 'integrator'"
                                    >
                                        Acciones
                                    </th>
                                    <th class="text-white">#</th>
                                    <th class="text-white text-center">
                                        Actividad
                                    </th>
                                    <!-- <th class="text-white">D. E. USUARIO</th> -->
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
                                    <th class="text-white">Cliente</th>
                                    <th class="text-white">Número</th>
                                    <th
                                        class="text-white"
                                        v-if="columns.sale_note.visible"
                                    >
                                        N. V.
                                    </th>
                                    <th
                                        class="text-white"
                                        v-if="columns.dispatch.visible"
                                    >
                                        G. R.
                                    </th>
                                    <th
                                        class="text-white"
                                        v-if="columns.notes.visible"
                                    >
                                        Notas C/D
                                    </th>
                                    <th class="text-white">Estado</th>
                                    <th class="text-white"
                                    v-if="typeUser == 'superadmin'"
                                    >Estado Sunat</th>
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
                                    <th
                                        class="text-white text-left"
                                        
                                    >
                                        T.Igv
                                    </th>
                                    <th class="text-white text-center">
                                        Saldo
                                    </th>
                                    <!-- <th
                                        class="text-center"
                                        v-if="columns.boxes.visible"
                                    >
                                        Metodo de pago
                                    </th> -->
                                    <th class="text-white text-left">Total</th>

                                    <th class="text-white text-center">Pago</th>

                                    <th class="text-white text-center">
                                        Descargas
                                    </th>
                                    <!--<th class="text-center">Anulación</th>-->
                                </tr>

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
                                                class="dropdown-menu dropdown-menu-end"
                                                style=""
                                            >
                                                <template
                                                    v-if="
                                                        row.state_type_id !=
                                                            '11'
                                                    "
                                                >
                                                    <a 
                                                        :disabled="row.btn_delete_doc_type_03 || row.deleting"
                                                        type="button"
                                                        class="dropdown-item bg-info text-white"
                                                        @click.prevent="
                                                            row.deleting = true;
                                                            clickDeleteDocument(row.id).finally(() => {
                                                                row.deleting = false;
                                                            })
                                                        "
                                                        v-if="
                                                            row.btn_delete_doc_type_03 &&
                                                                !isAccountant &&
                                                                configuration.internal_voided
                                                        "
                                                        >Anulado Interno
                                                    </a>
                                                    <a
                                                        type="button"
                                                        class="dropdown-item"
                                                        @click.prevent="
                                                            clickChangeToRegisteredStatus(
                                                                row.id
                                                            )
                                                        "
                                                        v-if="
                                                            row.btn_change_to_registered_status
                                                        "
                                                        >Cambiar a estado
                                                        registrado
                                                    </a>
                                                    <a
                                                        type="button"
                                                        class="dropdown-item"
                                                        @click.prevent="
                                                            clickReStore(row.id)
                                                        "
                                                        >Volver a recrear
                                                    </a>
                                                    <a  
                                                        
                                                        type="button"
                                                        class="dropdown-item"
                                                        @click.prevent="
                                                            clickVoided(row.id)
                                                        "
                                                        v-if="
                                                            row.btn_voided &&
                                                                !isAccountant &&
                                                                configuration.anulate_sunat

                                                        "
                                                        >Anular Sunat</a
                                                    >
                                                    <a
                                                        :href="
                                                            `/dispatches/create_new/document/${row.id}`
                                                        "
                                                        class="dropdown-item"
                                                        v-if="
                                                            (row.btn_guide &&
                                                                typeUser ==
                                                                    'admin') ||
                                                                typeUser ==
                                                                    'superadmin'
                                                        "
                                                    >
                                                        Guía
                                                    </a>
                                                    <a
                                                        type="button"
                                                        :href="
                                                            `/${resource}/note/${row.id}`
                                                        "
                                                        class="dropdown-item"
                                                        v-if="
                                                            row.btn_note &&
                                                                !isAccountant
                                                        "
                                                        >Nota de Credito</a
                                                    >

                                                    <a
                                                        type="button"
                                                        class="dropdown-item"
                                                        @click.prevent="
                                                            clickEdit(row.id)
                                                        "
                                                        v-if="
                                                            (row.state_type_id ===
                                                                '01' ||
                                                                row.state_type_id ===
                                                                    '14') &&
                                                                !isAccountant
                                                        "
                                                        >Modificar
                                                    </a>
                                                    <a
                                                        type="button"
                                                        class="dropdown-item"
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
                                                        >Validar CPE
                                                    </a>
                                                    <a
                                                        type="button"
                                                        class="dropdown-item"
                                                        @click.prevent="
                                                            clickResend(row.id)
                                                        "
                                                        v-if="
                                                            row.btn_resend &&
                                                                !isClient &&
                                                                row.document_type_id !=
                                                                    '03'
                                                        "
                                                    >
                                                        Reenviar
                                                    </a>
                                                    <a
                                                        type="button"
                                                        class="dropdown-item"
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
                                                        Enviar Servidor
                                                    </a>
                                                    <a
                                                        type="button"
                                                        class="dropdown-item"
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
                                                        Consultar Servidor
                                                    </a>
                                                    <a
                                                        v-if="row.is_credit"
                                                        type="button"
                                                        class="dropdown-item"
                                                        @click.prevent="
                                                            clickPayment(row.id)
                                                        "
                                                        >Pagos</a
                                                    >
                                                </template>

                                                <a
                                                    type="button"
                                                    class="dropdown-item"
                                                    @click.prevent="
                                                        clickOptions(
                                                            row.id,
                                                            false
                                                        )
                                                    "
                                                >
                                                    Imprimir
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                    <td
                                        :class="{
                                            'text-dark':
                                                row.state_type_id === '11'
                                        }"
                                    >
                                        {{ index }}
                                    </td>
                                    <td> 
                                        <el-button 
                                            type="primary" 
                                            @click="clickView(row.id)"
                                         
                                         >
                                            Ver Movimiento
                                        </el-button>
                                    </td>
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
                                    <td
                                        :class="{
                                            'text-dark':
                                                row.state_type_id === '11'
                                        }"
                                        v-if="columns.user_name.visible"
                                    >
                                        {{ row.user_name }}
                                        <br /><small
                                            v-text="row.user_email"
                                        ></small>
                                    </td>
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
                                    <td
                                        :class="{
                                            'text-dark':
                                                row.state_type_id === '11'
                                        }"
                                    >
                                        {{ row.customer_name }}<br /><small
                                            class="badge bg-dark"
                                            v-text="row.customer_number"
                                        ></small>
                                    </td>
                                    <td
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
                                    </td>
                                    <td v-if="columns.sale_note.visible">
                                        <div
                                            v-for="(row,
                                            index) in row.sale_note_related"
                                            :key="index"
                                        >
                                            <small class="d-block">{{
                                                row.number
                                            }}</small>
                                        </div>
                                    </td>
                                    <td v-if="columns.dispatch.visible">
                                        <div
                                            v-for="(row,
                                            index) in row.dispatches"
                                            :key="index"
                                        >
                                            <small class="d-block">{{
                                                row.description
                                            }}</small>
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

                                    <td>
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
                                        >
                                            <template
                                                v-if="row.state_type_id == '11'"
                                            >
                                                <span
                                                    v-if="row.internal_voided"
                                                >
                                                    Anulado Interno
                                                </span>
                                                <span v-else> Anulado Sunat</span>
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

                                    <td
                                        v-if="typeUser == 'superadmin'"
                                    >
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
                                    <td
                                        :class="{
                                            'text-dark':
                                                row.state_type_id === '11'
                                        }"
                                        class="text-left"
                                    
                                    >
                                        {{ row.total_igv }}
                                    </td>
                                    <td class="text-warning text-center">
                                        <span v-if="row.remain > 0">
                                            {{ row.remain.toFixed(2) }}
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
                                    <td
                                        :class="{
                                            'text-dark':
                                                row.state_type_id === '11'
                                        }"
                                        class="text-left"
                                    >
                                        {{ row.total }}
                                    </td>
                                    <template>
                                        <td class="text-center">
                                            <span
                                                v-if="row.remain == 0"
                                                class="badge rounded-pill bg-success text-white"
                                            >
                                                Pagado
                                            </span>
                                            <span
                                                v-else
                                                class="badge rounded-pill bg-warning text-white"
                                            >
                                                Pendiente
                                            </span>
                                        </td>
                                    </template>

                                    <!-- <td
                                        :class="{
                                            'text-dark':
                                                row.state_type_id === '11'
                                        }"
                                        class="text-center"
                                    >
                                        <button
                                            type="button"
                                            style="min-width: 41px"
                                            class="btn btn-sm btn-primary hover-outline"
                                            @click.prevent="
                                                clickDownload(row.download_xml)
                                            "
                                            v-if="row.has_xml"
                                        >
                                            XML
                                        </button>
                                        <button
                                            type="button"
                                            style="min-width: 41px"
                                            class="btn btn-sm btn-primary hover-outline"
                                            @click.prevent="
                                                clickDownload(row.download_pdf)
                                            "
                                            v-if="row.has_pdf"
                                        >
                                            PDF
                                        </button>
                                        <button
                                            type="button"
                                            style="min-width: 41px"
                                            class="btn btn-sm btn-primary hover-outline"
                                            @click.prevent="
                                                clickDownload(row.download_cdr)
                                            "
                                            v-if="row.has_cdr"
                                        >
                                            CDR
                                        </button>
                                    </td> -->
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
                                                    >Descargas</span
                                                >
                                            </button>
                                            <div
                                                class="dropdown-menu dropdown-menu-end"
                                                style=""
                                            >
                                                <template
                                                    v-if="
                                                        row.state_type_id !=
                                                            '11'
                                                    "
                                                >
                                                    <button
                                                        type="button"
                                                        style="min-width: 41px"
                                                        class="btn btn-sm btn-success hover-outline w-100"
                                                        @click.prevent="
                                                            clickDownload(
                                                                row.download_xml
                                                            )
                                                        "
                                                        v-if="row.has_xml"
                                                    >
                                                        XML
                                                    </button>
                                                    <button
                                                        type="button"
                                                        style="min-width: 41px"
                                                        class="btn btn-sm btn-danger hover-outline w-100"
                                                        @click.prevent="
                                                            clickDownload(
                                                                row.download_pdf
                                                            )
                                                        "
                                                        v-if="row.has_pdf"
                                                    >
                                                        PDF
                                                    </button>
                                                    <button
                                                        type="button"
                                                        style="min-width: 41px"
                                                        class="btn btn-sm btn-info hover-outline w-100 "
                                                        @click.prevent="
                                                            clickDownload(
                                                                row.download_cdr
                                                            )
                                                        "
                                                        v-if="row.has_cdr"
                                                    >
                                                        CDR
                                                    </button>
                                                </template>
                                            </div>
                                        </div>
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
        "configuration"
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
            await this.destroy(`/${this.resource}/delete_document/${document_id}`);
            this.$eventHub.$emit("reloadData");
        },
        clickReportPayments() {
            this.showDialogReportPayment = true;
        }
    },
    mounted() {
        this.teclasInit();
        //prueba haber
        //nada
    }
};
</script>
