<template>
    <div v-loading="ordenLoading">
        <div>
            <div class="d-md-flex flex-wrap justify-content-between ">
                <!-- <div class="dropdown-as-select d-inline-block mb-1" data-childselector="span"> -->
                <!-- <button v-if="
                        configuration.sale_note_credit_confirm
                            ? isAnalist || user.can_accept_credit_sale_note
                            : true
                    " class="btn p-2" type="button" data-bs-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        Acciones
                        <span class="btn btn-primary dropdown-toggle" data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-delay="0" title data-bs-original-title="Item Count"
                            aria-label="Item Count">Acciones</span>
                    </button> -->
                <div class="pos-action-buttons">
                    <!-- Puedes controlar el padding usando clases Bootstrap o estilos en línea -->
                    <!-- Botón Abrir Caja (rojo) -->
                    <button v-if="!cash_id && !isSeller" class="btn btn-danger mb-2" type="button" @click="openCash"
                        style="padding: 5px 5px; color: red; ">
                        <i class="fas fa-cash-register" style="margin-right: 2px;"></i>
                        Abrir<br />Caja
                    </button>
                    <!-- Botón Cerrar Caja (azul) -->
                    <button v-if="cash_id && !isSeller" class="btn btn-primary pos-btn mb-2" type="button"
                        @click="trigerFunction(3)" style="padding: 5px 5px;">
                        <i class="fas fa-cash-register" style="margin-right: 2px;"></i>
                        Cerrar<br />Caja
                    </button>
                    <!-- Recibir Mercaderia -->
                    <button v-if="
                        configuration.receive_merchandise &&
                        !isSeller &&
                        configuration.translate_direct === false
                    " class="btn btn-primary pos-btn mb-2" type="button" @click="trigerFunction(2)"
                        style="padding: 5px 5px;">
                        <i class="fas fa-people-carry" style="margin-right: 2px;"></i>
                        Recibir <br />
                        Mercadería
                    </button>

                    <button v-if="
                        configuration.restaurant &&
                        !configuration.college &&
                        !isHotel &&
                        !isSeller
                    " class="btn btn-primary pos-btn mb-2" type="button" @click="trigerFunction(5)"
                        style="padding: 5px 5px;">
                        <i class="fas fa-tasks" style="margin-right: 2px;"></i>Ver
                        <br />
                        Ordenes
                    </button>

                    <button v-if="
                        configuration.show_expenses_incomes_caja &&
                        !isSeller
                    " class="btn btn-primary pos-btn mb-2" type="button" @click="trigerFunction(7)"
                        style="padding: 5px 5px;">
                        <i class="fas fa-money-bill-wave-alt" style="margin-right: 2px;"></i>
                        Gastos<br />Ingresos
                    </button>

                    <button v-if="localOrden.length > 0" class="btn btn-primary pos-btn mb-2" type="button"
                        @click="openOrden" style="padding: 5px 5px;">
                        <i class="el-icon-view" style="margin-right: 2px;"></i>
                        Ver
                        <br />
                        Ordenes
                    </button>

                    <button v-if="configuration.digital_notifications" class="btn btn-primary pos-btn mb-2"
                        type="button" @click="openDigitalPay" style="background-color: #800080; padding: 5px 5px;">
                        <i class="fas fa-mobile-alt" style="margin-right: 2px;"></i>
                        Pagos<br />Digitales
                    </button>

                    <button v-if="configuration.credit_list && !isSeller" class="btn btn-primary pos-btn mb-2"
                        type="button" @click="trigerFunction(6)" style="padding: 5px 5px;">
                        <i class="fas fa-file-invoice" style="margin-right: 2px;"></i>
                        Lista de crédito
                    </button>

                    <el-badge :value="ordenInBox.length" class="item" v-if="
                        !configuration.college &&
                        configuration.aparcado &&
                        ordenInBox.length > 0
                    ">
                        <button class="btn btn-primary pos-btn mb-2" type="button" @click="trigerFunction(4)"
                            style="padding: 5px 5px;">
                            <i class="fas fa-cart-arrow-down" style="margin-right: 2px;"></i>
                            ver
                            <br />
                            Aparcado
                        </button>
                    </el-badge>
                    <button v-if="
                        configuration.sale_note_credit_confirm &&
                        configuration.principal_cash &&
                        cash_id
                    " class="btn btn-primary pos-btn mb-2" :class="cashAvailable < 0 ? 'btn-danger' : 'btn-primary'
                        " type="button" @click="checkCashAvailable" style="padding: 5px 5px;">
                        Disponible S/ {{ cashAvailable.toFixed(2) }}
                    </button>
                    <button v-if="
                        configuration.consolidated_quotations &&
                        !isSeller &&
                        cash_id
                    " class="btn btn-primary pos-btn mb-2" type="button" @click="consolidatedQuotations"
                        style="padding: 5px 5px;">
                        Consolidar
                    </button>
                </div>
                <!-- <div class="dropdown-menu dropdown-menu-end col-md-2 col-1" style="width: 153px;">
                        <div class="col-12" v-for="(option, idx) in optionsMenu" :key="idx" v-show="option.visible">
                            <el-button v-if="option.visible" @click="trigerFunction(option.id)"
                                class="btn btn-light m-1 rounded d-flex flex-column align-items-center justify-content-center col-12"
                                style="max-width: 150px;">
                                <div class="text-center" style="margin-bottom: 2px">
                                    <p style="margin: 0 !important; padding: 0 !important; font-size: 15px;"
                                        v-for="(title, idx2) in option.title" :key="idx2">
                                        {{ title }}
                                    </p>
                                    <i :class="[option.icon, 'fa-1x']"></i>
                                </div>
                                <div></div>
                            </el-button>
                        </div>
                    </div> -->
                <!-- </div> -->
            </div>
            <!-- <div v-if="screenWidth < 600" class="d-flex flex-wrap">
                <div v-for="(option, idx) in optionsMenu" :key="idx" v-show="option.visible">
                    <div v-if="option.visible && option.id != 5" @click="trigerFunction(option.id)"
                        class="m-1 btn btn-light rounded d-flex flex-column align-items-center justify-content-center"
                        style="max-width: 60px; max-height: 60px">
                        <div class="text-center" style="margin-bottom: 2px"></div>
                        <div>
                            <label v-if="option.id == 4" style="margin-left: 2px">{{ ordenInBox.length }}</label>

                            <i :class="[option.icon]"></i>
                        </div>
                    </div>
                </div>
            </div> -->

            <div v-if="
                configuration.sale_note_credit_confirm
                    ? isAnalist || user.can_accept_credit_sale_note
                    : true
            " class="bg-primary align-items-center rounded-top" style="padding-top: 12px">
                <div class="row col-12" v-if="clientTableData.table">
                    <div class="col-6" v-if="configuration.restaurant">
                        <h5 class="text-white">
                            <strong style="padding-left: 20px">
                                {{
                                    ` ${isCreatingOrden
                                        ? "Creando Orden"
                                        : clientTableData.correlative
                                            ? `(Orden N°
                                ${clientTableData.correlative})`
                                            : ""
                                    }`
                                }}
                            </strong>
                        </h5>
                    </div>
                    <div class="h5 text-white col-6" style="padding-left: 25px" v-else>
                        <template v-if="quotationId">
                            GENERANDO COMPROBANTE - COTIZACIÓN
                            {{ cotIdentifier }}
                        </template>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <h3 class="text-white" style="text-align: right">
                                Total {{ currency_id == "USD" ? "$" : "S/" }}
                                {{ getTotalToShow() }}
                            </h3>
                        </div>
                    </div>
                </div>

                <div class="row h5 text-white col-12" style="padding-left: 25px"
                    v-if="clientTableData.table && configuration.restaurant">
                    <strong>
                        {{ clientTableData.is_room ? "Habitación" : "Mesa" }}
                        {{ clientTableData.table }}- Ref:
                        {{ clientTableData.ref }}
                        {{ clientTableData.customer_id }}
                        {{ clientTableData.table_id }}
                    </strong>
                </div>

                <div class="row col-12">
                    <div class="col-7">
                        <div class="h6 text-white col-12" style="padding-left: 25px">
                            <strong v-if="!clientTableData.table">
                                <template v-if="!isConsignment">
                                    {{
                                        quotationId
                                            ? `GENERANDO COMPROBANTE - COTIZACIÓN ${cotIdentifier}`
                                            : "VENTA DIRECTA"
                                    }}
                                </template>
                                <template v-else>LIQUIDACIÓN DE CONSIGNACIÓN</template>
                            </strong>
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="row">
                            <h3 v-if="!clientTableData.table" class="text-white" style="text-align: right">
                                Total {{ currency_id }}
                                {{ getTotalToShow() }}
                            </h3>
                        </div>
                    </div>
                </div>

                <div class="row col-12" style="padding-left: 20px;">
                    <div class="col-6" v-if="configuration.other_currency_pos">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <label for="currency" class="text-white w-100 margin-top: 10px;">
                                        <small>Moneda</small>
                                    </label>
                                    <el-radio-group v-model="currency_id" size="small" @change="changeCurrency">
                                        <el-radio-button value="PEN" label="S/"></el-radio-button>
                                        <el-radio-button value="USD" label="$"></el-radio-button>
                                    </el-radio-group>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <label for="tc" class="text-white text-center w-100">T/C
                                    </label>
                                    <el-input v-model="exchange_rate_sale" type="number" style="width: 100px"
                                        :controls="false" @input="calculateTotal">
                                    </el-input>
                                </div>
                            </div>
                            <!-- <div class="d-flex justify-content-end" v-if="configuration.other_currency_pos">
                                    <div style="margin-top: 5px" class="justify-content-end text-end">
                                        <label for="currency" class="text-dark w-100 margin-top: 10px;">
                                            <small>Moneda</small>
                                        </label>
                                        <el-radio-group
                                            v-model="currency_id"
                                            size="small"
                                            @change="changeCurrency"
                                        >
                                            <el-radio-button
                                                value="PEN"
                                                label="S/"
                                            ></el-radio-button>
                                            <el-radio-button
                                                value="USD"
                                                label="$"
                                            ></el-radio-button>
                                        </el-radio-group>
                                    </div>
                                    <div class="text-dark text-end" style="margin-top: 5px">
                                       
                                    </div>
                                </div> -->
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card bg-white">
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="row justify-content-center" v-if="configuration.edit_count_products">
                                        <h6 v-if="!clientTableData.table" class="text-white fw-bold text-center">
                                            <span style="color: darkblue; font-weight: bold; font-size: 12px;">
                                                Productos:
                                            </span>
                                            <br />
                                            <span
                                                style="color: darkblue; font-weight: bold; display: inline-block; width: 40px; height: 40px; line-height: 40px; text-align: center; border-radius: 50%; background-color: lightblue;">
                                                {{ totalUniqueProducts }}</span>
                                            <el-tooltip content="Total de producto a vender" placement="top"
                                                effect="light">
                                            </el-tooltip>
                                        </h6>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="row justify-content-center" v-if="configuration.edit_count_products">
                                        <h6 v-if="!clientTableData.table" class="text-white fw-bold text-center">
                                            <span style="color: darkblue; font-weight: bold; font-size: 12px;">
                                                Unidades:
                                            </span>
                                            <br />
                                            <span
                                                style="color: darkblue; font-weight: bold; display: inline-block; width: 40px; height: 40px; line-height: 40px; text-align: center; border-radius: 50%; background-color: lightblue;">
                                                {{ totalQuantityProducts }}
                                            </span>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div :class="`p-1 bg-primary`" v-if="
                configuration.sale_note_credit_confirm
                    ? isAnalist || user.can_accept_credit_sale_note
                    : true
            ">
                <div class="row col-md-12 mx-1">
                    <div>
                        <template v-if="!configuration.sale_note_credit_confirm">
                            <template v-if="
                                (this.quotation_stock &&
                                    configuration.quotation &&
                                    localOrden.length != 0) ||
                                this.isSeller
                            ">
                                <button alt="Cotizar" class="btn btn-light mt-2" type="button" @click="openQuotation"
                                    style="max-height: 45px ; max-width: 80px;">
                                    <i class="fas fa-clipboard-list" style="color: var(--primary) !important"></i>
                                    <br />Cotizar
                                </button>
                            </template>
                            <template v-else>
                                <button alt="Cobrar La venta " v-if="isCreatingOrden == false"
                                    class="btn btn-light mt-2" type="button" @click="payOrden()"
                                    :disabled="cotizarConfirmado" style="max-height: 45px ; max-width: 60px;">
                                    <i class="fas fa-money-bill-wave fw-bold"
                                        style="color: var(--primary) !important"></i>
                                    <br />
                                    <span style="display: flex; justify-content: center;">Pagar</span>
                                </button>
                            </template>
                        </template>
                        <button v-if="canBeSaleOffert" class="btn btn-light mt-2" type="button"
                            @click="clickSaleOffert()" style="max-height: 45px ;">
                            <div>
                                <i class="fas fa-tag" style="color: var(--primary) !important"></i>
                            </div>
                            <div>
                                {{ canBeSaleOffert }}
                            </div>
                        </button>
                        <button v-if="
                            isCreatingOrden == true ||
                            clientTableData.table == undefined
                        " class="btn btn-light mt-2" type="button" @click="cancelOrden"
                            style="max-height: 45px ; max-width: 60px;">
                            <i class="fas fa-trash" style="color: var(--primary) !important"></i>
                            <br />
                            <span style="display: flex; justify-content: center;">Limpiar</span>
                        </button>
                        <button v-if="
                            localOrden.length > 0 &&
                            configuration.restaurant_delivery &&
                            configuration.restaurant &&
                            !clientTableData.table
                        " class="btn btn-light mt-2" type="button" @click="openDeliveryForm()"
                            style="max-height: 45px ; max-width: 60px;">
                            <i class="fas fa-biking" style="color: var(--primary) !important"></i>
                            <br />
                            <span style="display: flex; justify-content: center;">Delivery</span>
                        </button>
                        <button v-if="isDev" class="btn btn-light mt-2" type="button" @click="clgOrden()"
                            style="max-height: 45px ; max-width: 80px;">
                            <i class="fas fa-money-bill-wave fw-bold" style="color: var(--primary) !important"></i>
                            <br />Print
                        </button>
                        <button :disabled="isSeller" v-if="
                            configuration.quotation &&
                            !isSeller &&
                            !isAnalist &&
                            !isSellerConsolidated
                        " alt="Cotizar " class="btn btn-light mt-2" type="button" @click="openQuotation"
                            style="max-height: 45px ; max-width: 60px;">
                            <i class="fas fa-clipboard-list" style="color: var(--primary) !important"></i>
                            <br />
                            <span style="display: flex; justify-content: center;">Cotizar</span>
                        </button>

                        <button v-if="
                            configuration.aparcado &&
                            isCreatingOrden == false &&
                            clientTableData.table == undefined &&
                            !configuration.college
                        " @click="openApart" :disabled="cotizarConfirmado" class="btn btn-light mt-2" type="button"
                            style="max-height: 45px ; max-width: 60px;">
                            <i class="fas fa-cart-arrow-down" style="color: var(--primary) !important"></i>
                            <br />
                            <span style="display: flex; justify-content: center;">Aparcar</span>
                        </button>
                        <button v-if="
                            configuration.consignment &&
                            localOrden.length != 0 &&
                            !isSeller
                        " class="btn btn-light mt-2" type="button" @click="openConsignment"
                            style="max-height: 45px ; max-width: 60px;">
                            <i class="fas fa-clipboard-list" style="color: var(--primary) !important"></i>
                            <br />
                            <span style="display: flex; justify-content: center;">Consigna</span>
                        </button>
                        <button v-if="
                            configuration.credits &&
                            !configuration.sale_note_credit_confirm &&
                            localOrden.length != 0 &&
                            !isSeller
                        " @click="openCredit" class="btn btn-light mt-2" style="max-height: 45px ; max-width: 60px;">
                            <i class="fas fa-credit-card" style="color: var(--primary) !important"></i>
                            <br />
                            <span style="display: flex; justify-content: center;">Crédito</span>
                        </button>

                        <button v-if="
                            isCreatingOrden == false &&
                            configuration.credit_list &&
                            localOrden.length != 0 &&
                            !isSeller &&
                            isRestaurantWarehouse
                        " class="btn btn-light mt-2" type="button" @click="toCreditList"
                            style="max-height: 45px ; max-width: 60px;">
                            <i class="far fa-credit-card" style="color: var(--primary) !important"></i>
                            <br />
                            <span style="display: flex; justify-content: center;">A Cuenta</span>
                        </button>
                        <button v-if="
                            (isCreatingOrden == true ||
                                clientTableData.orden_id) &&
                            localOrden.length != 0 &&
                            !isSeller &&
                            (configuration.restaurant ||
                                configuration.modo_billar)
                        " class="btn btn-light mt-2" type="button" @click="sendOrden()"
                            style="max-height: 45px ; max-width: 60px;">
                            <i class="fas fa-paper-plane" style="color: var(--primary) !important"></i>
                            <br />
                            <span style="display: flex; justify-content: center;">Enviar</span>
                        </button>
                        <button v-if="
                            isCreatingOrden == false &&
                            clientTableData.table != undefined &&
                            ordens.length != 0
                        " class="btn btn-light mt-2" type="button" @click="printOrden()"
                            style="max-height: 45px ; max-width: 65px;">
                            <i class="fas fa-print" style="color: var(--primary) !important"></i>
                            <br />
                            <span style="display: flex; justify-content: center;">Precuenta</span>
                        </button>
                        <button v-if="
                            isCreatingOrden == false &&
                            clientTableData.table != undefined &&
                            ordens.length != 0 &&
                            configuration.pdf_preorder
                        " class="btn btn-light mt-2" type="button" @click="printOrdenPdf()"
                            style="max-height: 45px ; max-width: 60px;">
                            <i class="fas fa-print" style="color: var(--primary) !important"></i>
                            <br />
                            <span style="display: flex; justify-content: center;">PDF</span>
                        </button>
                        <span class="float-end" v-if="isSellerConsolidated">
                            <span class="h3 text-white">Atención: {{ num_orden }}</span>
                        </span>
                        <button v-if="
                            isCreatingOrden == false &&
                            clientTableData.table != undefined &&
                            ordens.length != 0
                        " class="btn btn-light mt-2" type="button" style="max-height: 45px ;  max-width: 60px;" @click="
                            cancelGeneralOrden(clientTableData.orden_id)
                            ">
                            <i class="fas fa-window-close" style="color: var(--primary) !important"></i>
                            <br />
                            <span style="display: flex; justify-content: center;">Cancelar</span>
                        </button>
                        <div class="dropdown-as-select d-inline-block mt-2" data-childselector="span">
                            <template v-if="!configuration.sale_note_credit_confirm">
                                <div class="dropdown-menu dropdown-menu-start col-md-2 col-1" style="max-width: 154px;">
                                    <div class="col-12">
                                        <el-button v-if="
                                            configuration.credits &&
                                            localOrden.length != 0 &&
                                            !isSeller
                                        " @click="openCredit"
                                            class="btn btn-light m-1 rounded d-flex flex-column align-items-center justify-content-center col-12"
                                            style="max-width: 150px;">
                                            <div class="text-center" style="margin-bottom: 2px">
                                                <span style="margin: 0 !important; padding: 0 !important">Crédito</span>
                                                <i class="fas fa-credit-card"
                                                    style="color: var(--primary) !important"></i>
                                            </div>
                                            <div></div>
                                        </el-button>
                                    </div>
                                </div>
                            </template>
                            <template v-else>
                                <button alt="Cobrar La venta " v-if="isCreatingOrden == false"
                                    class="btn btn-light mt-2" type="button" @click="openCredit"
                                    style="max-height: 45px ; max-width: 60px;">
                                    <i class="fas fa-money-bill-wave" style="color: var(--primary) !important"></i>
                                    <br />
                                    <span style="display: flex; justify-content: center;">
                                        {{
                                            localOrden.length != 0
                                                ? "Crédito"
                                                : "Simular"
                                        }}
                                    </span>
                                </button>
                            </template>
                        </div>
                    </div>

                    <div v-if="clientTableData.table" class="col-md-3">
                        <button @click="directSale" class="btn btn-warning mt-2" type="button"
                            style="max-height: 45px ;">
                            Venta Directa
                        </button>
                    </div>
                </div>

                <!-- Para llevar  y Variación -->
                <div class="d-flex align-items-center p-1 m-2">
                    <div class="col-12">
                        <template v-if="
                            configuration.restaurant &&
                            (clientTableData.table == undefined ||
                                configuration.box_orden)
                        ">
                            <el-checkbox v-if="
                                localOrden.length != 0 &&
                                !configuration.college &&
                                !isSeller
                            " v-model="to_carry" @change="allToCarry">
                                <span class="text-white">Para llevar</span>
                            </el-checkbox>
                        </template>
                        <template>
                            <el-checkbox class="margin-left:5px;" v-model="variation" @change="changeVariation" v-if="
                                configuration.show_variation_dcto &&
                                !isSeller &&
                                !isAnalist
                            ">
                                <span class="text-white">Variación</span>
                            </el-checkbox>
                        </template>
                        <template v-if="
                            (commercialTreatments.length > 0 &&
                                configuration.commercial_treatments) ||
                            configuration.commercial_treatment_items
                        ">
                            <el-select style="margin-bottom: 5px;" clearable class="black-placeholder"
                                v-model="commercialTreatmentId" placeholder="Seleccione un tratamiento comercial"
                                @change="getCommercialTreatment" @clear="clearCommercialTreatment">
                                <el-option v-for="(item,
                                    index) in commercialTreatments" :key="index" :label="item.description"
                                    :value="item.id"></el-option>
                            </el-select>
                        </template>
                        <template v-if="isSellerConsolidated">
                            <el-select v-model="formQtn.customer_id" filterable clearable remote
                                class="border-left rounded-left border-info" popper-class="el-select-customers"
                                dusk="customer_search_id"
                                placeholder="Escriba el nombre o número de documento del cliente"
                                :remote-method="searchRemoteCustomers" :loading="loading_search"
                                @change="changeCustomer">
                                <el-option v-for="option in customersSearch" :key="option.id" :value="option.id"
                                    :label="option.description"></el-option>
                            </el-select>
                        </template>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <template>
                                        <div class="custom-flex">
                                            <el-input v-if="
                                                !configuration.college &&
                                                configuration.restaurant
                                            " type="text" class="black-placeholder" v-model="clientTableData.ref"
                                                placeholder="Referencia:" maxlength="45" show-word-limit
                                                style="margin-bottom: 10px;"></el-input>
                                        </div>
                                    </template>
                                </div>
                            </div>
                            <div class="col-md-6" v-if="configuration.hotels">
                                <div class="row">
                                    <!-- Canjear Promoción Piscina y Desayuno -->
                                    <template>
                                        <div class="custom-flex">
                                            <el-input @input="seachPromotion" type="text" maxlength="10" show-word-limit
                                                v-model="promotionCode" placeholder="Canjear Promoción"
                                                style="margin-bottom: 10px;"></el-input>
                                        </div>
                                    </template>
                                    <!-- Canjear  por N° de orden -->
                                    <!-- <el-input
                                            @input="searchOrdenNumber"
                                            type="text"
                                            maxlength="10"
                                            show-word-limit
                                            v-model="ordenNumber"
                                            placeholder="Cobrar por N° de orden"
                                        ></el-input> -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Venta rápida solo con Nota de venta  y con clientes varios-->
                    <div class="col-md-6 d-flex justify-content-end align-items-end" v-if="
                        establishments.conf &&
                        establishments.conf.direct_sale
                    ">
                        <div class="d-flex flex-column" style="margin-left:15px;">
                            <label class="text-white">
                                Venta rápida
                            </label>
                            <el-switch @change="changeQuickSale" v-model="establishments.conf.pos_quick_sale"
                                active-color="#13ce66" inactive-color="#ff4949"></el-switch>
                        </div>
                        <div class="d-flex flex-column" style="margin-left:15px;">
                            <template v-if="establishments.conf.pos_quick_sale">
                                <label class="text-white">Impresión</label>
                                <el-switch @change="savePrint" v-model="printing" active-color="#13ce66"
                                    inactive-color="#ff4949"></el-switch>
                            </template>
                        </div>
                    </div>
                </div>
                <section v-loading="loading" class="scroll-section border bg-white" vid="checkboxes">
                    <div class="scroll-out">
                        <div class="scroll-by-count os-host os-theme-dark os-host-overflow os-host-overflow-y os-host-resize-disabled os-host-scrollbar-horizontal-hidden os-host-transition"
                            data-count="4" id="checkboxTable" style="height: 151vh">
                            <!-- calc(100vh - 8rem); -->
                            <div class="os-resize-observer-host observed">
                                <div class="os-resize-observer" style="left: 0px; right: auto"></div>
                            </div>
                            <div class="os-size-auto-observer observed" style="height: calc(100% + 1px); float: left">
                                <div class="os-resize-observer"></div>
                            </div>
                            <div class="os-content-glue" style="margin: 0px 5px"></div>
                            <div class="os-padding">
                                <div class="os-viewport" style="overflow-y: scroll; margin-right: 15px">
                                    <div class="m-3"></div>
                                    <div class="os-content" style="padding: 0px 5px; height: 100%; width: 100%">
                                        <div v-if="variation" class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                            <div v-for="(variationItem,
                                                idx) in foodDefaults" :key="idx"
                                                class="mx-2 coupon rounded d-flex justify-content-between">
                                                <div class="tengah py-2 d-flex w-100 justify-content-start p-2"
                                                    style="margin-top: 20px !important;">
                                                    <div class="col-12 overflow-hidden card shadow-lg p-3 rounded">
                                                        <div class="row" style="min-width: 500px;">
                                                            <div class="col-12">
                                                                <div class="row align-items-center">
                                                                    <!-- Descripción: ocupa más espacio -->
                                                                    <div class="col-8 col-md-8 col-lg-8 col-xl-8">
                                                                        <h3 class="m-0 fw-bold"
                                                                            style="font-family: 'Arial Black', Arial, sans-serif; font-size: 1.2rem;">
                                                                            {{
                                                                                variationItem.description.toUpperCase()
                                                                            }}
                                                                        </h3>
                                                                    </div>

                                                                    <!-- Botones: ocupan menos espacio -->
                                                                    <div
                                                                        class="col-4 col-md-4 col-lg-4 col-xl-4 text-end">
                                                                        <el-button size="mini" round
                                                                            class="text-white bg-primary" @click="
                                                                                showChangeDescription(
                                                                                    idx
                                                                                )
                                                                                ">Cambiar</el-button>
                                                                        <el-button size="mini" round
                                                                            class="text-white bg-success" v-if="
                                                                                idx ==
                                                                                0
                                                                            " @click="
                                                                                addVariation
                                                                            ">Agregar
                                                                            Item</el-button>
                                                                        <el-button size="mini" round
                                                                            class="text-white bg-danger" v-if="
                                                                                foodDefaults.length >
                                                                                1
                                                                            " @click="
                                                                                deleteDefaultFood(
                                                                                    idx
                                                                                )
                                                                                ">Eliminar</el-button>
                                                                        <!-- <el-tag
                                                                            role="button"
                                                                            class="text-white bg-primary me-1"
                                                                            style="padding: 8px 18px; font-size: 14px; border-radius: 6px; font-weight: bold; cursor: pointer; text-align: center;"
                                                                            @click="
                                                                                showChangeDescription(
                                                                                    idx
                                                                                )
                                                                            "
                                                                        >
                                                                            Cambiar
                                                                        </el-tag> -->

                                                                        <!-- <el-tag
                                                                            type="success"
                                                                            v-if="
                                                                                idx ==
                                                                                    0
                                                                            "
                                                                            role="button"
                                                                            class="me-1"
                                                                            style="padding: 8px 18px; font-size: 14px; border-radius: 6px; font-weight: bold; cursor: pointer; text-align: center;"
                                                                            @click="
                                                                                addVariation
                                                                            "
                                                                        >
                                                                            Agregar
                                                                            item
                                                                        </el-tag> -->

                                                                        <!-- <el-tag
                                                                            v-if="
                                                                                foodDefaults.length >
                                                                                    1
                                                                            "
                                                                            type="danger"
                                                                            role="button"
                                                                            @click="
                                                                                deleteDefaultFood(
                                                                                    idx
                                                                                )
                                                                            "
                                                                        >
                                                                            <i
                                                                                class="el-icon-delete"
                                                                            ></i>
                                                                        </el-tag> -->
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- <div class="col-12">
                                                                <div
                                                                    class="col-6 col-md-6 col-lg-6 col-xl-6"
                                                                >
                                                                    {{
                                                                        variationItem.description.toUpperCase()
                                                                    }}
                                                                </div>
                                                                <div
                                                                    class="col-4 col-md-4 col-lg-4 col-xl-4"
                                                                >
                                                                    <el-tag
                                                                        role="button"
                                                                        class="text-white bg-primary"
                                                                        style="padding: 8px 18px; font-size: 14px; border-radius: 6px; font-weight: bold; cursor: pointer; min-width: 100px; text-align: center;"
                                                                        @click="
                                                                            showChangeDescription(
                                                                                idx
                                                                            )
                                                                        "
                                                                    >
                                                                        Cambiar
                                                                    </el-tag>

                                                                    <el-tag
                                                                        type="success"
                                                                        v-if="
                                                                            idx ==
                                                                                0
                                                                        "
                                                                        role="button"
                                                                        style="padding: 8px 18px; font-size: 14px; border-radius: 6px; font-weight: bold; cursor: pointer; min-width: 100px; text-align: center;"
                                                                        @click="
                                                                            addVariation
                                                                        "
                                                                    >
                                                                        Agregar
                                                                        otro
                                                                        item
                                                                    </el-tag>
                                                                    <el-tag
                                                                        v-if="
                                                                            foodDefaults.length >
                                                                                1
                                                                        "
                                                                        type="danger"
                                                                        role="button"
                                                                        @click="
                                                                            deleteDefaultFood(
                                                                                idx
                                                                            )
                                                                        "
                                                                    >
                                                                        <i
                                                                            class="el-icon-delete"
                                                                        ></i>
                                                                    </el-tag>
                                                                </div>
                                                            </div> -->
                                                            <!-- <h3
                                                                class="lead font-weight-light fw-bold"
                                                                style="font-weight: bold; font-family: 'Arial Black', Arial, sans-serif; font-size: 1.2rem; padding: auto; min-width: 350px;"
                                                            >
                                                                {{
                                                                    variationItem.description.toUpperCase()
                                                                }}
                                                                <el-tag
                                                                    role="button"
                                                                    class="text-white bg-primary"
                                                                    style="padding: 8px 18px; font-size: 14px; border-radius: 6px; font-weight: bold; cursor: pointer; min-width: 100px; text-align: center;"
                                                                    @click="
                                                                        showChangeDescription(
                                                                            idx
                                                                        )
                                                                    "
                                                                >
                                                                    Cambiar
                                                                </el-tag>

                                                                <el-tag
                                                                    type="success"
                                                                    v-if="
                                                                        idx == 0
                                                                    "
                                                                    role="button"
                                                                    style="padding: 8px 18px; font-size: 14px; border-radius: 6px; font-weight: bold; cursor: pointer; min-width: 100px; text-align: center;"
                                                                    @click="
                                                                        addVariation
                                                                    "
                                                                >
                                                                    Agregar otro
                                                                    item
                                                                </el-tag>
                                                                <el-tag
                                                                    v-if="
                                                                        foodDefaults.length >
                                                                            1
                                                                    "
                                                                    type="danger"
                                                                    role="button"
                                                                    @click="
                                                                        deleteDefaultFood(
                                                                            idx
                                                                        )
                                                                    "
                                                                >
                                                                    <i
                                                                        class="el-icon-delete"
                                                                    ></i>
                                                                </el-tag>
                                                            </h3> -->
                                                        </div>
                                                        <p
                                                            class="badge bg-foreground text-uppercase font-weight-light p-0">
                                                        </p>
                                                        <div class="row align-items-end">
                                                            <div class="col-md-4">
                                                                <span class="fw-bold text-primary"
                                                                    style="font-size: 1rem; font-family: 'Arial', sans-serif;">
                                                                    Cantidad
                                                                    <br />
                                                                    <div class="input-group spinner">
                                                                        <input type="text"
                                                                            class="form-control text-center bg-white"
                                                                            v-model="variationItem.quantity
                                                                                " data-rule="currency" />
                                                                        <div class="input-group-text">
                                                                            <button type="button" class="spin-up"
                                                                                data-spin="up" @click="
                                                                                    updateDefaultFoodQty(
                                                                                        true,
                                                                                        idx
                                                                                    )
                                                                                    ">
                                                                                <span class="arrow"></span>
                                                                            </button>
                                                                            <button type="button" class="spin-down"
                                                                                data-spin="down" @click="
                                                                                    updateDefaultFoodQty(
                                                                                        false,
                                                                                        idx
                                                                                    )
                                                                                    ">
                                                                                <span class="arrow"></span>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </span>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <span class="time font-weight-light">
                                                                    <span class="fw-bold text-primary"
                                                                        style="font-size: 1rem; font-family: 'Arial', sans-serif;">
                                                                        Precio
                                                                        <br />
                                                                        <el-input class="custom_input bg-white"
                                                                            style="width: 100%" type="number" v-model="variationItem.sale_unit_price
                                                                                ">
                                                                            <span slot="prepend"
                                                                                style="padding-left: 6px;padding-right: 6px;">
                                                                                <template v-if="
                                                                                    configuration.other_currency_pos
                                                                                ">
                                                                                    {{
                                                                                        currency_id ==
                                                                                            "USD"
                                                                                            ? "$"
                                                                                            : "S/"
                                                                                    }}
                                                                                </template>
                                                                                <template v-else>
                                                                                    S/
                                                                                </template>
                                                                            </span>
                                                                        </el-input>
                                                                    </span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mx-4 h4 txt-info p-10 f-w-700 d-flex align-items-center">
                                            <template v-if="configuration.restaurant">
                                                <a class="bage bg-dark text-white" style="margin-right: 5px">
                                                    <template v-if="
                                                        localOrden.length <=
                                                        9
                                                    ">
                                                        0{{ localOrden.length }}
                                                    </template>
                                                    <template v-else>
                                                        {{ localOrden.length }}
                                                    </template>
                                                </a>
                                                <!-- terterterterterter -->
                                                Por solicitar
                                                <template v-if="
                                                    configuration.divided_items
                                                ">
                                                    <el-checkbox v-model="localDividedItems
                                                        " style="margin-left: 10px;" @change="
                                                            saveDividedItemsLocalStorage
                                                        ">Dividir ordenes
                                                        iguales</el-checkbox>
                                                </template>
                                            </template>
                                        </div>
                                        <div class="mx-4 h4 txt-info p-10 f-w-700 d-flex align-items-center"
                                            v-if="isAppNotIgvAndHaveIgv">
                                            <span class="text-danger">
                                                <i class="fas fa-exclamation-triangle"></i>
                                                <span>
                                                    Esta operación es gravada,
                                                    hay productos con IGV.
                                                </span>
                                            </span>
                                        </div>
                                        <div v-show="localOrden.length > 0"
                                            class="col-sm-12 col-md-12 col-lg-12 col-xl-12" v-for="(order_pend,
                                                indexx) in localOrden" :key="indexx" v-loading="loadingCommercialTreatment
                                                    ">
                                            <!--  -->
                                            <div class="mx-2 coupon rounded d-flex justify-content-between">
                                                <div class="tengah py-2 d-flex w-100 justify-content-start p-2">
                                                    <div class="col-12 overflow-hidden card shadow-lg p-3 rounded"
                                                        style="
                              box-shadow: 0 1rem 3rem rgb(0 0 0 / 18%) !important;
                            ">
                                                        <div class="row">
                                                            <h6 class="text-danger" v-if="
                                                                igvStatusMap[
                                                                order_pend
                                                                    .id
                                                                ]
                                                            ">
                                                                PRODUCTO CON IGV
                                                            </h6>
                                                            <h3 class="lead font-weight-light fw-bold">
                                                                <template v-if="
                                                                    order_pend
                                                                        .food
                                                                        .item
                                                                        .name_product_pdf
                                                                ">
                                                                    {{
                                                                        order_pend.food.item.name_product_pdf.toUpperCase()
                                                                    }}
                                                                </template>
                                                                <template v-else>
                                                                    {{
                                                                        order_pend.food.description.toUpperCase()
                                                                    }}
                                                                </template>

                                                                <span v-if="
                                                                    order_pend.type_id
                                                                " class="text-primary">
                                                                    <small>
                                                                        <template v-if="
                                                                            configuration.change_unit_type_pos
                                                                        ">
                                                                            <el-dropdown @command="
                                                                                changeUnitType
                                                                            " size="medium" type="primary">
                                                                                <span>
                                                                                    <strong>
                                                                                        *{{
                                                                                            order_pend.type_description
                                                                                        }}
                                                                                    </strong>
                                                                                </span>
                                                                                <el-dropdown-menu slot="dropdown">
                                                                                    <el-dropdown-item v-for="(unit_type,
                                                                                        indext) in order_pend
                                                                                            .food
                                                                                            .types" :key="indext
                                                                                                " :command="{
                                                                                                    indexx,
                                                                                                    unit_type
                                                                                                }">
                                                                                        <strong>
                                                                                            {{
                                                                                                unit_type.description
                                                                                            }}
                                                                                        </strong>
                                                                                    </el-dropdown-item>
                                                                                </el-dropdown-menu>
                                                                            </el-dropdown>
                                                                        </template>
                                                                        <template v-else>
                                                                            <strong>
                                                                                *{{
                                                                                    order_pend.type_description
                                                                                }}
                                                                            </strong>
                                                                        </template>
                                                                    </small>
                                                                </span>
                                                                <span v-if="
                                                                    order_pend.categoriaMadera
                                                                " class="text-primary">
                                                                    <small>
                                                                        <strong>
                                                                            {{
                                                                                `${order_pend.categoriaMadera.selectedGrosor}x${order_pend.categoriaMadera.selectedAncho}x${order_pend.categoriaMadera.selectedLargo}`
                                                                            }}
                                                                        </strong>
                                                                    </small>
                                                                </span>

                                                                <span v-if="
                                                                    configuration.quantity_prices &&
                                                                    order_pend
                                                                        .food
                                                                        .item_price_ranges
                                                                        .length >
                                                                    0
                                                                ">
                                                                    <el-tooltip>
                                                                        <template slot="content">
                                                                            <div v-for="(price_range,
                                                                                index) in order_pend
                                                                                    .food
                                                                                    .item_price_ranges" :key="index
                                                                                        " style="margin-bottom: 4px;">
                                                                                <strong>Cantidad:</strong>
                                                                                {{
                                                                                    price_range.quantity_min
                                                                                }}
                                                                                <br />
                                                                                <strong>Precio:</strong>
                                                                                S/.
                                                                                {{
                                                                                    price_range.price
                                                                                }}
                                                                            </div>
                                                                        </template>
                                                                        <i class="fas fa-info-circle"></i>
                                                                    </el-tooltip>
                                                                </span>

                                                                <el-tooltip v-if="
                                                                    configuration.edit_name_product
                                                                " content="Cambiar nombre del producto">
                                                                    <el-tag role="button" type="success" size="mini"
                                                                        @click="
                                                                            changeName(
                                                                                indexx
                                                                            )
                                                                            ">
                                                                        <i class="fas fa-edit text-black"></i>
                                                                    </el-tag>
                                                                </el-tooltip>
                                                                <el-tooltip v-if="
                                                                    order_pend
                                                                        .food
                                                                        .item
                                                                        .name_product_pdf
                                                                " content="Restaurar nombre del producto">
                                                                    <el-tag role="button" type="danger" size="mini"
                                                                        @click="
                                                                            restoreName(
                                                                                indexx
                                                                            )
                                                                            ">
                                                                        <i class="fas fa-times text-black"></i>
                                                                    </el-tag>
                                                                </el-tooltip>
                                                            </h3>
                                                            <p
                                                                class="badge bg-foreground text-uppercase font-weight-light p-0">
                                                            </p>
                                                        </div>
                                                        <div class="row col-12">
                                                            <div class="col-2 col-md-2" v-if="
                                                                !configuration.college
                                                            ">
                                                                <el-tag v-if="
                                                                    configuration.restaurant
                                                                " @click="
                                                                    toCarry(
                                                                        indexx
                                                                    )
                                                                    " size="medium" role="button" :type="order_pend.to_carry
                                                                            ? 'success'
                                                                            : 'info'
                                                                            " :effect="order_pend.to_carry
                                                                            ? 'dark'
                                                                            : 'plain'
                                                                            ">
                                                                    <i class="fas fa-biking" style="color: black"></i>
                                                                </el-tag>
                                                            </div>
                                                            <div class="col-4 col-md-4">
                                                                <el-button-group>
                                                                    <el-button class="text-white" type="danger"
                                                                        icon="el-icon-delete" size="mini" circle @click="
                                                                            deleteFood(
                                                                                indexx
                                                                            )
                                                                            "></el-button>
                                                                    <el-button v-if="
                                                                        configuration.restaurant &&
                                                                        !configuration.college
                                                                    " class="text-white" type="info"
                                                                        icon="el-icon-s-order" size="mini" circle
                                                                        @click="
                                                                            openLocalObservationDialog(
                                                                                indexx,
                                                                                order_pend.observation,
                                                                                order_pend
                                                                                    .food
                                                                                    .item
                                                                                    .id
                                                                            )
                                                                            "></el-button>
                                                                </el-button-group>
                                                            </div>
                                                        </div>
                                                        <!-- Cantidad de productos en lista de venta directa -->
                                                        <div class="row align-items-end">
                                                            <div class="col-6 col-4 col-md-5 col-lg-4 col-xl-4">
                                                                <span class="fw-bold "
                                                                    style="font-weight: bold; font-family: 'Arial Black', Arial, sans-serif; font-size: 1.2rem;">
                                                                    Cantidad:
                                                                    <br />
                                                                    <div class="input-group spinner"
                                                                        data-trigger="spinner">
                                                                        <input type="text" :readonly="(order_pend
                                                                            .food
                                                                            .item
                                                                            .is_set &&
                                                                            configuration.item_set_quantity_pos) ||
                                                                            isConsignment ||
                                                                            !configuration.quantity_cash ||
                                                                            order_pend
                                                                                .food
                                                                                .item
                                                                                .series_enabled ==
                                                                            1 ||
                                                                            order_pend
                                                                                .food
                                                                                .item
                                                                                .has_color_size ==
                                                                            1 ||
                                                                            (order_pend
                                                                                .food
                                                                                .item
                                                                                .lots_enabled ==
                                                                                1 &&
                                                                                order_pend
                                                                                    .food
                                                                                    .item
                                                                                    .lots_group
                                                                                    .length >
                                                                                1)
                                                                            " class="form-control text-center fw-bold"
                                                                            style="font-weight: bold; font-family: 'Arial Black', Arial, sans-serif;"
                                                                            v-model="order_pend.quantity"
                                                                            :type="'text'"
                                                                            data-rule="currency" :class="{
                                                                                'custom-bg-light': !configuration.item_set_quantity_pos,
                                                                                'custom-bg-danger;': configuration.item_set_quantity_pos
                                                                            }" @input="
                                                                                verifyStock(order_pend, indexx)
                                                                            " />

                                                                        <div class="input-group-text">
                                                                            <button type="button" class="spin-up"
                                                                                data-spin="up" :disabled="(order_pend
                                                                                    .food
                                                                                    .item
                                                                                    .is_set &&
                                                                                    configuration.item_set_quantity_pos) ==
                                                                                    1 ||
                                                                                    isConsignment ||
                                                                                    (order_pend
                                                                                        .food
                                                                                        .item
                                                                                        .series_enabled ==
                                                                                        1 &&
                                                                                        !configuration.quotation) ||
                                                                                    order_pend
                                                                                        .food
                                                                                        .item
                                                                                        .has_color_size ==
                                                                                    1 ||
                                                                                    (order_pend
                                                                                        .food
                                                                                        .item
                                                                                        .lots_enabled ==
                                                                                        1 &&
                                                                                        order_pend
                                                                                            .food
                                                                                            .item
                                                                                            .lots_group
                                                                                            .length >
                                                                                        1)
                                                                                    " @click="
                                                                                        sumar_orden(
                                                                                            indexx
                                                                                        )
                                                                                        ">
                                                                                <span class="arrow"></span>
                                                                            </button>
                                                                            <button type="button" class="spin-down"
                                                                                data-spin="down" :disabled="isConsignment ||
                                                                                    (order_pend
                                                                                        .food
                                                                                        .item
                                                                                        .series_enabled ==
                                                                                        1 &&
                                                                                        !configuration.quotation) ||
                                                                                    order_pend
                                                                                        .food
                                                                                        .item
                                                                                        .has_color_size ==
                                                                                    1 ||
                                                                                    (order_pend
                                                                                        .food
                                                                                        .item
                                                                                        .lotes_enabled ==
                                                                                        1 &&
                                                                                        order_pend
                                                                                            .food
                                                                                            .item
                                                                                            .lots_group
                                                                                            .length >
                                                                                        1)
                                                                                    " @click="
                                                                                        restar_orden(
                                                                                            indexx
                                                                                        )
                                                                                        ">
                                                                                <span class="arrow"></span>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </span>
                                                            </div>

                                                            <!-- Precio unitario del produto en lista de venta directa -->
                                                            <template>
                                                                <div class="col-6 col-4 col-md-5 col-lg-5 col-xl-4">
                                                                    <span class="time font-weight-light">
                                                                        <span class="fw-bold"
                                                                            style="font-weight: bold; font-family: 'Arial Black', Arial, sans-serif; font-size: 1.2rem;">
                                                                            Precio:
                                                                            {{
                                                                                currency_id
                                                                            }}

                                                                            <template v-if="
                                                                                order_pend.prices
                                                                            ">
                                                                                <el-input v-if="
                                                                                    isEditing &&
                                                                                    configuration.edit_price_sales
                                                                                " class="custom_input fw-bold"
                                                                                    style="font-weight: bold; font-family: 'Arial Black', Arial, sans-serif; font-size: 1.2rem;"
                                                                                    type="number" v-model.number="order_pend.price
                                                                                        " @input="
                                                                                            update_price(
                                                                                                indexx
                                                                                            )
                                                                                            "
                                                                                    placeholder="Editar precio"></el-input>
                                                                                <el-select v-else v-model="order_pend.price
                                                                                    "
                                                                                    placeholder="Seleccione un precio"
                                                                                    @change="
                                                                                        update_price(
                                                                                            indexx,
                                                                                            order_pend.price
                                                                                        )
                                                                                        ">
                                                                                    <el-option v-for="(price,
                                                                                        index) in order_pend.prices"
                                                                                        :key="index
                                                                                            " :value="price
                                                                                                " :label="price
                                                                                                "></el-option>
                                                                                </el-select>
                                                                                <el-button v-if="
                                                                                    configuration.edit_price
                                                                                " @click="
                                                                                    toggleEdit
                                                                                ">{{
                                                                                        isEditing
                                                                                            ? "C"
                                                                                            : "E"
                                                                                    }}</el-button>
                                                                            </template>
                                                                            <template v-else>
                                                                                <el-input class="custom_input text-dark"
                                                                                    style="font-weight: bold; font-family: 'Arial Black', Arial, sans-serif; font-size: 1.2rem;"
                                                                                    :disabled="isSellerConsolidated ||
                                                                                        configuration.editar_precio_politica ===
                                                                                        false
                                                                                        " type="number" v-model="order_pend.price
                                                                                            " @input="
                                                                                            update_price(
                                                                                                indexx,
                                                                                                order_pend.price
                                                                                            )
                                                                                            ">
                                                                                    <!-- <template
                                                                                        slot="prepend"
                                                                                    >
                                                                                        {{
                                                                                            currency_id
                                                                                        }}
                                                                                    </template> -->
                                                                                </el-input>
                                                                            </template>
                                                                        </span>
                                                                    </span>
                                                                </div>
                                                                <div class="col-4 col-md-2 col-lg-3 mt-2" v-if="
                                                                            configuration.edit_subtotal_box &&
                                                                                !isSellerConsolidated
                                                                        ">

                                                                    <strong>
                                                                        {{ typeof order_pend.newSubtotal === 'number' ? Number(order_pend.newSubtotal).toFixed(2) : parseFloat(order_pend.price * order_pend.quantity).toFixed(2) }}
                                                                    </strong>

                                                                    <el-input class="input-new-tag1 text-center w-100"
                                                                        style="font-weight: bold; font-family: 'Arial Black', Arial, sans-serif; font-size: 1.2rem; text-align: center;"
                                                                        v-model="order_pend.newSubtotal"
                                                                        type="number" step="0.01"
                                                                        @input="val => handleSubtotalInput(val, indexx)"
                                                                        placeholder="0.00" size="medium" />

                                                                    <!-- ...existing code... -->
                                                                </div>
                                                            </template>
                                                        </div>
                                                        <div v-if="
                                                            order_pend.food
                                                                .item
                                                                .series_enabled
                                                        ">
                                                            <template v-if="
                                                                order_pend
                                                                    .series
                                                                    .length ==
                                                                0
                                                            ">
                                                                <el-tag style="margin-top: 5px" role="button" @click="
                                                                    showSeriesDialog(
                                                                        order_pend,
                                                                        indexx
                                                                    )
                                                                    " type="danger">
                                                                    **Seleccione
                                                                    una serie
                                                                </el-tag>
                                                            </template>
                                                            <template v-else>
                                                                <div v-for="(serie,
                                                                    idx) in order_pend.series" :key="idx"
                                                                    style="margin-top: 5px">
                                                                    <el-tag type="primary" closable
                                                                        :disable-transitions="false
                                                                            " @close="
                                                                                deleteSerie(
                                                                                    indexx,
                                                                                    serie.id
                                                                                )
                                                                                ">
                                                                        {{
                                                                            serie.series
                                                                        }}
                                                                    </el-tag>
                                                                    <br />
                                                                </div>
                                                                <el-tag style="margin-top: 5px" role="button" @click="
                                                                    showSeriesDialog(
                                                                        order_pend,
                                                                        indexx
                                                                    )
                                                                    " type="success">
                                                                    Ver Series
                                                                </el-tag>
                                                            </template>
                                                        </div>
                                                        <div v-if="
                                                            order_pend.food
                                                                .item
                                                                .has_color_size
                                                        ">
                                                            <template v-if="
                                                                order_pend.color_size &&
                                                                order_pend
                                                                    .color_size
                                                                    .length ==
                                                                0
                                                            ">
                                                                <el-tag style="margin-top: 5px" role="button" @click="
                                                                    showColorSizeDialog(
                                                                        order_pend,
                                                                        indexx
                                                                    )
                                                                    " type="danger">
                                                                    **Seleccione
                                                                    un color y
                                                                    talla
                                                                </el-tag>
                                                            </template>
                                                            <template v-else>
                                                                <div v-for="(color_size,
                                                                    idx) in order_pend.color_size" :key="idx"
                                                                    style="margin-top: 5px">
                                                                    <el-tag type="primary" closable
                                                                        :disable-transitions="false
                                                                            " @close="
                                                                                deleteColorSize(
                                                                                    indexx,
                                                                                    color_size.id
                                                                                )
                                                                                ">
                                                                        {{
                                                                            color_size.color
                                                                        }}
                                                                        -
                                                                        {{
                                                                            color_size.size
                                                                        }}
                                                                        - Cant.
                                                                        {{
                                                                            color_size.quantity
                                                                        }}
                                                                    </el-tag>
                                                                    <br />
                                                                </div>
                                                                <el-tag style="margin-top: 5px" role="button" @click="
                                                                    showColorSizeDialog(
                                                                        order_pend,
                                                                        indexx
                                                                    )
                                                                    " type="success">
                                                                    Ver Colores
                                                                    & Tallas
                                                                </el-tag>
                                                            </template>
                                                        </div>
                                                        <div v-if="
                                                            order_pend.food
                                                                .item
                                                                .lots_enabled &&
                                                            !order_pend
                                                                .food
                                                                .item
                                                                .series_enabled
                                                        ">
                                                            <template v-if="
                                                                order_pend
                                                                    .lotes
                                                                    .length ==
                                                                0
                                                            ">
                                                                <el-tag style="margin-top: 5px" role="button" @click="
                                                                    showLotesDialog
                                                                " type="danger">
                                                                    **Seleccione
                                                                    el lote
                                                                </el-tag>
                                                            </template>
                                                            <template v-else>
                                                                <div v-for="(lot,
                                                                    idx) in order_pend.lotes" :key="idx"
                                                                    style="margin-top: 5px" v-show="lot.quantitySelected >
                                                                        0
                                                                        ">
                                                                    <el-tooltip :content="`Cant. en almacén: ${lot.quantity}`
                                                                        ">
                                                                        <el-tag type="primary">
                                                                            {{
                                                                                lot.code
                                                                            }}
                                                                            <template v-if="
                                                                                order_pend
                                                                                    .food
                                                                                    .item
                                                                                    .lots_group
                                                                                    .length >
                                                                                1
                                                                            ">
                                                                                -
                                                                                Cant.
                                                                                {{
                                                                                    lot.quantitySelected
                                                                                }}
                                                                            </template>
                                                                        </el-tag>
                                                                    </el-tooltip>
                                                                    <br />
                                                                </div>
                                                                <el-tag v-if="
                                                                    order_pend
                                                                        .food
                                                                        .item
                                                                        .lots_group
                                                                        .length >
                                                                    1
                                                                " style="margin-top: 5px" role="button" @click="
                                                                    showLotesDialog(
                                                                        order_pend,
                                                                        indexx
                                                                    )
                                                                    " type="success">
                                                                    Ver Lotes
                                                                </el-tag>
                                                            </template>
                                                        </div>
                                                        <div v-if="
                                                            order_pend.observation
                                                        ">
                                                            <small>
                                                                OBS:
                                                                {{
                                                                    order_pend.observation
                                                                }}
                                                            </small>
                                                        </div>
                                                        <div class="row" v-if="isConsignment">
                                                            <div class="col-md-4" v-if="
                                                                !order_pend.is_penalty
                                                            ">
                                                                <label for="warehouse">
                                                                    Para el
                                                                    almacen
                                                                </label>
                                                                <el-input-number :min="0" @change="
                                                                    updateWarehouse(
                                                                        order_pend,
                                                                        indexx
                                                                    )
                                                                    " class="w-100" controls-position="right" v-model="order_pend.toWarehouse
                                                                        "></el-input-number>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr />
                                            </div>
                                        </div>
                                        <div class="d-flex h-0 justify-content-center align-items-center" v-if="
                                            localOrden.length == 0 &&
                                            !variation
                                        ">
                                            <p class="font-weight-lighter">
                                                Lista vacía.
                                            </p>
                                        </div>
                                        <div v-if="
                                            ordens.length != 0 &&
                                            !variation &&
                                            isCreatingOrden == false
                                        " class="mx-2 h4 txt-info p-10 f-w-700 d-flex align-items-center">
                                            <a class="badge badge bg-dark text-white" style="margin-right: 5px">
                                                <template v-if="ordens.length <= 9">
                                                    0{{ ordens.length }}
                                                </template>
                                                <template v-else>
                                                    {{ ordens.length }}
                                                </template>
                                            </a>
                                            Atendidos
                                        </div>

                                        <div v-if="isCreatingOrden == false" v-show="ordens.length > 0 && !variation
                                            " class="col-12" v-for="(ord, idx) in ordens" :key="`${idx}-A`">
                                            <div class="mx-2 coupon rounded d-flex justify-content-between">
                                                <div class="tengah py-2 d-flex w-100 justify-content-start p-2">
                                                    <div class="overflow-hidden w-100 card shadow-lg p-3" style="
                                                        box-shadow: rgba(0, 0, 0, 0.18) 0px 1rem 3rem !important;
                                                        ">
                                                        <h3 class="lead font-weight-light fw-bold"
                                                            style="font-weight: bold; font-family: 'Arial Black', Arial, sans-serif; font-size: 1.2rem;">
                                                            <template v-if="
                                                                ord.food
                                                                    .item
                                                                    .name_product_pdf
                                                            ">
                                                                {{
                                                                    ord.food.item.name_product_pdf.toUpperCase()
                                                                }}
                                                            </template>
                                                            <template v-else>
                                                                {{
                                                                    ord.food.description.toUpperCase()
                                                                }}
                                                            </template>

                                                            <span v-if="
                                                                ord.type_id
                                                            " class="text-primary">
                                                                <small>
                                                                    <strong>
                                                                        *{{
                                                                            ord.type_description
                                                                        }}
                                                                    </strong>
                                                                </small>
                                                            </span>
                                                            <span v-if="
                                                                ord.categoriaMadera
                                                            " class="text-primary">
                                                                <small>
                                                                    <strong>
                                                                        *{{
                                                                            `${ord.categoriaMadera.selectedGrosor}x${ord.categoriaMadera.selectedAncho}x${ord.categoriaMadera.selectedLargo}`
                                                                        }}
                                                                    </strong>
                                                                </small>
                                                            </span>
                                                        </h3>
                                                        <p
                                                            class="badge bg-foreground text-uppercase font-weight-light p-0">
                                                        </p>
                                                        <div class="row align-items-end">
                                                            <div class="col-5 col-md-5 col-lg-3 col-xl-4">
                                                                <span class=""
                                                                    style="font-weight: bold; font-family: 'Arial Black', Arial, sans-serif; font-size: 1.2rem;">
                                                                    Cantidad
                                                                    <br />
                                                                    <div class="input-group spinner"
                                                                        data-trigger="spinner">
                                                                        <input type="text" readonly
                                                                            class="form-control text-center" v-model="ord.quantity
                                                                                " data-rule="currency" />
                                                                        <input v-if="
                                                                            ord.categoriaMadera
                                                                        " type="text" readonly
                                                                            class="form-control text-center" v-model="ord
                                                                                .categoriaMadera
                                                                                .quantity
                                                                                " data-rule="currency" />
                                                                        <div class="input-group-text">
                                                                            <button type="button" class="spin-up"
                                                                                data-spin="up">
                                                                                <span class="arrow"></span>
                                                                            </button>
                                                                            <button type="button" class="spin-down"
                                                                                data-spin="down">
                                                                                <span class="arrow"></span>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </span>
                                                            </div>

                                                            <div class="col-6 col-4 col-md-5 col-lg-5 col-xl-4">
                                                                <span class="time font-weight-light">
                                                                    <span class=""
                                                                        style="font-weight: bold; font-family: 'Arial Black', Arial, sans-serif; font-size: 1.2rem;">
                                                                        Precio

                                                                        <el-input class="custom_input"
                                                                            style="width: 100%; font-weight: bold; font-family: 'Arial Black', Arial, sans-serif; font-size: 1.2rem;"
                                                                            type="number" v-model="ord.price
                                                                                " @input="
                                                                                    calculateTotal
                                                                                ">
                                                                            <template slot="prepend">
                                                                                {{
                                                                                    currency_id ==
                                                                                        "USD"
                                                                                        ? "$"
                                                                                        : "S/"
                                                                                }}
                                                                            </template>
                                                                            <!-- <template
                                                                                slot="prepend"
                                                                                v-if="
                                                                                    ord
                                                                                        .food
                                                                                        .item
                                                                                        .currency_type_id ==
                                                                                        'USD'
                                                                                "
                                                                            >
                                                                                $
                                                                        </template>-->
                                                                        </el-input>
                                                                    </span>
                                                                </span>
                                                            </div>
                                                            <div class="col-md-6 m2 mt-2 col-lg-3">
                                                                <el-button-group>
                                                                    <el-button v-if="
                                                                        ord.status_orden_id !=
                                                                        3
                                                                    " @click="
                                                                        ordenReady(
                                                                            ord.id
                                                                        )
                                                                        " type="success" icon="el-icon-check"
                                                                        size="mini" circle></el-button>
                                                                    <el-button class="text-white" type="danger"
                                                                        icon="el-icon-delete" size="mini" circle @click="
                                                                            cancelOrdena(
                                                                                ord.id
                                                                            )
                                                                            "></el-button>
                                                                </el-button-group>
                                                                <el-tag size="medium">
                                                                    <strong
                                                                        style=" font-weight: bold; font-family: 'Arial Black', Arial, sans-serif; font-size: 1.2rem;">
                                                                        {{
                                                                            parseFloat(
                                                                                ord.price *
                                                                                ord.quantity
                                                                            ).toFixed(
                                                                                2
                                                                            )
                                                                        }}
                                                                    </strong>
                                                                </el-tag>
                                                            </div>
                                                            <div v-if="
                                                                configuration.restaurant &&
                                                                ord.observations
                                                            " class="col-md-12 mt-1">
                                                                <small>
                                                                    OBS:
                                                                    {{
                                                                        ord.observations
                                                                    }}
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- <div
                                            class="mx-4 h4 txt-info p-10 f-w-700 d-flex align-items-center"
                                        >
                                            <template
                                                v-if="configuration.restaurant"
                                            >
                                                <a
                                                    class="bage bg-dark text-white"
                                                    style="margin-right: 5px"
                                                >
                                                    <template
                                                        v-if="
                                                            localOrden.length <=
                                                                9
                                                        "
                                                    >
                                                        0{{ localOrden.length }}
                                                    </template>
                                                    <template v-else>
                                                        {{ localOrden.length }}
                                                    </template>
                                                </a>
                                                
                                                Por solicitar
                                                <template
                                                    v-if="
                                                        configuration.divided_items
                                                    "
                                                >
                                                    <el-checkbox
                                                        v-model="
                                                            localDividedItems
                                                        "
                                                        style="margin-left: 10px;"
                                                        @change="
                                                            saveDividedItemsLocalStorage
                                                        "
                                                        >Dividir ordenes
                                                        iguales</el-checkbox
                                                    >
                                                </template>
                                            </template>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <el-dialog @close="closeLocalObservationDialog" :visible="dialogLocalObservation" append-to-body
            title="Editando observación">
            <span>
                <label class="control-label">Observación</label>
                <el-input v-model="localObservation"></el-input>
            </span>
            <span slot="footer" class="dialog-footer">
                <button class="btn btn-sm btn-secondary" @click="changeLocalObservation">
                    Cambiar
                </button>
                <button class="btn btn-sm btn-light" @click="closeLocalObservationDialog">
                    Cerrar
                </button>
            </span>
        </el-dialog>
        <!-- modal de aparcado -->
        <el-dialog :visible="apart" :close-on-click-modal="false" :close-on-press-escape="false" title="Aparcar orden"
            @close="apart = false" width="20%">
            <br />
            <div class="card p-2">
                <div class="col-md-12">
                    <label class="control-label fw-bold">Datos Referenciales</label>
                    <el-input v-model="numberCustomerApart" placeholder="Dni o Nombre"></el-input>
                </div>
                <div class="d-flex justify-content-end">
                    <button class="btn btn-light m-1" @click="apart = false">
                        Cancelar
                    </button>

                    <button class="btn btn-primary m-1" @click="pullApartOrden">
                        Aparcar
                    </button>
                </div>
            </div>
            <br />
        </el-dialog>
        <transfers-modal :showDialog.sync="showTransfersDialog"></transfers-modal>
        <show-lotes-product :idx="currentIdx" :orden="ordenLot" :showDialog.sync="showLotes"
            @updateLotes="updateLotes"></show-lotes-product>
        <show-series-product :limitQty="limitQty" :idx="currentIdx" :item="currentItem" :showDialog.sync="showSeries"
            :seriesSelected.sync="currentSeries" @updateSeries="updateSeries"
            :establishments="establishments"></show-series-product>
        <show-color-size-product :limitQty="limitQty" :idx="currentIdx" :item="currentItem"
            :showDialog.sync="showColorSize" :colorSizeSelected.sync="currentColorSize"
            @updateColorSize="updateColorSize" :establishments="establishments"></show-color-size-product>
        <orden-pull-apart @restoreToLocalOrdens="restoreToLocalOrdens" :showPullApart.sync="listApart"
            :ordenInBox.sync="ordenInBox"></orden-pull-apart>
        <table-ordens-pending :areas="areas" :showPendingOrdens.sync="showPendingOrdens"
            :configuration="configuration"></table-ordens-pending>
        <cash-form v-if="showDialogCash" :showDialog.sync="showDialogCash" :recordId="cash_id" :fromBox="true"
            :fromPos="true" @updateCashId="updateCashId"></cash-form>
        <close-cash v-if="showDialogClose" :recordId.sync="cash_id" :showDialogClose.sync="showDialogClose"
            :fromBox="true" :configuration="configuration" :fromPos="true" @updateCashId="updateCashId"></close-cash>
        <expenses-incomes v-if="configuration.show_expenses_incomes_caja" :showDialog.sync="showExpensesIncomes"
            :company="company" :cash_id="cash_id" :establishments="establishments"
            @checkCashAvailable="checkCashAvailable" :fromPos="true"></expenses-incomes>
        <observation-form :current="current" :observations.sync="tags" :showDialog.sync="showObservations"
            :ordenId="currentOrden" @addObservation="addObservation" :configuration="configuration"></observation-form>
        <quotation-form v-if="configuration.quotation" :configuration="configuration" :isSeller="isSeller"
            :showDialog.sync="showQuotationForm" :quotationDirect.sync="quotationDirect" :items="localOrden"
            :all_customers.sync="customers" @limpiarForm="limpiarForm" :cash_id="cash_id" :sellers="sellers"
            :establishment="establishments" :formQtn.sync="formQtn" :fromPos="true"
            @cotizacionCreada="handleCotizacionCreada" :currencyIdChoice.sync="currencyIdChoice"></quotation-form>

        <credit-form v-if="user && configuration.sale_note_credit_penalty" :users.sync="users" :user.sync="user"
            :showDialog.sync="showCreditForm" :items="localOrden" :customers="customers" @limpiarForm="limpiarForm"
            :cash_id="cash_id" :all_series.sync="all_series" :establishments="establishments"
            :configuration="configuration" :fromPos="true"></credit-form>
        <el-dialog :visible.sync="showChangeDescriptionVariation" title="Cambiar descripción"
            @close="showChangeDescriptionVariation = false">
            <div class="card p-3">
                <el-input placeholder="Nueva descripción" v-model="descriptionTemp"></el-input>
                <br />
                <div class="d-flex justify-content-end">
                    <el-button type="primary" @click="changeDescription">Cambiar</el-button>
                    <el-button @click="showChangeDescriptionVariation = false">Cerrar</el-button>
                </div>
            </div>
        </el-dialog>
        <el-dialog v-loading="deleteOrdenLoading" width="350px" :visible.sync="showPinRequest" title="Ingrese su PIN"
            append-to-body @closed="handlePinDialogClose">
            <div class="row mt-1">
                <p class="h5" style="word-break: break-word;">
                    Para poder eliminar la orden debe ingresar un motivo y su
                    PIN de usuario.
                </p>
            </div>
            <div class="row mt-1">
                <div class="col-12">
                    <el-input v-model="reasonToDelete" placeholder="Ingrese un motivo" type="textarea" maxlength="200"
                        show-word-limit></el-input>
                </div>
            </div>
            <div class="row mt-2">
                <div class="pin-input d-flex justify-content-center">
                    <span v-for="(digit, index) in 4" :key="index" class="pin-circle"
                        :class="{ filled: pin[index] !== undefined }"></span>
                </div>
                <el-input ref="pinInput" v-model="pin" type="password" maxlength="4" class="hidden-input"
                    @keyup.native="handleKeyPress" />

                <div class="col-12 card p-4" style="max-width: 350px; margin-left: 0px; margin-top: 14px;">
                    <div class="">
                        <div class="keypad-grid">
                            <el-button v-for="num in [1, 2, 3, 4, 5, 6, 7, 8, 9]" :key="num"
                                class="keypad-button btn-primary" @click="generatePin(num)">{{ num }}</el-button>

                            <el-button @click="pin = ''" class="keypad-button" type="danger"
                                icon="el-icon-delete"></el-button>

                            <el-button class="keypad-button btn-primary" @click="generatePin(0)">0</el-button>

                            <el-button @click="cancelOrdenaPin" class="keypad-button" type="success"
                                icon="el-icon-s-promotion"></el-button>

                            <!-- <div class="keypad-spacer"></div> -->
                        </div>
                    </div>
                </div>
            </div>
            <div slot="footer" class="dialog-footer" style="text-align: right !important;">
                <el-button @click="showPinRequest = false" type="danger" size="large"
                    style="padding: 12px 24px; font-size: 16px;">
                    Cancelar
                </el-button>
            </div>
        </el-dialog>
        <consignment-form v-if="
            configuration.consignment && localOrden.length != 0 && !isSeller
        " :showDialog.sync="showConsignmentForm" :items="localOrden" :all_customers="customers"
            :establishments="establishments" @limpiarForm="limpiarForm" :fromPos="true"></consignment-form>
        <consolidated-modal :configuration="configuration" :showDialog.sync="showConsolidated"></consolidated-modal>
        <credit-list-modal v-if="configuration.credit_list" :showDialog.sync="showCreditListModal"
            :amountToAdd="creditListAmount" @sendOrdenToCreditList="sendOrdenToCreditList" :cashId="cash_id"
            :fromPos="true"></credit-list-modal>

        <credit-list-dialog v-if="configuration.credit_list" :showDialog.sync="showCreditListDialog"
            :amountToAdd="creditListAmount" @sendOrdenToCreditList="sendOrdenToCreditList"
            @paymentsOrden="paymentsOrden" :fromPos="true"></credit-list-dialog>
        <el-dialog :visible.sync="showChangeName" title="Cambiar nombre de producto" @close="showChangeName = false"
            append-to-body>
            <div class="row m-2">
                <el-input v-model="name_pdf" placeholder="Ingrese un nombre"></el-input>
            </div>
            <div slot="footer" class="dialog-footer">
                <el-button @click="showChangeName = false">Cancelar</el-button>
                <el-button type="primary" @click="changeNamePdf">Guardar</el-button>
            </div>
        </el-dialog>
        <digital-payments :showDigitalPay.sync="showDigitalPay" />
        <open-items :showDialog.sync="showOpenOrden" :selectedItems="selectedItems" :localOrden="localOrden" />
        <!-- <delivery-form :showDialog.sync="showDeliveryForm" :localOrden="localOrden" /> -->
        <DeliveryForm :visible="showDeliveryForm" @close="showDeliveryForm = false" :localOrden="localOrden"
            :configuration="configuration" :all_customers.sync="customers" :fromPos="true" @limpiarForm="limpiarForm"
            :cash_id="cash_id" />
    </div>
</template>
<style>
.black-placeholder::placeholder {
    color: black;
}

.el-input__inner::placeholder {
    color: rgb(6, 6, 6);
}

.el-input-group__prepend {
    padding-left: 6px !important;
    padding-right: 6px !important;
}

.custom_input .el-input__inner {
    padding: 0 5px !important;
    font-weight: bold;
    font-family: "Arial Black", Arial, sans-serif;
}

.el-tag+.el-tag {
    margin-left: 10px;
}

.button-new-tag {
    margin-left: 10px;
    height: 32px;
    line-height: 30px;
    padding-top: 0;
    padding-bottom: 0;
}

.input-new-tag1 {
    width: 70px;
    margin-left: 10px;
    vertical-align: bottom;
}

.input-new-tag1 .el-input__inner {
    height: 30px !important;
}

.custom-flex {
    display: flex;
    align-items: center;
    gap: 10px;
    /* Espaciado entre el texto y los botones */
}

.keypad-grid {
    display: grid;
    grid-template-columns: repeat(3, 80px);
    grid-template-rows: repeat(4, 80px);
    gap: 10px;
    justify-content: center;
}

.keypad-button {
    width: 100%;
    height: 100%;
    border-radius: 50% !important;
    font-size: 24px;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
}

.keypad-spacer {
    width: 80px;
    height: 80px;
}

.pin-input {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
}

/* .pin-circle {
    width: 20px;
    height: 20px;
    border: 2px solid #aaa;
    border-radius: 50%;
} */

.pin-circle {
    width: 20px;
    height: 20px;
    border: 2px solid black;
    /* 🔹 Borde negro */
    border-radius: 50%;
    background-color: white;
    /* 🔹 Fondo blanco */
}

/* 🔹 Cuando se llena un círculo */
.filled {
    background-color: rgb(0, 17, 173);
}

/* 🔹 Ocultar el input real */
.hidden-input {
    position: absolute;
    opacity: 0;
    pointer-events: none;
}
</style>
<script>
const ConsignmentForm = () => import("./consignment_modal.vue");
const QuotationForm = () => import("./quotation_modal.vue");
const CreditForm = () => import("./credit_modal.vue");
const CashForm = () => import("../../cash/form.vue");
const CloseCash = () => import("../../cash/closecash.vue");
const OrdenPullApart = () => import("./ordens_pull_apart.vue");
const TableOrdensPending = () => import("./list_pending_ordens.vue");
const ObservationForm = () => import("../../partials/observation_form.vue");
const ExpensesIncomes = () => import("../partials/expenses_incomes.vue");
const ShowSeriesProduct = () => import("../partials/show_series_product.vue");
const ShowColorSizeProduct = () =>
    import("../partials/show_color_size_product.vue");
const ShowLotesProduct = () => import("../partials/show_lotes_product.vue");
const TransfersModal = () => import("../partials/transfer_modal.vue");
const CreditListModal = () => import("../partials/credit_list_modal.vue");
const CreditListDialog = () => import("../partials/credit_list_dialog.vue");
const ConsolidatedModal = () => import("../partials/consolidated_modal.vue");
const DigitalPayments = () => import("../partials/digital_payments.vue");
const OpenItems = () => import("../partials/visualizate.vue");
import { exchangeRate } from "@mixins/functions";
import DeliveryForm from "../partials/delivery_from.vue";
export default {
    mixins: [exchangeRate],

    components: {
        DigitalPayments,
        ConsolidatedModal,
        CreditListDialog,
        CreditListModal,
        ConsignmentForm,
        CreditForm,
        CashForm,
        CloseCash,
        TableOrdensPending,
        OrdenPullApart,
        ObservationForm,
        ExpensesIncomes,
        ShowSeriesProduct,
        ShowLotesProduct,
        TransfersModal,
        QuotationForm,
        ShowColorSizeProduct,
        OpenItems,
        DeliveryForm
    },
    props: [
        "currencyIdChoice",
        "cotizarConfirmado",
        "formQtn",
        "users",
        "cotIdentifier",
        "quotationId",
        "isSeller",
        "isAnalist",
        "sellers",
        "affectation_igv_types",
        "all_series",
        "areas",
        "customers",
        "company",
        "customer_variation",
        "variationShow",
        "establishments",
        "itemDefault",
        "ordensPending",
        "area_id",
        "blockCart",
        "localOrden",
        "configuration",
        "ordens",
        "total2",
        "clientTableData",
        "isCreatingOrden",
        "ordenId",
        "cash_id",
        "isHotelArea",
        "user",
        "divided_items"
        // "exchange_rate_sale"
    ],

    data() {
        return {
            showDeliveryForm: false,
            boxOperation: "Abrir",
            selectedItems: [],
            isEditing: false,
            /* localOrden: [], */
            /* totalUniqueProducts: 0,
            totalQuantityProducts: 0, */
            localCotizarConfirmado: this.cotizarConfirmado,
            showDigitalPay: false,
            showOpenOrden: false,
            countdown: 0,
            latencia: 0, // Variable para almacenar la latencia en ms
            latenciaInterval: null, // Interval para medir latencia periódicamente
            num_orden: 0,
            isRestaurantWarehouse: true,
            showConsolidated: false,
            quotationDirect: false,
            exchange_rate_sale: 1,
            currency_id: "S/",
            cashAvailable: 0,
            showColorSize: false,
            currentColorSize: null,
            loadingCommercialTreatment: false,
            ordenNumber: null,
            timer: null,
            promotionCode: null,
            currentArea: null,
            showCreditListDialog: false,
            showCreditListModal: false,
            creditListAmount: 0,
            commercialTreatmentId: null,
            quotation_stock: false,
            name_pdf: null,
            showChangeName: false,
            isConsignment: false,
            showConsignmentForm: false,
            deleteGeneralOrden: false,
            deleteOrdenLoading: false,
            reasonToDelete: null,
            ordenIdToDelete: null,
            showPinRequest: false,
            showCreditForm: false,
            showQuotationForm: false,
            limitQty: 0,
            showTransfersDialog: false,
            descriptionTemp: null,
            showChangeDescriptionVariation: false,
            variation: false,
            showObservations: false,
            showDialogCash: false,
            tags: [],
            showSeries: false,
            current: null,
            showDialogClose: false,
            showPendingOrdens: false,
            ordenLoading: false,
            listApart: false,
            apart: false,
            numberCustomerApart: null,
            ordenInBox: [],
            pin: "",
            totalOrdenItems: 0.0,
            total: 0.0,
            disableSend: false,
            totalOrden: 0.0,
            loading: false,
            commands_fisico: "",
            AllSelected: false,
            showDialogPing: false,
            dialogLocalObservation: false,
            currentLocalOrden: null,
            localObservation: null,
            dialogObservation: false,
            observation: null,
            loadingObservation: false,
            currentOrden: null,
            form_ped: {},
            to_carry: false,
            optionsMenu: [],
            foodDefault: null,
            showExpensesIncomes: false,
            showLotes: false,
            ordenLot: null,
            currentIdx: null,
            currentItem: null,
            currentSeries: [],
            screenWidth: 0,
            printing: false,
            foodDefaults: [],
            currentFoodDefault: null,
            commercialTreatments: [],
            currentCommercialTreatment: null,
            isHotel: false,
            customersSearch: [],
            loading_search: false,
            customer_search_id: null,
            saleOfferts: [],
            localDividedItems: this.divided_items,
            subtotalInputTimeouts: [],
        };
    },

    watch: {
        showPinRequest(newValue) {
            if (newValue) {
                // Cuando se abre el diálogo, focus en el input oculto
                this.$nextTick(() => {
                    if (this.$refs.pinInput) {
                        this.$refs.pinInput.$el.querySelector("input").focus();
                    }
                });
            }
        },
        localOrden: {
            handler(newVal) {
                // Aquí puedes llamar a calculateTotal u otras funciones
                this.calculateTotal(newVal);
            },
            deep: true // Para observar cambios dentro de los objetos en localOrden
        },
        cotizarConfirmado() {
            this.handleCotizarConfirmado();
            console.log("Cotización confirmada, ver valor");
        },
        isHotelArea(value, __) {
            this.isHotel = value;
            this.setOptionMenu();
        },
        variationShow(variat, _) {
            if (this.variation && !variat) {
                this.variation = false;
            }
        },
        /*  aqui se puede modificar esto  */
        itemDefault(newItem, _) {
            this.foodDefault = this.itemDefault;
            this.foodDefault.quantity = 1;
            /* this.foodDefault.quantity = newItem.quantity ? newItem.quantity : 1; */
            this.foodDefault.sale_unit_price = Number(
                this.foodDefault.sale_unit_price
            );
            this.foodDefaults = [{ ...this.foodDefault }];
        },
        cash_id(newCash, _) {
            this.boxOperation = newCash ? "Cerrar" : "Abrir";
            this.optionsMenu[2].title = [this.boxOperation, " Caja"];
        },
        ordens(newOrdens, _) {
            if (newOrdens == null) return;
            this.calculateTotal(newOrdens);
        },
        localOrden(newOrdens, _) {
            console.log("localOrden", newOrdens);
            this.calculateTotal(this.ordens);
        }
    },
    computed: {
        igvStatusMap() {
            // Crea un mapa que cachea los resultados por item
            return this.localOrden.reduce((map, orden) => {
                const igvTypeId = orden.food.item.sale_affectation_igv_type_id;
                map[orden.id] =
                    this.configuration.affectation_igv_type_id !== "10" &&
                    igvTypeId == "10";
                return map;
            }, {});
        },
        isAppNotIgvAndHaveIgv() {
            return (
                this.configuration.affectation_igv_type_id != "10" &&
                this.localOrden.some(
                    item => item.food.item.sale_affectation_igv_type_id == "10"
                )
            );
        },
        isDev() {
            return window.location.href.includes("sdrimsac-tenant.oo");
        },
        totalUniqueProducts() {
            // Cantidad de productos únicos
            return this.localOrden.length;
        },
        /* totalQuantityProducts() {
            // Cantidad total considerando las cantidades de cada producto
            return this.localOrden.reduce(
                (total, item) => total + item.quantity,
                0
            );
        }, */

        totalQuantityProducts() {
            // Asegurarse de que el resultado siempre sea un número
            return Array.isArray(this.localOrden)
                ? this.localOrden.reduce(
                    (total, item) => total + (Number(item.quantity) || 0), // Convertir a número
                    0
                )
                : 0; // Devuelve 0 si no es un array válido
        },
        canBeSaleOffert() {
            if (!this.configuration.sale_offert) return null;
            let quantityProducts = this.localOrden.length;
            let offert = this.saleOfferts.find(
                offert => offert.quantity_free == quantityProducts
            );
            if (offert) {
                return `${offert.quantity_free} X ${offert.quantity_total}`;
            }

            return null;
        },
        isSellerConsolidated() {
            return this.isSeller && this.configuration.consolidated_quotations;
        }
        /* formattedCountdown() {
            // Convierte los segundos a minutos y segundos
            const minutes = Math.floor(this.countdown / 60);
            const seconds = this.countdown % 60;
            return `${minutes
                .toString()
                .padStart(2, "0")}:${seconds.toString().padStart(2, "0")}`;
        }, */
    },
    async mounted() {
        // Iniciar medición de latencia
        //this.iniciarMedicionLatencia();

        this.isRestaurantWarehouse = this.establishments.description.includes(
            "RESTAURANT"
        );

        this.quotation_stock = this.isSeller;
        this.screenWidth = window.innerWidth;
        window.addEventListener("resize", this.handleResize);
        this.foodDefault = this.itemDefault;
        this.boxOperation = this.cash_id ? "Cerrar" : "Abrir";
        this.setOptionMenu();
        let ordens = [];
        let ordensSave = localStorage.ordens;
        if (ordensSave) {
            ordens = JSON.parse(ordensSave);
        }
        this.ordenInBox = ordens;
        // Inicializar newSubtotal en cada producto de localOrden
        if (Array.isArray(this.localOrden)) {
            this.localOrden.forEach(o => {
                if (typeof o.newSubtotal === 'undefined' || o.newSubtotal === null) {
                    o.newSubtotal = parseFloat((o.price * o.quantity).toFixed(2));
                }
            });
        }
        setTimeout(() => { }, 1000);
        Echo.channel("insert_cash").listen(
            `.insert-cash-${this.configuration.socket_channel}`,
            e => {
                let { amount, cash_id } = e;
                if (this.$cashId == cash_id) {
                    // this.cashAvailable = Number(amount);
                    this.checkCashAvailable();
                }
            }
        );
    },
    beforeDestroy() {
        // Limpia el intervalo para evitar fugas de memoria
        clearInterval(this.syncCountdown);
        // Detener medición de latencia
        this.detenerMedicionLatencia();
    },
    async created() {
        let printing = localStorage.getItem("cajaPrint");

        this.printing = printing == 1;
        // Inicializar newSubtotal en cada producto de localOrden
        if (Array.isArray(this.localOrden)) {
            this.localOrden.forEach(o => {
                if (typeof o.newSubtotal === 'undefined' || o.newSubtotal === null) {
                    o.newSubtotal = parseFloat((o.price * o.quantity).toFixed(2));
                }
            });
        }
        qz.security.setCertificatePromise((resolve, reject) => {
            this.$http
                .get("/api/qz/crt/override", {
                    responseType: "text"
                })
                .then(response => {
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error.data);
                });
        });
        qz.security.setSignaturePromise(toSign => {
            return (resolve, reject) => {
                this.$http
                    .post("/api/qz/signing", {
                        request: toSign
                    })
                    .then(response => {
                        resolve(response.data);
                    })
                    .catch(error => {
                        reject(error.data);
                    });
            };
        });

        //await this.getTags();
        this.getCommercialTreatments();
        this.checkCashAvailable();
        this.getLasNumOrden();
        this.getSaleOfferts();
        this.searchExchangeRateByDate(moment().format("YYYY-MM-DD"));
        this.readDividedItemsLocalStorage();
    },
    methods: {
        getTotalToShow() {
            // Si hay solo un producto y tiene subtotal editado, mostrar ese subtotal
            if (this.localOrden && this.localOrden.length === 1 && typeof this.localOrden[0].newSubtotal === 'number') {
                return Number(this.localOrden[0].newSubtotal).toFixed(2);
            }
            // Si hay subtotal editado en todos los productos, sumar esos subtotales
            if (this.localOrden && this.localOrden.length > 0 && this.localOrden.every(o => typeof o.newSubtotal === 'number')) {
                let sum = this.localOrden.reduce((acc, o) => acc + Number(o.newSubtotal), 0);
                return sum.toFixed(2);
            }
            // Si hay al menos un producto con subtotal editado, sumar solo esos subtotales
            if (this.localOrden && this.localOrden.length > 0 && this.localOrden.some(o => typeof o.newSubtotal === 'number')) {
                let sum = this.localOrden.filter(o => typeof o.newSubtotal === 'number').reduce((acc, o) => acc + Number(o.newSubtotal), 0);
                return sum.toFixed(2);
            }
            // Si no, mostrar el total calculado normal
            return (this.total + this.totalOrdenItems).toFixed(2);
        },

        handleSubtotalInput(val, idx) {
            // Limpiar timeout anterior si existe
            if (this.subtotalInputTimeouts[idx]) {
                clearTimeout(this.subtotalInputTimeouts[idx]);
            }
            // Guardar el valor temporalmente, forzando dos decimales
            this.localOrden[idx].newSubtotal = val === '' || val === null ? null : parseFloat(Number(val).toFixed(2));
            // Si el subtotal fue editado, recalcular la cantidad con 6 decimales
            if (this.localOrden[idx].price > 0 && this.localOrden[idx].newSubtotal !== null) {
                this.localOrden[idx].quantity = parseFloat((this.localOrden[idx].newSubtotal / this.localOrden[idx].price).toFixed(6));
            }
            // Crear nuevo timeout para ejecutar el proceso después de 600ms
            this.subtotalInputTimeouts[idx] = setTimeout(() => {
                if (val === '' || val === null) {
                    this.changeSubtotal(idx);
                } else {
                    this.saveSubtotal(idx);
                }
            }, 1000);
        },

        openDeliveryForm() {
            this.to_carry = true; // Asegúrate de esto antes
            this.allToCarry();
            this.showDeliveryForm = true;
        },
        addItemToSelection(item) {
            // Agregar el elemento seleccionado al array
            if (!this.selectedItems.includes(item)) {
                this.selectedItems.push(item);
            }
        },
        removeItemFromSelection(item) {
            // Eliminar el elemento del array si se deselecciona
            this.selectedItems = this.selectedItems.filter(
                selectedItem => selectedItem !== item
            );
        },
        // checkIgvApp(igv_type_id) {
        //     console.log("igv_type_id", igv_type_id);
        //     return (
        //         this.configuration.affectation_igv_type_id !== "10" &&
        //         igv_type_id == "10"
        //     );
        // },
        toggleEdit() {
            this.isEditing = !this.isEditing;
        },
        clgOrden() {
            console.log("el orden es", this.localOrden);
        },
        // precio selecionable
        getDefaultPrice(type) {
            let listPricesDescription = ["price1", "price2", "price3"];
            let currentPriceIndx =
                listPricesDescription[type.price_default - 1];
            let price = type[currentPriceIndx];
            if (type.total == null || this.configuration.price_item_unit_type) {
            } else {
                price = Number(type.total);
            }
            return price;
        },
        changeUnitType({ indexx, unit_type }) {
            let prices = [unit_type.price1, unit_type.price2, unit_type.price3];
            let default_price = unit_type.price_default - 1;
            let newPrices = [
                prices[default_price],
                ...prices.filter((_, index) => index !== default_price)
            ].filter(p => p > 0);
            let orden = this.localOrden[indexx];
            if (this.configuration.price_item_unit_type) {
                orden.prices = newPrices;
            } else {
                orden.prices = null;
            }
            orden.type_id = unit_type.id;
            orden.type_description = unit_type.description;
            orden.type_quantity = unit_type.quantity_unit;
            orden.type_price_ranges = unit_type.item_unit_type_price_ranges;
            orden.price = this.getDefaultPrice(unit_type);

            console.log(indexx, unit_type);
            console.log(this.localOrden[indexx]);

            this.localOrden[indexx] = orden;

            this.calculateTotal();
        },
        saveDividedItemsLocalStorage() {
            this.$emit("update:divided_items", this.localDividedItems);

            localStorage.setItem("divided_items", this.localDividedItems);
        },
        readDividedItemsLocalStorage() {
            let divided_items = localStorage.getItem("divided_items");
            if (divided_items) {
                this.localDividedItems = divided_items == "true";
                this.$emit("update:divided_items", this.localDividedItems);
            }
        },
        handleCotizacionCreada(value) {
            this.$emit("cotizarConfirmado", value);
        },

        handleCotizarConfirmado() {
            this.cotizarConfirmado;
            console.log(
                "Cotización confirmada, procesando...",
                this.cotizarConfirmado
            );
        },

        openOrden() {
            this.showOpenOrden = true;
        },

        openDigitalPay() {
            this.showDigitalPay = true;
        },
        searchExchangeRateByDate(date) {
            this.$http(`/service/exchange?date=${date}`).then(response => {
                if (response.status == 200) {
                    let data = response.data;
                    data = data.toString();
                    data = data.replace(",", ".");
                    this.exchange_rate_sale = Number(data);
                }
            });
        },
        getSaleOfferts() {
            if (this.configuration.sale_offert) {
                this.$http.get("/items/sale-offert/get").then(response => {
                    this.saleOfferts = response.data;
                });
            }
        },
        clickSaleOffert() {
            let quantityProducts = this.localOrden.length;
            let offert = this.saleOfferts.find(
                offert => offert.quantity_free == quantityProducts
            );
            let { quantity_free, quantity_total } = offert;
            let quantity = quantity_free - quantity_total;
            let itemsOrdenados = [...this.localOrden].sort((a, b) => {
                return a.food.item.unit_price - b.food.item.unit_price;
            });

            let itemsSeleccionados = itemsOrdenados.slice(0, quantity);

            // this.payOrden(offert, quantity);
            this.payOrden(offert);
        },
        openQuotationList() { },
        changeCustomer() {
            this.$emit("update:localOrden", []);
            this.$emit(
                "searchFoodByCustomerUnitTypeId",
                this.formQtn.customer_id
            );
        },
        searchRemoteCustomers(input) {
            if (input.length > 0) {
                this.loading_search = true;
                let parameters = `input=${input}`;

                this.$http
                    .get(`/documents/search/customers?${parameters}`)
                    .then(response => {
                        this.customersSearch = response.data.customers;
                        this.loading_search = false;
                    });
            }
        },
        consolidatedQuotations() {
            this.showConsolidated = true;
        },
        changeCurrency() {
            // ;
            this.$emit("updateCurrencyChoice", this.currency_id);
            this.changeCurrencyItems();
            this.calculateTotal();
        },
        changeCurrencyItems() {
            if (!this.configuration.other_currency_pos) return;
            let items = [...this.localOrden];
            for (let i = 0; i < items.length; i++) {
                let orden = items[i];

                let { currency_type_id: local_currency_type_id } = orden.food;

                let isLocalCurrency = this.currency_id == "S/";

                if (local_currency_type_id == "PEN" && isLocalCurrency) {
                    items[i].price = Number(items[i].original_price);
                    // No cambiar el precio
                }

                if (local_currency_type_id != "PEN" && isLocalCurrency) {
                    // Multiplicar por tipo de cambio
                    items[i].price = items[i].price * this.exchange_rate_sale;
                    items[i].price = Number(items[i].price.toFixed(2));
                }

                if (local_currency_type_id == "PEN" && !isLocalCurrency) {
                    console.log("aqui");
                    // Dividir por tipo de cambio
                    items[i].price = items[i].price / this.exchange_rate_sale;
                    items[i].price = Number(items[i].price.toFixed(2));
                }
                if (local_currency_type_id != "PEN" && !isLocalCurrency) {
                    items[i].price = Number(items[i].original_price);
                }
            }

            this.$emit("update:localOrden", items);
        },
        async savePriceProduct(idx) {
            try {
                await this.$confirm(
                    "¿Está seguro de guardar el precio del producto?",
                    "Atención",
                    {
                        confirmButtonText: "Aceptar",
                        cancelButtonText: "Cancelar",
                        type: "warning"
                    }
                );

                let orden = this.localOrden[idx];
                // return;
                let {
                    price,
                    type_id,
                    food: {
                        item: { id }
                    }
                } = orden;
                let url = `/items/update_price_cash`;
                let form = {
                    sale_unit_price: price,
                    item_id: id
                };

                if (this.commercialTreatmentId) {
                    url = `/items/update_price_cash_commercial_treatment`;
                    form = {
                        sale_unit_price: price,
                        item_id: id,
                        commercial_treatment_id: this.commercialTreatmentId
                    };
                }
                if (type_id) {
                    url = `/items/update_price_cash_unit_type`;
                    form = {
                        sale_unit_price: price,
                        unit_type_id: type_id
                    };
                }

                const response = await this.$http.post(url, form);
                if (response.status == 200) {
                    this.$toast.success("Precio guardado");
                    this.$emit("reloadProduct");
                }
            } catch (e) {
                return;
            }
        },
        checkCashAvailable() {
            this.$http
                .get("/caja/worker/cash_available/" + this.cash_id)
                .then(response => {
                    let data = response.data;
                    this.cashAvailable = data.cash_available;
                    // this.cashAvailable = response.data.data;
                })
                .catch(error => {
                    console.log(
                        "🚀 ~ checkCashAvailable ~ error:",
                        error.response
                    );
                });
        },
        showColorSizeDialog(orden, index = null) {
            this.limitQty = orden.type_quantity ?? 0;

            let ordens = this.localOrden.filter(l => l.id == orden.id);
            if (ordens.length == 1) {
                let [currentOrden] = ordens;
                let color_size = currentOrden.color_size.map(s => ({
                    ...s,
                    quantity: s.quantity || 0
                }));
                this.currentColorSize = color_size;
            } else {
                let color_size = [];
                for (let i = 0; i < ordens.length; i++) {
                    let currentOrden = ordens[i];
                    color_size = [
                        ...color_size,
                        ...currentOrden.color_size.map(s => ({
                            ...s,
                            quantity: s.quantity || 0
                        }))
                    ];
                }
                this.currentColorSize = color_size;
            }
            this.currentItem = orden.food.item;
            // this.currentSeries = orden.series;

            this.currentIdx = index;
            this.showColorSize = true;
        },
        sendOrdens(orden) {
            this.$emit("sendOrdens", orden);
            this.ordenNumber = null;
        },
        searchOrdenNumber() {
            if (this.ordenNumber) {
                if (this.timer) {
                    clearTimeout(this.timer);
                }
                this.timer = setTimeout(async () => {
                    const response = await this.$http(
                        `/caja/worker/record/${this.ordenNumber}`
                    );
                    let { data } = response.data;
                    this.sendOrdens(data);

                    this.ordenNumber = null;
                }, 1000);
            }
        },
        async promotionDesactive(id) {
            try {
                this.loading = true;
                const response = await this.$http(
                    `/caja/rooms/desactive_promotion/${id}`
                );
                if (response.status == 200) {
                    this.$toast.success("Promoción desactivada");
                }
            } catch (e) {
                this.$toast.error("Error al desactivar promoción");
            } finally {
                this.loading = false;
            }
        },
        async seachPromotion() {
            if (this.promotionCode && this.promotionCode.length > 5) {
                if (this.timer) {
                    clearTimeout(this.timer);
                }
                this.timer = setTimeout(async () => {
                    const response = await this.$http(
                        `/caja/rooms/promotion/${this.promotionCode}`
                    );
                    let {
                        data: { data, success, message }
                    } = response;
                    if (success) {
                        let {
                            has_items,
                            name,
                            id,
                            items,
                            customer_number,
                            customer_id
                        } = data;
                        if (!has_items) {
                            let message = `Desea dar por entregada la promoción ${name}?`;
                            try {
                                await this.$confirm(message, "Atención", {
                                    confirmButtonText: "Aceptar",
                                    cancelButtonText: "Cancelar",
                                    type: "warning"
                                });
                                await this.promotionDesactive(id);
                            } catch (e) { }
                        } else {
                            this.$toast.success("Cargando productos");
                            // Determinar si el usuario pertenece a un establecimiento de tipo RESTAURANT
                            const isRestaurantEst =
                                this.establishments &&
                                    this.establishments.description
                                    ? this.establishments.description
                                        .toString()
                                        .toUpperCase()
                                        .includes("RESTAURANT")
                                    : false;
                            const sameEstablishment =
                                this.user &&
                                    this.user.establishment_id &&
                                    this.establishments &&
                                    this.establishments.id
                                    ? Number(this.user.establishment_id) ===
                                    Number(this.establishments.id)
                                    : false;
                            const printerDefault =
                                isRestaurantEst && sameEstablishment;
                            this.$emit("paymentsOrden", {
                                items: items,
                                is_room: true,
                                hotel_rent_item_service_id: id,
                                customer_number,
                                customer_id,
                                promotion_sale: true,
                                caja: true,
                                printerOn: false,
                                printerDefault
                            });
                            // this.$emit('update:localOrden',items)
                        }
                    } else {
                        if (message) {
                            this.$toast.error(message);
                        } else {
                            this.$toast.error("Promoción no encontrada");
                        }
                    }
                    this.promotionCode = null;
                }, 1000);
            }
        },
        setOptionMenu() {
            this.optionsMenu = [
                {
                    id: 1,
                    icon: "fas fa-cogs",
                    title: ["Configuración"],
                    visible: false
                },
                {
                    id: 2,
                    title: ["Recibir ", "mercaderia"],
                    icon: "fas fa-people-carry",
                    visible:
                        this.configuration.receive_merchandise && !this.isSeller
                },
                {
                    id: 3,
                    title: [this.boxOperation, " Caja"],
                    icon: "fas fa-cash-register",
                    visible: true && !this.isSeller
                },
                {
                    id: 7,
                    title: ["Ingresos/", "/Gastos"],
                    icon: "fas fa-money-bill-wave-alt",
                    visible:
                        this.configuration.show_expenses_incomes_caja &&
                        !this.isSeller
                },
                {
                    id: 4,
                    title: ["Aparcado"],
                    icon: "fas fa-cart-arrow-down",
                    visible:
                        !this.configuration.college &&
                        this.configuration.aparcado
                },

                {
                    id: 5,
                    title: ["Ordenes"],
                    icon: "fas fa-tasks",
                    visible:
                        this.configuration.restaurant &&
                        !this.configuration.college &&
                        !this.isHotel &&
                        !this.isSeller
                },
                {
                    id: 6,
                    title: ["Lista de crédito"],
                    icon: "fas fa-file-invoice",
                    visible: this.configuration.credit_list && !this.isSeller
                }
            ];
        },
        openCash() {
            if (!this.cash_id) {
                this.showDialogCash = true;
            }
        },
        paymentsOrden(items) {
            this.$emit("paymentsOrden", items);
        },
        toCreditList() {
            if (!this.cash_id) {
                this.$toast.error("Debe abrir caja para poder dar a cuenta");
                return;
            }
            this.creditListAmount = 0;
            this.localOrden.forEach(orden => {
                this.creditListAmount +=
                    Number(orden.price) * Number(orden.quantity);
            });
            this.creditListAmount = Number(this.creditListAmount.toFixed(2));
            this.showCreditListModal = true;
        },
        clearCommercialTreatment() {
            let ordens = [...this.localOrden];
            ordens.forEach(orden => {
                if (orden.original_price) {
                    orden.price = orden.original_price;
                }
            });
            this.calculateTotal();
        },
        async getCommercialTreatment() {
            if (this.commercialTreatmentId) {
                if (this.configuration.commercial_treatment_items) {
                    let commercialTreatment = this.commercialTreatments.find(
                        c => c.id == this.commercialTreatmentId
                    );
                    if (commercialTreatment) {
                        let ordens = [...this.localOrden];
                        let itemIds = [];
                        ordens.forEach(orden => {
                            itemIds.push(orden.food.item.id);
                        });
                        try {
                            this.loadingCommercialTreatment = true;
                            const response = await this.$http.post(
                                `/commercial_treatment/items/get-items/${this.commercialTreatmentId}`,
                                { itemIds }
                            );
                            if (response.status == 200) {
                                let { data, success } = response.data;
                                if (success) {
                                    for (let i = 0; i < ordens.length; i++) {
                                        let orden = ordens[i];
                                        if (orden.type_id) continue;
                                        let newPrice = data[i];
                                        if (!orden.original_price) {
                                            orden.original_price = orden.price;
                                        }
                                        if (newPrice.amount) {
                                            orden.price = Number(
                                                Number(newPrice.amount).toFixed(
                                                    2
                                                )
                                            );
                                        } else {
                                            orden.price = Number(
                                                Number(
                                                    orden.original_price
                                                ).toFixed(2)
                                            );
                                        }
                                    }
                                }
                            }
                        } catch (e) {
                            this.$toast.error(
                                "Error al obtener el tratamiento comercial"
                            );
                        } finally {
                            this.loadingCommercialTreatment = false;
                        }
                    }
                } else {
                    let commercialTreatment = this.commercialTreatments.find(
                        c => c.id == this.commercialTreatmentId
                    );
                    if (commercialTreatment) {
                        let {
                            commercial_treatment_categories
                        } = commercialTreatment;
                        if (commercial_treatment_categories.length > 0) {
                            let is_amount = commercialTreatment.is_amount == 1;
                            let ordens = [...this.localOrden];
                            ordens.forEach(orden => {
                                let {
                                    food: { category }
                                } = orden;
                                let category_id = category.id;
                                if (!orden.original_price) {
                                    orden.original_price = orden.price;
                                }

                                let price = orden.original_price;
                                let factor = commercial_treatment_categories.find(
                                    c => c.category_item_id == category_id
                                );
                                if (factor && orden.type_id == null) {
                                    let amount = Number(factor.amount);
                                    if (is_amount) {
                                        if (price >= amount) {
                                            orden.price = price - factor.amount;
                                        }
                                    } else {
                                        orden.price =
                                            price / (1 + factor.amount / 100);
                                    }
                                    orden.price = Number(
                                        Number(orden.price).toFixed(2)
                                    );
                                }
                            });
                        }
                    }
                }
                this.calculateTotal();
            }
        },

        getCommercialTreatments() {
            if (
                this.configuration.commercial_treatments &&
                this.configuration.commercial_treatment_items
            ) {
                this.$http
                    .get("/commercial_treatment/records?all=true")
                    .then(res => {
                        this.commercialTreatments = res.data;
                    })
                    .catch(err => { });
            }
        },
        setQuotationStock() {
            let quotation_stock = this.quotation_stock ? 1 : 0;
            localStorage.setItem("quotation_stock", quotation_stock);
            if (!this.quotation_stock) {
                this.directSale();
            }
        },
        restoreName(idx) {
            let ordens = [...this.localOrden];
            ordens[idx].food.item.name_product_pdf = null;
            this.$emit("update:localOrden", ordens);
        },
        changeNamePdf() {
            let idx = this.currentIdx;
            let ordens = [...this.localOrden];
            ordens[idx].food.item.name_product_pdf = this.name_pdf;
            this.$emit("update:localOrden", ordens);
            this.showChangeName = false;
        },
        changeName(idx) {
            this.currentIdx = idx;
            let ordens = [...this.localOrden];
            this.name_pdf = ordens[idx].food.description;
            this.showChangeName = true;
        },
        updateWarehouse(order, index) {
            let ordens = [...this.localOrden];
            ordens[index].toWarehouse = order.toWarehouse;
            let newQuantity =
                ordens[index].originalQuantity - order.toWarehouse;
            if (newQuantity < 0) {
                this.$toast.error("No puede ser mayor a la cantidad original");
                ordens[index].toWarehouse = 0;
                ordens[index].quantity = ordens[index].originalQuantity;
            } else {
                ordens[index].quantity =
                    ordens[index].originalQuantity - order.toWarehouse;
            }
            this.$emit("update:localOrden", ordens);
        },
        setConsignment(consigment) {
            this.isConsignment = true;
        },
        removeConsignment() {
            this.isConsignment = false;
        },
        openConsignment() {
            this.showConsignmentForm = true;
        },
        async changeQuickSale() {
            let { conf } = this.establishments;
            try {
                let response = await this.$http.post(
                    "/establishments/update_conf",
                    {
                        ...conf
                    }
                );
                this.$toast.success(response.data.message);
            } catch (e) { }
        },
        deleteDefaultFood(index) {
            this.foodDefaults = this.foodDefaults.filter((_, i) => i != index);
        },
        addVariation() {
            let foodDefault = { ...this.itemDefault };
            foodDefault.description =
                foodDefault.description +
                " " +
                Number(this.foodDefaults.length + 1);
            // Inicializar el subtotal por defecto
            if (foodDefault.price && foodDefault.quantity) {
                foodDefault.newSubtotal = parseFloat((foodDefault.price * foodDefault.quantity).toFixed(2));
            }
            this.foodDefaults = [...this.foodDefaults, foodDefault];
            // Inicializar el subtotal por defecto al agregar un producto a localOrden
            if (product.price && product.quantity) {
                product.newSubtotal = parseFloat((product.price * product.quantity).toFixed(2));
            }
            this.localOrden.push(product);
        },
        openCredit() {
            if (!this.cash_id) {
                this.$toast.error("Debe abrir caja para poder dar a crédito");
                return;
            }
            let allHaveQuantity = this.localOrden.every(o => o.quantity > 0);
            if (!allHaveQuantity) {
                this.$toast.error(
                    "Debe ingresar la cantidad de todos los productos"
                );
                return;
            }
            if (this.configuration.sale_note_credit_confirm) {
                if (!this.canGiveCash()) return;
            }
            this.showCreditForm = true;
        },
        hasService() {
            let items = this.localOrden;
            let hasService = items.some(
                item => item.food.item.unit_type_id == "ZZ"
            );
            return hasService;
        },
        canGiveCash() {
            if (!this.hasService()) return true;

            let total = this.localOrden.reduce(
                (a, b) => a + Number(b.price),
                0
            );

            if (total > this.cashAvailable) {
                this.$toast.error(
                    "No tiene suficiente efectivo para realizar la operación"
                );
                return false;
            }
            return true;
        },
        openQuotation() {
            this.quotationDirect = false;
            if (this.localOrden.length > 0) {
                if (
                    this.isSellerConsolidated &&
                    !this.configuration.consolidated_quotation_details
                ) {
                    this.quotationDirect = true;
                }

                this.showQuotationForm = true;
                /* this.localCotizarConfirmado = false;
                this.$emit('cotizarConfirmadoChanged', this.localCotizarConfirmado); */
            }
        },
        savePrint() {
            localStorage.setItem("cajaPrint", this.printing ? 1 : 0);
            this.$toast.success("Configuración guardada");
        },
        handleResize() {
            this.screenWidth = window.innerWidth;
            this.quotation_stock = this.isSeller;
        },
        showTransfers() {
            this.showTransfersDialog = true;
        },
        deleteColorSize(index, color_size_id) {
            let ordens = [...this.localOrden];

            ordens[index].color_size = ordens[index].color_size.filter(
                s => s.id != color_size_id
            );
            ordens[index].quantity = ordens[index].color_size.reduce(
                (a, b) => a + Number(b.quantity),
                0
            );
            this.$emit("update:localOrden", ordens);
        },
        deleteSerie(index, serie_id) {
            let ordens = [...this.localOrden];

            ordens[index].series = ordens[index].series.filter(
                s => s.id != serie_id
            );
            ordens[index].quantity = ordens[index].series.length;
            this.$emit("update:localOrden", ordens);
        },

        medirLatencia(url = "https://www.google.com/generate_204") {
            const start = performance.now();
            return fetch(url, {
                method: "GET",
                cache: "no-store",
                mode: "no-cors"
            })
                .then(() => Math.round(performance.now() - start))
                .catch(() => -1);
        },

        async updateColorSize(idx, color_size) {
            let ordens = [...this.localOrden];
            if (this.hasSamePrice(color_size)) {
                let [first] = color_size;
                let { price } = first;
                price = Number(price || "0");
                ordens[idx].color_size = [...color_size];
                if (price != 0) {
                    ordens[idx].price = price;
                }
                ordens[idx].quantity = color_size.reduce(
                    (a, b) => a + Number(b.quantity),
                    0
                );
            } else {
                // Clonar la orden original y dividir por grupos de color_size con el mismo precio
                let ordenOriginal = JSON.parse(JSON.stringify(ordens[idx]));
                // Eliminar la orden original de la lista
                ordens = ordens.filter((o, i) => i != idx);
                let colors_sizes = this.splitByPrice(color_size);
                for (let i = 0; i < colors_sizes.length; i++) {
                    let color_size_group = colors_sizes[i];
                    let newOrden = JSON.parse(JSON.stringify(ordenOriginal));
                    let [first] = color_size_group;
                    let { price } = first;
                    newOrden.color_size = [...color_size_group];
                    price = Number(price || "0");
                    if (price != 0) {
                        newOrden.price = price;
                    }
                    newOrden.quantity = color_size_group.reduce(
                        (a, b) => a + Number(b.quantity),
                        0
                    );
                    ordens.push(newOrden);
                }
            }
            await this.$emit("update:localOrden", ordens);
        },
        hasSamePrice(color_price) {
            let samePrice = true;
            let price = 0;
            for (let i = 0; i < color_price.length; i++) {
                if (i == 0) {
                    price = color_price[i].price;
                } else {
                    if (price != color_price[i].price) {
                        samePrice = false;
                        break;
                    }
                }
            }
            return samePrice;
        },
        splitByPrice(color_price) {
            let prices = Array.from(new Set(color_price.map(c => c.price)));
            let colors_sizes = [];
            for (let i = 0; i < prices.length; i++) {
                let price = prices[i];
                let color_size = color_price.filter(c => c.price == price);
                colors_sizes.push(color_size);
            }

            return colors_sizes;
        },
        updateSeries(idx, series) {
            let ordens = [...this.localOrden];
            ordens[idx].series = series;
            if (this.limitQty) {
                ordens[idx].quantity = series.length / this.limitQty;
            } else {
                ordens[idx].quantity = series.length;
            }

            this.$emit("update:localOrden", ordens);
        },
        updateLotes(idx, lotes) {
            let ordens = [...this.localOrden];
            ordens[idx].lotes = lotes;
            ordens[idx].quantity = lotes.reduce(
                (a, b) => a + Number(b.quantitySelected),
                0
            );
            this.$emit("update:localOrden", ordens);
        },
        showLotesDialog(orden, index) {
            this.ordenLot = orden;
            this.currentIdx = index;
            this.showLotes = true;
        },
        showSeriesDialog(orden, index = null) {
            this.limitQty = orden.type_quantity ?? 0;

            let ordens = this.localOrden.filter(l => l.id == orden.id);
            if (ordens.length == 1) {
                let [currentOrden] = ordens;
                let series = currentOrden.series.map(s => ({
                    ...s,
                    disabled: false
                }));
                this.currentSeries = series;
            } else {
                let series = [];
                for (let i = 0; i < ordens.length; i++) {
                    let currentOrden = ordens[i];
                    series = [
                        ...series,
                        ...currentOrden.series.map(s => ({
                            ...s,
                            disabled: orden.type_id != currentOrden.type_id
                        }))
                    ];
                }
                this.currentSeries = series;
            }
            this.currentItem = orden.food.item;
            // this.currentSeries = orden.series;

            this.currentIdx = index;
            this.showSeries = true;
        },
        
        justNumber(indexx) {
            let val = this.localOrden[indexx].newSubtotal;
            val = String(val).replace(/[^0-9.]/g, "");
            let subtotal = parseFloat(val) || 0;
            this.localOrden[indexx].newSubtotal = subtotal;
            // Recalcular cantidad según el precio base
            let price = parseFloat(this.localOrden[indexx].price) || 0;
            if (price > 0) {
                this.localOrden[indexx].quantity = parseFloat((subtotal / price).toFixed(2));
            }
        },

        updateDefaultFoodQty(bool, idx) {
            let foodDefault = this.foodDefaults[idx];
            if (bool) {
                foodDefault.quantity += 1;
            } else {
                if (foodDefault.quantity > 1) {
                    foodDefault.quantity -= 1;
                }
            }

            this.$forceUpdate();
        },

        showChangeDescription(idx) {
            this.descriptionTemp = null;
            this.currentFoodDefault = idx;
            this.showChangeDescriptionVariation = true;
        },

        changeDescription() {
            let foodDefault = this.foodDefaults[this.currentFoodDefault];
            foodDefault.description = this.descriptionTemp;
            this.showChangeDescriptionVariation = false;
        },

        changeVariation() {
            if (this.customer_variation == null) {
                this.variation = false;
                // this.$emit("update:variation", false);

                return this.$toast.error("Clientes modificado no creado");
            }
            if (this.itemDefault == null) {
                //   this.$emit("update:variation", false);
                this.variation = false;

                return this.$toast.error(
                    "Producto para variación no seleccionado"
                );
            }

            this.foodDefaults = [this.foodDefault];
        },

        saveSubtotal(idx) {
            let ordensModified = [...this.localOrden];
            let currentOrden = ordensModified[idx];
            let sub = Number(currentOrden.newSubtotal);
            if (isNaN(sub) || sub <= 0) {
                ordensModified[idx].change_subtotal = false;
                ordensModified[idx].series = [];
                ordensModified[idx].color_size = [];
                ordensModified[idx].lotes = [];
                ordensModified[idx].newSubtotal = null;
                this.$emit("update:localOrden", ordensModified);
                this.$toast.error("Subtotal no válido");
                return;
            }

            // Mantener el precio unitario (sale_unit_price/precio base) y recalcular la cantidad
            const unitBase = Number(
                (currentOrden.food && currentOrden.food.sale_unit_price != null)
                    ? currentOrden.food.sale_unit_price
                    : currentOrden.price
            );

            if (isNaN(unitBase) || unitBase <= 0) {
                this.$toast.error("Precio unitario no válido");
                return;
            }

            let newQty = sub / unitBase;
            // Siempre usar 3 decimales al recalcular por subtotal para no alterar el total ingresado
            newQty = Number(newQty.toFixed(6));

            if (!isFinite(newQty) || newQty <= 0) {
                this.$toast.error("Cantidad resultante no válida");
                return;
            }

            // Actualizar solo la cantidad. No tocar el precio unitario.
            ordensModified[idx].quantity = newQty;
            ordensModified[idx].change_subtotal = false;
            ordensModified[idx].series = [];
            ordensModified[idx].color_size = [];
            ordensModified[idx].lotes = [];
            ordensModified[idx].newSubtotal = null;
            this.$emit("update:localOrden", ordensModified);
            this.calculateTotal();
            this.$toast.success("Subtotal actualizado");
        },

        changeSubtotal(idx) {
            let ordensModified = [...this.localOrden];
            ordensModified[idx].change_subtotal = !ordensModified[idx]
                .change_subtotal;
            this.$emit("update:localOrden", ordensModified);
        },
        addObservation(obs) {
            let ordensModified = [...this.localOrden];
            ordensModified[this.currentLocalOrden].observation = obs;
            this.$emit("update:localOrden", ordensModified);
        },
        /* async getTags() {
            if (this.configuration.restaurant && !this.configuration.college) {
                const response = await this.$http("../observations/records");
                if (response.status == 200) {
                    const { data } = response;
                    this.tags = data;
                }
            }
        }, */
        async updateCashId(id) {
            this.$emit("update:cash_id", id);
        },
        cancelGeneralOrdenPin() {
            this.deleteGeneralOrden = true;
            this.showPinRequest = true;
        },
        async deleteGeneralOrdenPin() {
            try {
                this.deleteOrdenLoading = true;
                let id = this.ordens[0].orden_id;
                let form = {
                    id,
                    pin: this.pin,
                    reason: this.reasonToDelete
                };
                const response = await this.$http.post("cancel-orden", form);
                if (response.status == 200) {
                    const { message, success } = response.data;
                    if (success) {
                        this.$toast.success(message);
                        this.$eventHub.$emit("reloadData");
                        this.$emit("ordenDeleted");
                        this.deleteGeneralOrden = false;
                        this.showPinRequest = false;
                        this.reasonToDelete = null;
                        this.directSale();
                    } else {
                        this.$toast.error(message);
                    }
                }
            } catch (e) {
                if (e != "cancel") {
                    // this.$toast.error("Ocurrió un error");
                }
            } finally {
                this.pin = "";
                this.deleteOrdenLoading = false;
            }
        },
        async cancelGeneralOrden(id) {
            if (this.configuration.pin_orden_delete) {
                this.cancelGeneralOrdenPin();
            } else {
                try {
                    let res = await this.$confirm(
                        "Desea cancelar toda la orden?",
                        "Cancelar",
                        {
                            confirmButtonText: "Ok",
                            cancelButtonText: "Cancelar",
                            type: "warning"
                        }
                    );
                    if (res) {
                        this.loading = true;

                        let form = {
                            id
                        };
                        const response = await this.$http.post(
                            "cancel-orden",
                            form
                        );
                        if (response.status == 200) {
                            const { message } = response.data;
                            this.$toast.success(message);
                            this.$eventHub.$emit("reloadData");
                            this.$emit("ordenDeleted");
                            this.directSale();
                        }
                    }
                } catch (e) {
                    if (e != "cancel") {
                        this.$toast.error("Ocurrió un error");
                    }
                } finally {
                    this.loading = false;
                }
            }
        },
        allToCarry() {
            if (this.localOrden.length == 0) return;
            let ord = [...this.localOrden];
            ord = ord.map(o => {
                let {
                    food: {
                        item: { delivery_cost }
                    }
                } = o;
                let delivery = Number(delivery_cost);
                let factor = this.to_carry ? 1 : -1;
                let price = Number(o.price) + delivery * factor;

                return {
                    ...o,
                    to_carry: this.to_carry,
                    price
                };
            });
            this.$emit("update:localOrden", ord);
        },
        toCarry(idx) {
            let ord = [...this.localOrden];
            let {
                food: {
                    item: { delivery_cost }
                }
            } = ord[idx];
            ord[idx].to_carry = !ord[idx].to_carry;
            let delivery = Number(delivery_cost);
            let factor = ord[idx].to_carry ? 1 : -1;
            ord[idx].price = Number(ord[idx].price) + delivery * factor;

            this.$emit("update:localOrden", ord);
        },
        verifyStock(orden, idx) {
            let current_orden = this.localOrden.filter(o => o.id == orden.id);
            let unit_type_id = current_orden[0].food.item.unit_type_id;

            // Update price based on quantity
            this.localOrden[idx].price = this.getPriceRange(
                this.localOrden[idx]
            );

            if (
                this.configuration.sales_stock &&
                !this.quotation_stock &&
                unit_type_id != "ZZ"
            ) {
                let qty = Number(this.localOrden[idx].quantity); // Get current input quantity
                let stock = 0;

                // Determine available stock
                if (
                    current_orden.length == 1 &&
                    current_orden[0].lotes.length == 1
                ) {
                    let [orden] = current_orden;
                    let [lote] = orden.lotes;
                    stock = lote.quantity;
                } else {
                    stock = Number(current_orden[0].food.item.stock);
                }

                // Validate quantity against stock
                /* if (qty > stock) {
                    this.$toast.warning(
                        `La cantidad excede el stock disponible (${stock})`
                    );
                    // Reset to maximum available stock
                    this.localOrden[idx].quantity = stock;

                    // Update lots if single lot
                    if (current_orden.length == 1) {
                        let [orden] = current_orden;
                        if (orden.lotes.length == 1) {
                            orden.lotes[0].quantitySelected = stock;
                        }
                    }
                    return;
                } */

                // Update lot quantity if single lot
                if (current_orden.length == 1) {
                    let [orden] = current_orden;
                    if (orden.lotes.length == 1) {
                        orden.lotes[0].quantitySelected = qty;
                    }
                }
            }
            // Solo actualizar el total, no formatear decimales aquí
            this.calculateTotal();
        },

        formatQuantity(idx) {
            // Formatear a 3 decimales solo al perder el foco
            const val = this.localOrden[idx].quantity;
            if (val !== '' && val !== null && !isNaN(Number(val))) {
                this.localOrden[idx].quantity = Number(val).toFixed(3);
            }
        },
        showOrdensPending() {
            this.showPendingOrdens = true;
        },

        validStock(orden, quantity = 1) {
            // Si el item es un set (receta), no validar stock
            if (orden.food.item.is_set) {
                return false;
            }
            if (this.configuration.quotation_stock) {
                return false;
            }
            let qty = this.localOrden
                .filter(o => o.id == orden.id)
                .reduce((a, b) => a + Number(b.quantity), 0);
            if (orden.type_id) {
                qty += orden.type_quantity;
            } else {
                qty += quantity;
            }
            let stock = Number(orden.food.item.stock);
            let unit_type_id = orden.food.item.unit_type_id;
            if (
                this.configuration.sales_stock == true &&
                !this.quotation_stock &&
                unit_type_id != "ZZ"
            ) {
                if (qty > stock) {
                    return true;
                }
            }
            return false;
        },
        async printOrdenPdf() {
            this.ordenLoading = true;
            try {
                await this.printTicket(this.clientTableData.orden_id, true);
            } catch (e) {
                this.$toast.error("No se pudo imprimir");
            } finally {
                this.ordenLoading = false;
            }
        },
        async printOrden() {
            this.ordenLoading = true;
            try {
                await this.printTicket(this.clientTableData.orden_id);
            } catch (e) {
                this.$toast.error("No se pudo imprimir");
            } finally {
                this.ordenLoading = false;
            }
        },
        async sendOrdenToCreditList(customer_id) {
            try {
                this.ordenLoading = true;
                const responses = await this.$http.post(
                    "/credit-list/send-credit",
                    {
                        customer_id,
                        items: this.localOrden,
                        cash_id: this.cash_id,
                        ref: this.clientTableData.ref
                    }
                );

                this.ordenLoading = false;
                if (responses.status != 200) {
                    this.$toast.warning("Ocurrió un error");

                    return;
                }
                this.to_carry = false;
                this.$emit("cancelOrden");
                this.$emit("update:isCreatingOrden", false);
                let msg = `Se agregó correctamente a la cuenta.`;
                this.$toast.success(msg);
            } catch (e) {
                this.ordenLoading = false;
                this.$toast.error("Ocurrió un error");
            }
        },
        async sendOrden() {
            if (this.localOrden.length == 0 && !this.variation) {
                this.$showSAlert(
                    "ALERTA",
                    "No Tienes Productos Para Cobrar",
                    "warning"
                );
                return;
            }
            let orden = {
                status_orden_id: 1,
                table_id: this.clientTableData.table_id,
                to_carry: this.to_carry
            };

            if (this.clientTableData.customer_id) {
                orden.customer_id = this.clientTableData.customer_id;
            }

            this.ordenLoading = true;
            try {
                const responses = await this.$http.post(
                    "/caja/worker/send-orden",
                    {
                        id: this.clientTableData.orden_id,
                        ref: this.clientTableData.ref,
                        items: this.localOrden,
                        caja: true,
                        printing: true,
                        saleDirect: false,
                        orden
                    }
                );

                // Check success property from response
                if (!responses.data.success) {
                    // Show error message from server
                    this.$showSAlert("ALERTA", responses.data.message, "error");
                    //this.$toast.error(responses.data.message);
                    this.ordenLoading = false;
                    return;
                }

                let ordenId = responses.data.id;
                this.ordenLoading = false;

                if (responses.status != 200) {
                    this.$toast.warning("Ocurrió un error");
                    return;
                }

                this.to_carry = false;
                this.$emit("cancelOrden");
                this.$emit("update:isCreatingOrden", false);

                let msg = "";
                if (this.clientTableData.orden_id) {
                    msg = `Se agregaron los pedidos a la orden ${ordenId}`;
                } else {
                    msg = `La orden ${ordenId} fue creada.`;
                }
                this.$toast.success(msg);
            } catch (e) {
                this.ordenLoading = false;
                if (e.response && e.response.data) {
                    // Show error message from server if available
                    this.$toast.error(e.response.data.message);
                } else {
                    this.$toast.error("Ocurrió un error");
                }
            }
        },
        directSale() {
            this.$emit("update:clientTableData", {});
            this.$emit("update:localOrden", []);
            this.$emit("update:ordens", []);
            this.$emit("update:blockCart", false);
            this.$emit("update:isCreatingOrden", false);
            //ordenId
            this.$emit("update:idOrden", null);
            this.$emit("resetOrden");
        },
        restoreToLocalOrdens(ordens) {
            this.$emit("update:localOrden", ordens);
        },
        async checkTables() {
            const response = await this.$http("/caja/tables/check");
            const { data } = response;
            return data;
        },
        //aqui van los cases
        async trigerFunction(id) {
            switch (id) {
                case 6:
                    this.showCreditListDialog = true;
                    break;
                case 7:
                    if (!this.cash_id) {
                        this.$toast.error("Abra una caja");
                    } else {
                        this.showExpensesIncomes = true;
                    }
                    break;
                case 2:
                    if (!this.cash_id) {
                        this.$toast.error("Abra una caja");
                    } else {
                        this.showTransfers();
                    }

                    break;
                case 3:
                    if (this.cash_id) {
                        if (this.configuration.ordens_cash) {
                            let data = await this.checkTables();
                            if (!data.success) {
                                this.showDialogClose = true;
                            } else {
                                let { ordenes, total, items } = data;
                                try {
                                    await this.$confirm(
                                        `Existen ${ordenes} ordenes pendientes por cobrar, con un total de ${total} soles. Desea emitir una nota de venta por el total?`,
                                        "Cerrar Caja",
                                        {
                                            confirmButtonText: "Emitir",
                                            cancelButtonText: "Cerrar",
                                            type: "warning"
                                        }
                                    );

                                    this.$emit("sendOrdensAllTables", items);
                                } catch (e) { }
                            }
                        } else {
                            this.showDialogClose = true;
                        }
                    } else {
                        this.showDialogCash = true;
                    }
                    break;
                case 5:
                    if (!this.cash_id) {
                        this.$toast.error("Abra una caja");
                    } else {
                        this.showOrdensPending();
                    }

                    break;
                case 4:
                    if (!this.cash_id) {
                        this.$toast.error("Abra una caja");
                        return;
                    }

                    if (this.ordenInBox.length > 0) {
                        this.listApart = true;
                    } else {
                        this.$toast.warning("Sin ventas apartacadas.");
                    }
                    break;

                default:
                    //naa
                    break;
            }
        },
        limpiarForm() {
            this.commercialTreatmentId = null;
            this.quotation_stock = this.isSeller;
            this.checkCashAvailable();
            this.$emit("limpiarForm");
            this.getLasNumOrden();
        },
        openApart() {
            if (!this.cash_id) {
                this.$toast.error("Abra una caja");
                return;
            }
            if (this.localOrden.length == 0) {
                /* this.$toast.error("Sin ordenes pendientes"); */
                this.$showSAlert(
                    "ALERTA",
                    "No Tienes Ordenes en la Lista para Aparcar",
                    "error"
                );
                return;
            }
            this.apart = true;
        },
        pullApartOrden() {
            this.commercialTreatmentId = null;
            if (
                !this.numberCustomerApart &&
                this.numberCustomerApart.length <= 1
            ) {
                this.$showSAlert(
                    "ALERTA",
                    "Documento o referencia inválida",
                    "error"
                );
                return;
            } else if (this.ordenInBox.length == 15) {
                this.$showSAlert("ALERTA", "Limite Excedido.", "error");
                return;
            } else if (
                this.ordenInBox.some(
                    f =>
                        f.ref.toLowerCase() ==
                        this.numberCustomerApart.toLowerCase()
                )
            ) {
                this.$showSAlert("ALERTA", "La referencia ya existe", "error");
                return;
            } else {
                this.ordenInBox.push({
                    ref: this.numberCustomerApart,
                    ordens: this.localOrden
                });
                localStorage.ordens = JSON.stringify(this.ordenInBox);
                this.numberCustomerApart = undefined;
                this.apart = false;
                this.$emit("cancelOrden");
                this.$showSAlert(
                    "APARCADO",
                    "Orden Aparcada correctamente",
                    "success"
                );
            }
        },
        async cancelOrden() {
            this.commercialTreatmentId = null;
            try {
                let res = await this.$confirm(
                    "Desea cancelar este pedido?",
                    "Cancelar",
                    {
                        confirmButtonText: "Ok",
                        cancelButtonText: "Cancelar",
                        type: "warning"
                    }
                );
                if (res) {
                    this.isConsignment = false;
                    this.$emit("cancelOrden");
                    /* this.cotizarConfirmado = false; */
                    this.localCotizarConfirmado = false;
                    /* this.$emit("cotizarConfirmadoChanged", this.cotizarConfirmado); */
                    this.$emit(
                        "cotizarConfirmadoChanged",
                        this.localCotizarConfirmado
                    );
                    console.log(
                        "ver valor enviado en el evento",
                        this.localCotizarConfirmado
                    );
                }
            } catch (e) { }
            /* this.cotizarConfirmado = false;
            this.$emit('cotizarConfirmadoChanged', this.cotizarConfirmado); */
        },
        addNumberPin(number) {
            if (this.pin.length >= 4) {
                return;
            }
            this.pin += number.toString();
        },
        close() {
            this.$emit("update:localOrden", []);
        },

        //aqui modificamos el precio
        update_price(index, sale_unit_price) {
            let localOrden_update = this.localOrden;
            /* if (this.configuration.is_grifo) {
                localOrden_update[index].food.quantity =
                    sale_unit_price / localOrden_update[index].food.price;
                console.log(
                    "ver el precio modificado",
                    localOrden_update[index].food.quantity
                );
            } else { */
            localOrden_update[index].food.sale_unit_price = sale_unit_price;
            /* } */
            this.$emit("update:localOrden", localOrden_update);
            this.calculateTotal();
        },

        /* update_price(index, sale_unit_price) {
            // Clonar para mantener reactividad
            const items = [...this.localOrden];
            const item = { ...items[index] };

            if (this.configuration.is_grifo) {
                const unit = Number(item.food.price) || 0;
                const total =
                    sale_unit_price != null
                        ? Number(sale_unit_price)
                        : Number(item.price) || 0;
                const newQty = unit > 0 ? Number((total / unit).toFixed(3)) : 0;
                item.quantity = newQty;
            } else {
                const newPrice = Number(sale_unit_price);
                if (!isNaN(newPrice)) {
                    item.price = newPrice; 
                    if (item.food) item.food.sale_unit_price = newPrice;
                }
            }

            items[index] = item;
            this.$emit("update:localOrden", items);
            this.calculateTotal();
        }, */

        getPriceRange(orden) {
            if (this.configuration.quantity_prices) {
                if (orden.type_id) {
                    let { type_price_ranges } = orden;
                    if (type_price_ranges.length > 0) {
                        let sortedRanges = [...type_price_ranges].sort(
                            (a, b) => b.quantity_min - a.quantity_min
                        );
                        let orderQuantity = Number(orden.quantity);

                        let price_range = sortedRanges.find(
                            row =>
                                orderQuantity == row.quantity_min ||
                                orderQuantity >= row.quantity_min
                        );
                        if (price_range) {
                            return price_range.price;
                        }
                        return orden.original_price;
                    }
                } else {
                    let { item_price_ranges } = orden.food;
                    if (item_price_ranges.length > 0) {
                        let sortedRanges = [...item_price_ranges].sort(
                            (a, b) => b.quantity_min - a.quantity_min
                        );
                        let orderQuantity = Number(orden.quantity);

                        let price_range = sortedRanges.find(
                            row =>
                                orderQuantity == row.quantity_min ||
                                orderQuantity >= row.quantity_min
                        );
                        if (price_range) {
                            return price_range.price;
                        }

                        return orden.original_price;
                    }
                }
            }
            return orden.price;
        },
        sumar_orden(index) {
            if (this.validStock(this.localOrden[index])) {
                this.$toast.warning("Limite de stock alcanzado");
                return;
            }
            let localOrden_quantity = this.localOrden;
            if (this.localOrden[index].type_id) {
                localOrden_quantity[index].quantity =
                    Number(localOrden_quantity[index].quantity) + 1;
                // localOrden_quantity[index].quantity =
                //     Number(localOrden_quantity[index].quantity) +
                //     Number(localOrden_quantity[index].type_quantity);
            } else {
                localOrden_quantity[index].quantity =
                    Number(localOrden_quantity[index].quantity) + 1;
            }
            // Formatear a 3 decimales para mostrar
            localOrden_quantity[index].quantity = Number(
                localOrden_quantity[index].quantity
            ).toFixed(3);
            localOrden_quantity[index].price = this.getPriceRange(
                localOrden_quantity[index]
            );
            this.$emit("update:localOrden", localOrden_quantity);
            this.calculateTotal();
        },
        restar_orden(index) {
            let localOrden_quantity = this.localOrden;
            let min = 1;
            if (this.localOrden[index].type_id) {
                min = Number(localOrden_quantity[index].type_quantity);
            }
            let quantity = localOrden_quantity[index].quantity * min;
            if (quantity > min) {
                // if (localOrden_quantity[index].quantity > min) {
                if (this.localOrden[index].type_id) {
                    // localOrden_quantity[index].quantity =

                    //     Number(localOrden_quantity[index].quantity) -
                    //     Number(localOrden_quantity[index].type_quantity);
                    localOrden_quantity[index].quantity =
                        Number(localOrden_quantity[index].quantity) - 1;
                } else {
                    localOrden_quantity[index].quantity =
                        Number(localOrden_quantity[index].quantity) - 1;
                }
                // Formatear a 3 decimales para mostrar
                localOrden_quantity[index].quantity = Number(
                    localOrden_quantity[index].quantity
                ).toFixed(3);
                localOrden_quantity[index].price = this.getPriceRange(
                    localOrden_quantity[index]
                );
                this.$emit("update:localOrden", localOrden_quantity);
                this.calculateTotal();
            } else {
                this.$toast.warning("Mínimo permitido");
            }
        },
        async printTicket(id, pdf = false) {
            try {
                const response = await this.$http.get(
                    `/caja/worker/record/${id}?precuenta=true`
                );
                let url = response.data.print;
                if (pdf) {
                    window.open(url, "_blank");
                    return;
                }
                await this.$http.post("/caja/re-print", {
                    url
                });

                return;

                let config = qz.configs.create(response.data.printer, {
                    scaleContent: false
                });
                if (!qz.websocket.isActive()) {
                    await qz.websocket.connect(config);
                }
                let isPosd = response.data.printer.split(" ")[
                    response.data.printer.split(" ").length - 1
                ];
                if (isPosd == "POSD") {
                    config.density = 200;
                }
                let data = [
                    {
                        type: "pdf",
                        format: "file",
                        data: url
                    }
                ];
                qz.print(config, data).catch(e => {
                    this.$toast.error(e.message);
                });
            } catch (e) {
                this.$toast.error(e.message);
            }
        },

        view_orders() {
            $(".style-switcher")
                .animate(
                    {
                        right: "0"
                    },
                    300
                )
                .addClass("active");
        },

        closeDialog(ordenId = null) {
            let ordenToAdd = [...this.localOrden];
            ordenToAdd = ordenToAdd.map(o => ({
                status_orden_id: 1,
                food: {
                    description: o.food.description,
                    price: o.food.price
                },
                observations: o.observation
            }));
            // let allOrdens = [...ordenToAdd, ...this.ordens];
            this.$emit("updateOrdens", ordenId);
            this.$emit("listtables");
            // this.$emit("update:ordens", allOrdens);
            this.$emit("update:localOrden", []);
            this.$eventHub.$emit("reloadData");
            this.totalOrdenItems = 0.0;
            this.total = 0.0;
            this.totalOrden = 0.0;
        },
        clear_command() {
            this.commands_fisico = null;
        },
        checkIsExistSerie() {
            let hasError = false;
            for (let ord of this.localOrden) {
                let { series_enabled } = ord.food.item;

                if (series_enabled && ord.series.length == 0) {
                    hasError = true;
                    break;
                }
            }
            return hasError;
        },
        checkIfHasZeroTotal() {
            let { localOrden } = this;
            let pass = true;
            for (let ord of localOrden) {
                let {
                    food: { item }
                } = ord;
                let is15 =
                    item.sale_affectation_igv_type_id == "15" ||
                    item.sale_affectation_igv_type_id == 15;
                if ((ord.price == 0 || ord.quantity == 0) && !is15) {
                    pass = false;
                    break;
                }
            }
            return pass;
        },
        async payOrden(offert = null) {
            if (!this.checkIfHasZeroTotal()) {
                this.$toast.error(
                    "No puede realizar una venta de productos con total 0"
                );
                return;
            }
            if (this.checkIsExistSerie()) {
                this.$toast.error("Producto sin serie seleccionada");
                return;
            }
            if (!this.cash_id) {
                this.$toast.error("No tiene una caja abierta");
                return;
            }
            if (this.clientTableData.table) {
                if (this.ordens.length == 0) {
                    /* this.$toast.warning("Orden sin productos"); */
                    this.$showSAlert(
                        "ALERTA",
                        "No Tienes Productos Para Cobrar",
                        "warning"
                    );
                    return;
                }
            } else {
                if (this.localOrden.length == 0 && !this.variation) {
                    /* this.$toast.warning("Orden sin productos"); */
                    this.$showSAlert(
                        "ALERTA",
                        "No Tienes Productos Para Cobrar",
                        "warning"
                    );
                    return;
                }
            }

            this.disableSend = true;
            let form_submit = {
                id: null,
                caja: true,
                printDocument: this.printing,
                printing: this.configuration.print_commands,
                commands_fisico: this.commands_fisico,
                comercial_treatment_id: this.commercialTreatmentId,
                print_kitchen: this.configuration.print_kitchen,
                to_carry: this.to_carry,
                orden: {
                    table_id: 1,
                    status_orden_id: 1
                },

                pin: null,
                offert
            };
            if (this.clientTableData.table) {
                form_submit.items = this.ordens;
            } else {
                form_submit.items = this.localOrden;
            }
            if (this.clientTableData.ref) {
                form_submit.ref = this.clientTableData.ref;
            }
            if (this.clientTableData.customer_id) {
                form_submit.customer_id = this.clientTableData.customer_id;
                console.log(
                    "ver pasando el customer_id",
                    this.clientTableData.customer_id
                );
            }
            if (!this.configuration.maderera && !this.divided_items) {
                form_submit.items = this.mergeItems(form_submit.items);
            }
            this.loading = true;

            this.commands_fisico = "";

            form_submit.is_for_carry = this.to_carry;
            if (this.variation) {
                form_submit.variationItems = this.foodDefaults;

                this.$emit("paymentsOrden", form_submit, this.foodDefaults);
            } else {
                this.$emit("paymentsOrden", form_submit);
            }

            this.loading = false;
            this.disableSend = false;
            this.to_carry = false;
            this.foodDefaults = [];
            this.variation = false;
            // Limpiar referencia después de cobrar la orden
            if (this.clientTableData && this.clientTableData.ref) {
                this.$emit("update:clientTableData", {
                    ...this.clientTableData,
                    ref: null
                });
            }
        },
        mergeItems(items) {
            let hasFoodId = items.every(item => item.food && item.food.id);
            if (!hasFoodId) {
                return items;
            }
            const resultado = {};
            // Recorrer el arreglo original
            if (this.configuration.divided_items) {
                items.forEach(obj => {
                    const key = `${obj.food.id}-${Number(obj.price).toFixed(
                        2
                    )}-${obj.observation}`;
                    if (resultado[key]) {
                        resultado[key].quantity += Number(obj.quantity);
                    } else {
                        resultado[key] = {
                            ...obj,
                            quantity: Number(obj.quantity)
                        };
                    }
                });
            } else {
                items.forEach(obj => {
                    const key = `${obj.food.id}-${Number(obj.price).toFixed(
                        2
                    )}`;
                    if (resultado[key]) {
                        resultado[key].quantity += Number(obj.quantity);
                    } else {
                        resultado[key] = {
                            ...obj,
                            quantity: Number(obj.quantity)
                        };
                    }
                });
            }

            const arregloResultado = Object.values(resultado);
            return arregloResultado;
        },
        formatUrlImage(url) {
            if (!url) return;
            let formated = "storage/uploads/items/" + url;
            return `/${formated}`;
        },
        getPriceCurrency(price, currency_id) {
            let localCurrencyId = this.currency_id == "S/" ? "PEN" : "USD";
            if (localCurrencyId == currency_id) {
                return price;
            }
            if (localCurrencyId == "PEN" && currency_id != "PEN") {
                return price * this.exchange_rate_sale;
            }
            if (localCurrencyId != "PEN" && currency_id == "PEN") {
                return price / this.exchange_rate_sale;
            }
        },
        calculateTotal(w = null) {
            this.totalOrdenItems = 0.0;
            this.total = 0.0;
            this.totalOrden = 0.0;
            let OrdenPen = 0;
            let OrdenPenAtendidos = 0;

            // Sumar el subtotal manual si existe, si no, cantidad * precio
            _.forEach(this.localOrden, value => {
                let subtotal = (typeof value.newSubtotal === 'number' && !isNaN(value.newSubtotal))
                    ? parseFloat(Number(value.newSubtotal).toFixed(2))
                    : parseFloat((value.quantity * value.price).toFixed(2));
                OrdenPen += subtotal;
            });
            this.totalOrden = parseFloat(OrdenPen.toFixed(2));
            _.forEach(this.ordens, values => {
                let { item } = values.food;
                OrdenPenAtendidos =
                    parseFloat(OrdenPenAtendidos) +
                    values.quantity *
                    this.getPriceCurrency(
                        values.price,
                        item.currency_type_id
                    );
            });
            this.totalOrdenItems = _.round(OrdenPenAtendidos, 2);
            this.total = _.round(this.totalOrden, 2);
            this.$emit("total_salcancelOrdenaes", this.total);
        },
        deleteFood(idx) {
            this.$emit("deletedFood", idx);
            this.calculateTotal();
        },
        async submit() {
            //this.loading = true;
            this.showDialogPing = true;
            this.open_orders();
        },
        async cancelOrdenaPin() {
            if (this.pin.length > 3 && this.reasonToDelete) {
                if (this.deleteGeneralOrden) {
                    this.deleteGeneralOrdenPin();
                } else {
                    try {
                        this.deleteOrdenLoading = true;
                        const response = await this.$http.post(
                            `delete-orden-pin`,
                            {
                                id: this.ordenIdToDelete,
                                pin: this.pin,
                                reason: this.reasonToDelete
                            }
                        );
                        if (response.status == 200) {
                            if (response.data.success) {
                                const { message } = response.data;
                                let newOrdenItems = [...this.ordens];
                                newOrdenItems = newOrdenItems.filter(
                                    n => n.id != this.ordenIdToDelete
                                );
                                this.$emit("update:ordens", newOrdenItems);
                                this.$eventHub.$emit("reloadData");
                                this.$toast.success(message);
                                this.reasonToDelete = null;
                                this.showPinRequest = false;
                            } else {
                                this.$toast.error(response.data.message);
                            }
                        }
                    } catch (e) {
                        this.$toast.error("Ocurrió un error");
                    } finally {
                        this.pin = "";
                        this.deleteOrdenLoading = false;
                    }
                }
            } else {
                this.$toast.error("Ingrese el pin");
                return;
            }
        },

        handlePinDialogClose() {
            this.pin = "";
            this.reasonToDelete = null;
            this.ordenIdToDelete = null;
            this.deleteGeneralOrden = false;
        },

        handleKeyPress(event) {
            const key = event.key;

            // Solo permitir números
            if (/^\d$/.test(key) && this.pin.length < 4) {
                // No es necesario hacer nada ya que el v-model actualizará el pin
            } else if (key === "Backspace") {
                // Permitir borrar
                this.pin = this.pin.slice(0, -1);
            } else if (key === "Enter" && this.pin.length === 4) {
                // Si presiona Enter y el PIN está completo
                this.cancelOrdenaPin();
            }

            // Prevenir cualquier otra entrada
            if (!/^\d$/.test(key) && key !== "Backspace") {
                event.preventDefault();
            }
        },

        generatePin(num) {
            if (this.pin.length < 4) {
                this.pin += num;
                if (this.pin.length === 4) {
                    // Opcionalmente, ejecutar la acción cuando se complete el PIN
                    // this.cancelOrdenaPin();
                }
            }
        },
        async cancelOrdena(id) {
            if (this.configuration.pin_orden_delete) {
                this.showPinRequest = true;
                this.ordenIdToDelete = id;
            } else {
                try {
                    let x = await this.$confirm(
                        `Está apunto de cancelar un producto de una orden.`,
                        "Mensaje de Advertencia",
                        {
                            confirmButtonText: "Eliminar",
                            cancelButtonText: "Cancelar",
                            type: "warning"
                        }
                    );
                    if (id && x) {
                        const response = await this.$http.delete(
                            `delete-orden/${id}`
                        );
                        if (response.status == 200) {
                            const { message } = response.data;
                            let newOrdenItems = [...this.ordens];
                            newOrdenItems = newOrdenItems.filter(
                                n => n.id != id
                            );
                            this.$emit("update:ordens", newOrdenItems);
                            this.$eventHub.$emit("reloadData");
                            this.$toast.success(message);
                        }
                    }
                } catch (e) {
                    //todo
                    if (e != "cancel") {
                        this.$toast.error("Ocurrió un error");
                    }
                }
            }
        },
        async ordenReady(id) {
            this.loading = true;
            try {
                const response = await this.$http.get(`ordens-ready/${id}`);

                const { success, message } = response.data;
                success
                    ? this.$toast.success(message)
                    : this.$toast.error(message);
                if (success) {
                    let cloneOrdenItems = [...this.ordens];
                    cloneOrdenItems = cloneOrdenItems.map(o => {
                        if (o.id == id) {
                            o.status_orden_id = 3;
                        }
                        return o;
                    });
                    this.$emit("update:ordens", cloneOrdenItems);
                }
            } catch (e) {
                this.$toast.error("Ocurrió un error");
            } finally {
                this.loading = false;
            }
        },
        changeLocalObservation() {
            let ordensModified = [...this.localOrden];
            ordensModified[
                this.currentLocalOrden
            ].observation = this.localObservation;
            this.$emit("update:localOrden", ordensModified);
            this.closeLocalObservationDialog();
        },
        async changeObservation() {
            //this.localObservation
            this.loadingObservation = true;
            const response = await this.$http.post("change-observation", {
                observation: this.observation,
                id: this.currentOrden
            });
            if (response.status == 200) {
                this.$eventHub.$emit("reloadData");
                let newOrdenItems = [...this.ordens];
                newOrdenItems.find(
                    n => n.id == this.currentOrden
                ).observations = this.observation;
            }
            this.loadingObservation = false;
            this.closeObservationDialog();
        },
        openObservationDialog(id, idx) {
            this.currentOrden = id;
            this.observation = this.ordens[idx].observations;
            this.dialogObservation = true;
        },
        closeObservationDialog() {
            this.dialogObservation = false;
            this.observation = null;
        },

        openLocalObservationDialog(idx, obs, ordenId) {
            this.currentOrden = ordenId;
            console.log("orden id ver si pasa el id", ordenId);
            this.showObservations = true;
            this.currentLocalOrden = idx;
            console.log("local orden", this.currentLocalOrden);
            this.current = obs;
            return;

            this.localObservation = this.localOrden[idx].observation;
            this.dialogLocalObservation = true;
        },
        closeLocalObservationDialog() {
            this.dialogLocalObservation = false;
            this.currentLocalOrden = null;
            this.localObservation = null;
        },
        getLasNumOrden() {
            if (!this.isSellerConsolidated) return;
            this.$http.get("/quotations/get-last-num-orden").then(res => {
                if (res.data && res.data.data) this.num_orden = res.data.data;
            });
        }
    }
};
</script>
