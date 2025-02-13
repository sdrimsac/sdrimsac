<template>
    <div v-loading="loading">
        <header class="page-header">
            <h2>
                <a href="/dashboard">
                    <i class="fa fa-list-alt"></i>
                </a>
            </h2>
            <ol class="breadcrumbs">
                <li class="active">
                    <span>Dashboard</span>
                </li>
            </ol>
        </header>
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div
                                    class="chart-data-selector ready pl-3 pr-4 pt-4"
                                >
                                    <div class="chart-data-selector-items">
                                        <chart-line
                                            v-if="loaded"
                                            :data="dataChartLine"
                                        ></chart-line>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row px-4 mt-2 pb-3">
                            <div class="col-2 font-weight-bold text-primary">
                                {{ year }}
                            </div>
                            <div class="col-10 font-weight-semibold text-right">
                                Comprobantes generados por mes
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="row">
                    <div class="col-md-12">
                        <section class="card card-horizontal">
                            <header class="card-header bg-success">
                                <div class="card-header-icon">
                                    <i class="fas fa-users"></i>
                                </div>
                            </header>
                            <div class="card-body p-4 text-center">
                                <p class="font-weight-semibold mb-0 mx-4">
                                    Total Clientes
                                </p>
                                <h2 class="font-weight-semibold mt-0">
                                    {{ records.length }}
                                </h2>
                                <div class="summary-footer">
                                    <a
                                        class="text-muted text-uppercase"
                                        href="#client-list"
                                        >Ver todos</a
                                    >
                                </div>
                            </div>
                        </section>
                    </div>
                    <div class="col-md-12 mb-0">
                        <section class="card card-horizontal">
                            <header class="card-header bg-secondary">
                                <div class="card-header-icon">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                            </header>
                            <div class="card-body p-4 text-center">
                                <p class="font-weight-semibold mb-0 mt-3">
                                    Total Comprobantes
                                </p>
                                <h2 class="font-weight-semibold mt-0 mb-3">
                                    {{ total_documents }}
                                </h2>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-3 col-lg-6">
                <section
                    class="card card-featured-left card-featured-primary mb-4"
                >
                    <div class="card-body">
                        <div class="widget-summary widget-summary-md">
                            <div
                                class="widget-summary-col widget-summary-col-icon"
                            >
                                <div class="summary-icon text-secondary">
                                    <div
                                        :data-value="discUsed"
                                        class="progress1 mx-auto"
                                    >
                                        <span class="progress1-left">
                                            <span
                                                class="progress1-bar border-primary"
                                            ></span>
                                        </span>
                                        <span class="progress1-right">
                                            <span
                                                class="progress1-bar border-primary"
                                            ></span>
                                        </span>
                                        <div
                                            class="progress1-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center"
                                        >
                                            <div class="font-weight-bold">
                                                {{ discUsed
                                                }}<small class="small"></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-summary-col">
                                <div class="summary">
                                    <h4 class="title">
                                        <!-- Disco <br> Duro -->
                                    </h4>
                                    <div class="info">
                                        <strong class="amount"
                                            >Disco Duro</strong
                                        ><br />
                                        <!-- <span class="text-warning" v-if="discUsed == 0">no se pudo obtener</span> -->
                                    </div>
                                </div>
                                <div class="summary-footer d-block">
                                    <a
                                        class="text-muted text-uppercase"
                                        href="https://docs.google.com/document/d/1hpEQUs9OFha_35yyLb1cMKeluD-dEku5lQsQ3TJFib8/edit"
                                        target="BLANK"
                                        >Incrementar</a
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="col-xl-3 col-lg-6">
                <section
                    class="card card-featured-left card-featured-primary mb-4"
                >
                    <div class="card-body">
                        <div class="widget-summary widget-summary-md">
                            <div
                                class="widget-summary-col widget-summary-col-icon"
                            >
                                <div class="summary-icon text-secondary">
                                    <div
                                        :data-value="iUsed"
                                        class="progress1 mx-auto"
                                    >
                                        <span class="progress1-left">
                                            <span
                                                class="progress1-bar border-primary"
                                            ></span>
                                        </span>
                                        <span class="progress1-right">
                                            <span
                                                class="progress1-bar border-primary"
                                            ></span>
                                        </span>
                                        <div
                                            class="progress1-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center"
                                        >
                                            <div class="font-weight-bold">
                                                {{ iUsed
                                                }}<small class="small"></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-summary-col">
                                <div class="summary">
                                    <h4 class="title">
                                        <!-- Disco <br> Duro -->
                                    </h4>
                                    <div class="info">
                                        <strong class="amount">Inodes</strong>
                                        <!-- <span class="text-primary">(14 unread)</span> -->
                                    </div>
                                </div>
                                <div class="summary-footer d-block">
                                    <a
                                        class="text-muted text-uppercase"
                                        href="https://drive.google.com/open?id=1foPKDI3V3Z9uKTjRc2SPSoztVSOBevPAluT2BqFbfxA"
                                        target="BLANK"
                                        >Limpiar</a
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="col-xl-3 col-lg-6">
                <section
                    class="card card-featured-left card-featured-primary mb-4"
                >
                    <div class="card-body">
                        <div class="widget-summary widget-summary-md">
                            <div
                                class="widget-summary-col widget-summary-col-icon"
                            >
                                <div class="summary-icon text-secondary">
                                    <div
                                        class="progress1 mx-auto"
                                        data-value="100"
                                    >
                                        <span class="progress1-left">
                                            <span
                                                class="progress1-bar border-tertiary"
                                            ></span>
                                        </span>
                                        <span class="progress1-right">
                                            <span
                                                class="progress1-bar border-tertiary"
                                            ></span>
                                        </span>
                                        <div
                                            class="progress1-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center"
                                        >
                                            <div class="font-weight-bold">
                                                {{ storageSize
                                                }}<small class="small"></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-summary-col">
                                <div class="summary">
                                    <h4 class="title">
                                        <!-- Disco <br> Duro -->
                                    </h4>
                                    <div class="info">
                                        <strong class="amount"
                                            >Archivos <br />
                                            Generados</strong
                                        >
                                        <!-- <span class="text-primary">(14 unread)</span> -->
                                    </div>
                                </div>
                                <div class="summary-footer">
                                    <!-- <a class="text-muted text-uppercase">(view all)</a> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="col-xl-3 col-lg-6">
                <section
                    class="card card-featured-left card-featured-primary mb-4"
                >
                    <div class="card-body">
                        <div class="widget-summary widget-summary-md">
                            <div
                                class="widget-summary-col widget-summary-col-icon"
                            >
                                <div
                                    class="summary-icon"
                                    style="background-color: #292961"
                                >
                                    <i class="fab fa-gitlab"></i>
                                </div>
                            </div>
                            <div class="widget-summary-col">
                                <div class="summary">
                                    <h4 class="title">
                                        <!-- Disco <br> Duro -->
                                    </h4>
                                    <div class="info">
                                        <strong class="amount">Versión</strong
                                        ><br />
                                        <span class="text-primary">{{
                                            version
                                        }}</span>
                                    </div>
                                </div>
                                <div class="summary-footer">
                                    <!-- <a class="text-muted text-uppercase">(view all)</a> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <div id="client-list" class="card mb-0">
            <div class="card-header bg-secondary">
                <h4>
                    <i class="fas fa-user"></i>
                    Listado de Clientes
                </h4>
            </div>
            <div class="data-table-visible-columns">
                <el-button
                    type="secondary"
                    class=""
                    @click.prevent="clickSendPendingDocuments()"
                >
                    <i class="fab fa-whatsapp fa-lg"></i>
                    <i class="fa fa-sync"></i>
                    Enviar reportes de documentos pendientes
                </el-button>
                <el-button
                    type="secondary"
                    class=""
                    @click.prevent="clickRestartWhatsapp()"
                >
                    <i class="fab fa-whatsapp fa-lg"></i>
                    <i class="fa fa-sync"></i>
                    Reiniciar Whatsapp
                </el-button>
                <el-button
                    type="secondary"
                    class=""
                    href="javascript:void(0)"
                    @click.prevent="clickCreate()"
                >
                    <i class="fas fa-user fa-lg"></i>
                    <i class="fa fa-plus-circle"></i>
                    Nuevo Cliente
                </el-button>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <!-- <button class="btn btn-custom btn-sm mt-2 mr-2 mb-3 bg-secondary" type="button" @click.prevent="clickCreate()">
                        <i class="fa fa-plus-circle"></i> Nuevo
                    </button> -->
                    </div>
                </div>
                <div class="card-body">
                    <data-table :resource="resource">
                        <tr slot="heading" class="bg-secondary">
                            <th class="text-center border text-white">#</th>
                            <th class="text-white text-center border">
                                Acciones
                            </th>
                            <th class="text-white text-center border">Logo</th>
                            <th class="text-white text-center border">
                                Entorno
                            </th>
                            <th class="text-white text-center border">
                                Bloquear cuenta
                            </th>
                            <th class="text-white text-center border">
                                Notificaciones
                            </th>
                            <th class="text-white text-center border">
                                Último Registro
                            </th>
                            <th class="text-white text-center border">
                                Fecha de vencimiento
                            </th>
                            <th class="text-white text-center border">
                                Hostname
                            </th>
                            <th class="text-white text-center border">Ruc</th>
                            <th class="text-white text-center border">
                                Nombre
                            </th>

                            <th class="text-white text-center border">
                                Inicio Ciclo Facturacion
                            </th>
                            <th class="text-white text-center border">
                                Monto de facturación por mes
                                <el-tooltip
                                    class="item"
                                    content="Monto de facturación por mes"
                                    effect="dark"
                                    placement="top-start"
                                >
                                    <i class="fas fa-info-circle"></i>
                                </el-tooltip>
                            </th>
                            <!-- <th class="text-white">Plan</th> -->
                            <!-- <th class="text-white">Correo</th> -->
                            <!-- <th class="text-white text-center border">Ruc</th> -->
                            <th class="text-white text-center border">
                                Total CPE
                            </th>
                            <!-- <th class="text-white text-center">CPE Ciclo Facturacion</th> -->
                            <th class="text-white text-center border">
                                Usuarios
                            </th>
                            <th class="text-white text-center border">
                                Establecimientos
                            </th>
                            <th class="text-white text-center border">
                                Ventas (Mes)
                            </th>
                            <th class="text-white text-center border">
                                F.Creación
                            </th>
                            <th class="text-white text-center border">
                                Consultas <br />API Peru
                            </th>
                            <th class="text-white text-center border">
                                Cant.NV
                            </th>
                            <!-- <th class="text-white text-center">CPE Y NV </th> -->
                        </tr>

                        <tr slot-scope="{ index, row }">
                            <td class="">{{ index }}</td>
                            <td>
                                <el-dropdown
                                    @command="manageIndexCommand"
                                    trigger="click"
                                >
                                    <el-button
                                        type="primary"
                                        class="bg-secondary"
                                    >
                                        Acciones<i
                                            class="el-icon-arrow-down el-icon--right"
                                        ></i>
                                    </el-button>
                                    <el-dropdown-menu slot="dropdown">
                                        <el-dropdown-item
                                            :command="['clickPassword', row.id]"
                                        >
                                            Resetar clave
                                        </el-dropdown-item>
                                        <el-dropdown-item
                                            :command="['clickDelete', row]"
                                        >
                                            Eliminar
                                        </el-dropdown-item>
                                        <el-dropdown-item
                                            :command="['clickPayments', row.id]"
                                        >
                                            Pagos
                                        </el-dropdown-item>
                                        <el-dropdown-item
                                            :command="[
                                                'clickAccountStatus',
                                                row.id
                                            ]"
                                        >
                                            E. Cuenta
                                        </el-dropdown-item>
                                        <el-dropdown-item
                                            :command="['clickEdit', row.id]"
                                        >
                                            Editar
                                        </el-dropdown-item>
                                    </el-dropdown-menu>
                                </el-dropdown>
                            </td>

                            <td class="">
                                <img
                                    :src="
                                        `/storage/uploads/logos/${row.imgClient}`
                                    "
                                    alt=""
                                    style="  max-width: 70px;  max-height: 70px;"
                                />
                            </td>
                            <td>
                                <span
                                    v-if="row.soap_type == '01'"
                                    class="badge badge-demo"
                                    >Demo</span
                                >
                                <span
                                    v-if="row.soap_type == '02'"
                                    class="badge badge-produccion"
                                    >Producción</span
                                >
                                <span
                                    v-if="row.soap_type == '03'"
                                    class="badge badge-interno"
                                    >Interno</span
                                >
                            </td>
                            <td class="text-center">
                                <template v-if="!row.locked">
                                    <el-switch
                                        v-model="row.locked_tenant"
                                        style="display: block"
                                        @change="changeLockedTenant(row)"
                                    ></el-switch>
                                </template>
                            </td>
                            <td class="text-center">
                                <el-tooltip
                                    class="item"
                                    content="Comprobantes enviados / por enviar"
                                    effect="dark"
                                    placement="top-start"
                                >
                                    <el-badge
                                        :value="row.document_not_sent"
                                        class="item"
                                        :type="
                                            row.document_not_sent == 0
                                                ? 'primary'
                                                : 'danger'
                                        "
                                    >
                                        <i
                                            class="far fa-bell text-secondary"
                                        ></i>
                                    </el-badge>
                                </el-tooltip>

                                <el-tooltip
                                    class="item"
                                    content="Comprobantes pendientes de rectificación"
                                    effect="dark"
                                    placement="top-start"
                                >
                                    <el-badge
                                        :value="
                                            row.document_regularize_shipping
                                        "
                                        class="item  ml-4"
                                        :type="
                                            row.document_regularize_shipping ==
                                            0
                                                ? 'primary'
                                                : 'danger'
                                        "
                                    >
                                        <i
                                            class="fas fa-exclamation-triangle text-secondary"
                                        ></i>
                                    </el-badge>
                                </el-tooltip>

                                <el-tooltip
                                    class="item"
                                    content="Comprobantes por anular"
                                    effect="dark"
                                    placement="top-start"
                                >
                                    <el-badge
                                        :value="row.document_to_be_canceled"
                                        class="item  ml-4"
                                        :type="
                                            row.document_to_be_canceled == 0
                                                ? 'primary'
                                                : 'danger'
                                        "
                                    >
                                        <i
                                            class="fas fa-exclamation-circle text-secondary"
                                        ></i>
                                    </el-badge>
                                </el-tooltip>
                            </td>
                            <td>
                                <template
                                    v-if="
                                        row.last_register &&
                                            row.last_register.user
                                    "
                                >
                                    <span>{{ row.last_register.user }}</span
                                    ><br />
                                    <span
                                        :class="
                                            `${
                                                row.last_register.date_time
                                                    .is24Hours
                                                    ? 'text-danger'
                                                    : ''
                                            }`
                                        "
                                        >{{
                                            formatDateTime(
                                                row.last_register.date_time
                                            )
                                        }}</span
                                    >
                                </template>
                            </td>
                            <td>
                                <template v-if="row.end_payment">
                                    <span>{{ row.end_payment }}</span>
                                </template>
                            </td>
                            <td class="">
                                <a
                                    :href="`http://${row.hostname}`"
                                    style="color:blue"
                                    target="_blank"
                                    >{{ row.hostname }}</a
                                >
                            </td>
                            <td>{{ row.number }}</td>
                            <td>{{ row.name }}</td>

                            <td class="text-center">
                                <template v-if="row.start_billing_cycle">
                                    <span></span>
                                    <span>{{ row.start_billing_cycle }}</span>
                                </template>
                                <template v-else>
                                    <el-date-picker
                                        v-model="row.select_date_billing"
                                        placeholder="..."
                                        type="date"
                                        value-format="yyyy-MM-dd"
                                        @change="
                                            setStartBillingCycle($event, row.id)
                                        "
                                    ></el-date-picker>
                                </template>
                            </td>
                            <td class="text-center">
                                <el-input 
                                style="width: 100px;"
                                :min="0"
                                @input="changeLimitMonthAmount(row)"
                                v-model="row.limit_month_amount" type="number" placeholder="Ingrese el monto de facturación por mes"></el-input>
                            </td>
                            <!-- <td>{{ row.plan }}</td> -->
                            <!-- <td>{{ row.email }}</td> -->
                            <!-- <td>
                            <span v-if="row.soap_type == '01'" class="badge badge-default">Demo</span>
                            <span v-if="row.soap_type == '02'" class="badge badge-success">Producción</span>
                            <span v-if="row.soap_type == '03'" class="badge badge-info">Interno</span>
                        </td> -->

                            <!-- <td class="text-center">
                            <label>
                                <strong>{{ row.count_doc }}</strong>
                            </label>
                        </td> -->

                            <td class="text-center">
                                <strong>
                                    {{
                                        row.count_doc_month
                                            ? row.count_doc_month
                                            : 0
                                    }}
                                    /
                                    <template v-if="row.max_documents == 0">
                                        <i class="fas fa-infinity"></i>
                                    </template>
                                    <template v-else>
                                        <strong>{{ row.max_documents }}</strong>
                                    </template>
                                </strong>
                            </td>

                            <td class="text-center">
                                <template
                                    v-if="
                                        row.max_users !== 0 &&
                                            row.count_user > row.max_users
                                    "
                                >
                                    <el-popover
                                        :content="text_limit_users"
                                        placement="top-start"
                                        trigger="hover"
                                        width="220"
                                    >
                                        <label
                                            slot="reference"
                                            class="text-danger"
                                        >
                                            <strong>{{
                                                row.count_user
                                            }}</strong>
                                        </label>
                                    </el-popover>
                                </template>
                                <template v-else>
                                    <label>
                                        <strong>{{ row.count_user }}</strong>
                                    </label>
                                </template>
                                /
                                <template v-if="row.max_users == 0">
                                    <i class="fas fa-infinity"></i>
                                </template>
                                <template v-else>
                                    <strong>{{ row.max_users }}</strong>
                                </template>
                            </td>

                            <td class="text-center">
                                <data-limit-notification
                                    entity_description="establecimientos"
                                    :unlimited="row.establishments_unlimited"
                                    :quantity="row.quantity_establishments"
                                    :max_quantity="
                                        row.max_quantity_establishments
                                    "
                                >
                                </data-limit-notification>
                            </td>

                            <td class="text-center">
                                <data-limit-notification
                                    entity_description="ventas"
                                    style_div="width: 150px !important"
                                    :unlimited="row.sales_unlimited"
                                    :quantity="row.monthly_sales_total"
                                    :max_quantity="row.max_sales_limit"
                                >
                                </data-limit-notification>
                            </td>

                            <td class="text-center">
                                {{ row.created_at }}
                            </td>
                            <td>{{ row.queries_to_apiperu }}</td>

                            <td class="text-center">
                                <strong>{{ row.count_sales_notes }}</strong>
                            </td>
                            <!-- <td class="text-center">
                            <strong>{{
                                        row.count_doc_month +
                                            row.count_sales_notes_month
                                    }}</strong>
                        </td> -->

                            <!-- <td class="text-right">
                                    <template v-if="!row.locked">
                                        <el-tooltip
                                            content="Se ingresa con el RUC"
                                            placement="top"
                                        >
                                            <button
                                                class="btn waves-effect waves-light btn-xs btn-info m-1__2"
                                                type="button"
                                                @click.prevent="
                                                    clickPassword(row.id)
                                                "
                                            >
                                                Resetear clave
                                            </button>
                                        </el-tooltip>
                                        <button
                                            class="btn waves-effect waves-light btn-xs btn-danger m-1__2"
                                            type="button"
                                            @click.prevent="clickDelete(row)"
                                        >
                                            Eliminar
                                        </button>
                                    </template>
                                </td>
                                <td class="text-right">
                                    <button
                                        class="btn waves-effect waves-light btn-xs btn-warning m-1__2"
                                        type="button"
                                        @click.prevent="clickPayments(row.id)"
                                    >
                                        Pagos
                                    </button>
                                </td>
                                <td class="text-right">
                                    <button
                                        class="btn waves-effect waves-light btn-xs btn-primary m-1__2"
                                        type="button"
                                        @click.prevent="
                                            clickAccountStatus(row.id)
                                        "
                                    >
                                        E. Cuenta
                                    </button>
                                </td>
                                <td class="text-right">
                                    <button
                                        class="btn waves-effect waves-light btn-xs btn-primary m-1__2"
                                        type="button"
                                        @click.prevent="clickEdit(row.id)"
                                    >
                                        Editar
                                    </button>
                                </td> -->
                        </tr>
                    </data-table>
                </div>
            </div>
        </div>

        <system-clients-form
            :recordId="recordId"
            :showDialog.sync="showDialog"
        ></system-clients-form>

        <!--<system-clients-form-edit :showDialog.sync="showDialogEdit"
        :recordId="recordId"></system-clients-form-edit>-->

        <client-payments
            :clientId="recordId"
            :showDialog.sync="showDialogPayments"
        ></client-payments>

        <account-status
            :clientId="recordId"
            :showDialog.sync="showDialogAccountStatus"
        ></account-status>

        <client-delete
            :record="record"
            :showDialog.sync="showDialogDelete"
        ></client-delete>
    </div>
</template>

<style>
.el-dropdown {
    vertical-align: top;
}

.el-dropdown + .el-dropdown {
    margin-left: 15px;
}

.el-icon-arrow-down {
    font-size: 12px;
}
table.dataTable.dataTable_width_auto {
    width: auto;
}

.badge-demo {
    background-color: #ffc107; /* Ámbar */
    color: white;
}
.badge-produccion {
    background-color: #28a745; /* Verde */
    color: white;
}
.badge-interno {
    background-color: #17a2b8; /* Azul */
    color: white;
}
.badge {
    display: inline-block;
    padding: 0.5em 1em;
    border-radius: 0.25em;
    font-size: 1em;
    cursor: pointer;
    text-align: center;
}
</style>

<script>
import CompaniesForm from "./form.vue";
//   import CompaniesFormEdit from './form_edit.vue'
import { deletable } from "../../../mixins/deletable";
import { changeable } from "../../../mixins/changeable";
import ChartLine from "./charts/Line";
import ClientPayments from "./partials/payments.vue";
import AccountStatus from "./partials/account_status.vue";
import ClientDelete from "./partials/delete.vue";
import DataLimitNotification from "./partials/DataLimitNotification.vue";
import DataTable from "../../../components/DataTable2.vue";
import { debounce } from 'lodash';

export default {
    mixins: [deletable, changeable],
    props: ["discUsed", "iUsed", "storageSize", "version"],
    components: {
        CompaniesForm,
        ChartLine,
        ClientPayments,
        AccountStatus,
        ClientDelete,
        DataLimitNotification,
        DataTable
    },
    data() {
        return {
            loading: false,
            selectBillingDate: "",
            showDialogEdit: false,
            showDialog: false,
            showDialogPayments: false,
            showDialogAccountStatus: false,
            resource: "clients",
            recordId: null,
            records: [],
            text_limit_doc: null,
            text_limit_users: null,
            loaded: false,
            year: moment().format("YYYY"),
            total_documents: 0,
            dataChartLine: {
                labels: null,
                datasets: [
                    {
                        // label: 'Data One',
                        // backgroundColor: '#f87979',
                        data: null
                    }
                ]
            },
            showDialogDelete: false,
            record: {}
        };
    },
    async mounted() {
        this.loaded = false;
        await this.$http.get(`/${this.resource}/charts`).then(response => {
            let line = response.data.line;
            this.dataChartLine.labels = line.labels;
            this.dataChartLine.datasets[0].data = line.data;
            this.total_documents = response.data.total_documents;
            // console.log(response.data)
            // this.records = response.data.data
        });
        this.loaded = true;
    },
    created() {
        console.log("object");
        this.$eventHub.$on("reloadData", () => {
            this.getData();
        });
        this.getData();

        this.text_limit_doc = "El límite de comprobantes fue superado";
        this.text_limit_users = "El límite de usuarios fue superado";
    },
    methods: {
        changeLimitMonthAmount: debounce(function(row){
            this.loading = true;
            this.$http.post(`/${this.resource}/change_limit_month_amount`, row)
                .then(response => {
                    if (response.data.success) {
                        this.$message.success(response.data.message);
                    }
                })
                .catch(error => {
                    this.$message.error(error.response.data.message);
                })
                .finally(() => {
                    this.loading = false;
                });
        }, 1000),
        clickSendPendingDocuments() {
            this.loading = true;
            this.$http
                .get(`/check-documents`)
                .then(response => {
                    this.$showSAlert("Correcto", "Se enviaron los reportes");
                })
                .catch(error => {
                    console.log(error);
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        clickRestartWhatsapp() {
            this.loading = true;
            this.$http
                .get(`/restart-whatsapp`)
                .then(response => {
                    if (response.data.success) {
                        this.$message.success(response.data.message);
                    } else {
                        this.$message.error(response.data.message);
                    }
                })
                .catch(error => {
                    if (error.response.status === 500) {
                        this.$message.error(error.response.data.message);
                    } else {
                        console.log(error.response);
                    }
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        manageIndexCommand([command, arg1 = null, arg2 = null]) {
            switch (command) {
                case "clickPassword":
                    this.clickPassword(arg1);
                    break;
                case "clickDelete":
                    this.clickDelete(arg1);
                    break;
                case "clickPayments":
                    this.clickPayments(arg1);
                    break;
                case "clickAccountStatus":
                    this.clickAccountStatus(arg1);
                    break;
                case "clickEdit":
                    this.clickEdit(arg1);
                    break;
            }
        },
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
        changeLockedTenant(row) {
            this.$http
                .post(`${this.resource}/locked_tenant`, row)
                .then(response => {
                    if (response.data.success) {
                        this.$message.success(response.data.message);
                        this.$eventHub.$emit("reloadData");
                    } else {
                        this.$message.error(response.data.message);
                    }
                })
                .catch(error => {
                    if (error.response.status === 500) {
                        this.$message.error(error.response.data.message);
                    } else {
                        console.log(error.response);
                    }
                })
                .then(() => {});
        },

        changeLockedUser(row) {
            this.$http
                .post(`${this.resource}/locked_user`, row)
                .then(response => {
                    if (response.data.success) {
                        this.$message.success(response.data.message);
                        this.$eventHub.$emit("reloadData");
                    } else {
                        this.$message.error(response.data.message);
                    }
                })
                .catch(error => {
                    if (error.response.status === 500) {
                        this.$message.error(error.response.data.message);
                    } else {
                        console.log(error.response);
                    }
                })
                .then(() => {});
        },
        changeLockedByColumn(row, column) {
            const params = {
                ...row
            };
            params.column = column;

            this.$http
                .post(`${this.resource}/locked-by-column`, params)
                .then(response => {
                    if (response.data.success) {
                        this.$message.success(response.data.message);
                        this.$eventHub.$emit("reloadData");
                    } else {
                        this.$message.error(response.data.message);
                    }
                })
                .catch(error => {
                    if (error.response.status === 500) {
                        this.$message.error(error.response.data.message);
                    } else {
                        console.log(error.response);
                    }
                })
                .then(() => {});
        },
        setStartBillingCycle(event, id) {
            this.$http
                .post(`${this.resource}/set_billing_cycle`, {
                    id: id,
                    start_billing_cycle: event
                })
                .then(response => {
                    if (response.data.success) {
                        this.$message.success(response.data.message);
                    } else {
                        this.$message.error(response.data.message);
                    }
                })
                .catch(error => {
                    if (error.response.status === 500) {
                        this.$message.error(error.response.data.message);
                    } else {
                        console.log(error.response);
                    }
                })
                .then(() => {
                    this.$eventHub.$emit("reloadData");
                });
        },
        changeLockedEmission(row) {
            this.$http
                .post(`${this.resource}/locked_emission`, row)
                .then(response => {
                    if (response.data.success) {
                        this.$message.success(response.data.message);
                        this.$eventHub.$emit("reloadData");
                    } else {
                        this.$message.error(response.data.message);
                    }
                })
                .catch(error => {
                    if (error.response.status === 500) {
                        this.$message.error(error.response.data.message);
                    } else {
                        console.log(error.response);
                    }
                })
                .then(() => {});
        },
        getData() {
            this.$http.get(`/${this.resource}/records`).then(response => {
                this.records = response.data.data;
                console.log(this.records);
            });
        },
        clickCreate(recordId = null) {
            this.recordId = recordId;
            this.showDialog = true;
        },
        clickPayments(recordId = null) {
            this.recordId = recordId;
            this.showDialogPayments = true;
        },
        clickAccountStatus(recordId = null) {
            this.recordId = recordId;
            this.showDialogAccountStatus = true;
        },
        clickPassword(id) {
            this.change(`/${this.resource}/password/${id}`);
        },
        clickDelete(record) {
            this.record = record;
            this.showDialogDelete = true;
            // this.destroy(`/${this.resource}/${id}`).then(() =>
            //     this.$eventHub.$emit("reloadData")
            // );
        },
        clickEdit(recordId) {
            this.recordId = recordId;
            this.showDialog = true;
        }
    }
};
</script>
