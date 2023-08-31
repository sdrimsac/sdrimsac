<template>
    <div
        style="position: relative"
        v-loading.fullscreen="loading"
        element-loading-text="Espere..."
    >
        <div class="row ">
            <div
                v-if="screenWidth > 678"
                class="d-flex flex-row justify-content-start card mb-2"
            >
                <div
                    class="col-7 col-sm-5 col-lg-6 col-md-5 col-xl-7 col-xxl-7"
                >
                    <div class="card-body p-2">
                        <div class="row">
                            <div class="d-flex flex-wrap ">
                                <div
                                    class="dropdown-as-select d-inline-block mb-1"
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
                                            >Menu De Acciones
                                        </span>
                                    </button>

                                    <div
                                        class="dropdown-menu dropdown-menu-end col-md-2 col-1 "
                                        style="width: 153px;"
                                    >
                                        <div
                                            class="col-12"
                                            v-for="(option, idx) in optionsMenu"
                                            :key="idx"
                                            v-show="option.visible"
                                        >
                                            <el-button
                                                v-if="option.visible"
                                                @click="
                                                    trigerFunction(option.id)
                                                "
                                                class="
                                                        btn btn-light
                                                        m-1
                                                        rounded
                                                        d-flex
                                                        flex-column
                                                        align-items-center
                                                        justify-content-center
                                                        col-12
                                                        "
                                                style="max-width: 150px;"
                                            >
                                                <div
                                                    class="text-center"
                                                    style="margin-bottom: 2px"
                                                >
                                                    <p
                                                        style="margin: 0 !important; padding: 0 !important ; font-size: 15px;"
                                                        v-for="(title,
                                                        idx2) in option.title"
                                                        :key="idx2"
                                                    >
                                                        {{ title }}
                                                    </p>
                                                    <i :class="option.icon"></i>
                                                </div>
                                                <div></div>
                                            </el-button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row card mx-1 mt-2">
                            <div>
                                <div class="d-flex row align-items-center">
                                    <div class="col-2 d-flex flex-column">
                                        <el-checkbox
                                            v-model="barcode"
                                            @change="saveInLocalStorageBarcode"
                                        >
                                            <h2 class="text-muted text-small">
                                                Barcode
                                            </h2>
                                            <!-- <i
                                                class="fas fa-barcode"
                                                style="font-size:30px;"
                                            ></i> -->
                                        </el-checkbox>
                                        <el-checkbox
                                            v-model="type_code"
                                            @change="saveInLocalStorage"
                                        >
                                            <h2 class="text-muted text-small">
                                                QR
                                            </h2>
                                            <!-- <i
                                                class="fas fa-barcode"
                                                style="font-size:30px;"
                                            ></i> -->
                                        </el-checkbox>
                                    </div>
                                    <div class="col-12 col-lg-3 p-2">
                                        <template>
                                            <h2 class="text-muted text-small">
                                                Categorias
                                            </h2>
                                            <el-select
                                                v-model="category"
                                                filterable
                                                clearable
                                                placeholder="Selecionar aqui...."
                                                @change="search_items(null)"
                                            >
                                                <el-option
                                                    v-for="item in categories"
                                                    :key="item.id"
                                                    :label="item.name"
                                                    :value="item.id"
                                                >
                                                </el-option>
                                            </el-select>
                                        </template>
                                    </div>
                                    <div class="col-12 col-lg-7 p-2">
                                        <h2 class="text-muted text-small">
                                            Buscar
                                        </h2>
                                        <template v-if="selectOption == 4">
                                            <el-input
                                                ref="input_items"
                                                size="small"
                                                v-model="input_item"
                                                @input="search()"
                                                @focus="clear_input()"
                                                autofocus
                                                clearable
                                            >
                                                <el-button
                                                    slot="append"
                                                    icon="el-icon-search"
                                                    @click="search"
                                                ></el-button>
                                            </el-input>
                                        </template>

                                        <template v-else>
                                            <el-input
                                                ref="input_item"
                                                size="small"
                                                v-model="input_item"
                                                @input="search()"
                                                @focus="clear_input()"
                                                autofocus
                                            >
                                                <el-button
                                                    slot="append"
                                                    icon="el-icon-search"
                                                    @click="search"
                                                ></el-button>
                                            </el-input>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div
                            class="row"
                            v-if="selectOption == 4 || selectOption == 3"
                        >
                            <div class="col-md-12 p-1">
                                <ListFood
                                    :localOrden="localOrden"
                                    :blockAdd.sync="blockCart"
                                    ref="list_foods"
                                    :barcode.sync="barcode"
                                    :type_code.sync="type_code"
                                    :worker="worker"
                                    @insertOrden="insertOrden"
                                    :configuration="configuration"
                                    :foods.sync="allFoods"
                                    @buscarnuevo="buscarnuevo"
                                >
                                </ListFood>
                            </div>
                        </div>

                        <div
                            class="row"
                            v-if="selectOption == 1 || selectOption == 2"
                        >
                            <div class="col-12 mb-1">
                                <div
                                    class="card mb-2 bg-transparent no-shadow d-none d-lg-block"
                                >
                                    <div class="row g-0 sh-3">
                                        <div class="col">
                                            <div
                                                class="card-body pt-0 pb-0 h-100"
                                            >
                                                <div
                                                    class="row g-0 h-100 align-content-center"
                                                >
                                                    <div
                                                        class="
                              col-6 col-lg-2
                              d-flex
                              align-items-center
                              justify-content-start
                              text-alternate text-medium text-muted text-small
                            "
                                                    >
                                                        CANTIDAD
                                                    </div>
                                                    <div
                                                        class="
                              col-6 col-lg-5
                              d-flex
                              align-items-center
                              justify-content-start
                              text-alternate text-medium text-muted text-small
                            "
                                                    >
                                                        DESCRIPCION
                                                    </div>
                                                    <div
                                                        class="
                              col-6 col-lg-2
                              d-flex
                              align-items-center
                              justify-content-center
                              text-alternate text-medium text-muted text-small
                            "
                                                    >
                                                        PRECIO
                                                    </div>
                                                    <div
                                                        class="
                              col-6 col-lg-2
                              d-flex
                              align-items-center
                              justify-content-center
                              text-alternate text-medium text-muted text-small
                            "
                                                    >
                                                        IMPORTE
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="checkboxTable">
                                    <div
                                        class="card mb-2 hover-border-secondary border"
                                        v-for="(row, index) in ordens"
                                        :key="index"
                                    >
                                        <div class="card-body p-2">
                                            <div
                                                class="row g-0 h-100 align-content-center"
                                            >
                                                <div
                                                    class="
                            col-6 col-lg-2
                            d-flex
                            flex-column
                            justify-content-start
                            mb-2 mb-lg-0
                            order-lg-2
                          "
                                                >
                                                    <div
                                                        class="text-muted text-small d-lg-none"
                                                    >
                                                        <h1>CANTIDAD</h1>
                                                    </div>
                                                    <div class="text-alternate">
                                                        <template>
                                                            <el-input-number
                                                                :disabled="
                                                                    disableCantidad
                                                                "
                                                                :min="1"
                                                                size="mini"
                                                                v-model="
                                                                    row.food
                                                                        .item
                                                                        .quantity
                                                                "
                                                                controls-position="right"
                                                                @change="
                                                                    calculateItem(
                                                                        index,
                                                                        row.food
                                                                            .item
                                                                            .quantity,
                                                                        row.food
                                                                            .price_sale
                                                                    )
                                                                "
                                                            >
                                                            </el-input-number>
                                                        </template>
                                                    </div>
                                                </div>
                                                <div
                                                    class="
                            col-12 col-lg-5
                            d-flex
                            flex-column
                            justify-content-start
                            mb-2 mb-lg-0
                            order-lg-3
                          "
                                                >
                                                    <div
                                                        class="text-muted text-small d-lg-none"
                                                    >
                                                        DESCRIPCION
                                                    </div>

                                                    <template
                                                        v-if="
                                                            row.food.item
                                                                .name_product_pdf !=
                                                                null
                                                        "
                                                    >
                                                        {{
                                                            row.food.item
                                                                .name_product_pdf
                                                        }}
                                                    </template>
                                                    <template v-else>
                                                        {{
                                                            row.food.item
                                                                .description
                                                        }}
                                                    </template>
                                                </div>
                                                <div
                                                    class="
                            col-6 col-lg-2
                            d-flex
                            flex-column
                            justify-content-center
                            mb-2 mb-lg-0
                            order-lg-4
                          "
                                                >
                                                    <div
                                                        class="text-muted text-small d-lg-none"
                                                    >
                                                        PRECIO
                                                    </div>
                                                    <div class="text-alternate">
                                                        <span>
                                                            <el-input
                                                                v-model="
                                                                    row.food
                                                                        .price
                                                                "
                                                                :disabled="
                                                                    disableCantidad
                                                                "
                                                                size="mini"
                                                                @input="
                                                                    calculateItem(
                                                                        index,
                                                                        row.food
                                                                            .item
                                                                            .quantity,
                                                                        row.food
                                                                            .price
                                                                    )
                                                                "
                                                            >
                                                                <template
                                                                    slot="prepend"
                                                                    >S/.
                                                                </template>
                                                            </el-input>
                                                        </span>
                                                    </div>
                                                </div>

                                                <div
                                                    class="
                            col-6 col-lg-2
                            d-flex
                            flex-column
                            justify-content-center
                            mb-2 mb-lg-0
                            order-lg-5
                            text-center
                          "
                                                >
                                                    <div
                                                        class="text-muted text-small d-lg-none mb-1"
                                                    >
                                                        IMPORTE
                                                    </div>
                                                    S/.
                                                    {{
                                                        (
                                                            parseFloat(
                                                                row.food.price
                                                            ) *
                                                            parseFloat(
                                                                row.food.item
                                                                    .quantity
                                                            )
                                                        ).toFixed(2)
                                                    }}
                                                </div>
                                                <div
                                                    class="
                            col-12 col-lg-1
                            d-flex
                            flex-column
                            justify-content-center
                            align-items-lg-end
                            mb-2 mb-lg-0
                            text-end
                            order-lg-last
                            pr-2
                          "
                                                >
                                                    <button
                                                        type="button"
                                                        class="
                              btn
                              waves-effect waves-light
                              btn-sm btn-danger
                            "
                                                        @click="
                                                            removeFood(
                                                                index,
                                                                row.id
                                                            )
                                                        "
                                                    >
                                                        <i
                                                            class="fas fa-times"
                                                        ></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Customers List End -->
                        <!--  -->

                        <div
                            class="row"
                            v-loading="loading"
                            v-if="selectOption == 0"
                        >
                            <div
                                class="col-12 col-lg-6 col-xxl-2 mb-2"
                                v-for="(row, index) in listar_tables"
                                :key="index"
                            >
                                <div
                                    class="card hover-border-secondary"
                                    :class="
                                        selecttables == row.id
                                            ? 'border-secondary'
                                            : ''
                                    "
                                    @click="selectTable(row, index)"
                                    data-bs-toggle="offcanvas"
                                    data-bs-target="#offcanvasRight"
                                    aria-controls="offcanvasRight"
                                >
                                    <div
                                        class="h-100 row g-0 card-body align-items-center"
                                    >
                                        <div class="col-auto">
                                            <div
                                                class="
                          bg-gradient-2
                          sw-6
                          sh-6
                          rounded-md
                          d-flex
                          justify-content-center
                          align-items-center
                        "
                                            >
                                                <i
                                                    class="
                            icofont icofont-dining-table icofont-2x
                            text-white
                          "
                                                ></i>
                                            </div>
                                        </div>
                                        <div
                                            class="
                        col
                        sh-6
                        ps-3
                        d-flex
                        flex-column
                        justify-content-center
                      "
                                        >
                                            <div
                                                class="heading mb-0 d-flex align-items-center lh-1-25"
                                            >
                                                Mesa {{ row.number }}
                                            </div>
                                            <div class="row g-0">
                                                <div class="col-auto">
                                                    <div
                                                        class="cta-2 text-primary"
                                                    >
                                                        <template
                                                            v-if="
                                                                row.ordens
                                                                    .length == 1
                                                            "
                                                        >
                                                            {{
                                                                (
                                                                    "00" +
                                                                    row.ordens
                                                                        .length
                                                                ).slice(-2)
                                                            }}
                                                        </template>
                                                        <template v-else>
                                                            <template
                                                                v-if="
                                                                    row.ordens
                                                                        .length +
                                                                        1 <=
                                                                        9
                                                                "
                                                            >
                                                                0{{
                                                                    row.ordens
                                                                        .length +
                                                                        1
                                                                }}
                                                                Ordenes
                                                            </template>
                                                            <template v-else>
                                                                {{
                                                                    row.ordens
                                                                        .length +
                                                                        1
                                                                }}
                                                                Ordenes
                                                            </template>
                                                        </template>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div
                            class="offcanvas offcanvas-end"
                            tabindex="-1"
                            id="offcanvasRight"
                            aria-labelledby="offcanvasRightLabel"
                        >
                            <div class="offcanvas-header">
                                <h5 id="offcanvasRightLabel">
                                    Mesa Nº {{ tableSelect.number }} /
                                    {{ ("00" + OrdenLength).slice(-2) }}
                                    Ordenes
                                </h5>
                                <button
                                    type="button"
                                    class="btn-close text-reset"
                                    data-bs-dismiss="offcanvas"
                                    aria-label="Close"
                                ></button>
                            </div>
                            <div class="offcanvas-body">
                                <section class="scroll-section" id="checkboxes">
                                    <div class="d-flex justify-content-between">
                                        <h2 class="small-title">
                                            Ordenes de Pedido
                                        </h2>
                                        <div
                                            class="btn-group check-all-container mt-n1"
                                        >
                                            <div
                                                class="
                          btn btn-sm btn-outline-primary btn-custom-control
                        "
                                                id="checkAllforCheckboxTable"
                                                data-target="#checkboxTable"
                                                @click="selectAllCats"
                                            >
                                                <span
                                                    class="form-check mb-0 pe-1"
                                                >
                                                    <input
                                                        type="checkbox"
                                                        class="form-check-input"
                                                        id="checkAll"
                                                        v-model="isAllSelected"
                                                    />
                                                </span>
                                            </div>
                                            <button
                                                type="button"
                                                class="
                          btn btn-sm btn-outline-primary
                          dropdown-toggle dropdown-toggle-split
                        "
                                                data-bs-offset="0,3"
                                                data-bs-toggle="dropdown"
                                                aria-haspopup="true"
                                                aria-expanded="false"
                                            ></button>
                                            <div
                                                class="dropdown-menu dropdown-menu-sm dropdown-menu-end"
                                            >
                                                <a
                                                    class="dropdown-item"
                                                    href="javascript:void(0)"
                                                    @click="status_orden_id(0)"
                                                    >Cancelar Ordenes</a
                                                >
                                                <div
                                                    class="dropdown-divider"
                                                ></div>
                                                <a
                                                    class="dropdown-item"
                                                    href="javascript:void(0)"
                                                    @click="status_orden_id(3)"
                                                    >Orden de Pedidos Listo</a
                                                >
                                                <a
                                                    class="dropdown-item"
                                                    href="javascript:void(0)"
                                                    @click="facturar_orden()"
                                                    >Facturar</a
                                                >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="scroll-out">
                                        <div
                                            class="
                        scroll-by-count
                        os-host
                        os-theme-dark
                        os-host-overflow
                        os-host-overflow-y
                        os-host-resize-disabled
                        os-host-scrollbar-horizontal-hidden
                        os-host-transition
                      "
                                            data-count="4"
                                            id="checkboxTable"
                                            style="height: calc(100vh - 7rem)"
                                        >
                                            <div
                                                class="os-resize-observer-host observed"
                                            >
                                                <div
                                                    class="os-resize-observer"
                                                    style="left: 0px; right: auto"
                                                ></div>
                                            </div>
                                            <div
                                                class="os-size-auto-observer observed"
                                                style="height: calc(100% + 1px); float: left"
                                            >
                                                <div
                                                    class="os-resize-observer"
                                                ></div>
                                            </div>
                                            <div
                                                class="os-content-glue"
                                                style="margin: 0px -15px"
                                            ></div>
                                            <div class="os-padding">
                                                <div
                                                    class="
                            os-viewport os-viewport-native-scrollbars-invisible
                          "
                                                    style="overflow-y: scroll"
                                                >
                                                    <div
                                                        class="os-content"
                                                        style="padding: 0px 15px; height: 100%; width: 100%"
                                                    >
                                                        <div
                                                            v-for="(data,
                                                            index) in tableSelect.ordens"
                                                            :key="index"
                                                        >
                                                            <div
                                                                class="row g-0 h-100 align-content-center"
                                                                v-if="
                                                                    data.status_id ==
                                                                        1
                                                                "
                                                                :class="
                                                                    data.status_id ==
                                                                    0
                                                                        ? 'animate__animated animate__backOutUp animate__delay-2s'
                                                                        : ''
                                                                "
                                                            >
                                                                <div
                                                                    class="
                                    col-12
                                    d-flex
                                    align-items-center
                                    mb-2 mb-md-0
                                    p-2
                                    font-weight-bold
                                  "
                                                                >
                                                                    ORDEN Nº
                                                                    {{
                                                                        data.id
                                                                    }}
                                                                    <!-- </div>
                                </div>-->
                                                                </div>
                                                            </div>

                                                            <div
                                                                v-for="(ordersItem,
                                                                indexx) in data.orden_items"
                                                                :key="indexx"
                                                            >
                                                                <div
                                                                    class="card mb-1 pt-2 pb-2 border"
                                                                    :class="
                                                                        data.status_orden_id ==
                                                                        3
                                                                            ? 'animate__animated animate__backOutUp animate__delay-2s'
                                                                            : ''
                                                                    "
                                                                    v-if="
                                                                        ordersItem.status_orden_id ==
                                                                            1
                                                                    "
                                                                >
                                                                    <div>
                                                                        <div>
                                                                            <div>
                                                                                <div>
                                                                                    Cantidad
                                                                                </div>
                                                                                {{
                                                                                    ordersItem.quantity
                                                                                }}
                                                                            </div>
                                                                            <div>
                                                                                <div>
                                                                                    Detalle
                                                                                </div>
                                                                                {{
                                                                                    ordersItem
                                                                                        .food
                                                                                        .description
                                                                                }}
                                                                            </div>

                                                                            <div>
                                                                                <div>
                                                                                    Precio
                                                                                </div>
                                                                                <div>
                                                                                    {{
                                                                                        ordersItem
                                                                                            .food
                                                                                            .price
                                                                                    }}
                                                                                </div>
                                                                            </div>

                                                                            <div>
                                                                                <div>
                                                                                    <input
                                                                                        type="checkbox"
                                                                                        class="form-check-input"
                                                                                        :value="
                                                                                            ordersItem.id
                                                                                        "
                                                                                        v-model="
                                                                                            selectedCatIds
                                                                                        "
                                                                                        @click="
                                                                                            select
                                                                                        "
                                                                                    />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-5 col-sm-7 col-lg-6 col-md-7 col-xl-5">
                    <div class="card-body p-2">
                        <list-orden
                            @sendOrdensAllTables="sendOrdensAllTables"
                            ref="list_orden"
                            :affectation_igv_types="affectation_igv_types"
                            :all_series.sync="all_series"
                            @resetOrden="resetOrden"
                            :areas="areas"
                            :company.sync="company"
                            :customers.sync="all_customers"
                            :customer_variation="customer_variation"
                            :variationShow.sync="variation"
                            :establishments="establishments"
                            :itemDefault.sync="itemDefault"
                            :cash_id.sync="cashId"
                            :ordenId.sync="ordenId"
                            :ordensPending.sync="ordensPending"
                            :area_id="area_id"
                            :isCreatingOrden.sync="isCreatingOrden"
                            :blockCart.sync="blockCart"
                            :total2.sync="form.total"
                            :configuration.sync="configuration"
                            :localOrden.sync="localOrden"
                            :ordens.sync="ordensItems"
                            @total_sales="total_sales"
                            @updateOrdens="updateOrdens"
                            @paymentsOrden="paymentsOrden"
                            @deletedFood="deletedFood"
                            @cancelOrden="cancelOrden"
                            @ordenDeleted="createOrden"
                            @limpiarForm="limpiarForm"
                            :clientTableData.sync="clientTableData"
                        ></list-orden>
                    </div>
                </div>
            </div>
            <div v-else>
                <!-- Modo Celular/ Movil -->
                <div class="d-flex flex-wrap ">
                    <button
                        type="button"
                        class="btn settings-button bg-primary text-white border border-white"
                        data-bs-toggle="modal"
                        data-bs-target="#settings"
                        id="settingsButton"
                    >
                        <i class="fas fa-cart-plus"></i>
                    </button>
                    <div
                        class="modal fade modal-right scroll-out-negative"
                        id="settings"
                        data-bs-backdrop="true"
                        tabindex="-1"
                        role="dialog"
                        aria-labelledby="settings"
                        aria-hidden="true"
                    >
                        <div
                            class="modal-dialog modal-dialog-scrollable full"
                            role="document"
                        >
                            <div class="modal-content">
                                <div class="modal-header bg-primary">
                                    <h5
                                        class="modal-title"
                                        style="color: var(--light-text) !important;"
                                    >
                                        Visualizacion de Productos
                                    </h5>
                                    <button
                                        type="button"
                                        class="btn-close"
                                        data-bs-dismiss="modal"
                                        aria-label="Close"
                                    ></button>
                                </div>

                                <div class="modal-body">
                                    <div class="scroll-track-visible">
                                        <div class="row ">
                                            <div class="col-12">
                                                <template>
                                                    <h2
                                                        class="text-muted text-small"
                                                    >
                                                        Categorias
                                                    </h2>
                                                    <el-select
                                                        v-model="category"
                                                        filterable
                                                        clearable
                                                        placeholder="Selecionar aqui...."
                                                    >
                                                        <el-option
                                                            v-for="item in categories"
                                                            :key="item.id"
                                                            :label="item.name"
                                                            :value="item.id"
                                                        >
                                                        </el-option>
                                                    </el-select>
                                                </template>
                                            </div>
                                            <div class="col-12 ">
                                                <h2
                                                    class="text-muted text-small"
                                                >
                                                    Buscar
                                                </h2>
                                                <template
                                                    v-if="selectOption == 4"
                                                >
                                                    <el-input
                                                        ref="input_items"
                                                        size="small"
                                                        v-model="input_item"
                                                        @input="search()"
                                                        @focus="clear_input()"
                                                        autofocus
                                                        placeholder="Ingrese aca Un Producto"
                                                    >
                                                        <el-button
                                                            slot="append"
                                                            icon="el-icon-search"
                                                            @click="receiveData"
                                                        ></el-button>
                                                    </el-input>
                                                </template>

                                                <template v-else>
                                                    <el-input
                                                        ref="input_itemMobil"
                                                        size="small"
                                                        v-model="input_item"
                                                        @input="search()"
                                                        @focus="clear_input()"
                                                        autofocus
                                                        placeholder="Ingrese aca Un Producto"
                                                    >
                                                        <el-button
                                                            slot="append"
                                                            icon="el-icon-search"
                                                            @click="receiveData"
                                                        ></el-button>
                                                    </el-input>
                                                </template>
                                            </div>
                                        </div>
                                        <div class="row d-flex flex-wrap">
                                            <div
                                                class="col-12  p-1"
                                                v-for="(data,
                                                index) in allFoods"
                                                :key="index"
                                            >
                                                <el-tooltip
                                                    effect="dark"
                                                    :disabled="
                                                        data.item.warehouses
                                                            .length == 1 ||
                                                            !configuration.show_stock_establishment_box
                                                    "
                                                >
                                                    <div slot="content">
                                                        Stock Almacenes <br />
                                                        <span
                                                            v-for="(info,
                                                            idx) in data.item
                                                                .warehouses"
                                                            :key="idx"
                                                        >
                                                            <label
                                                                v-if="
                                                                    info
                                                                        .warehouse
                                                                        .id !=
                                                                        establishmentId
                                                                "
                                                            >
                                                                <template
                                                                    v-if="
                                                                        data
                                                                            .item
                                                                            .max_quantity
                                                                    "
                                                                >
                                                                    <!-- {{
                                                                            `${
                                                                                info.warehouse.description
                                                                            }: ${Number(info.stock) /
                                                                                data.item.max_quantity}`
                                                                        }} -->
                                                                    {{
                                                                        formatedStockPresentation(
                                                                            data.item,
                                                                            info.stock
                                                                        )
                                                                    }}
                                                                </template>
                                                                <template
                                                                    v-else
                                                                >
                                                                    {{
                                                                        `${
                                                                            info
                                                                                .warehouse
                                                                                .description
                                                                        }: ${Number(
                                                                            info.stock
                                                                        ).toFixed(
                                                                            2
                                                                        )}`
                                                                    }}
                                                                </template> </label
                                                            ><br />
                                                        </span>
                                                    </div>
                                                    <div
                                                        id="card"
                                                        class="
                                                                    overflow-hidden
                                                                    coupon
                                                                    rounded
                                                                    d-flex
                                                                    flex-column
                                                                    justify-content-between
                                                                    p-1
                                                                    "
                                                        style="height: 125px; width: 297px ; margin-left: 9px; "
                                                    >
                                                        <div
                                                            @click="
                                                                addFood(index)
                                                            "
                                                        >
                                                            <div>
                                                                <span
                                                                    class="lead-font-weight-700 h5"
                                                                >
                                                                    {{
                                                                        data.description.toUpperCase()
                                                                    }}
                                                                </span>
                                                            </div>
                                                            <div
                                                                class="d-flex align-items-end justify-content-between"
                                                            >
                                                                <div
                                                                    class="p-1"
                                                                >
                                                                    <div
                                                                        class="icon-container"
                                                                    >
                                                                        <div
                                                                            class="icon-container_box"
                                                                        >
                                                                            <template
                                                                                v-if="
                                                                                    data.image ==
                                                                                        'imagen-no-disponible.jpg'
                                                                                "
                                                                            >
                                                                                <img
                                                                                    hidden
                                                                                    src="/images/imagen-no-disponible.jpg"
                                                                                    alt="User Img"
                                                                                    class="thumbail"
                                                                                />
                                                                            </template>
                                                                            <template
                                                                                v-else
                                                                            >
                                                                                <img
                                                                                    :src="
                                                                                        formatUrlImage(
                                                                                            data.image
                                                                                        )
                                                                                    "
                                                                                    class="thumbail"
                                                                                    style="  max-height: 69px;  max-width: 69px;"
                                                                                />
                                                                            </template>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div>
                                                                    {{
                                                                        data.code
                                                                    }}
                                                                </div>
                                                                <div
                                                                    class="d-flex flex-column align-items-end"
                                                                >
                                                                    <!-- <div class="text-uppercase font-weight-light h5">
                                                    {{ data.category.name }}
                                                </div> -->
                                                                    <div
                                                                        class="block mb-2"
                                                                    >
                                                                        <span
                                                                            class="time font-weight-light"
                                                                        >
                                                                            <span
                                                                                class="text-muted lead-font-weight-700"
                                                                            >
                                                                                S/
                                                                                {{
                                                                                    data.price
                                                                                }}</span
                                                                            >
                                                                        </span>
                                                                    </div>
                                                                    <div>
                                                                        <template
                                                                            v-if="
                                                                                data
                                                                                    .item
                                                                                    .stock >
                                                                                    0
                                                                            "
                                                                        >
                                                                            <span
                                                                                class="badge rounded-pill bg-primary m-l-0"
                                                                                >Stock
                                                                                <template
                                                                                    v-if="
                                                                                        data
                                                                                            .item
                                                                                            .max_quantity
                                                                                    "
                                                                                >
                                                                                    {{
                                                                                        formatedStockPresentation(
                                                                                            data.item,
                                                                                            data
                                                                                                .item
                                                                                                .stock
                                                                                        )
                                                                                    }}
                                                                                    <!-- {{
                                                                                            parseFloat(
                                                                                                data.item
                                                                                                    .stock /
                                                                                                    data
                                                                                                        .item
                                                                                                        .max_quantity
                                                                                            )
                                                                                        }} -->
                                                                                </template>
                                                                                <template
                                                                                    v-else
                                                                                >
                                                                                    {{
                                                                                        parseFloat(
                                                                                            data
                                                                                                .item
                                                                                                .stock
                                                                                        )
                                                                                    }}
                                                                                </template>
                                                                            </span>
                                                                        </template>
                                                                        <template
                                                                            v-else
                                                                        >
                                                                            <span
                                                                                class="badge rounded-pill bg-danger m-l-0"
                                                                            >
                                                                                Agotado
                                                                            </span>
                                                                        </template>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div
                                                            v-if="
                                                                data.types
                                                                    .length > 0
                                                            "
                                                            class="d-flex justify-content-end"
                                                            style="padding-right: 10px; margin-top: 5px"
                                                        >
                                                            <el-dropdown
                                                                @command="
                                                                    clickCommand
                                                                "
                                                            >
                                                                <span
                                                                    class="el-dropdown-link"
                                                                >
                                                                    Precios<i
                                                                        class="el-icon-arrow-down el-icon--right"
                                                                    ></i>
                                                                </span>
                                                                <el-dropdown-menu
                                                                    slot="dropdown"
                                                                >
                                                                    <el-dropdown-item
                                                                        v-for="(type,
                                                                        idx) in data.types"
                                                                        :key="
                                                                            idx
                                                                        "
                                                                        :command="
                                                                            type
                                                                        "
                                                                    >
                                                                        {{
                                                                            formatDescriptionType(
                                                                                type
                                                                            )
                                                                        }}
                                                                    </el-dropdown-item>
                                                                </el-dropdown-menu>
                                                            </el-dropdown>
                                                        </div>
                                                    </div>
                                                </el-tooltip>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- sidebarmodal fin  -->
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
                                ><i class="fas fa-list"></i
                            ></span>
                        </button>

                        <div
                            class="dropdown-menu dropdown-menu-end col-md-2 col-1"
                        >
                            <div
                                class="col-12"
                                v-for="(option, idx) in optionsMenu"
                                :key="idx"
                                v-show="option.visible"
                            >
                                <el-button
                                    v-if="option.visible"
                                    @click="trigerFunction(option.id)"
                                    class="
                                            btn btn-light
                                            m-1
                                            rounded
                                            d-flex
                                            flex-column
                                            align-items-center
                                            justify-content-center
                                            col-12
                                            "
                                    style="max-width: 150px;"
                                >
                                    <div
                                        class="text-center"
                                        style="margin-bottom: 2px"
                                    >
                                        <p
                                            style="margin: 0 !important; padding: 0 !important"
                                            v-for="(title,
                                            idx2) in option.title"
                                            :key="idx2"
                                        >
                                            {{ title }}
                                        </p>
                                        <i :class="[option.icon, 'fa-1x']"></i>
                                    </div>
                                    <div></div>
                                </el-button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <list-orden
                        :company.sync="company"
                        :customer_variation="customer_variation"
                        :variationShow.sync="variation"
                        :establishments="establishments"
                        :itemDefault.sync="itemDefault"
                        :cash_id.sync="cashId"
                        :ordenId.sync="ordenId"
                        :ordensPending.sync="ordensPending"
                        :area_id="area_id"
                        :isCreatingOrden.sync="isCreatingOrden"
                        :blockCart.sync="blockCart"
                        :total2.sync="form.total"
                        :configuration.sync="configuration"
                        :localOrden.sync="localOrden"
                        :ordens.sync="ordensItems"
                        @total_sales="total_sales"
                        @updateOrdens="updateOrdens"
                        @paymentsOrden="paymentsOrden"
                        @deletedFood="deletedFood"
                        @cancelOrden="cancelOrden"
                        @ordenDeleted="createOrden"
                        :clientTableData.sync="clientTableData"
                        :categories.sync="categories"
                    ></list-orden>
                </div>
                <template>
                    <list-food-mobiles
                        :localOrden="localOrden"
                        :blockAdd.sync="blockCart"
                        ref="list_foods"
                        :worker="worker"
                        @insertOrden="insertOrden"
                        :configuration="configuration"
                        :foods.sync="allFoods"
                        @buscarnuevo="buscarnuevo"
                        :category.sync="category"
                        :showDialogViewItems.sync="showDialogViewItems"
                        :categories.sync="categories"
                        :selectOption.sync="selectOption"
                        @data-received="receiveData"
                        @changeCategory="changeCategory"
                    >
                    </list-food-mobiles>
                </template>
            </div>
        </div>
        <DrawerOrdens
            ref="ordenRef"
            :configuration.sync="configuration"
            :localOrden.sync="localOrden"
            :ordens.sync="ordensItems"
            @total_sales="total_sales"
            @updateOrdens="updateOrdens"
            @paymentsOrden="paymentsOrden"
            @deletedFood="deletedFood"
            @ordenDeleted="createOrden"
        >
        </DrawerOrdens>

        <template>
            <payment-form
                :ordens_all_table.sync="ordens_all_table"
                :consignment_id="consignment_id"
                @removeConsignment="removeConsignment"
                :isConsignment.sync="isConsignment"
                :printer="printer"
                :personalWhatsapp="personalWhatsapp"
                @getFile="getFile"
                :customer_default="customer_default"
                :variation.sync="variation"
                :documentsType="documentsType"
                :cash_id.sync="cashId"
                v-if="is_payment == true"
                :percentage_igv="percentage_igv"
                :is_payment.sync="is_payment"
                :form="form"
                :orden_items="orden_items"
                :establishments="establishments"
                :company.sync="company"
                :idOrden="idOrden"
                :all_series.sync="all_series"
                :payments.sync="payments"
                :direct_printing="direct_printing"
                :currency-type-id-active="form.currency_type_id"
                :currency-type-active="currency_type"
                :exchange-rate-sale="form.exchange_rate_sale"
                :customer="customer"
                :auth_login="auth_login"
                :configuration="configuration"
                :desarrollador.sync="desarrollador"
                @limpiarForm="limpiarForm"
                :orden="ordenId"
                @openDrawer="openDrawer"
                :all_customers.sync="all_customers"
                :formVariation="formVariation"
                :customer_variation="customer_variation"
                :affectation_igv_types="affectation_igv_types"
            >
            </payment-form>
        </template>
        <template v-if="configuration.college">
            <college-parents
                :showDialog.sync="showDialogNewPerson"
            ></college-parents>
        </template>
        <template v-else>
            <person-form
                :external="false"
                :showDialog.sync="showDialogNewPerson"
            ></person-form>
        </template>
        <cash-history
            :cash_id.sync="cashId"
            :showHistoryCash.sync="showHistoryCash"
            :area_id="area_id"
            :sender="personalWhatsapp ? sender : 'sdrimsac'"
        >
        </cash-history>
        <item-form
            :showDialog.sync="showDialogNewItem"
            :external="true"
            :worker="worker"
        ></item-form>
        <college
            :showDialog.sync="showDialogCollege"
            :configuration="configuration"
        >
        </college>
        <warehouses-detail
            :showDialog.sync="showWarehousesDetail"
            :warehouses="warehousesDetail"
            :unit_type="unittypeDetail"
        >
        </warehouses-detail>
        <tables
            @creatingOrden="creatingOrden"
            @sendOrdens="sendOrdens"
            :showTables.sync="showTables"
        ></tables>

        <documents-print
            :sender="personalWhatsapp ? sender : 'sdrimsac'"
            :company="company"
            :showDialog.sync="showDocumentsPrint"
            :config.sync="config"
            :establishment.sync="establishments"
        ></documents-print>
        <PromotionCanje
            :showDialog.sync="showdialogPromocion"
            :config.sync="config"
            :establishment.sync="establishment"
        >
        </PromotionCanje>
        <credits-list :showDialog.sync="showCredits"> </credits-list>

        <dispatch-modal
            :configuration="configuration"
            :showDialog.sync="showDispatch"
        >
        </dispatch-modal>
        <category-drag :showDialog.sync="showCategoryDrag"></category-drag>
        <edit-product
            @getFoods="getFoods"
            :showDialog.sync="showEditProduct"
            :allItems="allFoods"
        ></edit-product>

        <el-dialog
            v-loading="showDailyCashLoading"
            width="450px"
            :visible.sync="showPinRequest"
            title="Ingrese su PIN"
            append-to-body
        >
            <div class="row mt-1">
                <h5>
                    Para poder visualizar la venta del día de hoy, ingrese su
                    PIN
                </h5>
            </div>

            <div class="row mt-2 d-flex justify-content-center">
                <div class="col-8 ">
                    <el-input
                        v-model="pin"
                        placeholder="Ingrese su PIN"
                        type="password"
                        maxlength="4"
                        readonly
                    ></el-input>
                </div>
                <div class="col-12 d-flex flex-wrap justify-content-center">
                    <el-button
                        v-for="num in [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]"
                        :key="num"
                        class="m-2"
                        @click="generatePin(num)"
                        >{{ num }}</el-button
                    >
                    <el-button
                        @click="pin = ''"
                        class="m-2"
                        type="danger"
                        icon="el-icon-delete"
                    ></el-button>
                </div>
            </div>
            <div slot="footer" class="dialog-footer">
                <el-button @click="showPinRequest = false">Cancelar</el-button>
                <el-button type="primary" @click="checkPin">Enviar</el-button>
            </div>
        </el-dialog>
        <consignment-list
            @setItemsToLiquidate="setItemsToLiquidate"
            :showDialog.sync="showDialogConsignment"
        ></consignment-list>
        <products-due :showDialog.sync="showDialogDueProducts"> </products-due>
        <item-set
            :showDialog.sync="showDialogItemSet"
            :external="true"
            :establishment_id.sync="establishmentId"
        >
        </item-set>
    </div>
</template>

<style>
/* .el-checkbox#barcode .el-checkbox__label {
    padding-top: 10px !important;
} */
</style>
<script>
import _ from "lodash";
const DrawerOrdens = () => import("./partials/drawer.vue");
//import DrawerOrdens from "./partials/drawer.vue";
import ListFood from "./partials/list_food.vue";
import {
    functions,
    exchangeRate
} from "../../../../../../../resources/js/mixins/functions";
import { calculateRowItem } from "../../../../../../../resources/js/helpers/functions";
// calculateRowItem,

//import PaymentForm from "./partials/payment.vue";
// import ItemForm from "./partials/form.vue";

//import ItemForm from "../../../../../../../resources/js/views/items/form.vue";
import queryString from "query-string";

//import PersonForm from "../../../../../../../resources/js/views/persons/form.vue";
//import NumberPad from "./partials/num_pad.vue";
//import ListOrden from "./partials/list_ordens.vue";
//import WarehousesDetail from "../../../../../../../resources/js/views/items/partials/warehouses.vue";
//import Tables from "./partials/tables.vue";
//import CashHistory from "./partials/cash_history.vue";
//import DocumentsPrint from "./partials/documents_print.vue";
const DispatchModal = () => import("./partials/dispatch_modal.vue");

const PaymentForm = () => import("./partials/payment.vue");
const ItemForm = () =>
    import("../../../../../../../resources/js/views/items/form.vue");
const PersonForm = () =>
    import("../../../../../../../resources/js/views/persons/form.vue");
const NumberPad = () => import("./partials/num_pad.vue");
const WarehousesDetail = () =>
    import(
        "../../../../../../../resources/js/views/items/partials/warehouses.vue"
    );
const Tables = () => import("./partials/tables.vue");
const CashHistory = () => import("./partials/cash_history.vue");
const DocumentsPrint = () => import("./partials/documents_print.vue");
const PromotionCanje = () =>
    import(
        /* webpackChunkName:"js/promotionscanje"*/ "./partials/promotionscanje.vue"
    );
const EditProduct = () => import("./partials/edit_product.vue");
const ListOrden = () => import("./partials/list_ordens.vue");
const ListFoodMobiles = () => import("./partials/list_food_mobiles.vue");
const College = () => import("./partials/college.vue");
const CreditsList = () => import("./partials/credits_list.vue");
const ConsignmentList = () => import("./partials/consignment_list_modal.vue");
const CollegeParents = () =>
    import(
        "../../../../../../College/Resources/assets/js/views/persons/form.vue"
    );
const CategoryDrag = () => import("./partials/category_drag.vue");
const ProductsDue = () => import("./partials/products_due.vue");
const ItemSet = () =>
    import("../../../../../../../resources/js/views/item_sets/form.vue");
const options = {
    text: "Loading ...",
    customClass: "login_loading",
    spinner: "el-icon-loading",
    lock: true
};
export default {
    props: [
        "pending_order",
        "cash_id",
        "worker",
        "configuration",
        "establishments",
        "auth_login",
        "desarrollador",
        "company",
        "area_id",
        "area"
    ],
    components: {
        ItemSet,
        ProductsDue,
        ConsignmentList,
        EditProduct,
        CategoryDrag,
        CreditsList,
        DispatchModal,
        CollegeParents,
        College,
        CashHistory,
        DocumentsPrint,
        NumberPad,
        PaymentForm,
        ItemForm,
        PersonForm,
        WarehousesDetail,
        DrawerOrdens,
        ListFood,
        ListOrden,
        Tables,
        ListFoodMobiles,
        PromotionCanje
    },
    mixins: [functions, exchangeRate],

    data() {
        return {
            showDialogItemSet: false,
            products_to_due: 0,
            showDialogDueProducts: false,
            type_code: false,
            ordens_all_table: false,
            consignment_id: null,
            isConsignment: false,
            showDialogConsignment: false,
            establishmentId: this.worker.establishment_id,
            input_itemMobil: "",
            showcustomModal: false,
            printer: null,
            showDailyCashLoading: false,
            pin: "",
            showPinRequest: false,
            showEditProduct: false,
            showCategoryDrag: false,
            showCredits: false,
            showDispatch: false,
            areas: [],
            conf: {},
            showDialogCollege: false,
            barcode: false,
            sender: null,
            socket: null,
            variation: false,
            showDocumentsPrint: false,
            cashId: null,
            formVariation: {},
            ordensPending: 0,
            isCreatingOrden: false,
            table: {},
            tableSelectedNumber: null,
            clientTableData: {},
            tactil: false,
            showTables: false,
            showHistoryCash: false,
            itemDefault: null,
            optionsMenu: [],
            time: null,
            blockCart: false,
            pagination: {},
            category: null,
            allSelected: false,
            selected: [],
            allFoods: [],
            listFoods: [],
            idOrden: null,
            listar_tables: [],
            ordensItems: [],
            newFood: null,
            paraLlevar: false,
            editProd: false,
            localOrden: [],
            type_search: "Descripcion",
            selectOption: null,
            tableSelect: {},
            OrdenLength: 0,
            selecttables: 0,
            categories: [],
            ordenId: null,
            name_product_pdf: null,
            ordens: [],
            listtables: [],
            value: null,
            payments: [],
            slickOptions: {
                slidesToShow: 3
                // Any other options that can be got from plugin documentation
            },
            category_selected: 0,
            history_item_id: null,
            date_last: null,
            search_item_by_barcode: false,
            warehousesDetail: [],
            unittypeDetail: [],
            input_person: {},
            showDialogHistoryPurchases: false,
            showDialogHistorySales: false,
            showDialogNewPerson: false,
            showDialogNewItem: false,
            showDialogViewItems: false,
            loading: true,
            colors: ["#1cb973", "#bf7ae6", "#fc6304", "#9b4db4", "#77c1f3"],
            buscar_por: 1,
            userId: null,
            place: false,
            is_payment: false,
            // is_payment: true,//aq
            showWarehousesDetail: false,
            resource: "pos",
            recordId: null,
            input_item: "",
            items: [],
            all_items: [],
            all_series: [],
            customers: [],
            affectation_igv_types: [],
            all_customers: [],
            establishment: null,
            currency_type: {},
            form_item: {},
            customer: {},
            row: {},
            user: {},
            form: {},
            document_type_id: null,
            last_date: null,
            direct_printing: 0,
            customer_default: {},
            customer_variation: null,
            isAllSelected: false,
            selectedCatIds: [],
            foodItem: 0,
            disableCantidad: false,
            total_sales_pos: 0,
            percentage_igv: null,
            orden_items: [],
            documentsType: [],
            personalWhatsapp: false,
            config: {},
            screenWidth: 0,
            showdialogPromocion: false
        };
    },

    async created() {
        localStorage.setItem("quotation_stock", 0);
        let type_code = localStorage.getItem("type_code");
        let barcode = localStorage.getItem("barcode");
        if (barcode) {
            this.barcode = barcode == "1" ? true : false;
        }
        if (type_code) {
            this.type_code = type_code == "1" ? true : false;
        }
        // console.log(this.establishments, " xdl");
        this.conf = this.establishments.conf ?? {};
        this.cashId = this.cash_id;
        this.ordensPending = this.pending_order;
        this.loading = true;
        this.socketWhatsappConfig();
        this.getPrinter();
        await this.getTables();
        await this.getSeries();
        await this.initForm(this.customer_default.id);
        await this.getFoods();
        await this.filterCategorie(0, false);
        this.setMenuOptions();
        // await this.changeCustomer();
        this.loading = false;
        this.$eventHub.$on("reloadDataPersons", customer_id => {
            this.reloadDataCustomers(customer_id);
        });
        this.$eventHub.$on("reloadDataItems", _ => {
            this.getFoods();
        });
        let form_data = {
            establishment_id: this.establishment.id,
            date: moment().format("YYYY-MM-DD")
        };
        const response = await this.$http.post("/get_igv", form_data);
        this.percentage_igv = response.data ?? 18;
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
    },
    sockets: {},
    computed: {},
    methods: {
        setMenuOptions() {
            this.optionsMenu = [
                {
                    id: 1,
                    title: ["Reimprimir"],
                    icon: "fas fa-print ",
                    visible: true
                },
                /* {
                    id: 2,
                    title: ["Abrir", "cajon"],
                    icon: "fas fa-cash-register",
                    visible: true
                }, */
                // {
                //     id: 3,
                //     title: ["Reabrir", "tickets"],
                //     icon: "fas fa-folder-open",
                //     visible: true
                // },
                {
                    id: 3,
                    title: ["Productos"],
                    icon: "fas fa-box-open",
                    visible: true
                },
                {
                    id: 4,
                    title: ["Clientes"],
                    //icon: "fas fa-hand-holding-water"
                    icon: "fas fa-user ",
                    visible: true
                },
                {
                    id: 5,
                    title: [" Zona "],
                    icon: "fas fa-map-pin ",
                    visible:
                        this.configuration.restaurant &&
                        !this.configuration.college
                },
                {
                    id: 6,
                    title: ["Venta", "del Dia"],
                    icon: "icofont-money-bag",
                    visible:
                        this.configuration.view_daily_cash ||
                        this.configuration.view_daily_cash_pin
                },

                {
                    id: 7,
                    title: ["Historial", ""],
                    icon: "fas fa-history ",
                    visible: true
                },

                {
                    id: 9,
                    title: ["Matriculas", "Mensualidades"],
                    icon: "fas fa-user-edit",
                    visible: this.configuration.college
                },
                {
                    id: 10,
                    title: ["Canjear", "Promocion"],
                    icon: "fas fa-user-tag",
                    visible: this.configuration.promotions_sell
                },
                {
                    id: 33,
                    title: ["Créditos"],
                    icon: "fas fa-credit-card",
                    visible: this.configuration.credits
                },
                {
                    id: 25,
                    title: ["Guías", "Remisión"],
                    icon: "fas fa-file",
                    visible: this.configuration.dispatch
                },
                {
                    id: 102,
                    title: ["Cambiar", "Categorías"],
                    icon: "fa fa-bars",
                    visible: this.configuration.pos_drag_category
                },
                {
                    id: 103,
                    title: ["Editar", "Productos"],
                    icon: "fa fa-edit",
                    visible: this.configuration.edit_product_pos
                },
                {
                    id: 109,
                    title: ["Ver", "Consignaciones"],
                    icon: "fa fa-edit",
                    visible: this.configuration.consignment
                },
                {
                    id: 42,
                    title: ["Productos", "Por vencer", this.products_to_due],
                    icon: "far fa-calendar-alt",
                    visible: this.configuration.items_due_caja
                },
                {
                    id: 32,
                    title: ["Crear", "Producto compuesto"],
                    icon: "el-icon-connection",
                    visible: this.configuration.item_set_caja
                }

                // {
                //     title: ["Configuración"],
                //     icon: "fas fa-printer"
                // },
                // {
                //     title: ["Movimiento ", "efectivo"],
                //     icon: "fas fa-printer"
                // },
                // {
                //     title: ["Abrir / Cerrar", " Caja"],
                //     icon: "fas fa-printer"
                // }
            ];
        },
        formatDescriptionType(type) {
            let price = this.getDefaultPrice(type);
            return `${type.description} (${Number(
                type.quantity_unit
            )}) - S/ ${price}`;
        },
        saveInLocalStorageBarcode(barcode) {
            localStorage.setItem("barcode", barcode ? "1" : "0");
        },
        saveInLocalStorage(type_code) {
            localStorage.setItem("type_code", type_code ? "1" : "0");
        },
        clickCommand(type) {
            let idxFood = this.listFoods.findIndex(
                food => food.item.id == type.item_id
            );
            if (idxFood >= 0) {
                this.addFood(idxFood, type);
            }
        },
        formatedStockPresentation(
            {
                max_quantity,
                item_unit_types,
                max_quantity_description,
                unit_type
            },
            stock
        ) {
            // let item_unit = item_unit_types.find(
            //     i => Number(i.quantity_unit) == Number(max_quantity)
            // );
            // let general = 0;
            // if (item_unit) {
            //     general = Math.trunc(stock / max_quantity);
            // } else {
            //     general = stock / max_quantity;
            // }
            // let part = ((stock / max_quantity) % 1).toFixed(2);
            // let part_general = general.toString().split(".");

            // if (part_general.length > 1 && part_general[1].length > 2) {
            //     general = general.toFixed(2);
            // }
            // let text = `${general} ${unit_type.id}`;
            // if (part != 0) {
            //     if (item_unit) {
            //         text += ` ${part * max_quantity} ${item_unit.unit_type.id}`;
            //     } else {
            //         text = `${general} ${max_quantity_description ||
            //             unit_type.id}`;
            //     }
            // } else {
            //     text = `${general} ${max_quantity_description || unit_type.id}`;
            // }

            // return text;
            let general = Math.trunc(stock / max_quantity);
            let part = ((stock / max_quantity) % 1).toFixed(2);

            let text = `${general} ${unit_type.id}`;
            if (part != 0) {
                let item_unit = item_unit_types.find(
                    i => Number(i.quantity_unit) == Number(max_quantity)
                );
                let part = (stock / max_quantity) % 1;
                if (item_unit) {
                    let new_part = part * max_quantity;
                    new_part = new_part.toFixed(2);
                    text += ` ${new_part} ${item_unit.unit_type.id}`;
                }
                if (max_quantity && max_quantity_description) {
                    text = `${general} ${max_quantity_description}`;
                    let new_part = part * max_quantity;
                    new_part = new_part.toFixed(2);
                    text += ` ${new_part} ${unit_type.id}`;
                }
            } else {
                if (max_quantity && max_quantity_description) {
                    text = `${general} ${max_quantity_description}`;
                }
            }

            return text;
        },
        handleKeydown(event) {
            let { keyCode, key } = event;
            switch (keyCode) {
                case 113:
                    event.preventDefault(); // Evita la función por defecto del navegador

                    if (this.configuration.restaurant) {
                        this.openTables();
                    }

                    break;

                default:
                    break;
            }
        },
        setItemsToLiquidate(items, consignment_id) {
            this.consignment_id = consignment_id;
            this.localOrden = items;
            this.isConsignment = true;
            this.$refs.list_orden.setConsignment(consignment_id);
        },
        removeConsignment() {
            this.isConsignment = false;
            if (this.$refs.list_orden) {
                this.$refs.list_orden.removeConsignment();
            }
        },
        async getPrinter() {
            const response = await this.$http.get(
                `/caja/worker/cash/get_printer/${this.area_id}`
            );
            if (response.status == 200) {
                const { printer } = response.data;

                this.printer = printer;
            }
        },

        generatePin(num) {
            if (this.pin.length == 4) {
                return;
            }
            this.pin += num;
        },
        async checkPin() {
            const response = await this.$http.post("check_pin", {
                pin: this.pin
            });
            if (response.status == 200) {
                const { success, message } = response.data;
                if (success) {
                    this.showPinRequest = false;
                    this.view_modal();
                } else {
                    this.$message.error(message);
                }
            }
        },
        openDistach() {
            this.showDispatch = true;
        },
        resetOrden() {
            this.ordenId = null;
            this.idOrden = null;
        },
        openCollege() {
            this.showDialogCollege = true;
        },
        changeCategory(category) {
            console.log(
                `cambiando la categoria de ${this.category} a ${category}`
            );
            //change;
        },

        receiveData(data) {
            this.search_items(data);
        },
        chlidMetod(data) {
            console.log(data);
        },
        searchFromMobil(data) {
            console.log(data);
        },
        handleResize() {
            this.screenWidth = window.innerWidth;
        },
        showMessage(text, duration = 6000) {
            this.$message({
                message: text,
                duration,
                type: "success"
            });
        },
        socketWhatsappConfig() {
            let hostName = window.location.hostname;
            let url = `https://${hostName}`;
            this.sender = hostName
                .replace(/https?\:\/\//, "")
                .replace("/", "")
                .split(".")
                .join("");
            try {
                this.socket = io.connect(this.$socketUrl);
            } catch (e) {
                console.log(e);
            }
            this.socket.on("ready", message => {
                this.showMessage(message);
            });
            this.socket.on("authenticated", ({ message, sender }) => {
                this.sender = sender;
                this.showMessage(message);
            });
            this.socket.on("connected", ({ message }) => {
                this.$toast.success(message, { icon: "fab fa-whatsapp fa-2x" });
                console.log("La url ", url);
                this.socket.emit("getStatus", url);
            });
            this.socket.on("setStatus", ({ status, sender }) => {
                if (!status) {
                    this.$toast.warning("Sesión iniciada con SDRIMSAC", {
                        icon: "fab fa-whatsapp fa-2x"
                    });
                } else {
                    this.sender = sender;
                    this.personalWhatsapp = true;
                    this.$toast.success("Whatsapp Listo!");
                }
            });
            //MessageResponse
            this.socket.on("MessageResponse", ({ success, message }) => {
                if (success) {
                    this.$message.success(message);
                } else {
                    this.$message.error(message);
                }
            });
        },

        async getFile({ total, documentId, documentTypeId, number, message }) {
            try {
                const response = await this.$http.post(
                    "/whatsapp/get-file",

                    {
                        document_id: documentId,
                        document_type_id: documentTypeId
                    }
                );
                const { pdf, xml, name } = response.data;
                let basicMessage =
                    "Su comprobante de pago electrónico " +
                    name +
                    "por " +
                    total +
                    " de *" +
                    this.establishments.description +
                    "*, ha sido generado correctamente a través del facturador electrónico de " +
                    "*" +
                    this.$desarrollador +
                    "*";
                if (message) {
                    basicMessage += "\n" + message;
                }
                this.socket.emit("basicMessage", {
                    message: basicMessage,
                    sender: this.sender,
                    number: `51${number}`
                });

                // file, name, number, sender }
                this.socket.emit("sendFile", {
                    file: pdf,
                    name: `${name}.pdf`,
                    number: `51${number}`,
                    sender: this.sender
                });

                if (xml) {
                    this.socket.emit("sendFile", {
                        file: xml,
                        name: `${name}.xml`,
                        number: `51${number}`,
                        sender: this.sender
                    });
                }
            } catch (e) {
                let msg = "Ocurrió un error";
                if (e.response) {
                    const { response } = e;
                    if (response.status == 404) {
                        msg = "No se encontró la ruta";
                    } else {
                        msg = response.data.message;
                    }
                }
                console.log(msg);
                this.$message.error(msg);
                console.log(e);
            } finally {
                this.limpiarForm();
            }
        },
        creatingOrden(number, id) {
            this.isCreatingOrden = true;
            this.clientTableData = {
                ref: undefined,
                table: number,
                table_id: id
            };
        },
        async setPaymentOrden(items) {
            let form = {
                id: null,
                caja: true,
                printDocument: false,
                printing: this.configuration.print_commands,
                commands_fisico: false,
                print_kitchen: this.configuration.print_kitchen,
                to_carry: false,
                orden: {
                    table_id: 1,
                    status_orden_id: 1
                },
                pin: null,
                items
            };
            this.orden_items = form;
            this.form.printDocument = form.printDocument;
            // let { items } = form;
            this.ordens = items;
            for (let i = 0; i < items.length; i++) {
                let item = items[i];
                this.ordens[i].food.item.from_unit_type_id = item.type_id;
                this.ordens[i].food.item.from_unit_type_id_desc =
                    item.type_description;

                this.ordens[i].food.item.quantity = item.quantity;
                this.ordens[i].food.item.lotes = item.lotes;
                this.ordens[i].food.item.lots = item.series;
                this.ordens[i].food.item.sale_unit_price = item.price;
                this.ordens[i].food.price = item.price;
                // this.ordens[i].food.item.price = item.price;
                this.ordens[i].food.item.toWarehouse = item.toWarehouse;
                this.ordens[i].food.item.consignment_item_id =
                    item.consignment_item_id;
            }
            this.form.items = this.ordens.map(o => o.food.item);
            this.formatItems();
            this.calculateTotal();
            this.form.enter_amount = this.form.total;
            this.form.difference = 0;
            let flag = 0;
            this.form.establishment_id = this.establishment.id;
            if (!this.form.customer_id) {
                let varios = this.all_customers.filter(a =>
                    a.name.toLowerCase().includes("varios")
                );
                if (varios.length == 0) {
                    this.form.customer_id = this.all_customers[0].id;
                } else {
                    this.form.customer_id = varios[0].id;
                }
                if (!this.form.customer_id) {
                    this.is_payment = false;
                    return this.$toast.error("Seleccione un cliente");
                }
            }
            this.is_payment = true;
        },
        sendOrdensAllTables(orden_items) {
            this.clientTableData = {
                table: "Todas",
                ref: "-"
                // table_id: orden.mesa.id,
                // orden_id: orden.id
            };

            // orden.type_id = type ? type.id : null;
            //  orden.type_description = type ? type.description : null;
            // orden.type_quantity = type ? Number(type.quantity_unit) : 0;
            this.ordensItems = [
                ...orden_items.map(o => {
                    let orden = o;
                    orden.price = Number(orden.price).toFixed(2);
                    if (orden.unit_type_id) {
                        let { item } = orden.food;

                        let unit_type = item.item_unit_types.find(
                            u => u.id == orden.unit_type_id
                        );
                        if (unit_type) {
                            orden.type_id = unit_type.id;
                            orden.type_description = unit_type.description;
                            orden.type_quantity = Number(
                                unit_type.quantity_unit
                            );
                        }
                    }
                    return {
                        ...orden,
                        sended: true
                    };
                })
            ];
            this.blockCart = true;
            this.isCreatingOrden = false;
            this.ordens_all_table = true;
            this.setPaymentOrden(orden_items);
            // this.idOrden = orden.id;
        },
        //aqui se envia los productos desde la mesa
        sendOrdens(orden) {
            if (this.localOrden.length != 0 && !this.configuration.box_orden) {
                this.$toast.warning("Tiene productos seleccionados.");
                return;
            }
            this.clientTableData = {
                table: orden.mesa.number,
                ref: orden.ref ?? "-",
                table_id: orden.mesa.id,
                orden_id: orden.id
            };

            // orden.type_id = type ? type.id : null;
            //  orden.type_description = type ? type.description : null;
            // orden.type_quantity = type ? Number(type.quantity_unit) : 0;
            this.ordensItems = [
                ...orden.orden_items.map(o => {
                    let orden = o;
                    orden.price = Number(orden.price).toFixed(2);
                    if (orden.unit_type_id) {
                        let { item } = orden.food;

                        let unit_type = item.item_unit_types.find(
                            u => u.id == orden.unit_type_id
                        );
                        if (unit_type) {
                            orden.type_id = unit_type.id;
                            orden.type_description = unit_type.description;
                            orden.type_quantity = Number(
                                unit_type.quantity_unit
                            );
                        }
                    }
                    return {
                        ...orden,
                        sended: true
                    };
                })
            ];
            this.blockCart = true;
            this.isCreatingOrden = false;
            this.idOrden = orden.id;
        },
        async rePrint() {
            try {
                const response = await this.$http(`print_last_document`);
                const { data } = response;
                if (!data.success) {
                    this.$toast.error("No se pudo imprimir");
                }
            } catch (e) {
                this.$toast.error("No se pudo imprimir");
            }
        },
        trigerFunction(id) {
            switch (id) {
                case 32:
                    this.showDialogItemSet = true;
                    break;
                case 42:
                    this.showDialogDueProducts = true;
                    break;
                case 109:
                    this.showDialogConsignment = true;
                    break;
                case 1:
                    this.showDocumentsPrint = true;
                    //this.rePrint();
                    break;
                case 5:
                    this.openTables();
                    break;
                case 6:
                    if (this.configuration.view_daily_cash_pin) {
                        this.showPinRequest = true;
                    } else {
                        this.view_modal();
                    }
                    break;
                case 7:
                    this.showHistory();
                    break;
                case 3:
                    this.showDialogNewItem = true;
                    break;
                case 4:
                    this.showDialogNewPerson = true;
                    break;
                case 8:
                    this.openviewsItemsMobil();
                    break;
                case 9:
                    this.openCollege();
                    break;
                case 10:
                    this.openPromocion();
                    break;
                case 33:
                    this.openCredit();
                    break;
                case 25:
                    this.openDistach();
                    break;
                case 102:
                    this.category = null;
                    this.search_items(null);
                    this.showCategoryDrag = true;
                    break;
                case 103:
                    this.showEditProduct = true;
                    break;
                default:
                    break;
            }
        },
        showHistory() {
            this.showHistoryCash = true;
        },
        openCredit() {
            this.showCredits = true;
        },
        openTables() {
            this.showTables = true;
        },
        openviewsItemsMobil() {
            this.showDialogViewItems = true;
        },
        cancelOrden() {
            this.isConsignment = false;
            this.localOrden = [];
            this.ordensItems = [];
            this.clientTableData = {};
            this.isCreatingOrden = false;
            this.idOrden = undefined;
        },
        async changePage(page) {
            this.pagination.current_page = page;
            await this.search_items();
        },
        async openDrawer() {
            let elementDrawer = document.querySelector("#drawer");
            if (elementDrawer != undefined) {
                elementDrawer.click();
            }
        },
        selectAllCats() {
            if (this.isAllSelected) {
                this.selectedCatIds = [];
                this.isAllSelected = false;
            } else {
                this.selectedCatIds = [];
                for (let cat = 0; cat < this.tableSelect.ordens.length; cat++) {
                    for (
                        let index = 0;
                        index < this.tableSelect.ordens[cat].orden_items.length;
                        index++
                    ) {
                        this.selectedCatIds.push(
                            this.tableSelect.ordens[cat].orden_items[index].id
                        );
                        this.foodItem = this.foodItem + 1;
                    }
                }
                this.isAllSelected = true;
            }
        },
        buscarnuevo() {
            this.$refs.input_items.$el.getElementsByTagName("input")[0].focus();
            this.$refs.input_items.$el.getElementsByTagName("input")[0].value =
                "";
        },
        add_customer(value) {
            this.value = value;
            this.form.customer_id = this.value;
        },
        forma(i) {
            return {
                ...i,
                item: i,
                item_id: i.id,
                unit_value:
                    i.sale_affectation_igv_type_id == 10
                        ? i.sale_unit_price / (1 + this.percentage_igv / 100)
                        : i.sale_unit_price,
                quantity: i.quantity,
                aux_quantity: i.quantity,
                total_base_igv:
                    i.sale_affectation_igv_type_id == 10
                        ? (i.sale_unit_price * i.quantity) /
                          (1 + this.percentage_igv / 100)
                        : i.sale_unit_price * i.quantity,
                percentage_igv: this.percentage_igv,
                total_igv:
                    i.sale_affectation_igv_type_id == 10
                        ? ((i.sale_unit_price * i.quantity) /
                              (1 + this.percentage_igv / 100)) *
                          (this.percentage_igv / 100)
                        : 0,
                total_base_isc: 0.0,
                percentage_isc: 0.0,
                total_isc: 0.0,
                total_base_other_taxes: 0.0,
                percentage_other_taxes: 0.0,
                total_other_taxes: 0.0,
                total_taxes:
                    i.sale_affectation_igv_type_id == 10
                        ? ((i.sale_unit_price * i.quantity) /
                              (1 + this.percentage_igv / 100)) *
                          (this.percentage_igv / 100)
                        : 0,
                total_value:
                    i.sale_affectation_igv_type_id == 10
                        ? (i.sale_unit_price * i.quantity) /
                          (1 + this.percentage_igv / 100)
                        : i.quantity * i.sale_unit_price,
                total_charge: 0.0,
                total_discount: 0.0,
                total: i.sale_unit_price * i.quantity,
                price_type_id: "01",
                unit_price: i.sale_unit_price,
                unit_price_value: i.sale_unit_price,
                has_igv: i.has_igv,
                affectation_igv_type_id: i.sale_affectation_igv_type_id,
                unit_price: i.sale_unit_price,
                presentation: null,
                charges: [],
                discounts: [],
                attributes: [],
                affectation_igv_type: i.sale_affectation_igv_type_id
            };
        },
        async paymentsOrden(form, variationItem = []) {
            this.orden_items = form;
            this.form.printDocument = form.printDocument;
            let { items } = form;
            this.ordens = items;
            for (let i = 0; i < items.length; i++) {
                let item = items[i];
                this.ordens[i].food.item.from_unit_type_id = item.type_id;
                this.ordens[i].food.item.from_unit_type_id_desc =
                    item.type_description;

                this.ordens[i].food.item.quantity = item.quantity;
                this.ordens[i].food.item.lotes = item.lotes;
                this.ordens[i].food.item.lots = item.series;
                this.ordens[i].food.item.sale_unit_price = item.price;
                this.ordens[i].food.price = item.price;
                // this.ordens[i].food.item.price = item.price;
                this.ordens[i].food.item.toWarehouse = item.toWarehouse;
                this.ordens[i].food.item.consignment_item_id =
                    item.consignment_item_id;
            }
            if (variationItem.length > 0) {
                this.variation = true;
                this.formVariation.items = [
                    ...variationItem.map(o => this.formatVariation(o))
                ];
                this.formVariation.enter_amount = variationItem.reduce(
                    (a, b) => a + b.sale_unit_price * b.quantity,
                    0
                );
                this.formVariation.difference = 0;
                this.formVariation.total = this.formVariation.enter_amount;
                this.formVariation.establishment_id = this.establishment.id;
                if (!this.formVariation.customer_id) {
                    let varios = this.all_customers.filter(a =>
                        a.name.toLowerCase().includes("varios")
                    );
                    if (varios.length == 0) {
                        this.formVariation.customer_id = this.all_customers[0].id;
                    } else {
                        this.formVariation.customer_id = varios[0].id;
                    }
                }

                this.calculateTotalVariation(this.formVariation);
            }
            this.form.items = this.ordens.map(o => o.food.item);
            this.formatItems();
            this.calculateTotal();
            this.form.enter_amount = this.form.total;
            this.form.difference = 0;
            let flag = 0;
            this.form.establishment_id = this.establishment.id;
            if (!this.form.customer_id) {
                let varios = this.all_customers.filter(a =>
                    a.name.toLowerCase().includes("varios")
                );
                if (varios.length == 0) {
                    this.form.customer_id = this.all_customers[0].id;
                } else {
                    this.form.customer_id = varios[0].id;
                }
                if (!this.form.customer_id) {
                    this.is_payment = false;
                    return this.$toast.error("Seleccione un cliente");
                }
            } else {
                if (variationItem.length > 0) {
                    let tmpchange = this.formVariation;
                    let tmpchange2 = this.form;

                    this.form = tmpchange;
                    this.formVariation = tmpchange2;
                    this.form.variation = true;
                }
                if (this.variation) {
                    this.isNoteIsDefault();
                }
                console.log(this.form.items);
                this.is_payment = true;
            }
        },
        formatVariation(i) {
            return {
                ...i,
                item: i,
                item_id: i.id,
                unit_value:
                    i.sale_affectation_igv_type_id == 10
                        ? i.sale_unit_price / (1 + this.percentage_igv / 100)
                        : i.sale_unit_price,
                quantity: i.quantity,
                aux_quantity: i.quantity,
                total_base_igv:
                    i.sale_affectation_igv_type_id == 10
                        ? (i.sale_unit_price * i.quantity) /
                          (1 + this.percentage_igv / 100)
                        : i.sale_unit_price * i.quantity,
                percentage_igv: this.percentage_igv,
                total_igv:
                    i.sale_affectation_igv_type_id == 10
                        ? ((i.sale_unit_price * i.quantity) /
                              (1 + this.percentage_igv / 100)) *
                          (this.percentage_igv / 100)
                        : 0,
                total_base_isc: 0.0,
                percentage_isc: 0.0,
                total_isc: 0.0,
                total_base_other_taxes: 0.0,
                percentage_other_taxes: 0.0,
                total_other_taxes: 0.0,
                total_taxes:
                    i.sale_affectation_igv_type_id == 10
                        ? ((i.sale_unit_price * i.quantity) /
                              (1 + this.percentage_igv / 100)) *
                          (this.percentage_igv / 100)
                        : 0,
                total_value:
                    i.sale_affectation_igv_type_id == 10
                        ? (i.sale_unit_price * i.quantity) /
                          (1 + this.percentage_igv / 100)
                        : i.quantity * i.sale_unit_price,
                total_charge: 0.0,
                total_discount: 0.0,
                total: i.sale_unit_price * i.quantity,
                price_type_id: "01",
                unit_price: i.sale_unit_price,
                unit_price_value: i.sale_unit_price,
                has_igv: i.has_igv,
                affectation_igv_type_id: i.sale_affectation_igv_type_id,
                unit_price: i.sale_unit_price,
                presentation: null,
                charges: [],
                discounts: [],
                attributes: [],
                affectation_igv_type: i.sale_affectation_igv_type_id
            };
        },

        select(id) {
            if (this.selectedCatIds.length + 1 == this.foodItem) {
                this.isAllSelected = true;
            } else {
                this.isAllSelected = false;
            }
        },
        deletedFood(idx) {
            this.localOrden.splice(idx, 1);
            this.calculateTotal();
        },
        getDefaultPrice(type) {
            let listPricesDescription = ["price1", "price2", "price3"];
            let currentPriceIndx =
                listPricesDescription[type.price_default - 1];
            let price = type[currentPriceIndx];
            if (type.total == null) {
                this.$toast.error(
                    "Politica de precio sin total: Tomando precio unitario.."
                );
            } else {
                price = Number(type.total);
            }
            return price;
        },
        insertOrden(orden, food_id, type) {
            //esto ya no me puede traer solo uno
            //ya que podré agregar más de una vez un producto
            // let ordenAdded = _.filter(this.localOrden, {
            //     id: food_id
            // });
            let ordenAdded = this.localOrden.filter(ord => ord.id == food_id);

            //si el producto no existe en el listado en ninguna presentacion

            if (ordenAdded.length == 0) {
                orden.to_carry = false;
                orden.change_subtotal = false;
                orden.series = [];
                orden.lotes = [];
                let added = false;
                let {
                    food: {
                        item: { lots_group }
                    }
                } = orden;

                if (lots_group.length != 0) {
                    for (let i = 0; i < lots_group.length; i++) {
                        let lot = lots_group[i];
                        if (lot.quantity > 0 && !added) {
                            orden.lotes = [
                                {
                                    ...lot,
                                    quantitySelected: 1
                                }
                            ];
                            added = true;
                        } else {
                            orden.lotes = [
                                ...orden.lotes,
                                { ...lot, quantitySelected: 0 }
                            ];
                        }
                    }
                }

                orden.type_id = type ? type.id : null;
                orden.type_description = type ? type.description : null;
                orden.type_quantity = type ? Number(type.quantity_unit) : 0;
                //si es el primer registro del prod en la lista

                if (type) {
                    // orden.quantity = Number(type.quantity_unit);
                    orden.quantity = orden.food.item.series_enabled ? 0 : 1;
                    orden.price = this.getDefaultPrice(type);
                }
                this.localOrden.unshift(orden);
            }
            //aca existe en original o en alguna  presentación
            else {
                //si la orden agregada es una presentación

                if (type != null) {
                    //si es, verificar si ya existe esa presentación en la lista
                    let indexFind = this.localOrden.findIndex(
                        orden => orden.type_id == type.id
                    );
                    if (indexFind != -1) {
                        this.localOrden[indexFind].quantity =
                            Number(this.localOrden[indexFind].quantity) + 1;
                        // Number(type.quantity_unit);
                    } else {
                        // orden.quantity = Number(type.quantity_unit);
                        orden.quantity = orden.food.item.series_enabled ? 0 : 1;
                        orden.price = this.getDefaultPrice(type);
                        orden.type_id = type.id;
                        orden.type_description = type.description;
                        orden.to_carry = false;
                        orden.change_subtotal = false;
                        orden.series = [];
                        orden.lotes = [];
                        let {
                            food: {
                                item: { lots_group }
                            }
                        } = orden;
                        if (lots_group.length != 0) {
                            for (let i = 0; i < lots_group.length; i++) {
                                let lot = lots_group[i];
                                if (lot.quantity > 0) {
                                    orden.lotes = [
                                        {
                                            ...lot,
                                            quantitySelected: 1
                                        }
                                    ];
                                    break;
                                }
                            }
                        }
                        orden.type_quantity = type
                            ? Number(type.quantity_unit)
                            : 0;
                        this.localOrden.unshift(orden);
                    }

                    //y si no agregarla como nueva
                } else {
                    //si es original, seguir agregando uno
                    let indexFind = this.localOrden.findIndex(
                        p => p.id == food_id && p.type_id == null
                    );
                    if (indexFind != -1) {
                        //actualizamos el elemento que agregamos, pero lo sacamos del objeot y lo volvemos a colocar de primero, de esta manera podemos saber si ya esta el producto que estamos agregando a la lista y saber cuanto tenemos en total
                        this.localOrden[indexFind].quantity =
                            Number(this.localOrden[indexFind].quantity) + 1;
                        let itemAwait = this.localOrden[indexFind];
                        this.localOrden.splice(indexFind, 1);
                        this.localOrden.unshift(itemAwait);
                    } else {
                        orden.to_carry = false;
                        orden.change_subtotal = false;
                        orden.series = [];
                        orden.lotes = [];
                        this.localOrden.unshift(orden);
                    }
                }

                this.localOrden = [...this.localOrden];
            }
            this.$refs.ordenRef.calculateTotal();
        },
        total_sales(val) {
            this.total_sales_pos = val;
        },
        async ordenCancel(id) {
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
                    const response = await this.$http.delete(
                        `delete-orden/${id}`
                    );
                    if (response.status == 200) {
                        const { message } = response.data;
                        this.$toast.success(message);
                    }
                }
            } catch (e) {
                //todo

                if (e != "cancel") {
                    this.$toast.error("Ocurrió un error");
                }
            }
        },

        async status_orden_id(status) {
            try {
                if (status == 0) {
                    let res = await this.$confirm(
                        "Desea cancelar los pedidos seleccionados?",
                        "Cancelar",
                        {
                            confirmButtonText: "Aceptar",
                            cancelButtonText: "Cancelar",
                            type: "warning"
                        }
                    );
                    if (res) {
                        for (
                            let index = 0;
                            index < this.selectedCatIds.length;
                            index++
                        ) {
                            const response = await this.$http.delete(
                                `worker/delete-orden/${this.selectedCatIds[index]}`
                            );
                            if (response.status == 200) {
                                const { message } = response.data;
                                this.$toast.success(message);
                            }
                        }

                        for (
                            let cat = 0;
                            cat < this.tableSelect.ordens.length;
                            cat++
                        ) {
                            for (
                                let indexxx = 0;
                                indexxx <
                                this.tableSelect.ordens[cat].orden_items.length;
                                indexxx++
                            ) {
                                let idOrden = this.tableSelect.ordens[cat]
                                    .orden_items[indexxx].id;
                                for (
                                    let index = 0;
                                    index < this.selectedCatIds.length;
                                    index++
                                ) {
                                    if (this.selectedCatIds[index] == idOrden) {
                                        this.selectedCatIds.splice(index, 1);
                                        this.tableSelect.ordens[
                                            cat
                                        ].orden_items[
                                            indexxx
                                        ].status_orden_id = status;
                                    }
                                }
                            }
                        }
                        const response = await this.$http.get(
                            `/caja/worker/ordens-status`
                        );
                        if (response.status == 200) {
                            let Ordens = response.data.ordens;
                            for (
                                let index = 0;
                                index < this.tableSelect.ordens.length;
                                index++
                            ) {
                                let Ord = _.find(Ordens, {
                                    id: this.tableSelect.ordens[index].id
                                });
                                if (Ord == undefined) {
                                    this.tableSelect.ordens[
                                        index
                                    ].status_id = 0;
                                }
                            }
                        }
                    }

                    //todo

                    if (e != "cancel") {
                        this.$toast.error("Ocurrió un error");
                    }
                } else {
                    if (status == 3) {
                        for (
                            let index = 0;
                            index < this.selectedCatIds.length;
                            index++
                        ) {
                            const response = await this.$http.get(
                                `/caja/worker/ordens-ready/` +
                                    this.selectedCatIds[index]
                            );
                            if (response.data.success == true) {
                                this.$toast.success(response.data.message);
                            }
                        }
                        for (
                            let cat = 0;
                            cat < this.tableSelect.ordens.length;
                            cat++
                        ) {
                            for (
                                let indexxx = 0;
                                indexxx <
                                this.tableSelect.ordens[cat].orden_items.length;
                                indexxx++
                            ) {
                                let idOrden = this.tableSelect.ordens[cat]
                                    .orden_items[indexxx].id;
                                for (
                                    let index = 0;
                                    index < this.selectedCatIds.length;
                                    index++
                                ) {
                                    if (this.selectedCatIds[index] == idOrden) {
                                        this.selectedCatIds.splice(index, 1);
                                        this.tableSelect.ordens[
                                            cat
                                        ].orden_items[
                                            indexxx
                                        ].status_orden_id = status;
                                    }
                                }
                            }
                        }
                        const response = await this.$http.get(
                            `/caja/worker/ordens-status`
                        );
                        if (response.status == 200) {
                            let Ordens = response.data.ordens;
                            for (
                                let index = 0;
                                index < this.tableSelect.ordens.length;
                                index++
                            ) {
                                let Ord = _.find(Ordens, {
                                    id: this.tableSelect.ordens[index].id
                                });
                                if (Ord == undefined) {
                                    this.tableSelect.ordens[
                                        index
                                    ].status_id = 0;
                                }
                            }
                        }
                    }
                }
            } catch (e) {
                console.log(e);
            }
        },
        reloadDataCustomers(customer_id) {
            this.$http
                .get(`/document/search/customer/${customer_id}`)
                .then(response => {
                    this.all_customers = response.data.customers;
                    this.form.customer_id = customer_id;
                });
        },

        updateOrdens() {
            this.createOrden();
        },
        createOrden() {
            this.ordensItems = [];
        },
        facturar_orden() {
            this.ordens = [];
            for (let cat = 0; cat < this.tableSelect.ordens.length; cat++) {
                for (
                    let indexxx = 0;
                    indexxx < this.tableSelect.ordens[cat].orden_items.length;
                    indexxx++
                ) {
                    let idOrden = this.tableSelect.ordens[cat].orden_items[
                        indexxx
                    ].id;
                    for (
                        let index = 0;
                        index < this.selectedCatIds.length;
                        index++
                    ) {
                        if (this.selectedCatIds[index] == idOrden) {
                            this.addNewFood(
                                this.tableSelect.ordens[cat].orden_items[
                                    indexxx
                                ].food_id
                            );
                        }
                    }
                }
            }
            this.selectOption = 1;
        },
        selectTable(row, index) {
            this.tableSelect = [];
            this.selecttables = row.id;
            this.tableSelect = this.listar_tables[index];
            this.OrdenLength = this.tableSelect.ordens.length;
            if (this.tableSelect.ordens.length == 1) {
                this.OrdenLength = this.tableSelect.ordens.length + 1;
            } else {
                this.OrdenLength = this.tableSelect.ordens.length;
            }
            for (let cat = 0; cat < this.tableSelect.ordens.length; cat++) {
                for (
                    let index = 0;
                    index < this.tableSelect.ordens[cat].orden_items.length;
                    index++
                ) {
                    this.foodItem++;
                }
            }
        },
        consumir() {
            this.ordens = [];
            this.form.total_exonerated = 0;
            this.form.total_taxed = 0;
            this.form.total_igv = 0;
            this.form.total = 0;
            this.$refs.input_item.$el.getElementsByTagName("input")[0].focus();
            this.calculateTotal();
        },
        removeFood(index, id) {
            this.$http.get(`/pos/orden_items/${id}`).then(response => {
                let item = this.ordens;
                let index_find = _.findIndex(this.form.items, {
                    id: this.ordens[index].food.id
                });
                this.ordens.splice(index, 1);
                this.form.items.splice(index_find, 1);
                this.calculateTotal();
            });
        },
        addNewFood(newFood = null) {
            let f = this.allFoods.find(ai => ai.id == newFood);

            if (f) {
                f.llevar = true;
                f.item.quantity = 1;
                f.name_product_pdf = null;
                this.ordens = [
                    ...this.ordens,
                    {
                        food: f
                    }
                ];
            }
            this.newFood = null;
            if (this.selectOption == 2) {
                this.ordens[0].food.item.name_product_pdf = "POR CONSUMO";
            }
            this.calculateTotal();
        },

        paLlevar() {
            this.paraLlevar = !this.paraLlevar;
        },
        next() {
            this.$refs.slick.next();
        },
        editarProd() {
            this.editProd = !this.editProd;
        },
        add_product_pdf(index) {
            this.ordens[
                index
            ].food.item.name_product_pdf = this.name_product_pdf;

            this.editProd = !this.editProd;
        },
        prev() {
            this.$refs.slick.prev();
        },
        async date_of_issue() {
            let form_date_of_issue = {
                document_type_id: this.form.document_type_id
            };

            const response_date = await this.$http.post(
                `/${this.resource}/date_of_issue`,
                form_date_of_issue
            );

            this.last_date = response_date.data.date_last;
        },
        async view_modal() {
            this.loading = true;
            const response = await this.$http.get(
                `/caja/worker/totales_sales?cash_id=${this.cashId}&send=1`
            );
            this.$toast(
                ` Venta Acumulada S/ ` + response.data.total_sales.toFixed(2)
            );
            this.loading = false;
        },
        async list_tables() {
            this.loading = true;
            const response = await this.$http.get(
                `/caja/worker/${this.resource}/listtables`
            );
            this.listtables = response.data;
            this.listar_tables = response.data;
            this.loading = false;
        },
        reInit() {
            // Helpful if you have to deal with v-for to update dynamic lists
            this.$nextTick(() => {
                this.$refs.slick.reSlick();
            });
        },
        async clickPrintPos(printerName, formatoPdf) {
            try {
                let config = qz.configs.create(printerName, {
                    size: {
                        width: 148,
                        height: 210
                    },
                    units: "mm",
                    colorType: "grayscale",
                    copies: 2
                });
                if (!qz.websocket.isActive()) {
                    await qz.websocket.connect(config);
                }
                let data = [
                    {
                        type: "pdf",
                        format: "file",
                        data: formatoPdf
                    }
                ];
                qz.print(config, data).catch(e => {
                    this.$toast.error(e.message);
                });
                // this.clickNewSaleNote();
            } catch (e) {
                this.$toast.error(e.message);
            }
        },
        clear_input() {
            this.input_item = "";
        },
        selectFocus(input_) {
            this.$refs[input_][0].select();
        },
        teclasInit() {
            document.onkeydown = e => {
                const key = e.key;
                if (key == "F3") {
                    this.$refs.input_item.$el
                        .getElementsByTagName("input")[0]
                        .focus();
                }
                if (key == "F4") {
                    //Agregar cliente
                    this.clickPayment();
                }
                if (key == "F6") {
                    //Agregar Producto
                    //this.clickAddItemInvoice()
                    //return false;
                }
                if (key == "F7" && this.form.items.length > 0) {
                    //Guardar
                    // this.submit()
                }
                if (key == "F8") {
                    //Cancelar
                    // this.close()
                }
            };
        },

        leftarrow(input, index) {
            let split = input.split("_");

            if (split[1] != this.form.items.length) {
                this.$nextTick(this.$refs[index][0].focus());
            }
        },
        rightarrow(index) {
            let split = index.split("_");
            if (split[1] != this.form.items.length) {
                this.$nextTick(this.$refs[index][0].focus());
            }
        },
        upDown(index, next = false) {
            let split = index.split("_");
            if (index != 0) {
                if (split[1] != this.form.items.length) {
                    this.$nextTick(this.$refs[index][0].focus());
                }
                if (split[1] != this.form.items.length) {
                    this.$nextTick(this.$refs[index][0].focus());
                }
            }
        },
        arrowDown(index, next = false) {
            let split = index.split("_");
            if (split[1] != this.form.items.length) {
                this.$nextTick(this.$refs[index][0].focus());
            }
        },
        select_cantidad(index, next = false) {
            let split = index.split("_");
            if (next == false) {
                if (split[1] == this.form.items.length - 1) {
                } else {
                    this.$nextTick(this.$refs[index][0].focus());
                }
            } else {
                if (split[1] != this.form.items.length) {
                    this.$nextTick(this.$refs[index][0].focus());
                }
            }
        },
        clickClose: function() {
            this.$confirm("¿Desea Salir del Punto de Venta?", "Advertencia", {
                confirmButtonText: "Aceptar",
                cancelButtonText: "Cerrar",
                type: "warning"
            }).then(() => {
                location.href = `/dashboard`;
            });
        },
        async nueva_venta() {
            this.initForm(this.customer_default.id);
            this.events();
            await this.getFormPosLocalStorage();
            await this.initCurrencyType();

            this.customer = await this.getLocalStorageIndex("customer");
        },
        filterCategorie(id, mod = false) {
            this.category_selected = id;
            this.$refs.list_foods.searchFoodCategories(id);
        },

        initCurrencyType() {
            this.currency_type = _.find(this.currency_types, {
                id: this.form.currency_type_id
            });
        },

        getFormPosLocalStorage() {
            let form_pos = localStorage.getItem("form_pos");

            form_pos = JSON.parse(form_pos);
            if (form_pos) {
                this.form = form_pos;

                this.calculateTotal();
            }
        },
        deleteFormPosLocalStorage() {
            localStorage.setItem("form_pos", JSON.stringify(this.form));
        },
        setFormPosLocalStorage(form_param = null) {
            /*if (form_param) {
                      localStorage.setItem("form_pos", JSON.stringify(form_param));
                  } else {
                      localStorage.setItem("form_pos", JSON.stringify(this.form));
                  }
                  */
        },

        cancelFormPosLocalStorage() {
            localStorage.setItem("form_pos", JSON.stringify(null));
            this.setLocalStorageIndex("customer", null);
        },
        clickOpenInputEditUP(index) {
            this.items[index].edit_unit_price = true;
        },
        clickEditUnitPriceItem(index) {
            let item_search = this.items[index];
            this.items[index].sale_unit_price = this.items[
                index
            ].edit_sale_unit_price;
            this.items[index].edit_unit_price = false;
        },
        clickCancelUnitPriceItem(index) {
            this.items[index].edit_unit_price = false;
        },
        clickWarehouseDetail(item) {
            this.unittypeDetail = item.unit_type;
            this.warehousesDetail = item.warehouses;
            this.showWarehousesDetail = true;
        },
        clickHistoryPurchases(item_id) {
            this.history_item_id = item_id;
            this.showDialogHistoryPurchases = true;
        },
        clickHistorySales(item_id) {
            if (!this.form.customer_id)
                return this.$toast.error("Debe seleccionar el cliente");
            this.history_item_id = item_id;
            this.showDialogHistorySales = true;
        },
        keyupEnterCustomer() {
            if (this.input_person.number) {
                if (!isNaN(parseInt(this.input_person.number))) {
                    switch (this.input_person.number.length) {
                        case 8:
                            this.input_person.identity_document_type_id = "1";
                            this.showDialogNewPerson = true;
                            break;

                        case 11:
                            this.input_person.identity_document_type_id = "6";
                            this.showDialogNewPerson = true;
                            break;
                        default:
                            this.input_person.identity_document_type_id = "6";
                            this.showDialogNewPerson = true;
                            break;
                    }
                }
            }
        },
        keyupCustomer(e) {
            //if(e.key !== "Enter"){
            this.input_person.number = this.$refs.select_person.$el.getElementsByTagName(
                "input"
            )[0].value;
            let exist_persons = this.all_customers.filter(customer => {
                let pos = customer.description.search(this.input_person.number);
                return pos > -1;
            });
            this.input_person.number =
                exist_persons.length == 0 ? this.input_person.number : null;
            //}
        },
        calculateQuantity(index) {
            if (this.form.items[index].item.calculate_quantity) {
                let quantity = _.round(
                    parseFloat(this.form.items[index].total) /
                        parseFloat(this.form.items[index].unit_price),
                    4
                );

                if (quantity) {
                    this.form.items[index].quantity = quantity;
                    this.form.items[index].item.aux_quantity = quantity;
                } else {
                    this.form.items[index].quantity = 0;
                    this.form.items[index].item.aux_quantity = 0;
                }
                // this.calculateTotal()
            }

            //  this.clickAddItem(this.form.items[index],index, true)
        },
        blurCalculateQuantity(index) {
            this.row = calculateRowItem(
                this.form.items[index],
                this.form.currency_type_id,
                1
            );
            this.form.items[index] = this.row;
            this.calculateTotal();
            this.setFormPosLocalStorage();
        },
        blurCalculateQuantity2(index) {
            this.row = calculateRowItem(
                this.form.items[index],
                this.form.currency_type_id,
                1
            );
            this.form.items[index] = this.row;
            this.calculateTotal();
        },
        changeCustomer() {
            this.form.customer_id = this.value;
            let customer = _.find(this.all_customers, {
                id: this.form.customer_id
            });
            this.customer = customer;
            if (customer) {
                this.form.document_type_id =
                    customer.identity_document_type_id == "1" ? "03" : "01";
            }
            this.setLocalStorageIndex("customer", this.customer);
            //  this.setFormPosLocalStorage()
        },

        getLocalStorageIndex(key, re_default = null) {
            let ls_obj = localStorage.getItem(key);
            ls_obj = JSON.parse(ls_obj);

            if (ls_obj) {
                return ls_obj;
            }

            return re_default;
        },
        setLocalStorageIndex(key, obj) {
            localStorage.setItem(key, JSON.stringify(obj));
        },
        async events() {
            await this.$eventHub.$on("initInputPerson", () => {
                this.initInputPerson();
            });

            await this.$eventHub.$on(
                "eventSetFormPosLocalStorage",
                form_param => {
                    this.setFormPosLocalStorage(form_param);
                }
            );

            await this.$eventHub.$on("cancelSale", () => {
                this.is_payment = false;
                this.getTables();
                this.initForm(this.customer_default.id);
                this.changeExchangeRate();
                this.ordenId = null;
                this.ordens = [];
                //  this.cancelFormPosLocalStorage()
            });

            await this.$eventHub.$on("reloadDataItems", item_id => {
                this.reloadDataItems(item_id);
            });

            await this.$eventHub.$on("saleSuccess", () => {
                //  this.is_payment = false;
                this.getTables();
                this.initForm(this.customer_default.id);
                this.setFormPosLocalStorage();
                this.ordenId = null;
                this.ordens = [];
            });
        },
        async initForm(customer_default = null) {
            this.variation = false;
            this.form = {
                afectar_caja: true,
                orden_id: null,
                customer_telephone: null,
                restaurant: true,
                total_rounded: 0.0,
                total_payment: 0.0,
                establishment_id: null,
                document_type_id:
                    this.company.soap_type_id != "03"
                        ? this.establishments.document_default
                        : "80",
                series_id: null,
                prefix: null,
                user_id: this.user.id,
                number: "#",
                date_of_issue: moment().format("YYYY-MM-DD"),
                time_of_issue: moment().format("HH:mm:ss"),
                currency_type_id: "PEN",
                purchase_order: null,
                exchange_rate_sale: 1,
                total_prepayment: 0,
                total_charge: 0,
                total_discount: 0,
                total_exportation: 0,
                total_free: 0,
                total_taxed: 0,
                total_unaffected: 0,
                total_exonerated: 0,
                total_igv: 0,
                total_base_isc: 0,
                total_isc: 0,
                total_base_other_taxes: 0,
                total_other_taxes: 0,
                total_taxes: 0,
                total_value: 0,
                total: 0,
                operation_type_id: "0101",
                date_of_due: moment().format("YYYY-MM-DD"),
                items: [],
                charges: [],
                discounts: [],
                attributes: [],
                guides: [],
                payments: [],
                hotel: {},
                additional_information: null,
                payment_condition_id: "01",
                printerOn: false,
                actions: {
                    format_pdf: "a4"
                },
                difference: 0.0,
                enter_amount: 0.0,
                method_pay: "Efectivo",
                commands_fisico: null,
                to_carry: false
            };
            this.formVariation = {
                afectar_caja: true,
                orden_id: null,
                customer_telephone: null,
                restaurant: true,
                total_rounded: 0.0,
                total_payment: 0.0,
                establishment_id: null,
                document_type_id: this.establishments.document_default,
                series_id: null,
                prefix: null,
                user_id: this.user.id,
                number: "#",
                date_of_issue: moment().format("YYYY-MM-DD"),
                time_of_issue: moment().format("HH:mm:ss"),
                currency_type_id: "PEN",
                purchase_order: null,
                exchange_rate_sale: 1,
                total_prepayment: 0,
                total_charge: 0,
                total_discount: 0,
                total_exportation: 0,
                total_free: 0,
                total_taxed: 0,
                total_unaffected: 0,
                total_exonerated: 0,
                total_igv: 0,
                total_base_isc: 0,
                total_isc: 0,
                total_base_other_taxes: 0,
                total_other_taxes: 0,
                total_taxes: 0,
                total_value: 0,
                total: 0,
                operation_type_id: "0101",
                date_of_due: moment().format("YYYY-MM-DD"),
                items: [],
                charges: [],
                discounts: [],
                attributes: [],
                guides: [],
                payments: [],
                hotel: {},
                additional_information: null,
                payment_condition_id: "01",
                printerOn: false,
                actions: {
                    format_pdf: "a4"
                },
                difference: 0.0,
                enter_amount: 0.0,
                method_pay: "Efectivo",
                commands_fisico: null,
                to_carry: false
            };
            this.value = customer_default;
            this.form.customer_id = customer_default;
            this.initFormItem();
            this.changeDateOfIssue();
            this.initInputPerson();
            //  this.changeCustomer();
            this.name_product_pdf = null;
        },
        initInputPerson() {
            this.input_person = {
                number: "",
                identity_document_type_id: ""
            };
        },
        initFormItem() {
            this.form_item = {
                item_id: null,
                item: {},
                affectation_igv_type_id: null,
                affectation_igv_type: {},
                has_isc: false,
                system_isc_type_id: null,
                calculate_quantity: false,
                percentage_isc: 0,
                suggested_price: 0,
                quantity: 1,
                aux_quantity: 1,
                unit_price_value: 0,
                unit_price: 0,
                charges: [],
                discounts: [],
                attributes: [],
                has_igv: false
            };
        },
        async clickPayment() {
            if (this.orden_items.length == 0) {
                this.orden_items = { items: this.ordens };
            }
            if (this.selectOption == 1) {
                this.form.orden_id = this.input_item;
                this.idOrden = this.input_item;
            }
            this.form.items = this.ordens.map(o => o.food.item);
            this.formatItems();
            this.form.enter_amount = this.form.total;
            this.form.difference = 0;
            let flag = 0;

            if (this.ordens[0].food.price == 0 && this.selectOption == 2) {
                return this.$toast.error("Ingrese el Precio por consumo");
            }
            if (!this.form.customer_id)
                return this.$toast.error("Seleccione un cliente");
            this.form.establishment_id = this.establishment.id;

            this.is_payment = true;
        },
        getLocalPrinter(key) {
            let ls_obj = localStorage.getItem(key);
            return ls_obj;
        },
        sleep(ms) {
            return new Promise(resolve => setTimeout(resolve, ms));
        },
        clickDeleteCustomer() {
            this.form.customer_id = null;
            this.setFormPosLocalStorage();
        },
        formatItems() {
            this.form.items = this.form.items.map(i => {
                return {
                    ...i,
                    attributes:i.attributes || [],
                    toWarehouse: i.toWarehouse || 0,
                    consignment_item_id: i.consignment_item_id,
                    warehouse_id: null,
                    item: i,
                    item_id: i.id,
                    unit_value:
                        i.sale_affectation_igv_type_id == 10
                            ? i.sale_unit_price /
                              (1 + this.percentage_igv / 100)
                            : i.sale_unit_price,
                    quantity: i.quantity,
                    aux_quantity: i.quantity,
                    total_base_igv:
                        i.sale_affectation_igv_type_id == 10
                            ? (i.sale_unit_price * i.quantity) /
                              (1 + this.percentage_igv / 100)
                            : i.sale_unit_price * i.quantity,
                    percentage_igv: this.percentage_igv,
                    total_igv:
                        i.sale_affectation_igv_type_id == 10
                            ? ((i.sale_unit_price * i.quantity) /
                                  (1 + this.percentage_igv / 100)) *
                              (this.percentage_igv / 100)
                            : 0,
                    total_base_isc: 0.0,
                    percentage_isc: 0.0,
                    total_isc: 0.0,
                    total_base_other_taxes: 0.0,
                    percentage_other_taxes: 0.0,
                    total_other_taxes: 0.0,
                    total_taxes:
                        i.sale_affectation_igv_type_id == 10
                            ? ((i.sale_unit_price * i.quantity) /
                                  (1 + this.percentage_igv / 100)) *
                              (this.percentage_igv / 100)
                            : 0,
                    total_value:
                        i.sale_affectation_igv_type_id == 10
                            ? (i.sale_unit_price * i.quantity) /
                              (1 + this.percentage_igv / 100)
                            : i.quantity * i.sale_unit_price,
                    total_charge: 0.0,
                    total_discount: 0.0,
                    total: i.sale_unit_price * i.quantity,
                    price_type_id: "01",
                    unit_price: i.sale_unit_price,
                    unit_price_value: i.sale_unit_price,
                    has_igv: i.has_igv,
                    affectation_igv_type_id: i.sale_affectation_igv_type_id,
                    unit_price: i.sale_unit_price,
                    presentation: null,
                    charges: [],
                    discounts: [],
                    affectation_igv_type: i.sale_affectation_igv_type_id
                };
            });
            this.calculateTotal();
        },
        isNoteIsDefault() {
            if (this.form.document_type_id == "80") {
                this.form.document_type_id = "03";
            }
        },
        async clickAddItem(
            item,
            index,
            input = false,
            price_sale = 0,
            focus = false
        ) {
            //this.loading = true;
            let exchangeRateSale = this.form.exchange_rate_sale;
            let exist_item = _.find(this.form.items, {
                item_id: item.item_id
            });
            let pos = this.form.items.indexOf(exist_item);
            let response = null;
            if (exist_item) {
                if (input) {
                    response = await this.getStatusStock(
                        item.item_id,
                        exist_item.item.aux_quantity
                    );
                    if (!response.success) {
                        item.item.aux_quantity = item.quantity;
                        this.loading = false;
                        return this.$toast.error(response.message);
                    }
                    exist_item.quantity = exist_item.item.aux_quantity;
                } else {
                    response = await this.getStatusStock(
                        item.item_id,
                        parseFloat(exist_item.item.aux_quantity) + 1
                    );
                    if (!response.success) {
                        // this.loading = false;
                        return this.$toast.error(response.message);
                    }

                    exist_item.quantity++;
                    exist_item.item.aux_quantity++;
                }

                let search_item_bd = await _.find(this.items, {
                    item_id: item.item_id
                });
                if (search_item_bd) {
                    exist_item.item.unit_price = parseFloat(
                        search_item_bd.sale_unit_price
                    );
                }
                if (price_sale > 0) {
                    exist_item.item.sale_unit_price = price_sale;
                }

                let unit_price = exist_item.item.has_igv
                    ? exist_item.item.sale_unit_price
                    : exist_item.item.sale_unit_price *
                      (1 + this.percentage_igv / 100);
                // exist_item.unit_price = unit_price
                exist_item.item.unit_price = unit_price;
                this.row = calculateRowItem(
                    exist_item,
                    this.form.currency_type_id,
                    exchangeRateSale
                );
                this.form.items[pos] = this.row;
            } else {
                response = await this.getStatusStock(item.item_id, 1);
                if (!response.success) {
                    // this.loading = false;
                    return this.$toast.error(response.message);
                }

                this.form_item.item = item;
                this.form_item.unit_price_value = this.form_item.item.sale_unit_price;
                this.form_item.has_igv = this.form_item.item.has_igv;
                this.form_item.affectation_igv_type_id = this.form_item.item.sale_affectation_igv_type_id;
                this.form_item.quantity = 1;
                this.form_item.aux_quantity = 1;

                let unit_price = this.form_item.has_igv
                    ? this.form_item.unit_price_value
                    : this.form_item.unit_price_value *
                      (1 + this.percentage_igv / 100);

                this.form_item.unit_price = unit_price;
                this.form_item.item.unit_price = unit_price;
                this.form_item.item.presentation = null;

                this.form_item.charges = [];
                this.form_item.discounts = [];
                this.form_item.attributes = [];
                this.form_item.affectation_igv_type = _.find(
                    this.affectation_igv_types,
                    {
                        id: this.form_item.affectation_igv_type_id
                    }
                );

                this.row = calculateRowItem(
                    this.form_item,
                    this.form.currency_type_id,
                    exchangeRateSale
                );
                this.form.items.push(this.row);
                item.aux_quantity = 1;
            }

            this.$notify({
                title: "",
                message: "Producto añadido!",
                type: "success",
                duration: 700,
                position: "bottom-right"
            });
            await this.calculateTotal();
            this.loading = false;
            await this.setFormPosLocalStorage();
            if (focus == true) {
                let indexx = this.form.items.length - 1;
                this.$nextTick(this.$refs["input_" + indexx][0].focus());
                this.$nextTick(this.$refs["input_" + indexx][0].select());
            }

            localStorage.setItem("form_pos", JSON.stringify(this.form));
        },
        async focus() {
            await this.sleep(200);
            let indexx = this.form.items.length - 1;
        },
        async Printer(
            Printer,
            linkpdf,
            copies,
            auth = null,
            multiple_boxes = false,
            typeuser = null,
            printing = true
        ) {
            let paperConfig = {
                scaleContent: false
            };
            let partsUrl = linkpdf.split("/");
            let document = partsUrl[partsUrl.length - 1];
            let isTicket = linkpdf.toLowerCase().includes("ticket");
            let isA4 = document.toLowerCase().includes("a4");
            let isA5 = document.toLowerCase().includes("a5");

            let tipoBandejaImpresora = this.config.new_old_printer;

            if (isA4) {
                if (tipoBandejaImpresora == 1) {
                    paperConfig.density = 700;
                    paperConfig.orientation = "portrait";
                } else {
                    paperConfig.density = 350;
                    paperConfig.orientation = "portrait";
                }
            } else {
                let orientation = "portrait";
                if(isA5){
                    let {a5_orientation} =  this.configuration
                    orientation = a5_orientation ? "landscape" : "portrait"
                }
                //NO MOVER ESTA CONFIGURACION ESTA PARA IMPRESION DIRECTA EN A5
                if (!isTicket && tipoBandejaImpresora == 1) {
                    //opciones que permiten hacer una impresion correcta en impresoras nuevas
                    paperConfig.density = 600;
                    paperConfig.orientation = orientation;
                    paperConfig.margins = { left: 2 };
                } else if (!isTicket && tipoBandejaImpresora == 0) {
                    paperConfig.density = 350;
                    paperConfig.orientation = orientation;
                    paperConfig.margins = { left: 1.5 };
                }
            } //FIN IMPRESION DIRECTA A5

            let config = qz.configs.create(Printer, paperConfig);

            if (!qz.websocket.isActive()) {
                await qz.websocket.connect(config);
            }
            let data = [
                {
                    type: "pdf",
                    format: "file",
                    data: linkpdf
                }
            ];

            qz.print(config, data).catch(e => {
                this.$toast.error(e.message);
            });
            for (let index = 0; index < copies; index++) {
                qz.print(config, data).catch(e => {
                    this.$toast.error(e.message);
                });
            }
            // if (multiple_boxes == true && typeuser != "admin") {
            //     //  if (true) { this.auth_login - auth
            //     let config = qz.configs.create(Printer, paperConfig);

            //     if (!qz.websocket.isActive()) {
            //         await qz.websocket.connect(config);
            //     }
            //     let data = [
            //         {
            //             type: "pdf",
            //             forma    t: "file",
            //             data: linkpdf
            //         }
            //     ];

            //     qz.print(config, data).catch(e => {
            //         this.$toast.error(e.message);
            //     });
            //     for (let index = 0; index < copies; index++) {
            //         qz.print(config, data).catch(e => {
            //             this.$toast.error(e.message);
            //         });
            //     }
            // }
            // if (
            //     multiple_boxes == true &&
            //     (typeuser == "admin" || typeuser == "superadmin")
            // ) {
            //     let config = qz.configs.create(Printer, paperConfig);
            //     console.log(paperConfig, "configu");
            //     console.log(config);
            //     if (!qz.websocket.isActive()) {
            //         await qz.websocket.connect(config);
            //     }
            //     let data = [
            //         {
            //             type: "pdf",
            //             format: "file",
            //             data: linkpdf
            //         }
            //     ];
            //     qz.print(config, data).catch(e => {
            //         this.$toast.error(e.message);
            //     });
            //     for (let index = 0; index < copies; index++) {
            //         qz.print(config, data).catch(e => {
            //             this.$toast.error(e.message);
            //         });
            //     }
            // }
            // if (multiple_boxes == false) {
            //     let config = qz.configs.create(Printer, paperConfig);
            //     console.log(paperConfig, "configu");
            //     console.log(config);
            //     if (!qz.websocket.isActive()) {
            //         await qz.websocket.connect(config);
            //     }
            //     let data = [
            //         {
            //             type: "pdf",
            //             format: "file",
            //             data: linkpdf
            //         }
            //     ];

            //     qz.print(config, data).catch(e => {
            //         this.$toast.error(e.message);
            //     });
            //     for (let index = 0; index < copies; index++) {
            //         qz.print(config, data).catch(e => {
            //             this.$toast.error(e.message);
            //         });
            //     }
            // }
        },
        async getStatusStock(item_id, quantity) {
            let data = {};
            if (!quantity) quantity = 0;
            await this.$http
                .get(`/${this.resource}/validate_stock/${item_id}/${quantity}`)
                .then(response => {
                    data = response.data;
                });
            return data;
        },
        async clickDeleteItem(index) {
            this.form.items.splice(index, 1);
            this.calculateTotal();
            this.deleteFormPosLocalStorage();
        },
        calculateItem(index, quantity = 0, price = 0) {
            this.ordens[index].food.quantity = quantity;
            this.ordens[index].food.price = price;
            this.form.items[index].quantity = quantity;
            let total_venta = _.round(
                Math.round(parseFloat(quantity) * parseFloat(price) * 10) / 10,
                2
            );
            this.form.items[index].total = total_venta;
            if (this.form.items[index].affectation_igv_type_id == "10") {
                this.form.items[index].total_value = (
                    this.form.items[index].total /
                    (1 + this.percentage_igv / 100)
                ).toFixed(2);
                this.form.items[index].total_taxes = (
                    (quantity * price * (this.percentage_igv / 100)) /
                    (1 + this.percentage_igv / 100)
                ).toFixed(2);
                this.form.items[index].total_base_igv = _.round(
                    this.form.items[index].total /
                        (1 + this.percentage_igv / 100),
                    2
                );
                this.form.items[index].unit_value = (
                    price /
                    (1 + this.percentage_igv / 100)
                ).toFixed(6);
                this.form.items[index].total_igv = _.round(
                    (this.form.items[index].total /
                        (1 + this.percentage_igv / 100)) *
                        (this.percentage_igv / 100),
                    2
                );
                this.form.items[index].total_base_igv = _.round(
                    this.form.items[index].total /
                        (1 + this.percentage_igv / 100),
                    2
                );
            } else {
                this.form.items[index].total_value =
                    Math.round(parseFloat(quantity) * parseFloat(price) * 10) /
                    10;
                this.form.items[index].total_taxes = 0.0;
                this.form.items[index].total_base_igv = _.round(
                    Math.round(parseFloat(quantity) * parseFloat(price) * 10) /
                        10,
                    2
                );
                this.form.items[index].unit_value = price;
                this.form.items[index].total_igv = 0;
                this.form.items[index].total_base_igv = _.round(
                    Math.round(parseFloat(quantity) * parseFloat(price) * 10) /
                        10,
                    2
                );
            }

            this.calculateTotal();
        },
        calculateTotalVariation(formVariation) {
            let total_exportation = 0;
            let total_taxed = 0;
            let total_taxes = 0;
            let total_exonerated = 0;
            let total_unaffected = 0;
            let total_free = 0;
            let total_igv = 0;
            let total_value = 0;
            let total = 0;
            let total_discount = 0;
            let total_charge = 0;
            //  total_igv = _.round((total / (1+(this.percentage_igv/100))) * (this.percentage_igv/100), 2);

            formVariation.items.forEach(row => {
                total_discount += parseFloat(row.total_discount);
                total_charge += parseFloat(row.total_charge);
                total += parseFloat(row.total);
                total_taxes += parseFloat(row.total_taxes);
                if (row.sale_affectation_igv_type_id === "10") {
                    total_igv += _.round(
                        parseFloat(row.total_value) *
                            (this.percentage_igv / 100),
                        2
                    );
                    total_value += _.round(row.total_value, 2);
                    total_taxed += parseFloat(row.total_value);
                }
                if (row.sale_affectation_igv_type_id === "20") {
                    total_exonerated += parseFloat(row.total);
                    total_value += _.round(row.total_value, 2);
                }
                if (row.sale_affectation_igv_type_id === "30") {
                    total_unaffected += parseFloat(row.total_value);
                    total_value += _.round(row.total_value, 2);
                }
                if (row.sale_affectation_igv_type_id === "40") {
                    total_exportation += parseFloat(row.total_value);
                    total_value += _.round(row.total_value, 2);
                }
                if (
                    ["10", "20", "30", "40"].indexOf(
                        row.affectation_igv_type_id
                    ) < 0
                ) {
                    total_free += parseFloat(row.total_value);
                }
            });

            formVariation.total_exportation = _.round(total_exportation, 2);
            formVariation.total_taxed = _.round(total_taxed, 2);
            formVariation.total_taxes = _.round(total_taxes, 2);
            formVariation.total_exonerated = _.round(total_exonerated, 2);
            formVariation.total_unaffsected = _.round(total_unaffected, 2);
            formVariation.total_free = _.round(total_free, 2);
            formVariation.total_igv = _.round(total_igv, 2);
            formVariation.total_value = _.round(total_value, 2);
            formVariation.total = _.round(total, 2);
        },
        calculateTotal(sale_unit_price = 0) {
            let total_discount = 0;
            let total_charge = 0;
            let total_exportation = 0;
            let total_taxed = 0;
            let total_taxes = 0;
            let total_exonerated = 0;
            let total_unaffected = 0;
            let total_free = 0;
            let total_igv = 0;
            let total_value = 0;
            let total = 0;
            this.ordens.forEach(orden => {
              let t = parseFloat(_.round(
                    parseFloat(orden.food.item.quantity) * parseFloat(orden.food.price),
                    2
                ));
                total += t;
            });

            this.form.items.forEach(row => {
                total_discount += parseFloat(row.total_discount);
                total_charge += parseFloat(row.total_charge);

                total_taxes += parseFloat(row.total_taxes);
                if (row.sale_affectation_igv_type_id === "10") {
                    total_igv += _.round(
                        parseFloat(row.total_value) *
                            (this.percentage_igv / 100),
                        2
                    );
                    total_value += _.round(row.total_value, 2);
                    total_taxed += parseFloat(row.total_value);
                }
                if (row.sale_affectation_igv_type_id === "20") {
                    total_exonerated += parseFloat(row.total);
                    total_value += _.round(row.total_value, 2);
                }
                if (row.sale_affectation_igv_type_id === "30") {
                    total_unaffected += parseFloat(row.total_value);
                    total_value += _.round(row.total_value, 2);
                }
                if (row.sale_affectation_igv_type_id === "40") {
                    total_exportation += parseFloat(row.total_value);
                    total_value += _.round(row.total_value, 2);
                }
                if (
                    ["10", "20", "30", "40"].indexOf(
                        row.affectation_igv_type_id
                    ) < 0
                ) {
                    total_free += parseFloat(row.total_value);
                }
            });

            this.form.total_exportation = _.round(total_exportation, 2);
            this.form.total_taxed = _.round(total_taxed, 2);
            this.form.total_taxes = _.round(total_taxes, 2);
            this.form.total_exonerated = _.round(total_exonerated, 2);
            this.form.total_unaffsected = _.round(total_unaffected, 2);
            this.form.total_free = _.round(total_free, 2);
            this.form.total_igv = _.round(total_igv, 2);
            this.form.total_value = _.round(total_value, 2);
            this.form.total = _.round(total, 2);
            if (this.ordens.length > 0) {
                if (this.selectOption == 2) {
                    this.ordens[0].food.item.sale_unit_price = sale_unit_price;
                }
            }
        },
        changeDateOfIssue() {
            // this.searchExchangeRateByDate(this.form.date_of_issue).then(response => {
            //     this.form.exchange_rate_sale = response
            // })
        },
        changeExchangeRate() {
            // this.searchExchangeRateByDate(this.form.date_of_issue).then(
            //   (response) => {
            //     this.form.exchange_rate_sale = response;
            //   }
            // );
        },
        //   import queryString from 'query-string'
        //   this.pagination = response.data.meta
        //   this.pagination.per_page = parseInt(response.data.meta.per_page)
        //  getQueryParameters() {
        //         return queryString.stringify({
        //             page: this.pagination.current_page,
        //             limit: this.limit
        //         })
        //     }
        getQueryParameters(form = {}) {
            return queryString.stringify({
                page: this.pagination.current_page,
                external_id: this.type_code,
                ...form

                // limit: this.limit
            });
        },
        async getFoods(query = "") {
            try {
                const response = await this.$http.get(
                    `${this.resource}/foods?${query}`
                );
                this.loading = true;
                if (response.status == 200) {
                    const {
                        data: { data, meta }
                    } = response;

                    this.allFoods = data.map(d => {
                        if (d.item.lots_group.length > 0) {
                            d.item.lots_group = d.item.lots_group.filter(
                                lt =>
                                    lt.warehouse_id ==
                                    this.worker.establishment_id
                            );
                        }
                        return d;
                    });
                    this.listFoods = this.allFoods;
                    this.pagination = meta;

                    this.selectOption = 4;
                    this.loading = false;
                }
            } catch (e) {
                console.log(e);
                this.loading = false;
            }
        },
        async getTables() {
            //this.loadingInstance = Loading.service({fullscreen: false,lock:true,text:"Espere por favor..."});
            await this.$http.get(`/${this.resource}/tables`).then(response => {
                // this.all_items = response.data.items;

                this.products_to_due = response.data.products_to_due;
                this.categories = response.data.categories;
                this.areas = response.data.areas;
                this.payments = response.data.method_payment;
                this.date_last = response.data.date_last;
                this.documentsType = response.data.documents_type;
                this.itemDefault = response.data.item_default;
                this.affectation_igv_types =
                    response.data.affectation_igv_types;
                this.all_customers = response.data.customers;

                let defaultClient = this.all_customers.find(c =>
                    c.name.toLowerCase().includes("varios")
                );
                if (defaultClient) {
                    this.form.customer_id = defaultClient.id;
                }

                this.establishment = response.data.establishment;
                this.currency_types = response.data.currency_types;
                this.customer_default =
                    response.data.customers_default[0] ||
                    response.data.customers[0];

                let [customerVariation] = response.data.customers_variation;
                if (customerVariation) {
                    this.customer_variation = customerVariation;
                }
                this.all_customers = [
                    ...this.all_customers.filter(
                        c => c.id != this.customer_default.id
                    ),
                    this.customer_default
                ];
                this.user = response.data.user;
                // this.desarrollador=response.data.desarrollador
                this.currency_types.length > 0
                    ? this.currency_types[0].id
                    : null;
                this.renderCategories(response.data.categories);
                // this.currency_type = _.find(this.currency_types, {'id': this.form.currency_type_id})
                // this.changeCurrencyType();
                // this.filterItems();
                // this.changeDateOfIssue();
                // this.changeExchangeRate();
                this.config = response.data.config;
            });

            // this.loadingInstance.close()
        },
        async getSeries() {
            this.$http.get(`/pos/payment_tables`).then(response => {
                this.all_series = response.data.series;
            });
        },
        getColor(i) {
            return this.colors[i % this.colors.length];
        },
        renderCategories(source) {
            const contex = this;
            this.categories = source.map((obj, index) => {
                return {
                    id: obj.id,
                    name: obj.name,
                    color: contex.getColor(index)
                };
            });
        },
        async limpiarForm() {
            this.ordens_all_table = false;
            this.isConsignment = false;
            this.selectOption = 4;
            this.blockCart = false;
            this.variation = false;
            this.form.discounts = [];
            this.form.total_discount = 0;
            this.cancelOrden();
            if (
                this.configuration.sales_quick == 1 ||
                this.configuration.sales_quick == true
            ) {
                this.ordens = [];
                this.localOrden = [];
                this.initFormItem();
                await this.initForm(this.customer_default.id);
            }
            await this.getFoods();
            await this.calculateTotal();
            this.$refs.input_items.$el.getElementsByTagName("input")[0].focus();
            this.total_sales_pos = 0;
        },
        typesearch() {
            this.ordens = [];
            this.localOrden = [];
            this.orden_items = [];
            this.initForm(this.customer_default.id);
            this.initFormItem();
            this.$refs.input_item?.$el
                ?.getElementsByTagName("input")[0]
                .focus();
            if (this.selectOption == 0) {
                this.type_search = "Buscar Mesa";
            } else if (this.selectOption == 1) {
                this.type_search = "Buscar Orden";
            } else if (this.selectOption == 2) {
                this.type_search = "Buscar Orden";
            } else if (this.selectOption == 3) {
                this.type_search = "Buscar Producto";
            } else if (this.selectOption == 4) {
                this.type_search = "Buscar Producto";
            }
        },
        search_tables() {
            this.listar_tables = this.listtables.filter(f =>
                f.number.toLowerCase().includes(this.input_item.toLowerCase())
            );
        },
        async search_orden() {
            this.loading = true;
            if (this.input_item.length > 0) {
                this.loading = true;
                let parameters = `input_item=${this.input_item}`;
                const response = await this.$http.get(
                    `${this.resource}/search_orden?${parameters}`
                );
                let { ordens, success, message } = response.data;
                if (!success) {
                    this.$toast.error(message);
                    this.loading = false;
                    return;
                }
                if (success) {
                    this.ordenId = ordens.id;
                    this.loading = false;
                    if (this.selectOption == 2) {
                        let f = this.allFoods[0];
                        if (f) {
                            f.llevar = true;
                            if (this.selectOption == 2) {
                                f.item.name_product_pdf = "POR CONSUMO";
                                f.item.quantity = 1;
                            }

                            this.ordens = [
                                ...this.ordens,
                                {
                                    food: f
                                }
                            ];
                        }
                        if (this.selectOption == 2) {
                            this.ordens[0].food.price = 0.0;
                        }

                        this.calculateTotal();
                    } else {
                        this.ordens = ordens.orden_items;
                        for (
                            let index = 0;
                            index < this.ordens.length;
                            index++
                        ) {
                            this.ordens[index].food.item.quantity = this.ordens[
                                index
                            ].quantity;
                        }
                    }
                    // this.ordens = ordens.orden_items;
                    this.form.items = this.ordens.map(o => o.food.item);
                    this.formatItems();
                    this.calculateTotal();
                    this.loading = false;
                }
            } else {
                this.filterItems();
            }
            this.newFood = null;
            this.name_product_pdf = null;
            this.loading = false;
        },
        async search_items(data) {
            let inputitem = this.input_item.toLowerCase();
            if (data == undefined) {
                let form = {
                    value: inputitem,
                    category: this.category
                };
                await this.getFoods(this.getQueryParameters(form));
            } else {
                let form = {
                    value: data,
                    category: this.category
                };
                await this.getFoods(this.getQueryParameters(form));
            }

            //            this.$refs.list_foods.searchFood(inputitem, this.type_search);
            //
            //  this.listFoods = this.allFoods.filter((f) =>
            //   f.description.toLowerCase().includes(inputitem)
            // );
        },
        async search() {
            if (this.time) {
                clearTimeout(this.time);
            }
            this.time = setTimeout(() => {
                if (this.selectOption == 0) {
                    this.search_tables();
                } else if (this.selectOption == 1) {
                    this.search_orden();
                } else if (this.selectOption == 2) {
                    this.search_orden();
                } else if (this.selectOption == 3) {
                    this.search_items();
                } else if (this.selectOption == 4) {
                    this.search_items();
                }
            }, 500);
        },
        async searchItemsBarcode() {
            if (this.input_item.length > 1) {
                this.loading = true;

                let parameters = `input_item=${this.input_item}`;

                await this.$http
                    .get(`/${this.resource}/search_items?${parameters}`)
                    .then(response => {
                        this.items = response.data.items;
                        this.enabledSearchItemsBarcode();
                        this.loading = false;
                        if (this.items.length == 0) {
                            this.filterItems();
                        }
                    });
            } else {
                await this.filterItems();
            }
        },
        enabledSearchItemsBarcode() {
            if (this.search_item_by_barcode) {
                if (this.items.length == 1) {
                    this.clickAddItem(this.items[0], 0);
                    this.filterItems();
                }

                this.cleanInput();
            }
        },
        changeSearchItemBarcode() {
            this.cleanInput();
        },
        cleanInput() {
            this.input_item = null;
        },
        filterItems() {
            this.items = this.all_items;
        },
        reloadDataCustomers(customer_id) {
            this.$http
                .get(`/${this.resource}/table/customers`)
                .then(response => {
                    this.all_customers = response.data;
                    this.form.customer_id = customer_id;
                    // this.changeCustomer();
                });
        },
        reloadDataItems(item_id) {
            this.$http.get(`/${this.resource}/table/items`).then(response => {
                this.all_items = response.data;
                let array_temp = _.filter(this.all_items, {
                    id: item_id
                });
                this.input_item = array_temp[0].description;
                this.filterItems();
                this.searchItems();
                this.clickAddItem(array_temp[0], 0, false);
            });
        },
        selectCurrencyType() {
            this.form.currency_type_id =
                this.form.currency_type_id === "PEN" ? "USD" : "PEN";
            this.changeCurrencyType();
        },
        async changeCurrencyType() {
            this.currency_type = await _.find(this.currency_types, {
                id: this.form.currency_type_id
            });
            let items = [];
            this.form.items.forEach(row => {
                items.push(
                    calculateRowItem(
                        row,
                        this.form.currency_type_id,
                        this.form.exchange_rate_sale
                    )
                );
            });
            this.form.items = items;
            this.calculateTotal();

            await this.setFormPosLocalStorage();
        },
        openFullWindow() {
            location.href = `/${this.resource}/pos_full`;
        },
        back(valor) {
            if (valor == 2) {
                this.place = true;
            } else {
                this.place = false;
                this.$refs.input_item.$el
                    .getElementsByTagName("input")[0]
                    .focus();
            }
        },
        setView() {
            this.place = "cat2";
        },
        nameSets(id) {
            let row = this.items.find(x => x.item_id == id);
            if (row) {
                if (row.sets.length > 0) {
                    return row.sets.join("-");
                } else {
                    return "";
                }
            }
        },
        openPromocion() {
            this.showdialogPromocion = true;
        },
        sidebarmodal() {
            console.log("abriendo modal sidebar");
            this.showcustomModal = true;
        },
        formatUrlImage(url) {
            if (!url) return;
            let formated = "storage/uploads/items/" + url;
            return `/${formated}`;
        },
        addFood(index = 0, type = null) {
            console.log();

            if (this.blockAdd && !this.configuration.box_orden) {
                this.$toast.error("No puede agregar productos a esta orden.");
                return;
            }
            this.selectedFood = JSON.parse(
                JSON.stringify(this.listFoods[index])
            );

            if (!this.selectedFood) return;

            if (
                Number(this.selectedFood.item.stock) <= 0 &&
                this.configuration.sales_stock == true
            ) {
                this.$toast.warning("Stock insuficiente");
                return;
            }
            let foodFound = this.localOrden.filter(
                f => f.id == this.selectedFood.id
            );

            if (foodFound.length != 0) {
                let { item } = this.selectedFood;
                if (item.lots_enabled) {
                    if (item.item_unit_types.length == 0) {
                        let message = "Producto con lote, ya  agregado";
                        this.$toast.warning(message);
                        return;
                    }
                }

                if (item.series_enabled) {
                    if (item.item_unit_types.length == 0) {
                        let message = "Producto con serie, ya  agregado";
                        this.$toast.warning(message);
                        return;
                    } else {
                        if (type) {
                            if (foodFound.some(i => i.type_id == type.id)) {
                                let message =
                                    "Producto con serie, ya  agregado";
                                this.$toast.warning(message);
                                return;
                            }
                        }
                    }
                }
                let qty = foodFound.reduce((a, b) => a + Number(b.quantity), 0);

                if (type) {
                    // qty += Number(type.quantity_unit);

                    qty += 1;
                } else {
                    qty += 1;
                }
                if (this.configuration.sales_stock == true) {
                    if (qty > Number(this.selectedFood.item.stock)) {
                        this.$toast.warning("Limite de stock alcanzado");
                        return;
                    }
                }
            } else {
                if (type) {
                    let qty = type.quantity_unit;
                    if (this.configuration.sales_stock == true) {
                        let stock = Number(this.selectedFood.item.stock);
                        if (qty > stock) {
                            this.$toast.warning("Limite de stock alcanzado");
                            return;
                        }
                    }
                }
            }

            this.currentFood = {
                id: this.selectedFood.id,
                food: this.selectedFood,
                observation: null,
                price: this.selectedFood.price,
                quantity: !!this.selectedFood.item.series_enabled ? 0 : 1
            };
            this.insertOrden(this.currentFood, this.selectedFood.id, type);
            this.$notify({
                title: this.currentFood.food.description.toLowerCase(),
                duration: 800,
                iconClass: "el-icon-food",
                message: "Agregado con èxito",
                position: "bottom-left"
            });

            this.currentFood = {
                food: null,
                observation: null,
                quantity: 0,
                price: 0
            };
            this.selectedFood = null;
            this.item = null;
            //this.setFalse();
            //this.$emit("buscarnuevo");
            //this.$forceUpdate();
        }
    },
    beforeUnmount() {
        document.removeEventListener("keydown", this.handleKeydown);
    },
    mounted() {
        document.addEventListener("keydown", this.handleKeydown);

        this.screenWidth = window.innerWidth;
        window.addEventListener("resize", this.handleResize);

        // this.teclasInit();
        Echo.channel("orden_pending").listen(
            `.orden-pending-${this.configuration.socket_channel}`,
            e => {
                let num = Number(e.amount);
                this.ordensPending = this.ordensPending + num;

                this.$notify({
                    title: "Aviso",
                    duration: 1500,
                    iconClass:
                        num > 0 ? "el-icon-star-on" : "el-icon-delete-solid",
                    message: num > 0 ? "Nueva orden" : "Una orden fue anulada",
                    position: "bottom-left"
                });
            }
        );
        Echo.channel("stock_orden").listen(
            `.stock-order-${this.configuration.socket_channel}`,
            e => {
                for (let index = 0; index < e.data.order_item.length; index++) {
                    let xFind = _.find(this.listFoods, {
                        id: e.data.order_item[index].food_id
                    });
                    if (xFind) {
                        let index_find = _.findIndex(this.listFoods, {
                            id: xFind.id
                        });
                        if (index_find !== -1) {
                            let nSaldo =
                                parseInt(
                                    this.listFoods[index_find].item.stock
                                ) - e.data.order_item[index].quantity;
                            this.listFoods[index_find].item.stock = nSaldo;
                        }
                    }
                }
            }
        );
        Echo.channel("print_orden").listen(
            `.print-order-${this.configuration.socket_channel}`,
            e => {
                console.log("imprimiendoxd", e);
                if (e.data.direct_printing == true) {
                    if (e.data.printing == true) {
                        this.Printer(
                            e.data.printer,
                            e.data.print,
                            e.data.copies,
                            e.data.user_id,
                            e.data.multiple_boxes,
                            e.data.typeuser,
                            e.data.printing
                        );
                    }
                } else {
                    console.log(e.data.print);
                    window.open(e.data.print, "_blank");
                }
            }
        );
    }
};
</script>
