<!-- Comprobantes  Caja -->
<template>
    <div v-loading="loading" class="">
        <div class="table-responsive col-md-12">
            <table
                class="table table-hover table-striped table-bordered table-responsive"
                style="width: 100%; white-space: nowrap; font-size: 14px;"
            >
                <thead class="thead-dark">
                    <tr class="bg-primary text-center">
                        <th v-if="type == 'documents'" class="text-white">
                            SUNAT
                        </th>

                        <th v-if="type == 'saleNotes'" class="text-white">
                            Acciones
                        </th>
                        <th
                            class="text-white"
                            v-if="type == 'quotations' || type == 'guides'"
                        >
                            Opciones
                        </th>
                        <th
                            v-if="
                                configuration.restaurant &&
                                    (type == 'documents' || type == 'saleNotes')
                            "
                            class="text-white"
                        >
                            Mesa Atendida
                        </th>
                        <th class="text-white">CPE Nº</th>
                        <th class="text-white">Fecha/Hora</th>
                        <th class="text-white">Cliente</th>
                        <th v-if="type == 'quotations'" class="text-white">
                            Vendedor
                        </th>
                        <th v-if="type == 'quotations'" class="text-white">
                            Dctos
                        </th>
                        <th v-if="type == 'documents'" class="text-white">
                            N/V
                        </th>
                        <th v-if="type == 'saleNotes'" class="text-white">
                            CPE
                        </th>
                        <th class="text-white">Estado</th>
                        <th
                            v-if="type == 'documents' || type == 'saleNotes'"
                            class="text-white"
                        >
                            Saldo
                        </th>
                        <th class="text-white" v-if="type != 'guides'">
                            Monto
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="(data, idx) in records"
                        :key="idx"
                        :class="{
                            'row-danger-border':
                                data.state_type_id == '11' ||
                                data.state_type_id == '13'
                        }"
                        class="text-center align-middle"
                    >
                        <!-- Menu CPE -->
                        <td
                            v-if="type == 'documents' && type !== 'saleNotes'"
                            :class="{
                                'text-white':
                                    data.state_type_id != '11' &&
                                    data.state_type_id != '13'
                            }"
                        >
                            <el-tooltip
                                content="Envio y descarga por WhatsApp CPE"
                                placement="top"
                            >
                                <el-button
                                    v-if="data.state_type_id == '11'"
                                    size="mini"
                                    type="info"
                                    circle
                                    class="me-1"
                                    @click="clickDocuments(data.id)"
                                >
                                    <i class="el-icon-document"></i>
                                </el-button>
                            </el-tooltip>
                            <el-tooltip
                                content="Previsualiza pdf"
                                placement="top"
                            >
                                <el-button
                                    v-if="data.state_type_id == '11'"
                                    size="mini"
                                    type="danger"
                                    circle
                                    style="border: 2px solid white;"
                                    @click="
                                        previsualitation(
                                            data.external_id,
                                            data.document_type_id
                                        )
                                    "
                                >
                                    <i class="far fa-file-pdf"></i>
                                </el-button>
                            </el-tooltip>

                            <el-dropdown>
                                <el-button
                                    type="primary"
                                    v-if="
                                        data.state_type_id != '11' &&
                                            data.state_type_id != '13'
                                    "
                                >
                                    Acciones<i
                                        class="el-icon-arrow-down el-icon--right"
                                    ></i>
                                </el-button>
                                <el-dropdown-menu slot="dropdown">
                                    <el-button
                                        append-to-body
                                        class="dropdown-item d-flex align-items-center"
                                        style="background-color: #ff4d4f; color: white; width: 100%; padding: 12px 10px; margin: 10px auto; border-radius: 5px; transition: all 0.3s ease;"
                                        v-if="
                                            data.state_type_id == '01' &&
                                                configuration.caja_actions &&
                                                configuration.internal_voided
                                        "
                                        type="text"
                                        @click="clickDeleteDocument(data.id)"
                                    >
                                        <i
                                            class="el-icon-close me-2"
                                            style="color: white; margin-right: 10px;"
                                        ></i>
                                        <span>Anulado Interno</span>
                                    </el-button>
                                    <el-button
                                        class="dropdown-item d-flex align-items-center"
                                        style="background-color: #ffcc00; color: black; width: 100%; padding: 12px 10px; margin: 10px auto; border-radius: 5px; transition: all 0.3s ease;"
                                        v-if="
                                            data.document_type_id == '01' &&
                                                data.document_type_id == '03' &&
                                                data.state_type_id == '05' &&
                                                configuration.anulate_sunat_cash
                                        "
                                        type="text"
                                        @click="clickVoided(data.id)"
                                    >
                                        <i
                                            class="el-icon-warning me-2"
                                            style="color: black; margin-right: 10px;"
                                        ></i>
                                        <span>Anular SUNAT</span>
                                    </el-button>
                                    <el-button
                                        class="dropdown-item d-flex align-items-center"
                                        style="background-color: #17a2b8; color: white; width: 100%; padding: 12px 10px; margin: 10px auto; border-radius: 5px; transition: all 0.3s ease;"
                                        v-if="data.state_type_id == '05'"
                                        type="text"
                                        @click="clickNote(data.id)"
                                    >
                                        <i
                                            class="el-icon-document me-2"
                                            style="color: white; margin-right: 10px;"
                                        ></i>
                                        <span>Nota de Crédito</span>
                                    </el-button>
                                    <el-button
                                        class="dropdown-item d-flex align-items-center"
                                        style="background-color: #52c41a; color: white; width: 100%; padding: 12px 10px; margin: 10px auto; border-radius: 5px; transition: all 0.3s ease;"
                                        v-if="data.is_credit"
                                        type="text"
                                        @click="clickPayment(data.id)"
                                    >
                                        <i
                                            class="el-icon-money me-2"
                                            style="color: white; margin-right: 10px;"
                                        ></i>
                                        <span>Pagos CPE</span>
                                    </el-button>
                                    <el-button
                                        class="dropdown-item d-flex align-items-center"
                                        style="background-color: #1890ff; color: white; width: 100%; padding: 12px 10px; margin: 10px auto; border-radius: 5px; transition: all 0.3s ease;"
                                        v-if="
                                            type == 'documents' &&
                                                data.state_type_id != '11' &&
                                                data.state_type_id != '13'
                                        "
                                        type="text"
                                        @click="clickSendOnline(data.id)"
                                    >
                                        <i
                                            class="el-icon-refresh me-2"
                                            style="color: white; margin-right: 10px;"
                                        ></i>
                                        <span>Reenviar CPE</span>
                                    </el-button>
                                    <el-button
                                        class="dropdown-item d-flex align-items-center"
                                        style="background-color: #13c2c2; color: white; width: 100%; padding: 12px 10px; margin: 10px auto; border-radius: 5px; transition: all 0.3s ease;"
                                        v-if="
                                            type == 'documents' &&
                                                data.state_type_id != '11' &&
                                                data.state_type_id != '13'
                                        "
                                        type="text"
                                        @click="clickValidarCpe(data.id)"
                                    >
                                        <i
                                            class="el-icon-check me-2"
                                            style="color: white; margin-right: 10px;"
                                        ></i>
                                        <span>Validar CPE</span>
                                    </el-button>
                                    <el-button
                                        class="dropdown-item d-flex align-items-center"
                                        style="background-color: #228B22; color: white; width: 100%; padding: 12px 10px; margin: 10px auto; border-radius: 5px; transition: all 0.3s ease;"
                                        v-if="
                                            data.state_type_id != '11' &&
                                                data.state_type_id != '13' &&
                                                cash_id
                                        "
                                        type="text"
                                        @click="clickGenerateGuie(data.id)"
                                    >
                                        <i
                                            class="el-icon-truck me-2"
                                            style="color: white; margin-right: 10px;"
                                        ></i>
                                        <span>Generar Guía</span>
                                    </el-button>

                                    <template v-if="type !== 'quotations'">
                                        <el-tooltip
                                            content="Envio y descarga por WhatsApp CPE"
                                            placement="top"
                                        >
                                            <el-button
                                                v-if="
                                                    data.state_type_id !=
                                                        '11' &&
                                                        data.state_type_id !=
                                                            '13'
                                                "
                                                size="mini"
                                                type="info"
                                                circle
                                                class="me-1"
                                                @click="clickDocuments(data.id)"
                                            >
                                                <i class="el-icon-document"></i>
                                            </el-button>
                                        </el-tooltip>
                                        <el-tooltip
                                            content="Enviar por WhatsApp"
                                            placement="top"
                                        >
                                            <el-button
                                                v-if="
                                                    data.state_type_id !=
                                                        '11' &&
                                                        data.state_type_id !=
                                                            '13'
                                                "
                                                size="mini"
                                                type="success"
                                                class="me-1"
                                                circle
                                                @click="clickOpenWhatsapp(data)"
                                            >
                                                <i class="fab fa-whatsapp"></i>
                                            </el-button>
                                        </el-tooltip>
                                        <el-tooltip
                                            content="Imprimir"
                                            placement="top"
                                        >
                                            <el-button
                                                v-if="
                                                    data.state_type_id !=
                                                        '11' &&
                                                        data.state_type_id !=
                                                            '13' &&
                                                        configuration.print_document_cash
                                                "
                                                size="mini"
                                                type="primary"
                                                class="me-1"
                                                circle
                                                @click="
                                                    print(
                                                        data.external_id,
                                                        data.document_type_id
                                                    )
                                                "
                                            >
                                                <i class="fas fa-print"></i>
                                            </el-button>
                                        </el-tooltip>
                                        <el-tooltip
                                            content="Previsualizar PDF"
                                            placement="top"
                                        >
                                            <el-button
                                                size="mini"
                                                type="danger"
                                                circle
                                                style="border: 2px solid white;"
                                                @click="
                                                    previsualitation(
                                                        data.external_id,
                                                        data.document_type_id
                                                    )
                                                "
                                            >
                                                <i class="far fa-file-pdf"></i>
                                            </el-button>
                                        </el-tooltip>
                                    </template>
                                </el-dropdown-menu>
                            </el-dropdown>

                            <!-- <div class="dropdown">
                                <button
                                    v-if="
                                        data.state_type_id != '11' &&
                                            data.state_type_id != '13'
                                    "
                                    class="btn btn-primary btn-sm dropdown-toggle"
                                    type="button"
                                    data-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false"
                                >
                                    <i class="fas fa-list"></i>
                                </button>
                                <div
                                    class="dropdown-menu"
                                    style="max-height: 250px; overflow-y: auto;"
                                >
                                    <template>
                                        
                                        <el-button
                                            append-to-body
                                            class="dropdown-item d-flex align-items-center"
                                            style="background-color: #ff4d4f; color: white; width: 100%; padding: 12px 10px; margin: 10px auto; border-radius: 5px; transition: all 0.3s ease;"
                                            v-if="
                                                data.state_type_id == '01' &&
                                                    configuration.caja_actions &&
                                                    configuration.internal_voided
                                            "
                                            type="text"
                                            @click="
                                                clickDeleteDocument(data.id)
                                            "
                                        >
                                            <i
                                                class="el-icon-close me-2"
                                                style="color: white; margin-right: 10px;"
                                            ></i>
                                            <span>Anulado Interno</span>
                                        </el-button>

                                        
                                        <el-button
                                            class="dropdown-item d-flex align-items-center"
                                            style="background-color: #ffcc00; color: black; width: 100%; padding: 12px 10px; margin: 10px auto; border-radius: 5px; transition: all 0.3s ease;"
                                            v-if="
                                                data.document_type_id == '01' &&
                                                    data.document_type_id ==
                                                        '03' &&
                                                    data.state_type_id ==
                                                        '05' &&
                                                    configuration.anulate_sunat_cash
                                            "
                                            type="text"
                                            @click="clickVoided(data.id)"
                                        >
                                            <i
                                                class="el-icon-warning me-2"
                                                style="color: black; margin-right: 10px;"
                                            ></i>
                                            <span>Anular SUNAT</span>
                                        </el-button>

                                       
                                        <el-button
                                            class="dropdown-item d-flex align-items-center"
                                            style="background-color: #17a2b8; color: white; width: 100%; padding: 12px 10px; margin: 10px auto; border-radius: 5px; transition: all 0.3s ease;"
                                            v-if="data.state_type_id == '05'"
                                            type="text"
                                            @click="clickNote(data.id)"
                                        >
                                            <i
                                                class="el-icon-document me-2"
                                                style="color: white; margin-right: 10px;"
                                            ></i>
                                            <span>Nota de Crédito</span>
                                        </el-button>

                                        
                                        <el-button
                                            class="dropdown-item d-flex align-items-center"
                                            style="background-color: #52c41a; color: white; width: 100%; padding: 12px 10px; margin: 10px auto; border-radius: 5px; transition: all 0.3s ease;"
                                            v-if="data.is_credit"
                                            type="text"
                                            @click="clickPayment(data.id)"
                                        >
                                            <i
                                                class="el-icon-money me-2"
                                                style="color: white; margin-right: 10px;"
                                            ></i>
                                            <span>Pagos CPE</span>
                                        </el-button>
                                    </template>

                                   
                                    <el-button
                                        class="dropdown-item d-flex align-items-center"
                                        style="background-color: #1890ff; color: white; width: 100%; padding: 12px 10px; margin: 10px auto; border-radius: 5px; transition: all 0.3s ease;"
                                        v-if="
                                            type == 'documents' &&
                                                data.state_type_id != '11' &&
                                                data.state_type_id != '13'
                                        "
                                        type="text"
                                        @click="clickSendOnline(data.id)"
                                    >
                                        <i
                                            class="el-icon-refresh me-2"
                                            style="color: white; margin-right: 10px;"
                                        ></i>
                                        <span>Reenviar CPE</span>
                                    </el-button>

                                    
                                    <el-button
                                        class="dropdown-item d-flex align-items-center"
                                        style="background-color: #13c2c2; color: white; width: 100%; padding: 12px 10px; margin: 10px auto; border-radius: 5px; transition: all 0.3s ease;"
                                        v-if="
                                            type == 'documents' &&
                                                data.state_type_id != '11' &&
                                                data.state_type_id != '13'
                                        "
                                        type="text"
                                        @click="clickValidarCpe(data.id)"
                                    >
                                        <i
                                            class="el-icon-check me-2"
                                            style="color: white; margin-right: 10px;"
                                        ></i>
                                        <span>Validar CPE</span>
                                    </el-button>

                                    
                                    <el-button
                                        class="dropdown-item d-flex align-items-center"
                                        style="background-color: #228B22; color: white; width: 100%; padding: 12px 10px; margin: 10px auto; border-radius: 5px; transition: all 0.3s ease;"
                                        v-if="
                                            data.state_type_id != '11' &&
                                                data.state_type_id != '13' &&
                                                cash_id
                                        "
                                        type="text"
                                        @click="clickGenerateGuie(data.id)"
                                    >
                                        <i
                                            class="el-icon-truck me-2"
                                            style="color: white; margin-right: 10px;"
                                        ></i>
                                        <span>Generar Guía</span>
                                    </el-button>
                                </div>
                            </div> -->
                        </td>

                        <!-- Menu Notas de Venta -->
                        <td
                            v-if="
                                type == 'saleNotes' &&
                                    type != 'documents' &&
                                    type != 'quotations'
                            "
                            :class="{
                                'text-white':
                                    data.state_type_id == '11' ||
                                    data.state_type_id == '13'
                            }"
                        >
                            <template
                                v-if="data.state_type_description === 'Anulado'"
                            >
                                <el-tooltip content="Opciones" placement="top">
                                    <el-button
                                        type="success"
                                        size="mini"
                                        circle
                                        @click="clickOptions(data.id)"
                                    >
                                        <i class="far fa-file-pdf"></i>
                                    </el-button>
                                </el-tooltip>
                                <el-tooltip
                                    content="Previsualización de pdf (Descargar)"
                                    placement="top"
                                >
                                    <el-button
                                        type="danger"
                                        size="mini"
                                        circle
                                        @click="
                                            previsualitation(
                                                data.external_id,
                                                data.document_type_id
                                            )
                                        "
                                    >
                                        <i class="far fa-file-pdf"></i>
                                    </el-button>
                                </el-tooltip>
                            </template>
                            <el-dropdown>
                                <el-button
                                    type="primary"
                                    v-if="
                                        data.state_type_id != '11' &&
                                            data.state_type_id != '13'
                                    "
                                >
                                    Acciones<i
                                        class="el-icon-arrow-down el-icon--right"
                                    ></i>
                                </el-button>
                                <el-dropdown-menu slot="dropdown">
                                    <template v-if="configuration.caja_actions">
                                        <el-button
                                            class="dropdown-item d-flex align-items-center"
                                            style="background-color: #ff4d4f; color: white; width: 100%; padding: 12px 10px; margin: 10px auto; margin-right: 5px; border-radius: 5px; transition: all 0.3s ease;"
                                            v-if="
                                                data.state_type_id != '11' &&
                                                    data.state_type_id != '13'
                                            "
                                            @click="clickVoidedNote(data)"
                                        >
                                            <i
                                                class="el-icon-close me-2"
                                                style="color: white; margin-right: 10px;"
                                            ></i>
                                            <span>Anular </span>
                                        </el-button>
                                    </template>
                                    <el-button
                                        class="dropdown-item d-flex align-items-center"
                                        style="background-color: #007bff; color: white; width: 100%; padding: 12px 10px; margin: 10px auto; margin-right: 5px; border-radius: 5px; transition: all 0.3s ease;"
                                        v-if="
                                            data.state_type_id != '11' &&
                                                data.state_type_id != '13' &&
                                                !data.changed &&
                                                cash_id
                                        "
                                        @click="clickGenerate(data.id)"
                                    >
                                        <i
                                            class="el-icon-document me-2"
                                            style="color: white; margin-right: 10px;"
                                        ></i>
                                        <span>Generar CPE</span>
                                    </el-button>

                                    <!-- Generar Guia de Remisión -->
                                    <el-button
                                        class="dropdown-item d-flex align-items-center"
                                        style="background-color: #28a745; color: white; width: 100%; padding: 12px 10px; margin: 10px auto; margin-right: 5px; border-radius: 5px; transition: all 0.3s ease;"
                                        v-if="
                                            data.state_type_id != '11' &&
                                                data.state_type_id != '13' &&
                                                cash_id
                                        "
                                        @click="
                                            clickGenerateGuie(data.id, '80')
                                        "
                                    >
                                        <i
                                            class="el-icon-truck me-2"
                                            style="color: white; margin-right: 10px;"
                                        ></i>
                                        <span>Generar Guía</span>
                                    </el-button>
                                    <template v-if="type !== 'quotations'">
                                        <el-tooltip
                                            content="Enviar por WhatsApp"
                                            placement="top"
                                        >
                                            <el-button
                                                v-if="
                                                    data.state_type_id !=
                                                        '11' &&
                                                        data.state_type_id !=
                                                            '13'
                                                "
                                                size="mini"
                                                type="success"
                                                class="me-1"
                                                circle
                                                @click="clickOpenWhatsapp(data)"
                                            >
                                                <i class="fab fa-whatsapp"></i>
                                            </el-button>
                                        </el-tooltip>
                                        <el-tooltip
                                            content="Imprimir"
                                            placement="top"
                                        >
                                            <el-button
                                                v-if="
                                                    data.state_type_id !=
                                                        '11' &&
                                                        data.state_type_id !=
                                                            '13' &&
                                                        configuration.print_document_cash
                                                "
                                                size="mini"
                                                type="primary"
                                                class="me-1"
                                                circle
                                                @click="
                                                    print(
                                                        data.external_id,
                                                        data.document_type_id
                                                    )
                                                "
                                            >
                                                <i class="fas fa-print"></i>
                                            </el-button>
                                        </el-tooltip>
                                        <el-tooltip
                                            content="Previsualizar PDF"
                                            placement="top"
                                        >
                                            <el-button
                                                size="mini"
                                                type="danger"
                                                circle
                                                style="border: 2px solid white;"
                                                @click="
                                                    previsualitation(
                                                        data.external_id,
                                                        data.document_type_id
                                                    )
                                                "
                                            >
                                                <i class="far fa-file-pdf"></i>
                                            </el-button>
                                        </el-tooltip>
                                    </template>
                                </el-dropdown-menu>
                            </el-dropdown>

                            <!-- <div class="dropdown-as-select d-inline-block">
                                <button
                                    v-if="
                                        data.state_type_id != '11' &&
                                            data.state_type_id != '13'
                                    "
                                    class="btn btn-primary btn-sm dropdown-toggle"
                                    type="button"
                                    data-bs-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false"
                                >
                                    <i class="fas fa-list"></i>
                                </button>
                                <div
                                    class="dropdown-menu p-1"
                                    style="background-color: #6c757d; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"
                                >
                                    
                                    <template v-if="configuration.caja_actions">
                                        <el-button
                                            class="dropdown-item d-flex align-items-center"
                                            style="background-color: #ff4d4f; color: white; width: 100%; padding: 12px 10px; margin: 10px auto; margin-right: 5px; border-radius: 5px; transition: all 0.3s ease;"
                                            v-if="
                                                data.state_type_id != '11' &&
                                                    data.state_type_id != '13'
                                            "
                                            @click="clickVoidedNote(data)"
                                        >
                                            <i
                                                class="el-icon-close me-2"
                                                style="color: white; margin-right: 10px;"
                                            ></i>
                                            <span>Anular </span>
                                        </el-button>
                                    </template>
                                    
                                    <el-button
                                        class="dropdown-item d-flex align-items-center"
                                        style="background-color: #007bff; color: white; width: 100%; padding: 12px 10px; margin: 10px auto; margin-right: 5px; border-radius: 5px; transition: all 0.3s ease;"
                                        v-if="
                                            data.state_type_id != '11' &&
                                                data.state_type_id != '13' &&
                                                !data.changed &&
                                                cash_id
                                        "
                                        @click="clickGenerate(data.id)"
                                    >
                                        <i
                                            class="el-icon-document me-2"
                                            style="color: white; margin-right: 10px;"
                                        ></i>
                                        <span>Generar CPE</span>
                                    </el-button>

                                    
                                    <el-button
                                        class="dropdown-item d-flex align-items-center"
                                        style="background-color: #28a745; color: white; width: 100%; padding: 12px 10px; margin: 10px auto; margin-right: 5px; border-radius: 5px; transition: all 0.3s ease;"
                                        v-if="
                                            data.state_type_id != '11' &&
                                                data.state_type_id != '13' &&
                                                cash_id
                                        "
                                        @click="
                                            clickGenerateGuie(data.id, '80')
                                        "
                                    >
                                        <i
                                            class="el-icon-truck me-2"
                                            style="color: white; margin-right: 10px;"
                                        ></i>
                                        <span>Generar Guía</span>
                                    </el-button>

                                   
                                    <el-button
                                        class="dropdown-item d-flex align-items-center"
                                        style="background-color: #17a2b8; color: white; width: 100%; padding: 12px 10px; margin: 10px auto; margin-right: 5px; border-radius: 5px; transition: all 0.3s ease;"
                                        v-if="data.paid == 0 && !data.is_credit"
                                        @click="clickPaymentSaleNotes(data.id)"
                                    >
                                        <i
                                            class="el-icon-money me-2"
                                            style="color: white; margin-right: 10px;"
                                        ></i>
                                        <span>Pagos</span>
                                    </el-button>
                                    
                                    <template v-if="type !== 'quotations'">
                                        <el-tooltip
                                            content="Enviar por WhatsApp"
                                            placement="top"
                                        >
                                            <el-button
                                                v-if="
                                                    data.state_type_id !=
                                                        '11' &&
                                                        data.state_type_id !=
                                                            '13'
                                                "
                                                size="mini"
                                                type="success"
                                                class="me-1"
                                                circle
                                                @click="clickOpenWhatsapp(data)"
                                            >
                                                <i class="fab fa-whatsapp"></i>
                                            </el-button>
                                        </el-tooltip>
                                        <el-tooltip
                                            content="Imprimir"
                                            placement="top"
                                        >
                                            <el-button
                                                v-if="
                                                    data.state_type_id !=
                                                        '11' &&
                                                        data.state_type_id !=
                                                            '13' &&
                                                        configuration.print_document_cash
                                                "
                                                size="mini"
                                                type="primary"
                                                class="me-1"
                                                circle
                                                @click="
                                                    print(
                                                        data.external_id,
                                                        data.document_type_id
                                                    )
                                                "
                                            >
                                                <i class="fas fa-print"></i>
                                            </el-button>
                                        </el-tooltip>
                                        <el-tooltip
                                            content="Previsualizar PDF"
                                            placement="top"
                                        >
                                            <el-button
                                                size="mini"
                                                type="danger"
                                                circle
                                                style="border: 2px solid white;"
                                                @click="
                                                    previsualitation(
                                                        data.external_id,
                                                        data.document_type_id
                                                    )
                                                "
                                            >
                                                <i class="far fa-file-pdf"></i>
                                            </el-button>
                                        </el-tooltip>
                                    </template>
                                </div>
                            </div> -->
                        </td>

                        <!-- Menu Cotizaciones -->
                        <td
                            v-if="
                                type === 'quotations' &&
                                    type !== 'saleNotes' &&
                                    type !== 'documents'
                            "
                        >
                            <template v-if="type == 'quotations'">
                                <div class="dropdown-as-select d-inline-block">
                                    <!-- Si esta Anulado  muestra este boton de Previsualizar -->
                                    <el-button
                                        v-if="data.state_type_id === '11'"
                                        type="text"
                                        style="border: 2px solid white; color: black; padding: 5px; margin: 5px auto; border-radius: 5px; transition: all 0.3s ease;"
                                        @click="
                                            previsualitation(
                                                data.external_id,
                                                data.document_type_id
                                            )
                                        "
                                    >
                                        <i
                                            class="el-icon-view"
                                            style="color: white;"
                                        ></i>
                                    </el-button>

                                    <el-dropdown>
                                        <el-button
                                            type="primary"
                                            v-if="data.state_type_id != '11'"
                                        >
                                            Acciones<i
                                                class="el-icon-arrow-down el-icon--right"
                                            ></i>
                                        </el-button>
                                        <el-dropdown-menu slot="dropdown">
                                            <el-button
                                                v-if="cash_id"
                                                class="dropdown-item d-flex align-items-center"
                                                style="background-color: #6f42c1; color: white; width: 100%; padding: 12px 10px; margin: 10px auto; border-radius: 5px; transition: all 0.3s ease;"
                                                @click="
                                                    clickOptionsQuotation(
                                                        data.id
                                                    )
                                                "
                                            >
                                                <i
                                                    class="el-icon-document me-2"
                                                    style="color: white; margin-right: 10px;"
                                                ></i>
                                                <span>Generar CPE</span>
                                            </el-button>

                                            <!-- Editar -->
                                            <el-button
                                                class="dropdown-item d-flex align-items-center"
                                                style="background-color: #007bff; color: white; width: 100%; padding: 12px 10px; margin: 10px auto; border-radius: 5px; transition: all 0.3s ease;"
                                                v-if="!configuration.maderera"
                                                @click="
                                                    clickEditQuotation(data.id)
                                                "
                                            >
                                                <i
                                                    class="el-icon-edit me-2"
                                                    style="color: white; margin-right: 10px;"
                                                ></i>
                                                <span>Editar</span>
                                            </el-button>
                                            <el-button
                                                v-if="cash_id"
                                                class="dropdown-item d-flex align-items-center"
                                                style="background-color: #dc3545; color: white; width: 100%; padding: 12px 10px; margin: 10px auto; border-radius: 5px; transition: all 0.3s ease;"
                                                @click="
                                                    clickAnulateQuotation(
                                                        data.id
                                                    )
                                                "
                                            >
                                                <i
                                                    class="el-icon-delete me-2"
                                                    style="color: white; margin-right: 10px;"
                                                ></i>
                                                <span>Anular</span>
                                            </el-button>
                                            <el-button
                                                v-if="cash_id"
                                                class="dropdown-item d-flex align-items-center"
                                                style="background-color: #dc3545; color: white; width: 100%; padding: 12px 10px; margin: 10px auto; border-radius: 5px; transition: all 0.3s ease;"
                                                @click="clickQotations(data.id)"
                                            >
                                                <i
                                                    class="el-icon-delete me-2"
                                                    style="color: white; margin-right: 10px;"
                                                ></i>
                                                <span>Formatos pdf</span>
                                            </el-button>
                                            <template>
                                                <!-- Envia Cotización por WhatsApp -->
                                                <el-tooltip
                                                    content="Enviar por WhatsApp"
                                                    placement="top"
                                                >
                                                    <el-button
                                                        size="mini"
                                                        type="success"
                                                        class="me-1"
                                                        circle
                                                        @click="
                                                            clickOpenWhatsapp(
                                                                data
                                                            )
                                                        "
                                                    >
                                                        <i
                                                            class="fab fa-whatsapp"
                                                        ></i>
                                                    </el-button>
                                                </el-tooltip>

                                                <!-- Imprimir Cotizacion -->
                                                <el-tooltip
                                                    content="Imprimir"
                                                    placement="top"
                                                >
                                                    <el-button
                                                        v-if="
                                                            configuration.print_document_cash
                                                        "
                                                        size="mini"
                                                        type="primary"
                                                        class="me-1"
                                                        circle
                                                        @click="
                                                            print(
                                                                data.external_id,
                                                                data.document_type_id
                                                            )
                                                        "
                                                    >
                                                        <i
                                                            class="fas fa-print"
                                                        ></i>
                                                    </el-button>
                                                </el-tooltip>
                                                <!-- Previsualizar cotización -->
                                                <el-tooltip
                                                    content="Previsualizar PDF"
                                                    placement="top"
                                                >
                                                    <el-button
                                                        size="mini"
                                                        type="danger"
                                                        circle
                                                        style="border: 2px solid white;"
                                                        @click="
                                                            previsualitation(
                                                                data.external_id,
                                                                data.document_type_id
                                                            )
                                                        "
                                                    >
                                                        <i
                                                            class="far fa-file-pdf"
                                                        ></i>
                                                    </el-button>
                                                </el-tooltip>
                                            </template>
                                        </el-dropdown-menu>
                                    </el-dropdown>

                                    <!-- Acciones de Cotización -->
                                    <!-- <button
                                        v-if="data.state_type_id != '11'"
                                        class="btn btn-primary btn-sm dropdown-toggle"
                                        type="button"
                                        data-bs-toggle="dropdown"
                                        aria-haspopup="true"
                                        aria-expanded="false"
                                    >
                                        <i class="fas fa-list"></i>
                                    </button> -->
                                    <!-- <div
                                        class="dropdown-menu p-1"
                                        style="background-color: #6c757d; 
                                         border-radius: 8px; 
                                         box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"
                                    >
                                      
                                        <el-button
                                            v-if="cash_id"
                                            class="dropdown-item d-flex align-items-center"
                                            style="background-color: #6f42c1; color: white; width: 100%; padding: 12px 10px; margin: 10px auto; border-radius: 5px; transition: all 0.3s ease;"
                                            @click="
                                                clickOptionsQuotation(data.id)
                                            "
                                        >
                                            <i
                                                class="el-icon-document me-2"
                                                style="color: white; margin-right: 10px;"
                                            ></i>
                                            <span>Generar CPE</span>
                                        </el-button>

                                       
                                        <el-button
                                            class="dropdown-item d-flex align-items-center"
                                            style="background-color: #007bff; color: white; width: 100%; padding: 12px 10px; margin: 10px auto; border-radius: 5px; transition: all 0.3s ease;"
                                            v-if="!configuration.maderera"
                                            @click="clickEditQuotation(data.id)"
                                        >
                                            <i
                                                class="el-icon-edit me-2"
                                                style="color: white; margin-right: 10px;"
                                            ></i>
                                            <span>Editar</span>
                                        </el-button>

                                        
                                        <el-button
                                            v-if="cash_id"
                                            class="dropdown-item d-flex align-items-center"
                                            style="background-color: #dc3545; color: white; width: 100%; padding: 12px 10px; margin: 10px auto; border-radius: 5px; transition: all 0.3s ease;"
                                            @click="
                                                clickAnulateQuotation(data.id)
                                            "
                                        >
                                            <i
                                                class="el-icon-delete me-2"
                                                style="color: white; margin-right: 10px;"
                                            ></i>
                                            <span>Anular</span>
                                        </el-button>
                                        <el-button
                                            v-if="cash_id"
                                            class="dropdown-item d-flex align-items-center"
                                            style="background-color: #dc3545; color: white; width: 100%; padding: 12px 10px; margin: 10px auto; border-radius: 5px; transition: all 0.3s ease;"
                                            @click="clickQotations(data.id)"
                                        >
                                            <i
                                                class="el-icon-delete me-2"
                                                style="color: white; margin-right: 10px;"
                                            ></i>
                                            <span>Formatos pdf</span>
                                        </el-button>

                                       
                                        <template>
                                            
                                            <el-tooltip
                                                content="Enviar por WhatsApp"
                                                placement="top"
                                            >
                                                <el-button
                                                    size="mini"
                                                    type="success"
                                                    class="me-1"
                                                    circle
                                                    @click="
                                                        clickOpenWhatsapp(data)
                                                    "
                                                >
                                                    <i
                                                        class="fab fa-whatsapp"
                                                    ></i>
                                                </el-button>
                                            </el-tooltip>

                                            
                                            <el-tooltip
                                                content="Imprimir"
                                                placement="top"
                                            >
                                                <el-button
                                                    v-if="
                                                        configuration.print_document_cash
                                                    "
                                                    size="mini"
                                                    type="primary"
                                                    class="me-1"
                                                    circle
                                                    @click="
                                                        print(
                                                            data.external_id,
                                                            data.document_type_id
                                                        )
                                                    "
                                                >
                                                    <i class="fas fa-print"></i>
                                                </el-button>
                                            </el-tooltip>
                                        
                                            <el-tooltip
                                                content="Previsualizar PDF"
                                                placement="top"
                                            >
                                                <el-button
                                                    size="mini"
                                                    type="danger"
                                                    circle
                                                    style="border: 2px solid white;"
                                                    @click="
                                                        previsualitation(
                                                            data.external_id,
                                                            data.document_type_id
                                                        )
                                                    "
                                                >
                                                    <i
                                                        class="far fa-file-pdf"
                                                    ></i>
                                                </el-button>
                                            </el-tooltip>
                                        </template>
                                    </div> -->
                                </div>
                            </template>
                        </td>
                        <!-- para las guias -->
                        <td
                            v-if="
                                type === 'guides' &&
                                    type !== 'saleNotes' &&
                                    type !== 'documents' &&
                                    type !== 'quotations'
                            "
                        >
                            <template v-if="type == 'guides'">
                                <div class="dropdown-as-select d-inline-block">
                                    <!-- Si esta Anulado  muestra este boton de Previsualizar -->

                                    <el-dropdown>
  <el-button type="primary" v-if="data.state_type_id != '11'">
    Acciones<i class="el-icon-arrow-down el-icon--right"></i>
  </el-button>
  <el-dropdown-menu slot="dropdown">
    <el-button
                                            v-if="cash_id"
                                            class="dropdown-item d-flex align-items-center"
                                            style="background-color: #dc3545; color: white; width: 100%; padding: 12px 10px; margin: 10px auto; border-radius: 5px; transition: all 0.3s ease;"
                                            @click="openPdfGuides(data.id)"
                                        >
                                            <i
                                                class="el-icon-delete me-2"
                                                style="color: white; margin-right: 10px;"
                                            ></i>
                                            <span>Formatos pdf</span>
                                        </el-button>
                                        <el-button
                                            v-if="cash_id"
                                            class="dropdown-item d-flex align-items-center"
                                            style="background-color: seagreen; color: white; width: 100%; padding: 12px 10px; margin: 10px auto; border-radius: 5px; transition: all 0.3s ease;"
                                            @click="whatsapp(data)"
                                        >
                                            <!-- <i
                                                class="el-icon-delete me-2"
                                                style="color: white; margin-right: 10px;"
                                            ></i> -->
                                            <span>WhatsApp</span>
                                        </el-button>
  </el-dropdown-menu>
</el-dropdown>

                                    <!-- Acciones de Cotización -->
                                    <!-- <button
                                        v-if="data.state_type_id != '11'"
                                        class="btn btn-primary btn-sm dropdown-toggle"
                                        type="button"
                                        data-bs-toggle="dropdown"
                                        aria-haspopup="true"
                                        aria-expanded="false"
                                    >
                                        <i class="fas fa-list"></i>
                                    </button> -->
                                    <!-- <div
                                        class="dropdown-menu p-1"
                                        style="background-color: #6c757d; 
                                         border-radius: 8px; 
                                         box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"
                                    >
                                        <el-button
                                            v-if="cash_id"
                                            class="dropdown-item d-flex align-items-center"
                                            style="background-color: #dc3545; color: white; width: 100%; padding: 12px 10px; margin: 10px auto; border-radius: 5px; transition: all 0.3s ease;"
                                            @click="openPdfGuides(data.id)"
                                        >
                                            <i
                                                class="el-icon-delete me-2"
                                                style="color: white; margin-right: 10px;"
                                            ></i>
                                            <span>Formatos pdf</span>
                                        </el-button>
                                        <el-button
                                            v-if="cash_id"
                                            class="dropdown-item d-flex align-items-center"
                                            style="background-color: seagreen; color: white; width: 100%; padding: 12px 10px; margin: 10px auto; border-radius: 5px; transition: all 0.3s ease;"
                                            @click="whatsapp(data)"
                                        >
                                            
                                            <span>WhatsApp</span>
                                        </el-button>
                                    </div> -->
                                </div>
                            </template>
                        </td>

                        <!-- Mesa y Ordenes (comandas) -->
                        <td
                            v-if="
                                configuration.restaurant &&
                                    (type == 'documents' || type == 'saleNotes')
                            "
                        >
                            {{ data.table_number }}
                            <br />
                            <small class="text-muted">{{
                                data.ordens_ref
                            }}</small>
                        </td>

                        <!-- Serie y numero de CPE -->
                        <td>
                            {{
                                type == "saleNotes"
                                    ? data.full_number
                                    : type == "documents"
                                    ? data.number
                                    : type == "guides"
                                    ? data.number
                                    : data.identifier
                            }}
                        </td>

                        <!-- Fecha y Hora de Emisión -->
                        <td>
                            {{ data.date_of_issue }}
                            <br />
                            <small class="text-muted">{{
                                data.time_of_issue
                            }}</small>
                        </td>

                        <!-- Cliente -->
                        <td class="text-start">
                            {{ data.customer_name }}
                            <br />
                            <small class="text-muted">{{
                                data.customer_number
                            }}</small>
                        </td>

                        <!-- Vendedor  solo en cotizaciones-->
                        <td v-if="type == 'quotations'" class="text-start">
                            <template v-if="data.user_name.includes(' - ')">
                                {{ data.user_name.split(" - ")[1] }}
                                <br />
                                <small class="text-muted">
                                    {{ data.user_name.split(" - ")[0] }}
                                </small>
                            </template>
                            <template v-else>
                                {{ data.user_name }}
                            </template>
                        </td>

                        <td v-if="type == 'quotations'">
                            <template v-if="data.documents.length > 0">{{
                                data.documents[0].number_full
                            }}</template>
                            <template v-if="data.sale_notes.length > 0">{{
                                data.sale_notes[0].identifier
                            }}</template>
                        </td>

                        <td v-if="type == 'documents'">
                            <div
                                v-for="(row, index) in data.sale_note_related"
                                :key="index"
                            >
                                <small class="d-block">{{ row.number }}</small>
                            </div>
                        </td>
                        <td v-if="type == 'saleNotes'">
                            <div
                                v-for="(row, index) in data.documents"
                                :key="index"
                            >
                                <small class="d-block">{{
                                    row.number_full
                                }}</small>
                            </div>
                            <span class="text-primary" v-if="data.variation">
                                {{ data.variation.series }}-{{
                                    data.variation.number
                                }}
                            </span>
                            <span class="text-muted" v-else>
                                <!-- Sin variación -->
                            </span>
                        </td>

                        <!-- Estado -->
                        <td
                            :class="{
                                'text-success':
                                    data.state_type_description == 'Aceptado',
                                'text-danger':
                                    data.state_type_description == 'Anulado' ||
                                    data.state_type_description == 'Por anular',
                                'text-primary':
                                    data.state_type_description == 'Enviado',
                                'text-black':
                                    data.state_type_description != 'Aceptado' &&
                                    data.state_type_description != 'Anulado' &&
                                    data.state_type_description !=
                                        'Por anular' &&
                                    data.state_type_description != 'Enviado'
                            }"
                        >
                            <b>{{ data.state_type_description }}</b>
                        </td>
                        <td v-if="type == 'documents'" class="text-warning">
                            {{ data.remain > 0 ? data.remain : "" }}
                        </td>
                        <td v-if="type == 'saleNotes'" class="text-warning">
                            {{
                                data.pending > 0 ? data.pending.toFixed(2) : ""
                            }}
                        </td>
                        <td v-if="type != 'guides'">
                            {{ data.currency_type_id === "USD" ? "$" : "S/." }}
                            {{ Number(data.total).toFixed(2) }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <el-pagination
            @current-change="getRecords"
            layout="total, prev, pager, next"
            :total="pagination.total"
            :current-page.sync="pagination.current_page"
            :page-size="pagination.per_page"
        ></el-pagination>

        <whatsapp-modal
            :documentNumber="currentNumber"
            :company="company"
            :documentId="currentId"
            :documentTypeId="currentType"
            :showDialog.sync="showWhatsappModal"
            :sender="sender"
            :establishment.sync="establishment"
        ></whatsapp-modal>

        <template v-if="type == 'quotations'">
            <quotation-options
                :showDialog.sync="showDialogOptions"
                :recordId="quotationId"
                :showGenerate="true"
                :showClose="true"
            ></quotation-options>
            <quotation-edit-modal
                :showDialog.sync="showEditQuotationDialog"
                :recordId="quotationId"
            ></quotation-edit-modal>
        </template>
        <document-print-previsualitation
            :resource="resourcePdf"
            :showDialog.sync="showPrevisualitation"
        ></document-print-previsualitation>

        <sale-note-generate
            :configuration="configuration"
            :showDialog.sync="showDialogGenerate"
            :recordId="currentId"
            :showGenerate="true"
            :showClose="false"
            :fromCaja="true"
            @getRecords="getRecords"
        ></sale-note-generate>
        <create-dispatch
            :showDialog.sync="showCreateDispatch"
            :type="currentType"
            :recordId="currentId"
            :configuration="configuration"
        ></create-dispatch>

        <documents-voided
            :external="true"
            @getRecords="getRecords"
            :showDialog.sync="showDialogVoided"
            :recordId="recordId"
        ></documents-voided>
        <documents-payments
            @getRecords="getRecords"
            :external="true"
            :showDialog.sync="showDialogPayments"
            :documentId="recordId"
        ></documents-payments>
        <sale-note-payments
            :configuration="configuration"
            :showDialog.sync="showDialogPaymentsSaleNotes"
            :documentId="recordId"
        ></sale-note-payments>
        <sale-notes-options
            :showDialog.sync="showDialogOptions"
            :configuration.sync="configuration"
            :showClose="true"
            :company="company"
            :recordId="recordId"
            :editSale.sync="editSale"
        ></sale-notes-options>

        <document-options
            :showDialog.sync="showDialogOptionsDocument"
            :editDocument="editDocument"
            :configuration="configuration"
            :recordId="recordId"
            :print="print"
            :company="company"
            :showClose="true"
        ></document-options>

        <quotation-options
            :showDialog.sync="showDialogOptionsQuotation"
            :recordId="recordId"
            :showGenerate="false"
            :showClose="true"
            :external="true"
        ></quotation-options>

        <note-modal
            :configuration="configuration"
            :showDialog.sync="showNoteModal"
            :recordId.sync="recordId"
            @getRecords="getRecords"
        ></note-modal>
        <dispatch-options
            :isUpdate="true"
            :recordId="recordId"
            :showClose="true"
            :showDialog.sync="showDialogOptionsGuides"
        ></dispatch-options>
        <whatsapp-modal-reports
            :resource="linkResource"
            :message="message"
            :showWhatsappForm.sync="showWhatsappForm"
        >
        </whatsapp-modal-reports>
        <el-dialog
            :visible.sync="showDialogReasonToAvoid"
            width="50%"
            :title="titleAvoidSaleNote"
            :close-on-click-modal="false"
            append-to-body
        >
            <div class="row m-2">
                <el-input
                    v-model="reasonToAvoid"
                    type="textarea"
                    :autosize="{ minRows: 3, maxRows: 10 }"
                    placeholder="Motivo de anulación"
                ></el-input>
            </div>
            <span slot="footer" class="dialog-footer">
                <el-button @click="showDialogReasonToAvoid = false"
                    >Cancelar</el-button
                >
                <el-button type="primary" @click="clickAnulateSaleNoteCredit()"
                    >Anular</el-button
                >
            </span>
        </el-dialog>
    </div>
</template>

<script>
const DocumentsVoided = () =>
    import(
        "../../../../../../../../resources/js/views/documents/partials/voided.vue"
    );
const DocumentsPayments = () =>
    import(
        "../../../../../../../../resources/js/views/documents/partials/payments.vue"
    );
import whatsappModal from "./whatsapp_modal.vue";
import { deletable } from "../../../../../../../../resources/js/mixins/deletable";
const DocumentPrintPrevisualitation = () =>
    import("./document_print_previsualitation.vue");
const QuotationEditModal = () => import("./quotation_edit_modal.vue");
const QuotationOptions = () =>
    import(
        "../../../../../../../../resources/js/views/quotations/partials/options.vue"
    );
const SaleNoteGenerate = () =>
    import(
        "../../../../../../../../resources/js/views/sale_notes/partials/option_documents.vue"
    );
const CreateDispatch = () => import("./create_dispatch.vue");
const NoteModal = () => import("./note_modal.vue");
import SaleNotesOptions from "../../../../../../../../resources/js/views/sale_notes/partials/options.vue";
import DocumentOptions from "../../../../../../../../resources/js/views/documents/partials/options.vue";
import DispatchOptions from "../../../../../../../../resources/js/views/dispatches/partials/options.vue";
const SaleNotePayments = () =>
    import(
        "../../../../../../../../resources/js/views/sale_notes/partials/payments.vue"
    );
const WhatsappModalReports = () =>
    import(
        "../../../../../../../../resources/js/components/WhatsappModalReports.vue"
    );
import swal from "sweetalert2";
export default {
    components: {
        whatsappModal,
        QuotationOptions,
        QuotationEditModal,
        DocumentPrintPrevisualitation,
        SaleNoteGenerate,
        CreateDispatch,
        DocumentsVoided,
        DocumentsPayments,
        NoteModal,
        SaleNotePayments,
        SaleNotesOptions,
        DocumentOptions,
        QuotationOptions,
        DispatchOptions,
        WhatsappModalReports,
        swal
    },
    mixins: [deletable],
    props: [
        "records",
        "pagination",
        "type",
        "company",
        "sender",
        "establishment",
        "configuration",
        "cash_id"
    ],
    data() {
        return {
            message: null,
            linkResource: null,
            showWhatsappForm: false,
            showDialogOptionsGuides: false,
            showDialogOptionsQuotation: false,
            showDialogOptionsDocument: false,
            editDocument: false,
            editSale: false,
            showDialogPaymentsSaleNotes: false,
            titleAvoidSaleNote: "Motivo de anulación",
            resourcePdf: null,
            showPrevisualitation: false,
            loading: false,
            showWhatsappModal: false,
            currentId: null,
            currentType: null,
            currentNumber: null,
            showDialogOptions: false,
            recordId: null,
            quotationId: null,
            showDialogVoided: false,
            showEditQuotationDialog: false,
            showDialogGenerate: false,
            currentType: null,
            showCreateDispatch: false,
            showDialogPayments: false,
            showNoteModal: false,
            showDialogReasonToAvoid: false,
            reasonToAvoid: null
        };
    },

    /* mounted() {
        this.$nextTick(() => {
            $(".dropdown-toggle").dropdown({ container: "body" });
        });
    }, */

    methods: {
        whatsapp(data) {
            let { external_id } = data;
            let formatoPdf = `/print/dispatch/${external_id}/ticket`;
            this.linkResource = formatoPdf;
            this.message =
                "Su comprobante electrónico *" +
                data.number +
                "*, ha sido generado correctamente a través del facturador electrónico de " +
                "*" +
                this.$desarrollador +
                "*";
            this.showWhatsappForm = true;
        },
        openPdfGuides(recordId) {
            this.recordId = recordId;
            this.showDialogOptionsGuides = true;
        },
        clickDocuments(recordId) {
            this.recordId = recordId;
            this.showDialogOptionsDocument = true;
        },
        clickOptions(recordId) {
            this.recordId = recordId;
            this.showDialogOptions = true;
        },
        clickQotations(recordId) {
            this.recordId = recordId;
            this.showDialogOptionsQuotation = true;
        },
        clickAnulateSaleNoteCredit() {
            if (this.reasonToAvoid == null || this.reasonToAvoid == "") {
                this.$toast.error("Debe introducir un motivo de anulación");
                return;
            }
            this.anular(
                `/sale-notes/anulate/${this.currentId}?reason_to_void=${this.reasonToAvoid}`
            ).then(() => {
                this.showDialogReasonToAvoid = false;
                this.$emit("getRecords");
            });
        },
        showDialogAvoid(id) {
            this.currentId = id;
            this.showDialogReasonToAvoid = true;
            this.reasonToAvoid = null;
        },
        /* clickVoidedNote(data) {
            let id = data.id;
            let is_credit = data.is_credit;
            if (is_credit) {
                this.showDialogAvoid(id);
                this.titleAvoidSaleNote =
                    "Motivo de anulación - " + data.identifier;
            } else {
                this.anular(`/sale-notes/anulate/${id}`).then(() =>
                    this.$emit("getRecords")
                );
            }
        }, */
        clickVoidedNote(data) {
            let id = data.id;
            let is_credit = data.is_credit;
            if (is_credit) {
                this.showDialogReasonToAvoid = true;
                this.reasonToAvoid = null;
                this.titleAvoidSaleNote =
                    "Motivo de anulación - " + data.identifier;
            } else {
                swal.fire({
                    title: "Motivo de Anulación",
                    input: "text",
                    inputPlaceholder: "Escribe el motivo de la anulación",
                    showCancelButton: true,
                    confirmButtonText: "Anular",
                    cancelButtonText: "Cancelar",
                    inputValidator: value => {
                        if (!value) {
                            return "El motivo es obligatorio";
                        }
                    }
                }).then(result => {
                    if (result.isConfirmed) {
                        const motivo = result.value;
                        this.$http
                            .get(`/sale-notes/anulate/${id}`, {
                                params: { motivo }
                            })
                            .then(() => {
                                this.$eventHub.$emit("reloadData");
                                this.$toast.success(
                                    "Nota de venta anulada correctamente"
                                );
                            })
                            .catch(error => {
                                this.$toast.error(
                                    "Ocurrió un error al anular la nota de venta"
                                );
                                console.error(error);
                            });
                        this.$emit("getRecords");
                    }
                });
            }
        },
        clickNote(id) {
            this.recordId = id;
            this.showNoteModal = true;
        },
        clickPaymentSaleNotes(recordId) {
            this.recordId = recordId;
            this.showDialogPaymentsSaleNotes = true;
        },
        clickPayment(recordId) {
            this.recordId = recordId;
            this.showDialogPayments = true;
        },
        clickVoided(recordId) {
            this.recordId = recordId;
            this.showDialogVoided = true;
        },
        clickDeleteDocument(document_id) {
            this.destroy(`/documents/delete_document/${document_id}`).then(() =>
                this.$emit("getRecords")
            );
        },
        clickGenerateGuie(recordId, type = "03") {
            this.currentId = recordId;
            this.currentType = type;
            this.showCreateDispatch = true;
        },
        clickGenerate(recordId) {
            this.currentId = recordId;
            this.showDialogGenerate = true;
        },
        previsualitation(external_id, type) {
            let { format_printer } = this.establishment;
            let format = "";
            switch (format_printer) {
                case "1":
                    format = "a4";
                    break;
                case "2":
                    format = "a5";
                    break;
                case "3":
                    format = "ticket";
                    break;
                default:
                    format = "ticket_50";
                    break;
            }
            console.log("🚀 ~ previsualitation ~ format:", format);
            let url = null;
            if (type == "80") {
                url = `/sale-notes/print/${external_id}/${format}`;
            } else if (
                type == "03" ||
                type == "01" ||
                type == "07" ||
                type == "08"
            ) {
                url = `/print/document/${external_id}/${format}`;
            } else {
                url = `/quotations/print/${external_id}/${format}`;
            }
            this.resourcePdf = url;
            this.showPrevisualitation = true;
        },
        clickAnulateQuotation(id = null) {
            this.anular(`/quotations/anular/${id}`).then(
                () => this.$emit("getRecords")
                // this.$eventHub.$emit("reloadData")
            );
        },
        clickEditQuotation(recordId = null) {
            this.quotationId = recordId;
            this.showEditQuotationDialog = true;
        },
        async clickOptionsQuotation(recordId = null) {
            this.quotationId = recordId;
            let quotation = this.records.find(it => it.id == recordId);
            let customer_number = quotation ? quotation.customer_number : null;
            try {
                this.loading = true;
                const response = await this.$http(
                    `/quotations/items-to-cash2/${recordId}`
                );
                if (response.status) {
                    let data = response.data;
                    let quotation_id = data.quotation_id;
                    let identifier = data.identifier;
                    if (data.items) {
                        data.items.forEach(it => {
                            this.$emit(
                                "insertOrden",
                                it,
                                quotation_id,
                                identifier,
                                customer_number
                            );
                            this.$emit("closeDialog");
                        });
                    }
                    // if (data.orden) {
                    //     let orden = data.orden;
                    //     orden.quotation_id = recordId;
                    //     orden.cot = data.cot;
                    //     this.$emit("sendOrdens", data.orden);
                    //     this.$emit("closeDialog");
                    // }
                }
            } catch (e) {
                this.$toast.error(
                    "Error al obtener los items de la cotización"
                );
            } finally {
                this.loading = false;
            }
            // this.showDialogOptions = true;
        },
        clickOpenWhatsapp(record) {
            console.log(this.establishment, " mode");
            this.showWhatsappModal = true;
            this.currentId = record.id;
            this.currentType = record.document_type_id || "COT";
            if (this.type == "saleNotes") {
                this.currentNumber = record.full_number;
            } else if (this.type == "documents") {
                this.currentNumber = record.number;
            } else {
                this.currentNumber = record.identifier;
            }
        },
        async clickSendOnline(document_id) {
            try {
                this.loading = true;
                const response = await this.$http.get(
                    `/documents/send/${document_id}`
                );

                if (response.data.success) {
                    this.$toast.success(
                        "Se envio satisfactoriamente el comprobante."
                    );
                    this.$eventHub.$emit("reloadData");

                    // this.clickCheckOnline(document_id);
                } else {
                    this.$toast.error(response.data.message);
                }
            } catch (error) {
                this.$toast.error(error.response.data.message);
            } finally {
                this.loading = false;
            }
        },
        async clickReStore(document_id) {
            try {
                this.loading = true;
                const response = await this.$http.get(
                    `/documents/re_store/${document_id}`
                );
                console.log(response);
                if (response.data.success) {
                    this.$toast.success(response.data.message);
                } else {
                    this.$toast.error(response.data.message);
                }
            } catch (error) {
                this.$toast.error(error.response.data.message);
            } finally {
                this.loading = false;
            }
        },

        async clickValidarCpe(document_id) {
            try {
                this.loading = true;
                const response = await this.$http.get(
                    `/documents/validate/${document_id}`
                );

                if (response.data.success) {
                    this.$toast.success(response.data.message);
                    this.$emit("getRecords", this.pagination.current_page);
                } else {
                    this.$toast.error(response.data.message);
                }
            } catch (error) {
                this.$toast.error(error.response.data.message);
            } finally {
                this.loading = false;
            }
        },
        getRecords() {
            this.$emit("getRecords", this.pagination.current_page);
        },
        print(external_id, type) {
            this.$emit("printData", external_id, type);
        }
    }
};
</script>

<style scoped>
/* .dropdown-menu {
    transform: translate(0, 0) !important;
} */

.row-danger-border {
    /* border-left: 6px solid #dc3545 !important;
    border-right: 6px solid #dc3545 !important; */
    border-top: 6px solid #dc3545 !important;
    border-bottom: 6px solid #dc3545 !important;
    background: none !important;
    color: #dc3545 !important;
}
</style>
