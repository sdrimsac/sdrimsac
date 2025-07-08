<template>
    <div v-loading="loading">
        <!-- <header class="page-header">
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
        </header> -->
        <div class="row">
            
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="chart-data-selector ready pl-3 pr-4 pt-4">
                                    <div class="chart-data-selector-items">
                                        <chart-line v-if="loaded" :data="dataChartLine"></chart-line>
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
            <div class="col-lg-3">
                <div class="row">
                    <div class="col-md-12">
                        <section class="card card-horizontal">
                            <header class="card-header bg-success">
                                <div class="card-header-icon">
                                    <i class="fas fa-users"></i>
                                </div>
                            </header>
                            <div class="card-body p-1 text-center">
                                <p class="font-weight-semibold mb-0 mx-4">
                                    Total Clientes
                                </p>
                                <h2 class="font-weight-semibold mt-0">
                                    {{ records.length }}
                                </h2>
                                <!-- <div class="summary-footer">
                                    <a class="text-muted text-uppercase" href="#client-list">Ver todos</a>
                                </div> -->
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
                            <div class="card-body p-1 text-center">
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
            <div class="col-lg-3">
                <section class="card card-featured-left card-featured-primary mb-4">
                    <div class="card-body">
                        <div class="widget-summary widget-summary-md">
                            <div class="widget-summary-col widget-summary-col-icon">
                                <div class="summary-icon text-secondary">
                                    <div :data-value="discUsed" class="progress1 mx-auto">
                                        <span class="progress1-left">
                                            <span class="progress1-bar border-primary"></span>
                                        </span>
                                        <span class="progress1-right">
                                            <span class="progress1-bar border-primary"></span>
                                        </span>
                                        <div
                                            class="progress1-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center">
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

                                    </h4>
                                    <div class="info">
                                        <strong class="amount">Disco Duro</strong><br />
                                        <span class="text-warning" v-if="discUsed == 0">no se pudo obtener</span>
                                    </div>
                                </div>
                                <!-- <div class="summary-footer d-block">
                                    <a class="text-muted text-uppercase"
                                        href="https://docs.google.com/document/d/1hpEQUs9OFha_35yyLb1cMKeluD-dEku5lQsQ3TJFib8/edit"
                                        target="BLANK">Incrementar</a>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </section>
                <section class="card card-featured-left card-featured-primary mb-4">
                    <div class="card-body">
                        <div class="widget-summary widget-summary-md">
                            <div class="">
                                <!-- <img :src="imageUrl" alt="Store" style="width:40px; height:40px; object-fit:contain; border-radius:50%;" />
                                this.imageUrl = "/acorn/img/profile/store.png" -->
                                <img src="/acorn/img/profile/store.png" alt="Logo" style="width:40px; height:40px; object-fit:contain; border-radius:50%;" />
                                <!-- <div class="summary-icon" style="background-color: #292961">
                                    
                                    <i class="fab fa-gitlab"></i>
                                </div> -->
                            </div>
                            <div class="widget-summary-col">
                                <div class="summary">
                                    <h4 class="title">

                                    </h4>
                                    <div class="info">
                                        <strong class="amount">Versión</strong><br />
                                        <span class="text-primary">{{
                                            version
                                        }}</span>
                                          070725-3
                                    </div>
                                </div>
                                <div class="summary-footer">
                                  
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <!-- <div class="row">
            <div class="col-xl-3 col-lg-6">
                <section class="card card-featured-left card-featured-primary mb-4">
                    <div class="card-body">
                        <div class="widget-summary widget-summary-md">
                            <div class="widget-summary-col widget-summary-col-icon">
                                <div class="summary-icon text-secondary">
                                    <div :data-value="discUsed" class="progress1 mx-auto">
                                        <span class="progress1-left">
                                            <span class="progress1-bar border-primary"></span>
                                        </span>
                                        <span class="progress1-right">
                                            <span class="progress1-bar border-primary"></span>
                                        </span>
                                        <div
                                            class="progress1-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center">
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

                                    </h4>
                                    <div class="info">
                                        <strong class="amount">Disco Duro</strong><br />
                                        <span class="text-warning" v-if="discUsed == 0">no se pudo obtener</span>
                                    </div>
                                </div>
                                <div class="summary-footer d-block">
                                    <a class="text-muted text-uppercase"
                                        href="https://docs.google.com/document/d/1hpEQUs9OFha_35yyLb1cMKeluD-dEku5lQsQ3TJFib8/edit"
                                        target="BLANK">Incrementar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="col-xl-3 col-lg-6">
                <section class="card card-featured-left card-featured-primary mb-4">
                    <div class="card-body">
                        <div class="widget-summary widget-summary-md">
                            <div class="widget-summary-col widget-summary-col-icon">
                                <div class="summary-icon text-secondary">
                                    <div :data-value="iUsed" class="progress1 mx-auto">
                                        <span class="progress1-left">
                                            <span class="progress1-bar border-primary"></span>
                                        </span>
                                        <span class="progress1-right">
                                            <span class="progress1-bar border-primary"></span>
                                        </span>
                                        <div
                                            class="progress1-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center">
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

                                    </h4>
                                    <div class="info">
                                        <strong class="amount">Inodes</strong>

                                    </div>
                                </div>
                                <div class="summary-footer d-block">
                                    <a class="text-muted text-uppercase"
                                        href="https://drive.google.com/open?id=1foPKDI3V3Z9uKTjRc2SPSoztVSOBevPAluT2BqFbfxA"
                                        target="BLANK">Limpiar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="col-xl-3 col-lg-6">
                <section class="card card-featured-left card-featured-primary mb-4">
                    <div class="card-body">
                        <div class="widget-summary widget-summary-md">
                            <div class="widget-summary-col widget-summary-col-icon">
                                <div class="summary-icon text-secondary">
                                    <div class="progress1 mx-auto" data-value="100">
                                        <span class="progress1-left">
                                            <span class="progress1-bar border-tertiary"></span>
                                        </span>
                                        <span class="progress1-right">
                                            <span class="progress1-bar border-tertiary"></span>
                                        </span>
                                        <div
                                            class="progress1-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center">
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

                                    </h4>
                                    <div class="info">
                                        <strong class="amount">Archivos <br />
                                            Generados</strong>

                                    </div>
                                </div>
                                <div class="summary-footer">

                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="col-xl-3 col-lg-6">
                <section class="card card-featured-left card-featured-primary mb-4">
                    <div class="card-body">
                        <div class="widget-summary widget-summary-md">
                            <div class="widget-summary-col widget-summary-col-icon">
                                <div class="summary-icon" style="background-color: #292961">
                                    <i class="fab fa-gitlab"></i>
                                </div>
                            </div>
                            <div class="widget-summary-col">
                                <div class="summary">
                                    <h4 class="title">

                                    </h4>
                                    <div class="info">
                                        <strong class="amount">Versión</strong><br />
                                        <span class="text-primary">{{
                                            version
                                            }}</span>
                                    </div>
                                </div>
                                <div class="summary-footer">

                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div> -->


        <div id="client-list" class="card mb-0">
            <div class="card-header bg-secondary">
                <h4>
                    <i class="fas fa-user"></i>
                    Listado de Clientes
                </h4>
            </div>
            <!-- v-if="canSee" -->
            <div class="data-table-visible-columns">
                <div class="d-flex flex-row align-items-center flex-wrap">
                    <el-tooltip class="item" content="Eviar toda las tareas programadas manualmente" effect="dark"
                        placement="top-start">
                        <vs-button :loading="buttonLoading" :disabled="buttonLoading"
                            @click.prevent="clickResetProgramn" class="mr-2 same-size-btn"
                            style="background-color: #ffc107; color: #fff; border-color: #ffc107;">
                            <i class="fas fa-tasks btn-icon"></i>
                            <span class="btn-label" style="margin: 0 8px;">Tareas</span>
                            <i class="fas fa-clock btn-icon"></i>
                        </vs-button>
                    </el-tooltip>
                    <el-tooltip class="item" content="Enviar mensajes de cobro a los clientes" effect="dark"
                        placement="top-start">
                        <vs-button :active="active == 4" :loading="loading" :disabled="loading" @click.prevent="
                            active = 4;
                        clickSendPaymentsMessages();
                        " class="mr-2 same-size-btn"
                            style="background-color: #28a745; color: #fff; border-color: #28a745;">
                            <i class="fab fa-whatsapp fa-lg btn-icon"></i>
                            <span class="btn-label" style="margin: 0 8px;">Cobros</span>
                            <i class="fas fa-bell fa-lg btn-icon"></i>
                        </vs-button>
                    </el-tooltip>
                    <el-tooltip class="item" content="Enviar reportes de documentos pendientes" effect="dark"
                        placement="top-start">
                        <vs-button :active="active == 5" :loading="loading" :disabled="loading" @click.prevent="
                            active = 5;
                        clickSendPendingDocuments();
                        " class="mr-2 same-size-btn"
                            style="background-color: #17a2b8; color: #fff; border-color: #17a2b8;">
                            <i class="fab fa-whatsapp fa-lg btn-icon"></i>
                            <span class="btn-label" style="margin: 0 8px;">Pendientes</span>
                            <i class="fas fa-file fa-lg btn-icon"></i>
                        </vs-button>
                    </el-tooltip>
                    <el-tooltip class="item" content="Reiniciar Whatsapp y enviar mensajes" effect="dark"
                        placement="top-start">
                        <vs-button :active="active == 6" :loading="loading" :disabled="loading" @click.prevent="
                            active = 6;
                        clickRestartWhatsapp();
                        " class="mr-2 same-size-btn"
                            style="background-color: #007bff; color: #fff; border-color: #007bff;">
                            <i class="fab fa-whatsapp fa-lg btn-icon"></i>
                            <span class="btn-label" style="margin: 0 8px;">Reiniciar</span>
                            <i class="fa fa-sync btn-icon"></i>
                        </vs-button>
                    </el-tooltip>
                    <vs-button :active="active == 1" @click.prevent="
                        active = 1;
                    clickCreate();
                    " class="same-size-btn" style="background-color: #007bff; color: #fff; border-color: #007bff;">
                        <i class="fa fa-plus-circle btn-icon"></i>
                        <span class="btn-label" style="margin: 0 8px;">Nueva APP</span>
                    </vs-button>
                </div>
                <!-- <el-tooltip class="item" content="Eviar toda las tareas programadas mnaualmente" effect="dark"
                    placement="top-start">
                    <el-button type="secondary" class="" :loading="buttonLoading" :disabled="buttonLoading"
                        @click.prevent="clickResetProgramn">
                        Tareas Programados
                    </el-button>
                </el-tooltip>
                <el-tooltip class="item" content="Enviar mensajes de cobro a los clientes" effect="dark"
                    placement="top-start">
                    <el-button type="secondary" class="" @click.prevent="clickSendPaymentsMessages()">
                        <i class="fab fa-whatsapp fa-lg"></i>
                        <i class="fas fa-bell fa-lg"></i>
                    </el-button>
                </el-tooltip>
                <el-tooltip class="item" content="Enviar reportes de documentos pendientes" effect="dark"
                    placement="top-start">
                    <el-button type="secondary" class="" @click.prevent="clickSendPendingDocuments()">
                        <i class="fab fa-whatsapp fa-lg"></i>
                        <i class="fas fa-file fa-lg"></i>
                    </el-button>
                </el-tooltip>
                <el-tooltip class="item" content="Reiniciar Whatsapp" effect="dark" placement="top-start">
                    <el-button type="secondary" class="" @click.prevent="clickRestartWhatsapp()">
                        <i class="fab fa-whatsapp fa-lg"></i>
                        <i class="fa fa-sync"></i>
                    </el-button>
                </el-tooltip>
                <el-button type="secondary" class="" href="javascript:void(0)" @click.prevent="clickCreate()">
                    <i class="fas fa-user fa-lg"></i>
                    <i class="fa fa-plus-circle"></i>
                    Nuevo Cliente
                </el-button> -->
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <!-- <button class="btn btn-custom btn-sm mt-2 mr-2 mb-3 bg-secondary" type="button" @click.prevent="clickCreate()">
                        <i class="fa fa-plus-circle"></i> Nuevo
                    </button> -->
                    </div>
                </div>
                <div class="card-body p-1">
                    <div class="table-responsive">
                        <data-table :resource="resource" ref="dataTable"
                            class="table table-hover table-striped table-bordered shadow-sm rounded">
                            <tr slot="heading" class="bg-secondary">
                                <th class="text-center border text-white align-middle" style="width: 40px;">#</th>
                                <th class="text-white text-center border align-middle" style="width: 110px;">
                                    <i class="fas fa-cogs fa-lg" style="color: #ffc107;" title="Acciones"></i>
                                </th>
                                <th class="text-white text-center border align-middle" style="width: 90px;">Logo</th>
                                <th class="text-white text-center border align-middle" style="width: 90px;">Entorno</th>
                                <!-- <th class="text-white text-center border align-middle" style="width: 140px;">Bloquear
                                    cuenta</th> -->
                                <!-- <th class="text-white text-center border align-middle" style="width: 100px;">
                                    <i class="fas fa-bell" title="Notificaciones"></i>
                                </th> -->
                                <th class="text-white text-center border align-middle" style="width: 100px;">Último
                                    Registro</th>
                                <!-- <th class="text-white text-center border align-middle" style="width: 130px;">Fecha de vencimiento</th> -->
                                <!-- <th class="text-white text-center border align-middle" style="width: 170px;">Hostname</th> -->
                                <th class="text-white text-center border align-middle" style="width: 300px;">Cliente
                                </th>
                                <!-- <th class="text-white text-center border align-middle" style="width: 200px;">Nombre</th> -->
                                <!-- <th class="text-white text-center border align-middle" style="width: 120px;">Inicio
                                    Ciclo Facturación</th>
                                <th class="text-white text-center border align-middle" style="width: 180px;">
                                    Monto de facturación por mes
                                    <el-tooltip class="item" content="Monto de facturación por mes" effect="dark"
                                        placement="top-start">
                                        <i class="fas fa-info-circle"></i>
                                    </el-tooltip>
                                </th> -->
                                <th class="text-white text-center border align-middle" style="width: 80px;">
                                    <i class="fas fa-store" title="Establecimiento"></i>

                                </th>
                                <th class="text-white text-center border align-middle" style="width: 90px;">CPE Emitidos
                                </th>
                                <!-- <th class="text-white text-center border align-middle" style="width: 120px;">Usuarios
                                </th>
                                <th class="text-white text-center border align-middle" style="width: 150px;">
                                    Establecimientos</th> -->
                                <th class="text-white text-center border align-middle" style="width: 90px;">Ventas S/
                                    (Mes)</th>
                                <!-- <th class="text-white text-center border align-middle" style="width: 120px;">F.Creación
                                </th>
                                <th class="text-white text-center border align-middle" style="width: 120px;">Consultas
                                    <br />API Peru
                                </th>
                                <th class="text-white text-center border align-middle" style="width: 90px;">Cant.NV</th> -->
                            </tr>

                            <tr slot-scope="{ index, row }" style="vertical-align: middle;">
                                <td class="align-middle font-weight-bold text-center">{{ index }}</td>
                                <td class="align-middle text-center">
                                    <el-dropdown @command="manageIndexCommand" trigger="click">
                                        <el-button type="primary" class="bg-secondary btn-sm rounded-pill px-3">
                                            <i class="fas fa-cogs mr-1"></i> Acciones
                                            <i class="el-icon-arrow-down el-icon--right"></i>
                                        </el-button>
                                        <el-dropdown-menu slot="dropdown" class="custom-dropdown-menu">
                                            <!-- <el-dropdown-item :command="['clickPassword', row.id]"
                                                class="dropdown-item-password">
                                                <i class="fas fa-key mr-2 text-warning"></i>
                                                <span class="text-dark">Resetear clave</span>
                                            </el-dropdown-item> -->
                                            
                                            <el-dropdown-item :command="['clickPayments', row.id]"
                                                class="dropdown-item-payments">
                                                <i class="fas fa-money-check-alt mr-2 text-success"></i>
                                                <span class="text-success">Pagos</span>
                                            </el-dropdown-item>
                                            <!-- <el-dropdown-item :command="['clickAccountStatus', row.id]"
                                                class="dropdown-item-account">
                                                <i class="fas fa-file-invoice-dollar mr-2 text-info"></i>
                                                <span class="text-info">E. Cuenta</span>
                                            </el-dropdown-item> -->
                                            
                                            <el-dropdown-item :command="['clickDelete', row]"
                                                class="dropdown-item-delete">
                                                <i class="fas fa-trash-alt mr-2 text-danger"></i>
                                                <span class="text-danger font-weight-bold">Eliminar</span>
                                            </el-dropdown-item>
                                        </el-dropdown-menu>
                                    </el-dropdown>
                                    <el-divider></el-divider>

                                    <span style="color: #073f68; font-weight: bold;">Bloquear Cuenta</span>
                                    <template v-if="!row.locked">
                                        <el-switch v-model="row.locked_tenant" style="display: block"
                                            @change="changeLockedTenant(row)"></el-switch>
                                    </template>

                                </td>
                                <td class="align-middle text-center">

                                    <img v-if="row.imgClient" :src="`/storage/uploads/logos/${row.imgClient}`"
                                        alt="Logo" class="img-fluid rounded shadow-sm"
                                        style="max-width: 80px; max-height: 50px; object-fit: contain;"
                                        @error="hideImage($event)" />

                                </td>
                                <td class="align-middle text-center">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <el-tooltip class="item" content="Comprobantes enviados / por enviar"
                                            effect="dark" placement="top-start">
                                            <el-badge :value="row.document_not_sent"
                                                :type="row.document_not_sent == 0 ? 'primary' : 'danger'" class="mx-1">
                                                <i class="far fa-bell text-secondary fa-lg"></i>
                                            </el-badge>
                                        </el-tooltip>
                                        <!-- <el-tooltip class="item" content="Comprobantes pendientes de rectificación"
                                            effect="dark" placement="top-start">
                                            <el-badge :value="row.document_regularize_shipping" class="mx-1"
                                                :type="row.document_regularize_shipping == 0 ? 'primary' : 'danger'">
                                                <i class="fas fa-exclamation-triangle text-secondary fa-lg"></i>
                                            </el-badge>
                                        </el-tooltip> -->
                                        <el-tooltip class="item" content="Comprobantes por anular" effect="dark"
                                            placement="top-start">
                                            <el-badge :value="row.document_to_be_canceled"
                                                :type="row.document_to_be_canceled == 0 ? 'primary' : 'danger'"
                                                class="mx-1">
                                                <i class="fas fa-exclamation-circle text-secondary fa-lg"></i>
                                            </el-badge>
                                        </el-tooltip>
                                    </div>
                                    <template v-if="String(row.soap_type) === '01'">
                                        <img src="/acorn/img/profile/demo.png" alt="demo"
                                            class="img-fluid rounded shadow-sm"
                                            style="max-width: 80px; max-height: 50px; object-fit: contain;" />
                                    </template>
                                    <template v-else-if="String(row.soap_type) === '02'">
                                        <img src="/acorn/img/profile/produccion.png" alt="producción"
                                            class="img-fluid rounded shadow-sm"
                                            style="max-width: 80px; max-height: 50px; object-fit: contain;" />
                                    </template>
                                    <template v-else-if="String(row.soap_type) === '03'">
                                        <img src="/acorn/img/profile/interno.png" alt="interno"
                                            class="img-fluid rounded shadow-sm"
                                            style="max-width: 80px; max-height: 50px; object-fit: contain;" />
                                    </template>
                                    <!-- <span v-if="row.soap_type == '01'" class="badge badge-warning px-2 py-1">Demo</span>
                                    <span v-if="row.soap_type == '02'" class="badge badge-success px-2 py-1">Producción</span>
                                    <span v-if="row.soap_type == '03'" class="badge badge-info px-2 py-1">Interno</span> -->
                                </td>
                                <!-- <td class="align-middle text-center">
                                    <template v-if="!row.locked">
                                        <el-switch v-model="row.locked_tenant" style="display: block"
                                            @change="changeLockedTenant(row)"></el-switch>
                                    </template>
                                </td> -->
                                <!-- <td class="align-middle text-center">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <el-tooltip class="item" content="Comprobantes enviados / por enviar" effect="dark" placement="top-start">
                                            <el-badge
                                                :value="row.document_not_sent"
                                                :type="row.document_not_sent == 0 ? 'primary' : 'danger'"
                                                class="mx-1"
                                            >
                                                <i class="far fa-bell text-secondary fa-lg"></i>
                                            </el-badge>
                                        </el-tooltip>
                                        <el-tooltip class="item" content="Comprobantes pendientes de rectificación"
                                            effect="dark" placement="top-start">
                                            <el-badge :value="row.document_regularize_shipping" class="mx-1"
                                                :type="row.document_regularize_shipping == 0 ? 'primary' : 'danger'">
                                                <i class="fas fa-exclamation-triangle text-secondary fa-lg"></i>
                                            </el-badge>
                                        </el-tooltip>
                                        <el-tooltip class="item" content="Comprobantes por anular" effect="dark" placement="top-start">
                                            <el-badge
                                                :value="row.document_to_be_canceled"
                                                :type="row.document_to_be_canceled == 0 ? 'primary' : 'danger'"
                                                class="mx-1"
                                            >
                                                <i class="fas fa-exclamation-circle text-secondary fa-lg"></i>
                                            </el-badge>
                                        </el-tooltip>
                                    </div>
                                </td> -->
                                <td class="align-middle text-left">
                                    <template v-if="row.last_register && row.last_register.user">
                                        <span>
                                            <template v-if="String(row.last_register.user).includes('-')">
                                                <span v-for="(part, idx) in String(row.last_register.user).split('-')"
                                                    :key="idx">
                                                    {{ part }}<br
                                                        v-if="idx < String(row.last_register.user).split('-').length - 1" />
                                                </span>
                                            </template>
                                            <template v-else>
                                                {{ row.last_register.user }}
                                            </template>
                                        </span><br />
                                        <span
                                            :class="row.last_register.date_time.is24Hours ? 'text-danger font-italic' : 'text-muted'">
                                            {{ formatDateTime(row.last_register.date_time) }}
                                        </span>
                                    </template>
                                </td>
                                <!-- <td class="align-middle text-center">
                                    <template v-if="row.end_payment">
                                        <span class="badge badge-light px-2 py-1">{{ row.end_payment }}</span>
                                    </template>
                                </td> -->
                                <td class="align-middle text-left">
                                    <span style="font-weight: bold; font-size: 1em;">
                                        {{ row.name }}
                                    </span>
                                    <br />
                                    <a :href="`http://${row.hostname}`" class="text-primary font-weight-bold"
                                        target="_blank">{{
                                        row.hostname }}</a>
                                    <br />
                                    RUC: {{ row.number }}
                                    <div class="row">
                                        <div class="col-6">
                                            Inicio de facturación
                                            <br />
                                            <template v-if="row.start_billing_cycle">
                                                <span class="badge badge-info px-2 py-1">{{ row.start_billing_cycle
                                                    }}</span>
                                            </template>
                                            <template v-else>
                                                <el-date-picker v-model="row.select_date_billing" placeholder="..."
                                                    type="date" value-format="yyyy-MM-dd"
                                                    @change="setStartBillingCycle($event, row.id)"></el-date-picker>
                                            </template>
                                        </div>
                                        <div class="col-6 text-center">
                                            <br />
                                            <span style="color: #155724;">Límite S/</span>
                                            <el-input style="width: 100px;" :min="0"
                                                @input="changeLimitMonthAmount(row)" v-model="row.limit_month_amount"
                                                type="number" placeholder="Monto">
                                            </el-input>
                                        </div>
                                    </div>
                                    <span class="badge badge-light px-2 py-1">{{ row.created_at }}</span>
                                </td>
                                <!-- <td class="align-middle text-center">{{ row.number }}</td>
                                <td class="align-middle">{{ row.name }}</td> -->
                                <!-- <td class="align-middle text-center">
                                    <template v-if="row.start_billing_cycle">
                                        <span class="badge badge-info px-2 py-1">{{ row.start_billing_cycle }}</span>
                                    </template>
                                    <template v-else>
                                        <el-date-picker v-model="row.select_date_billing" placeholder="..." type="date"
                                            value-format="yyyy-MM-dd"
                                            @change="setStartBillingCycle($event, row.id)"></el-date-picker>
                                    </template>
                                </td>
                                <td class="align-middle text-center">
                                    <el-input style="width: 100px;" :min="0" @input="changeLimitMonthAmount(row)"
                                        v-model="row.limit_month_amount" type="number" placeholder="Monto"></el-input>
                                </td> -->
                                <td>
                                    Establecimientos
                                    <data-limit-notification entity_description="establecimientos"
                                        :unlimited="row.establishments_unlimited"
                                        :quantity="row.quantity_establishments"
                                        :max_quantity="row.max_quantity_establishments">
                                    </data-limit-notification>

                                    <div>
                                        Usuarios
                                        <br />
                                        <template v-if="row.max_users !== 0 && row.count_user > row.max_users">
                                            <el-popover :content="text_limit_users" placement="top-start"
                                                trigger="hover" width="220">
                                                <label slot="reference" class="text-danger font-weight-bold">
                                                    {{ row.count_user }}
                                                </label>
                                            </el-popover>
                                        </template>
                                        <template v-else>
                                            <label class="font-weight-bold">{{ row.count_user }}</label>
                                        </template>
                                        /
                                        <template v-if="row.max_users == 0">
                                            <i class="fas fa-infinity"></i>
                                        </template>
                                        <template v-else>
                                            <strong>{{ row.max_users }}</strong>
                                        </template>
                                    </div>
                                </td>
                                <td class="align-middle text-center">
                                    <strong>
                                        {{ row.count_doc_month ? row.count_doc_month : 0 }}
                                        /
                                        <template v-if="row.max_documents == 0">
                                            <i class="fas fa-infinity"></i>
                                        </template>
                                        <template v-else>
                                            <strong>{{ row.max_documents }}</strong>
                                        </template>
                                    </strong>
                                </td>
                                <!-- <td class="align-middle text-center">
                                    <template v-if="row.max_users !== 0 && row.count_user > row.max_users">
                                        <el-popover :content="text_limit_users" placement="top-start" trigger="hover"
                                            width="220">
                                            <label slot="reference" class="text-danger font-weight-bold">
                                                {{ row.count_user }}
                                            </label>
                                        </el-popover>
                                    </template>
                                    <template v-else>
                                        <label class="font-weight-bold">{{ row.count_user }}</label>
                                    </template>
                                    /
                                    <template v-if="row.max_users == 0">
                                        <i class="fas fa-infinity"></i>
                                    </template>
                                    <template v-else>
                                        <strong>{{ row.max_users }}</strong>
                                    </template>
                                </td> -->
                                <!-- <td class="align-middle text-center">
                                    <data-limit-notification entity_description="establecimientos"
                                        :unlimited="row.establishments_unlimited"
                                        :quantity="row.quantity_establishments"
                                        :max_quantity="row.max_quantity_establishments"></data-limit-notification>
                                </td> -->
                                <td class="align-middle text-center">
                                    <data-limit-notification entity_description="ventas"
                                        style_div="width: 150px !important" :unlimited="row.sales_unlimited"
                                        :quantity="row.monthly_sales_total" :max_quantity="row.max_sales_limit">
                                    </data-limit-notification>
                                </td>
                                <!-- <td class="align-middle text-center">
                                    <span class="badge badge-light px-2 py-1">{{ row.created_at }}</span>
                                </td> -->
                                <!-- <td class="align-middle text-center">{{ row.queries_to_apiperu }}</td>
                                <td class="align-middle text-center">
                                    <strong>{{ row.count_sales_notes }}</strong>
                                </td> -->
                            </tr>
                        </data-table>
                    </div>
                </div>
            </div>
        </div>

        <system-clients-form :recordId="recordId" :showDialog.sync="showDialog"></system-clients-form>

        <!--<system-clients-form-edit :showDialog.sync="showDialogEdit"
        :recordId="recordId"></system-clients-form-edit>-->

        <client-payments :clientId="recordId" :affectation_tenant="affectation_tenant" :cash_id="cash_id"
            :client_number="client_number" :client_name="client_name"
            :showDialog.sync="showDialogPayments"></client-payments>

        <account-status :clientId="recordId" :showDialog.sync="showDialogAccountStatus"></account-status>

        <client-delete :record="record" :showDialog.sync="showDialogDelete"></client-delete>
    </div>
</template>

<style scoped>
.custom-dropdown-menu .el-dropdown-menu__item {
    display: flex;
    align-items: center;
    font-size: 15px;
    padding: 8px 18px;
    border-radius: 6px;
    transition: background 0.2s;
}

.custom-dropdown-menu .dropdown-item-password:hover {
    background: #fffbe6;
}

.custom-dropdown-menu .dropdown-item-delete:hover {
    background: #ffeaea;
}

.custom-dropdown-menu .dropdown-item-payments:hover {
    background: #eaffea;
}

.custom-dropdown-menu .dropdown-item-account:hover {
    background: #eaf6ff;
}

.custom-dropdown-menu .dropdown-item-edit:hover {
    background: #eaf0ff;
}

.el-dropdown {
    vertical-align: top;
}

.el-dropdown+.el-dropdown {
    margin-left: 15px;
}

.el-icon-arrow-down {
    font-size: 12px;
}

table.dataTable.dataTable_width_auto {
    width: auto;
}

.badge-demo {
    background-color: #ffc107;
    /* Ámbar */
    color: white;
}

.badge-produccion {
    background-color: #28a745;
    /* Verde */
    color: white;
}

.badge-interno {
    background-color: #17a2b8;
    /* Azul */
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

.card {
    transition: box-shadow 0.2s;
}

.card:hover {
    box-shadow: 0 0.5rem 1rem rgba(44, 62, 80, .15) !important;
}

.progress1 {
    width: 80px;
    height: 80px;
    position: relative;
}

.progress1-value {
    font-size: 1.5rem;
}

.display-4 {
    font-size: 2.2rem;
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
import { debounce } from "lodash";

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
            canSee: false,
            active: null,
            client_name: null,
            client_number: null,
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
            affectation_tenant: null,
            cash_id: null,
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
            record: {},
            buttonLoading: false, // Add a new state for the button
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
        this.$eventHub.$on("reloadData", () => {
            this.getData();
        });
        this.getData();
        this.getAffectationTenant();
        this.text_limit_doc = "El límite de comprobantes fue superado";
        this.text_limit_users = "El límite de usuarios fue superado";
    },
    methods: {
        hideImage(event) {
            event.target.style.display = 'none';
        },
        clickSendPaymentsMessages() {
            this.loading = true;
            this.$http
                .get(`/client_payments/send_payments_messages`)
                .then(response => {
                    this.$message.success(response.data.message);
                    this.loading = false;
                })
                .catch(error => {
                    this.loading = false;
                });
        },
        /* peticon para las tareas programanados hacia el servidor*/
        async clickResetProgramn() {
            this.buttonLoading = true; // Set button loading state
            try {
                const response = await this.$http.post(`tasks/programan`);
                this.$message.success(response.data.message);
            } catch (error) {
                console.error("Error ejecutando tareas:", error);
                this.$message.error("Hubo un error al ejecutar las tareas.");
            } finally {
                this.buttonLoading = false; // Reset button loading state
            }
        },
        getAffectationTenant() {
            this.$http
                .get(`/${this.resource}/affectation_tenant`)
                .then(response => {
                    this.affectation_tenant = response.data.affectation_tenant;
                    this.cash_id = response.data.cash_id;
                });
        },
        changeLimitMonthAmount: debounce(function (row) {
            this.loading = true;
            this.$http
                .post(`/${this.resource}/change_limit_month_amount`, row)
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
                .then(() => { });
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
                .then(() => { });
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
                .then(() => { });
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
                .then(() => { });
        },
        getData(records = null) {
            if (records) {
                this.records = records;
            } else {
                if (this.$refs.dataTable) {
                    this.records = this.$refs.dataTable.records;
                }
            }
        },
        clickCreate(recordId = null) {
            this.recordId = recordId;

            this.showDialog = true;
        },
        clickPayments(recordId = null) {
            this.recordId = recordId;
            let client = this.records.find(record => record.id == recordId);
            this.client_number = client.company_number;
            this.client_name = client.company_name;
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
