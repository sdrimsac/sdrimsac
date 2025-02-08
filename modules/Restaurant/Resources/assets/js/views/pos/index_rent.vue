<template>
    <div
        style="position: relative"
        v-loading.fullscreen="loading"
        element-loading-text="Espere..."
    >
        <div class="row">
            <!-- <a href="../../../../../../../public/status_images/credito.jpg" target="_blank">
            <img src="../../../../../../../public/status_images/credito.jpg" alt="Descripción de la imagen" class="img-fluid">
      </a>-->
            <div
                v-if="screenWidth > 678"
                class="d-flex flex-row justify-content-start card mb-2"
            >
                <div class="col-12">
                    <div class="card-body p-2">
                        <div class="row">
                            <div
                                class="d-flex flex-wrap gap-2 justify-content-around"
                            >
                                <template
                                    v-if="
                                        configuration.restaurant &&
                                            !this.isSeller
                                    "
                                >
                                    <template v-if="isAndroid">
                                        <button
                                            class="btn btn-primary"
                                            type="button"
                                            @click="printLastDocument"
                                        >
                                            <i class="fas fa-print"></i>
                                            <template v-if="lastDocument">
                                                {{ lastDocument.numberPrint }}
                                            </template>
                                        </button>
                                    </template>
                                </template>

                                <button
                                    v-for="(option, idx) in optionsMenu"
                                    :key="idx"
                                    @click="trigerFunction(option.id)"
                                    class="btn btn-light d-flex flex-column align-items-center justify-content-center shadow-sm rounded-3 position-relative overflow-hidden transition-all hover-lift"
                                    style="min-width: 120px; min-height: 100px; border: none; background: linear-gradient(145deg, #ffffff, #f5f5f5);"
                                >
                                    <div class="text-center">
                                        <p
                                            v-for="(title,
                                            idx2) in option.title"
                                            :key="idx2"
                                            class="mb-0 fw-bold"
                                            :class="{
                                                'text-danger':
                                                    option.id == 66 &&
                                                    !localCashId
                                            }"
                                            style="font-size: 14px; color: #444;"
                                        >
                                            {{ title }}
                                        </p>
                                        <i
                                            :class="[option.icon, 'mt-2']"
                                            style="font-size: 24px; color: #073F68;"
                                        ></i>
                                    </div>
                                </button>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="row">
                                    <div
                                        v-for="(floor, index) in floors"
                                        :key="index"
                                        class="col-md-2 col-sm-4 col-6 mb-2"
                                    >
                                        <el-button
                                            class="w-100 d-flex align-items-center justify-content-center"
                                            :type="
                                                currentFloorId == floor.id
                                                    ? 'danger'
                                                    : 'primary'
                                            "
                                            @click="selectFloor(floor)"
                                        >
                                            <i class="fas fa-building mr-2"></i>
                                            <!-- Icono de piso -->
                                            {{ floor.name }}
                                        </el-button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div
                                    v-if="tables.length > 0"
                                    class="d-flex flex-wrap justify-content-center"
                                >
                                    <div
                                        v-for="(table, idx) in tables"
                                        :class="
                                            `${
                                                table.rent_month &&
                                                table.status_table_id == 2
                                                    ? 'btn-warning'
                                                    : table.is_cleaning
                                                    ? 'btn-dirty'
                                                    : table.status_table_id == 1
                                                    ? 'btn-free'
                                                    : table.status_table_id == 2
                                                    ? 'btn-danger'
                                                    : table.status_table_id == 3
                                                    ? 'btn-black'
                                                    : table.status_table_id == 5
                                                    ? 'btn-dirty'
                                                    : 'btn-warning'
                                            }`
                                        "
                                        class=" col-2 btn   m-1 d-flex flex-column justify-content-center align-items-center "
                                        :key="idx"
                                        @click="selectTable(table)"
                                        style="height: 175px;    max-width: 145px;"
                                    >
                                        <!-- <div class="d-flex justify-content-end w-100 mb-2">
                                            <el-button
                                                size="mini"
                                                @click.stop="viewImages(table)"
                                                type="primary"
                                                icon="el-icon-picture-outline"
                                            ></el-button>
                                        </div> -->
                                        <template>
                                            <div
                                                class="d-flex flex-column justify-content-center align-items-center"
                                            >
                                                <span
                                                    class="text-white m-1"
                                                    style="font-size:45px;"
                                                >
                                                    <template
                                                        v-if="
                                                            table.status_table_id ==
                                                                1
                                                        "
                                                    >
                                                        <i
                                                            class="fas fa-door-closed"
                                                        ></i>
                                                    </template>
                                                    <template
                                                        v-else-if="
                                                            table.status_table_id ==
                                                                2
                                                        "
                                                    >
                                                        <template
                                                            v-if="
                                                                table.due_date
                                                            "
                                                        >
                                                            <div
                                                                class="text-white"
                                                                style="font-size: 20px;font-weight: bold;"
                                                            >
                                                                {{
                                                                    table.due_date
                                                                }}
                                                            </div>
                                                        </template>
                                                        <template v-else>
                                                            <i
                                                                class="fas fa-bed"
                                                            ></i>
                                                        </template>
                                                    </template>
                                                    <template
                                                        v-else-if="
                                                            table.status_table_id ==
                                                                3
                                                        "
                                                    >
                                                        <i
                                                            class="fas fa-tools"
                                                        ></i>
                                                    </template>
                                                    <template
                                                        v-else-if="
                                                            table.status_table_id ==
                                                                5
                                                        "
                                                    >
                                                        <i
                                                            class="fas fa-walking"
                                                        ></i>
                                                    </template>
                                                    <template v-else>
                                                        <i
                                                            class="fas fa-ban"
                                                        ></i>
                                                    </template>
                                                </span>

                                                <span
                                                    class="h6 mt-2 text-white"
                                                >
                                                    {{
                                                        table.number
                                                            .toString()
                                                            .toUpperCase()
                                                    }}
                                                </span>
                                                <small
                                                    v-if="table.timer"
                                                    class="text-white"
                                                >
                                                    {{ table.timer }}
                                                </small>

                                                <span v-if="table.tower_name">
                                                    {{
                                                        table.tower_name.toUpperCase()
                                                    }}
                                                </span>
                                            </div>
                                            <div class="d-flex">
                                                <el-tooltip content="Imagenes">
                                                    <el-button
                                                        size="mini"
                                                        class="m-1"
                                                        @click.stop="
                                                            viewImages(table)
                                                        "
                                                    >
                                                        <i
                                                            class="fas fa-images"
                                                        ></i> </el-button
                                                ></el-tooltip>
                                                <el-tooltip
                                                    content="Pagar"
                                                    v-if="
                                                        table.status_table_id ==
                                                            2
                                                    "
                                                >
                                                    <el-button
                                                        size="mini"
                                                        class="m-1"
                                                        @click="
                                                            openPayment(
                                                                $event,
                                                                table.hotel_rent_id
                                                            )
                                                        "
                                                    >
                                                        <svg
                                                            width="20px"
                                                            height="20px"
                                                            viewBox="0 0 24 24"
                                                            fill="none"
                                                            xmlns="http://www.w3.org/2000/svg"
                                                        >
                                                            <path
                                                                d="M18.5 4H5.5C4.11929 4 3 5.11929 3 6.5V17.5C3 18.8807 4.11929 20 5.5 20H18.5C19.8807 20 21 18.8807 21 17.5V6.5C21 5.11929 19.8807 4 18.5 4Z"
                                                                stroke="#000000"
                                                                stroke-width="2"
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                            />
                                                            <path
                                                                d="M3 10H21"
                                                                stroke="#000000"
                                                                stroke-width="2"
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                            />
                                                            <path
                                                                d="M7 15H7.01"
                                                                stroke="#000000"
                                                                stroke-width="2"
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                            />
                                                            <path
                                                                d="M11 15H13"
                                                                stroke="#000000"
                                                                stroke-width="2"
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                            />
                                                        </svg> </el-button
                                                ></el-tooltip>
                                            </div>
                                            <div
                                                class="d-flex"
                                                v-if="
                                                    table.status_table_id == 2
                                                "
                                            >
                                                <el-tooltip
                                                    content="Infracción"
                                                >
                                                    <el-button
                                                        size="mini"
                                                        class="m-1"
                                                        @click="
                                                            seeInfraction(
                                                                $event,
                                                                table.hotel_rent_id
                                                            )
                                                        "
                                                    >
                                                        <svg
                                                            width="20px"
                                                            height="20px"
                                                            viewBox="0 0 24 24"
                                                            fill="none"
                                                            xmlns="http://www.w3.org/2000/svg"
                                                        >
                                                            <path
                                                                d="M12 8L12 13"
                                                                stroke="#000000"
                                                                stroke-width="2"
                                                                stroke-linecap="round"
                                                            />
                                                            <path
                                                                d="M12 16V16.5"
                                                                stroke="#000000"
                                                                stroke-width="2"
                                                                stroke-linecap="round"
                                                            />
                                                            <path
                                                                d="M12 21C16.9706 21 21 16.9706 21 12C21 7.02944 16.9706 3 12 3C7.02944 3 3 7.02944 3 12C3 16.9706 7.02944 21 12 21Z"
                                                                stroke="#000000"
                                                                stroke-width="2"
                                                            />
                                                        </svg> </el-button
                                                ></el-tooltip>

                                                <el-tooltip
                                                    content="Documentos"
                                                >
                                                    <el-button
                                                        size="mini"
                                                        class="m-1"
                                                        @click="
                                                            seePayments(
                                                                $event,
                                                                table.hotel_rent_id
                                                            )
                                                        "
                                                    >
                                                        <svg
                                                            width="20px"
                                                            height="20px"
                                                            viewBox="0 0 24 24"
                                                            fill="none"
                                                            xmlns="http://www.w3.org/2000/svg"
                                                        >
                                                            <path
                                                                d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15Z"
                                                                stroke="#000000"
                                                                stroke-width="2"
                                                            />
                                                            <path
                                                                d="M3 12H9M15 12H21"
                                                                stroke="#000000"
                                                                stroke-width="2"
                                                                stroke-linecap="round"
                                                            />
                                                            <path
                                                                d="M3 7H21"
                                                                stroke="#000000"
                                                                stroke-width="2"
                                                                stroke-linecap="round"
                                                            />
                                                            <path
                                                                d="M3 17H21"
                                                                stroke="#000000"
                                                                stroke-width="2"
                                                                stroke-linecap="round"
                                                            />
                                                            <path
                                                                d="M5 3H19C20.1046 3 21 3.89543 21 5V19C21 20.1046 20.1046 21 19 21H5C3.89543 21 3 20.1046 3 19V5C3 3.89543 3.89543 3 5 3Z"
                                                                stroke="#000000"
                                                                stroke-width="2"
                                                            />
                                                        </svg> </el-button
                                                ></el-tooltip>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                                <div
                                    v-else
                                    class="h-25 d-flex justify-content-center align-items-center"
                                >
                                    <span>Sin habitaciones</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-else>
                <!-- Modo Celular/ Movil -->
                <div class="d-flex flex-wrap">
                    <button
                        v-if="
                            isSellerConsolidated
                                ? customer_unit_type_id != null &&
                                  customer_unit_type_id != ''
                                : true
                        "
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
                                    <div
                                        class="scroll-track-visible"
                                        style="overflow-y: auto;"
                                    >
                                        <div class="row">
                                            <div class="col-12"></div>

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
                                                        ></el-option>
                                                    </el-select>
                                                </template>
                                            </div>
                                            <div class="col-12">
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
                                                        placeholder="Ingrese Un Producto"
                                                    >
                                                        <el-button
                                                            slot="append"
                                                            icon="el-icon-search"
                                                            @click="receiveData"
                                                        ></el-button>
                                                    </el-input>
                                                </template>
                                            </div>
                                            <div class="col-12">
                                                <el-checkbox
                                                    v-model="barcode"
                                                    @change="
                                                        saveInLocalStorageBarcode
                                                    "
                                                >
                                                    <h2
                                                        class="text-muted text-small"
                                                    >
                                                        Barcode
                                                    </h2>
                                                </el-checkbox>
                                            </div>
                                        </div>
                                        <div class="row d-flex flex-wrap">
                                            <div
                                                class="col-12 p-1"
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
                                                        Stock Almacenes
                                                        <br />
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
                                  }}-->
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
                                                                </template>
                                                            </label>
                                                            <br />
                                                        </span>
                                                    </div>
                                                    <div
                                                        id="card"
                                                        class="overflow-hidden coupon rounded d-flex flex-column justify-content-between p-1"
                                                        style="height: 125px; width: 297px ; margin-left: 9px; "
                                                    >
                                                        <div
                                                            @click="
                                                                (configuration.consolidated_quotations ||
                                                                    configuration.direct_unit_type) &&
                                                                data.types
                                                                    .length > 0
                                                                    ? clickCommand(
                                                                          data
                                                                              .types[0]
                                                                      )
                                                                    : addFood(
                                                                          index
                                                                      )
                                                            "
                                                        >
                                                            <div>
                                                                <span
                                                                    class="lead-font-weight-700 h5"
                                                                >
                                                                    {{
                                                                        configuration.direct_unit_type
                                                                    }}
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
                                  </div>-->
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
                                                                                }}
                                                                            </span>
                                                                        </span>
                                                                    </div>
                                                                    <div
                                                                        v-if="
                                                                            (data
                                                                                .item
                                                                                .is_set ==
                                                                                0 &&
                                                                                data
                                                                                    .item
                                                                                    .unit_type_id !=
                                                                                    'ZZ') ||
                                                                                configuration.show_stock_cash ==
                                                                                    true
                                                                        "
                                                                    >
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
                                                                            >
                                                                                Stock
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
                                          }}-->
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
                                                                                >Agotado</span
                                                                            >
                                                                        </template>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div
                                                            v-if="
                                                                isSellerConsolidated
                                                                    ? data.types
                                                                          .length >
                                                                      1
                                                                    : data.types
                                                                          .length >
                                                                      0
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
                                                                    Precios
                                                                    <i
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
                                        <div style="margin-top: 150px;"></div>
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
                                title
                                data-bs-original-title="Item Count"
                                aria-label="Item Count"
                            >
                                <i class="fas fa-list"></i>
                            </span>
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
                                    class="btn btn-light m-1 rounded d-flex flex-column align-items-center justify-content-center col-12"
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
        ></DrawerOrdens>

        <template>
            <payment-form
                @updateTables="updateTables"
                :user="user"
                :currencyIdChoice.sync="currencyIdChoice"
                @clearVariation="clearVariation"
                :promotions_document="promotions_document"
                :itemDefault.sync="itemDefault"
                :quotationId.sync="quotationId"
                :clientSaleNoteNumber.sync="clientSaleNoteNumber"
                :clientSaleNoteDiscount.sync="clientSaleNoteDiscount"
                :sellers.sync="sellers"
                :ordens_all_table.sync="ordens_all_table"
                :consignment_id="consignment_id"
                @removeConsignment="removeConsignment"
                :isConsignment.sync="isConsignment"
                :printer.sync="printer"
                :personalWhatsapp="personalWhatsapp"
                @getFile="getFile"
                :customer_default="customer_default"
                :variation.sync="variation"
                :documentsType="documentsType"
                :cash_id.sync="localCashId"
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
                @printer="Printer"
                :all_customers.sync="all_customers"
                :formVariation.sync="formVariation"
                :customer_variation="customer_variation"
                :affectation_igv_types="affectation_igv_types"
                @reloadItems="getFoods"
            ></payment-form>
        </template>
        <template v-if="configuration.college">
            <college-parents
                v-if="showDialogNewPerson"
                :showDialog.sync="showDialogNewPerson"
                :fromPos="true"
            ></college-parents>
        </template>
        <template v-else>
            <person-form
                v-if="showDialogNewPerson"
                :external="false"
                :showDialog.sync="showDialogNewPerson"
                :fromPos="true"
            ></person-form>
        </template>
        <cash-history
            :configuration="configuration"
            :cash_id.sync="localCashId"
            :showHistoryCash.sync="showHistoryCash"
            :area_id="area_id"
            :sender="personalWhatsapp ? sender : 'sdrimsac'"
        ></cash-history>
        <item-form
            v-if="showDialogNewItem"
            :showDialog.sync="showDialogNewItem"
            :external="true"
            :worker="worker"
            :fromPos="true"
        ></item-form>

        <tables
            :configuration="configuration"
            @creatingOrden="creatingOrden"
            @sendOrdens="sendOrdens"
            :showTables.sync="showTables"
        ></tables>
        <tables-rooms
            v-if="configuration.hotels"
            :cash_id.sync="localCashId"
            :configuration="configuration"
            :printer.sync="printer"
            @getTablesToClean="getTablesToClean"
            @paymentsOrden="paymentsOrden"
            @creatingOrden="creatingOrden"
            @roomWasCleaned="roomWasCleaned"
            @sendOrdens="sendOrdens"
            :roomSeeId="roomSeeId"
            :showTables.sync="showTablesRooms"
            :itemDefault.sync="itemDefault"
            :fromPos="true"
        ></tables-rooms>
        <documents-print
            :sender="personalWhatsapp ? sender : 'sdrimsac'"
            :company="company"
            :showDialog.sync="showDocumentsPrint"
            :config.sync="config"
            @sendOrdens="sendOrdens"
            @insertOrdenQuotation="insertOrdenQuotation"
            @sendItems="sendItems"
            :establishment.sync="establishments"
            :area_id="area_id"
            :printer.sync="printer"
        ></documents-print>

        <edit-product
            @getFoods="getFoods"
            :showDialog.sync="showEditProduct"
            :allItems="allFoods"
        ></edit-product>
        <room-rent-form
            :showDialog.sync="showRoomRentForm"
            :table="currentTable"
            :types="types"
            :configuration="configuration"
            @finishRegister="finishRegister"
        ></room-rent-form>
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
                <div class="col-8">
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

        <month-sales :showDialog.sync="showMonthSales"></month-sales>
        <iframe ref="pdfFrame" style="display: none;"></iframe>
        <cash-form
            v-if="showDialogCash"
            :showDialog.sync="showDialogCash"
            :recordId="cash_id"
            :fromBox="true"
            :fromPos="true"
            @updateCashId="updateCashId"
        ></cash-form>
        <rent-documents
            :showDialog.sync="showDialogRentDocuments"
            :rentId="rentId"
        ></rent-documents>
        <expenses-incomes
            v-if="configuration.show_expenses_incomes_caja"
            :showDialog.sync="showExpensesIncomes"
            :company="company"
            :cash_id="localCashId"
            :establishments="establishments"
            @checkCashAvailable="checkCashAvailable"
            :fromPos="true"
        ></expenses-incomes>
        <rent-payment
            :showDialog.sync="showDialogRentPayment"
            :rentId="rentId"
            @paymentsOrden="paymentsOrden"
        ></rent-payment>
        <rent-infractions
            :showDialog.sync="showDialogRentInfractions"
            :rentId="rentId"
        ></rent-infractions>
        <rent-info :showDialog.sync="showRentInfo" :rentId="rentId"></rent-info>
        <close-cash
            v-if="showDialogClose"
            :recordId.sync="localCashId"
            :showDialogClose.sync="showDialogClose"
            :fromBox="true"
            :configuration="configuration"
            :fromPos="true"
            @updateCashId="updateCashId"
        ></close-cash>
        <el-dialog
            title="Imágenes de la habitación"
            width="60%"
            :visible.sync="showImagesDialog"
            append-to-body
            @close="showImagesDialog = false"
        >
            <template v-if="currentImages.length > 0">
                <el-carousel :interval="4000" type="card" height="300px">
                    <el-carousel-item
                        v-for="image in currentImages"
                        :key="image.id"
                        class="bg-white"
                    >
                        <img
                            :src="image.image_path"
                            alt="Imagen"
                            class="carousel-image"
                            @click="openImage(image.image_path)"
                        />
                    </el-carousel-item>
                </el-carousel>
                <el-dialog
                    :visible.sync="isDialogVisible"
                    width="40%"
                    append-to-body
                    @close="isDialogVisible = false"
                    title="Imagen Real"
                > 
                 <div class="card bg-white">
                    <img
                        :src="selectedImage"
                        alt="Imagen Ampliada"
                        class="full-image"
                    />
                 </div>
                </el-dialog>
            </template>
            <template v-else>
                <div class="text-center">
                    <i class="fas fa-images"></i>
                    <p>No hay imágenes disponibles</p>
                </div>
            </template>
        </el-dialog>
    </div>
</template>

<style>
.carousel-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
  cursor: pointer;
  transition: transform 0.3s ease-in-out;
}

/* Imagen en pantalla completa */
.full-image {
  width: 90%;
  height: 90%;
  display: block;
  margin: 0 auto;
}

.btn-black {
    background-color: #000;
}
.btn-free {
    background-color: #91d24c;
}
.btn-dirty {
    background-color: #a7a5a8;
}
.btn-reserve {
    background-color: #7030a0;
}
.Vue-Toastification__toast--default.digital-pay-toast {
    background-color: red;
}
.warning-color {
    background-color: #ffa407 !important;
    color: #fff !important;
}
.custom-text-size {
    font-size: 0.8em;
}
.no-header .el-dialog__header {
    display: none;
}
.custom-dialog .el-dialog {
    background-color: #1025e6; /* Cambia este color según tus necesidades */
    border-radius: 8px; /* Para esquinas redondeadas */
    padding: 0; /* Elimina cualquier padding predeterminado */
}
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

import queryString from "query-string";

const DispatchModal = () => import("./partials/dispatch_modal.vue");

const PaymentForm = () => import("./partials/payment_rent.vue");
const ItemForm = () =>
    import("../../../../../../../resources/js/views/items/form.vue");
const PersonForm = () =>
    import("../../../../../../../resources/js/views/persons/form.vue");
const NumberPad = () => import("./partials/num_pad.vue");
const RentDocuments = () => import("./partials/rent_documents.vue");
const RentInfractions = () => import("./partials/rent_infractions.vue");
const RentPayment = () => import("./partials/rent_payment.vue");
const RentInfo = () => import("./partials/rent_info.vue");
const Tables = () => import("./partials/tables.vue");
const TablesRooms = () => import("./partials/tables_rooms.vue");
const CashHistory = () => import("./partials/cash_history.vue");
const DocumentsPrint = () => import("./partials/documents_print.vue");
const CashForm = () => import("../cash/form.vue");
const CloseCash = () => import("../cash/closecash.vue");
const EditProduct = () => import("./partials/edit_product.vue");
const ListOrden = () => import("./partials/list_ordens.vue");
const ListFoodMobiles = () => import("./partials/list_food_mobiles.vue");
const ExpensesIncomes = () => import("./partials/expenses_incomes.vue");
const MonthSales = () => import("./partials/month_sales.vue");
const RoomRentForm = () => import("./partials/room_rent_form.vue");

import DigitalPayComponent from "./partials/digital_pay_component.vue";

const options = {
    text: "Loading ...",
    customClass: "login_loading",
    spinner: "el-icon-loading",
    lock: true
};
export default {
    props: [
        "pending_order",
        "worker",
        "configuration",
        "establishments",
        "auth_login",
        "desarrollador",
        "company",
        "lareaId",
        "area",
        "areaId",
        "cash_id"
    ],
    components: {
        ExpensesIncomes,
        RentInfractions,
        RentDocuments,
        RentPayment,
        MonthSales,
        EditProduct,
        DispatchModal,
        CashHistory,
        DocumentsPrint,
        NumberPad,
        PaymentForm,
        ItemForm,
        PersonForm,
        DrawerOrdens,
        ListFood,
        ListOrden,
        Tables,
        ListFoodMobiles,
        TablesRooms,
        RoomRentForm,
        CashForm,
        CloseCash,
        RentInfo
    },
    mixins: [functions, exchangeRate],

    data() {
        return {
            isDialogVisible: false,
            selectedImage: "",
            localCashId: this.cash_id,
            currentImages: [],
            showImagesDialog: false,
            showRentInfo: false,
            showExpensesIncomes: false,
            showDialogRentPayment: false,
            showDialogRentDocuments: false,
            showDialogRentInfractions: false,
            showDialogClose: false,
            showDialogCash: false,
            types: [],
            all_tables: [],
            tables: [],
            floors: [],
            showRoomRentForm: false,
            lastQuery: null,
            divided_items: false,
            showDialogWarranty: false,
            ordenToPrint: [],
            cotizarConfirmado: false,
            digitalPayMessage: null,
            quality: false,
            model: false,
            showMonthSales: false,
            showQuotationListDialog: false,
            customersSearch: [],
            loading_search: false,
            selectedFood: null,
            showUnitTypeModal: false,
            currentIndex: null,
            addingType: false,
            showConsolidatedList: false,
            promotions_document: [],
            currencyIdChoice: "PEN",
            showDialogDetraction: false,
            showDialogCreditReportDaily: false,
            loadingItems: false,
            allLocalFoods: [],
            cotIdentifier: null,
            isSeller: false,
            isAnalist: false,
            showColorSize: false,
            currentColorSize: [],
            showSaleNoteCreditCash: false,
            searchSecondName: false,
            area_id: null,
            isHotelArea: false,
            isPiscinaArea: false,
            roomSeeId: null,
            tablesClean: [],
            tablesLeave: [],
            clientSaleNoteNumber: null,
            clientSaleNoteDiscount: 0,
            sellers: [],
            searchSeries: false,
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
            showTablesRooms: false,
            showHistoryCash: false,
            itemDefault: null,
            optionsMenu: [],
            time: null,
            blockCart: false,
            pagination: {},
            category: null,
            brand: null,
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
            brands: [],
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
            quotationId: null,
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
            showdialogPromocion: false,
            timer: null,
            users: [],
            showDialogCreditReportDaily: false,
            medida_alto: null,
            medida_ancho: null,
            medida_grosor: null,
            categoria_madera: null,
            formQtn: {
                customer_id: null
            },
            customer_unit_type_id: null,
            recomputeTrigger: 0,
            lastDocument: null,
            currentFloorId: null,
            currentTable: null,
            rentId: null,
            boxOperation: "Abrir",
            cashAvailable: 0
        };
    },
    beforeDestroy() {
        clearInterval(this.timer);
    },
    watch: {},
    async created() {
        console.log("la configuracion es ", this.configuration);
        this.area_id = this.worker.area_id;
        this.getExchange();
        this.isSeller = this.checkWorkerType("vendedor");
        /* ; */ this.isAnalist = this.checkWorkerType("analista");
        localStorage.setItem("quotation_stock", 0);
        let type_code = localStorage.getItem("type_code");
        let barcode = localStorage.getItem("barcode");
        let searchSeries = localStorage.getItem("searchSeries");
        let searchSecondName = localStorage.getItem("searchSecondName");
        let model = localStorage.getItem("model");
        let quality = localStorage.getItem("quality");
        /* let brand = localStorage.getItem("brand") */
        if (barcode) {
            this.barcode = barcode == "1" ? true : false;
        }
        if (type_code) {
            this.type_code = type_code == "1" ? true : false;
        }
        if (searchSeries) {
            this.searchSeries = searchSeries == "1" ? true : false;
        }
        if (searchSecondName) {
            this.searchSecondName = searchSecondName == "1" ? true : false;
        }
        if (model) {
            this.model = model == "1" ? true : false;
        }
        if (quality) {
            this.quality = quality == "1" ? true : false;
        }
        /* if (brand){
            this.brand = brand == "1" ? true : false;
        } */
        // ;
        this.conf = this.establishments.conf ?? {};
        this.ordensPending = this.pending_order;
        this.loading = true;
        //this.socketWhatsappConfig();
        await this.getTables();
        await this.initForm(this.customer_default.id);
        await this.getPrinter();
        this.setMenuOptions();
        // await this.changeCustomer();
        this.loading = false;
        if (
            this.configuration.credits &&
            this.configuration.sale_note_credit_confirm
        ) {
            this.openCredit();
        }
        this.$eventHub.$on("reloadDataPersons", customer_id => {
            this.reloadDataCustomers(customer_id);
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

        setTimeout(() => {
            this.timer = setInterval(() => {
                this.updateTime();
            }, 1000);
        }, 500);
    },
    sockets: {},
    computed: {
        isAndroid() {
            return this.configuration.android_configuration;
        },
        isSellerConsolidated() {
            return this.isSeller && this.configuration.consolidated_quotations;
        },
        canAddItem() {
            if (this.isSeller && this.configuration.consolidated_quotations) {
                return !(
                    this.customer_unit_type_id == null ||
                    this.customer_unit_type_id == ""
                );
            }
            return true;
        }
    },
    methods: {
        openImage(imagePath) {
            this.selectedImage = imagePath;
            this.isDialogVisible = true; // Abre el modal
        },
        checkCashAvailable() {
            this.$http
                .get("/caja/worker/cash_available/" + this.localCashId)
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
        openPayment($event, id) {
            $event.stopPropagation();
            this.showDialogRentPayment = true;
            this.rentId = id;
        },
        seePayments($event, id) {
            $event.stopPropagation();
            this.showDialogRentDocuments = true;
            this.rentId = id;
            console.log("id", id);
        },
        seeInfraction($event, id) {
            this.showDialogRentInfractions = true;
            this.rentId = id;
            $event.stopPropagation();
            console.log("id", id);
        },
        updateCashId(id) {
            this.localCashId = id;
            this.boxOperation = id ? "Cerrar" : "Abrir";
            this.optionsMenu[0].title = [this.boxOperation, " Caja"];
        },
        updateTables() {
            this.$http.get(`/caja/rent/get-tables`).then(response => {
                this.tables = response.data.tables;
            });
        },
        async finishRegister(id, paymentVariation = null) {
            this.updateTables();
            // this.rentId = id;
            // const response = await this.$http(
            //     `/caja/rent/advance-document/${id}`
            // );
            // const { data } = response;
            // let { items, hotel_rent_id, customer_number } = data;
            // if (paymentVariation) {
            //     let { description, price } = paymentVariation;
            //     let foodDefault = this.itemDefault;
            //     foodDefault.description = description;
            //     foodDefault.quantity = 1;
            //     foodDefault.sale_unit_price = Number(price);
            //     this.paymentsOrden(
            //         {
            //             items,
            //             is_room: true,
            //             is_advance: true,
            //             hotel_rent_id,
            //             customer_number
            //         },
            //         [foodDefault]
            //     );
            // } else {
            //     this.paymentsOrden({
            //         items,
            //         is_room: true,
            //         is_advance: true,
            //         hotel_rent_id,
            //         customer_number
            //     });
            // }
        },

        sendToCleanById(id) {
            console.log(
                "🚀 ~ file: index_rent.vue:1353 ~ methods: { ~ id:",
                id
            );
        },
        sendToMaintenanceById(id) {
            console.log(
                "🚀 ~ file: index_rent.vue:1353 ~ methods: { ~ id:",
                id
            );
        },
        selectTable(table) {
            if (!this.localCashId) {
                this.$showSAlert(
                    "Error",
                    "Necesita abrir una caja para poder seleccionar una habitación",
                    "error"
                );
                return;
            }

            if (table.status_table_id == 1) {
                this.currentTable = table;
                this.showRoomRentForm = true;
            } else {
                this.showRentInfo = true;
                this.rentId = table.hotel_rent_id;
            }
        },
        selectFloor(floor) {
            this.currentFloorId = floor.id;
            this.tables = this.all_tables.filter(t => t.floor_id == floor.id);
        },
        async printFileWithRawBT(fileUrl) {
            try {
                const response = await fetch(fileUrl);

                // Verificar que el contenido sea PDF
                const contentType = response.headers.get("content-type");
                // if (!contentType || !contentType.includes('application/pdf')) {
                //     throw new Error('El archivo no es un PDF válido');
                // }

                const pdfBlob = await response.blob();

                // Convertir el Blob a base64 usando FileReader
                const base64File = await new Promise(resolve => {
                    const reader = new FileReader();
                    reader.onloadend = () => {
                        // Extraer solo la parte base64 del resultado, removiendo el data URL prefix
                        const base64String = reader.result.split(",")[1];
                        resolve(base64String);
                    };
                    reader.readAsDataURL(pdfBlob);
                });

                // Crear la URL del Intent con el esquema rawbt
                const intentUrl = `rawbt:base64,${base64File}`;

                // Redirigir al Intent
                window.location.href = intentUrl;
            } catch (error) {
                console.error("Error al intentar imprimir con RawBT:", error);
                this.$message.error(
                    `Error: ${error.message ||
                        "No se pudo imprimir el archivo. Verifica la instalación de RawBT."}`
                );
            }
        },
        printOrden(url, id) {
            window.open(url, "_blank");
            this.ordenToPrint = this.ordenToPrint.filter(o => o.id != id);
        },
        printLastDocument() {
            if (!this.lastDocument) return;
            let { external_id, document_type_id } = this.lastDocument;
            let url = "";
            if (document_type_id == "80") {
                url = `/sale-notes/print/${external_id}/ticket`;
            } else if (document_type_id == "01" || document_type_id == "03") {
                url = `/print/document/${external_id}/ticket`;
            }
            if (url) {
                window.open(url, "_blank");
            }
        },
        async getLastDocument() {
            try {
                this.loading = true;
                const response = await this.$http(
                    `/caja/worker/print_last_document`
                );

                if (response.status == 200) {
                    const {
                        data: { result }
                    } = response;
                    this.lastDocument = result;
                    this.lastDocument.numberPrint =
                        this.lastDocument.series +
                        "-" +
                        this.lastDocument.number;
                }
            } catch (e) {
                this.$toast.error("No se pudo obtener el ultimo documento");
            } finally {
                this.loading = false;
            }
        },
        handleCotizarConfirmadoRegreso(newValue) {
            this.cotizarConfirmado = newValue; // Actualiza el estado con el nuevo valor
            /* console.log(
                "Nuevo valor de cotizarConfirmado en el padre:",
                this.cotizarConfirmado
            ); */
        },
        handleCotizarConfirmado(newValue) {
            this.cotizarConfirmado = newValue; // Actualiza el estado con el nuevo valor
            /* console.log(
                "Evento recibiendo en el index:",
                this.cotizarConfirmado
            );  */
        },

        async limpiarcache(reload = true) {
            if ("caches" in window) {
                caches.keys().then(function(cacheNames) {
                    console.log(cacheNames);
                    cacheNames.forEach(function(cacheName) {
                        caches.delete(cacheName);
                    });
                });
            }

            navigator.serviceWorker
                ?.getRegistrations()
                .then(function(registrations) {
                    for (let registration of registrations) {
                        registration.unregister();
                    }
                });

            if (reload) {
                setTimeout(() => {
                    window.location.reload();
                }, 400);
            }
        },
        openQuotationDialog() {
            this.showQuotationListDialog = true;
        },

        changeCustomer() {
            this.localOrden = [];
            // this.$emit("update:localOrden", []);
            this.searchFoodByCustomerUnitTypeId(this.formQtn.customer_id);
            // this.$emit(
            //     "searchFoodByCustomerUnitTypeId",
            //     this.formQtn.customer_id
            // );
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
        searchFoodByCustomerUnitTypeId(id) {
            this.customer_unit_type_id = id;

            this.getFoods("customer_unit_type_id=" + id ?? "");
        },
        addUnitType(type) {
            this.addFood(this.currentIndex, type);
        },
        addCategoriaMadera(categoria, index) {
            /* ; */ //no se imprime en vista normal
            this.currentIndex = index;
            this.addingType = true;
            this.addFood(this.currentIndex, null, categoria);
        },
        clearVariation() {
            this.variation = false;
            this.formVariation = {};
        },
        insertOrdenQuotation(quotation_id, identifier, item, customer_number) {
            /*  */
            this.quotationId = quotation_id;
            this.cotIdentifier = identifier;
            this.form.quotation_customer_number = customer_number;
            let type = null;
            let categoriaMadera = null;
            if (item.type_quotation) {
                type = item.type_quotation;
            }
            if (item.categoriaMadera) {
                categoriaMadera = item.categoriaMadera;
            }
            this.insertOrden(item, item.id, type, false, categoriaMadera);
        },
        closeModal() {
            this.showDialogCreditReportDaily = false;
        },
        updateCurrencyChoice(currency) {
            console.log("currency", currency);
            this.currencyIdChoice = currency == "S/" ? "PEN" : "USD";
        },
        openCreditReportDaily() {
            this.showDialogCreditReportDaily = true;
        },
        checkWorkerType(type) {
            if (!type) return false;
            let { worker_type } = this.worker;
            if (!worker_type) return false;
            let { description } = worker_type;
            if (description.toLowerCase() == type.toLowerCase()) return true;
            return false;
        },
        async tableOpen(id) {
            if (!this.localCashId) {
                this.$message({
                    showClose: true,
                    type: "warning",
                    message: "Seleccione una caja para poder abrir una mesa"
                });
                return;
            }
            this.roomSeeId = id;
            this.openTablesRooms(id);
        },
        async roomCleaned(id) {
            const response = await this.$http(`/caja/rooms/cleaned/${id}`);
            if (response.status == 200) {
                this.tablesClean = this.tablesClean.filter(t => t.id != id);
            }
        },
        roomWasCleaned(id) {
            this.tablesClean = this.tablesClean.filter(t => t.id != id);
        },
        async isCleaned(id) {
            try {
                await this.$confirm(
                    "¿Está seguro de marcar como limpiada la habitación?",
                    "Mensaje",
                    {
                        confirmButtonText: "Aceptar",
                        cancelButtonText: "Cancelar",
                        type: "warning"
                    }
                );
                await this.roomCleaned(id);
            } catch (e) {}
        },
        playSound(sound = "services_sound.mp3") {
            let audio = new Audio(`/sounds/${sound}`);
            if (audio) {
                audio.play();
            }
        },
        updateTime() {
            this.tablesLeave.forEach(t => {
                let now = new Date();

                //crea una nueva fecha con las propiedades checkout_date_estimated checkout_time_estimated de t
                let { hotel_rent_items } = t;
                let hotel_rent_item = hotel_rent_items;
                // hotel_rent_items[hotel_rent_items.length - 1];
                let {
                    checkout_date_estimated,
                    checkout_time_estimated
                } = hotel_rent_item;
                let date = new Date(
                    `${checkout_date_estimated} ${checkout_time_estimated}`
                );
                let alarm_to_end = this.configuration.alarm_to_end;
                alarm_to_end = alarm_to_end * 60 * 1000;
                let diff = date.getTime() - now.getTime();
                if (diff < 0) {
                    t.timer = null;
                } else {
                    if (diff <= alarm_to_end) {
                        diff = Math.floor(diff / 1000);
                        let seconds = diff % 60;
                        diff = Math.floor(diff / 60);
                        let minutes = diff % 60;
                        let hours = Math.floor(diff / 60);
                        if (hours >= 1) {
                            t.timer = `${hours < 10 ? "0" : ""}${hours}:${
                                minutes < 10 ? "0" : ""
                            }${minutes}:${seconds < 10 ? "0" : ""}${seconds}`;
                        } else {
                            t.timer = `${minutes < 10 ? "0" : ""}${minutes}:${
                                seconds < 10 ? "0" : ""
                            }${seconds}`;
                        }
                    } else {
                        t.timer = null;
                    }
                }
            });

            this.tablesClean.forEach(t => {
                if (t.is_cleaning) {
                    if (t.cleaned === true) {
                        return;
                    }
                    let { cleaning_start_date } = t;
                    let date = new Date(cleaning_start_date);
                    let now = new Date();
                    let diff = date.getTime() - now.getTime();

                    if (diff <= 0) {
                        t.cleaned = true;
                        t.time_to_finish = null;
                        this.playSound();
                    } else {
                        diff = Math.floor(diff / 1000);
                        let seconds = diff % 60;
                        diff = Math.floor(diff / 60);
                        let minutes = diff % 60;
                        t.time_to_finish = `${
                            minutes < 10 ? "0" : ""
                        }${minutes}:${seconds < 10 ? "0" : ""}${seconds}`;
                    }
                }
            });
        },

        sendItems(items, clientNumber, notes, dscto_global) {
            this.clientSaleNoteNumber = clientNumber;
            this.clientSaleNoteDiscount = dscto_global;
            this.form.sale_notes_relateds = notes;
            for (let index = 0; index < items.length; index++) {
                let element = items[index];
                this.insertOrden(element, element.id, null);
            }
        },
        setMenuOptions() {
            this.optionsMenu = [
                {
                    id: 66,
                    title: [this.boxOperation, " Caja"],
                    icon: "fas fa-cash-register",
                    visible: true && !this.isSeller
                },

                {
                    id: 1,
                    title: ["Comprobantes"],
                    icon: "fas fa-print ",
                    visible: true && !this.isSeller
                },

                {
                    id: 4,
                    title: ["Clientes"],
                    //icon: "fas fa-hand-holding-water"
                    icon: "fas fa-user ",
                    visible: this.isSeller
                        ? this.configuration.button_consolidate
                        : true
                },

                {
                    id: 6,
                    title: ["Venta", "del Dia"],
                    icon: "icofont-money-bag",
                    visible:
                        (this.configuration.view_daily_cash ||
                            this.configuration.view_daily_cash_pin) &&
                        !this.isSeller
                },

                {
                    id: 7,
                    title: ["Historial", ""],
                    icon: "fas fa-history ",
                    visible: true && !this.isSeller
                }
            ];
            if (this.configuration.show_expenses_incomes_caja) {
                this.optionsMenu.push({
                    id: 77,
                    title: ["Ingresos/", "/Gastos"],
                    icon: "fas fa-money-bill-wave-alt"
                });
            }
        },
        formatDescriptionType(type) {
            let price = this.getDefaultPrice(type);
            return `${type.description} (${Number(
                type.quantity_unit
            )}) - S/ ${price}`;
        },
        saveInLocalStorageSearchSeries(searchSeries) {
            localStorage.setItem("searchSeries", searchSeries ? "1" : "0");
        },
        saveInLocalStorageSearchSecondName(searchSecondName) {
            localStorage.setItem(
                "searchSecondName",
                searchSecondName ? "1" : "0"
            );
        },
        saveInLocalStorageBarcode(barcode) {
            localStorage.setItem("barcode", barcode ? "1" : "0");
        },
        saveInLocalStorage(type_code) {
            localStorage.setItem("type_code", type_code ? "1" : "0");
        },
        saveInLocalStorageModel(model) {
            localStorage.setItem("model", model ? "1" : "0");
        },
        saveInLocalStorageQuality(quality) {
            localStorage.setItem("quality", quality ? "1" : "0");
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
        buttonSmTables() {
            if (this.configuration.hotels) {
                if (this.isCurrentAreaHotel()) {
                    this.roomSeeId = null;
                    this.openTablesRooms();
                } else {
                    this.openTables();
                }
            } else {
                this.openTables();
            }
        },
        handleKeydown(event) {
            let { keyCode, key } = event;
            switch (keyCode) {
                //f4
                case 115:
                    event.preventDefault(); // Evita la función por defecto del navegador
                    if (this.configuration.credits) {
                        this.openCredit();
                    }
                    // this.openDrawer();
                    break;
                case 113:
                    event.preventDefault(); // Evita la función por defecto del navegador
                    if (this.configuration.hotels) {
                        if (this.isCurrentAreaHotel()) {
                            this.roomSeeId = null;
                            this.openTablesRooms();
                        } else {
                            this.openTables();
                        }
                    } else {
                        if (this.configuration.restaurant) {
                            this.openTables();
                        }
                        // this.openTables();
                    }

                    break;

                default:
                    break;
            }
        },
        isCurrentAreaHotel() {
            return this.worker.area.description.toUpperCase() == "HOTEL";
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
                `/caja/worker/cash/get_printer/${this.worker.area_id}`
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
            //change;
        },
        /* changeBrand(brand){

        }, */

        receiveData(data) {
            this.search_items(data);
        },
        chlidMetod(data) {
            /* ; */
        },
        searchFromMobil(data) {
            /* ; */
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
            } catch (e) {}
            this.socket.on("ready", message => {
                this.showMessage(message);
            });
            this.socket.on("authenticated", ({ message, sender }) => {
                this.sender = sender;
                this.showMessage(message);
            });
            this.socket.on("connected", ({ message }) => {
                this.$toast.success(message, { icon: "fab fa-whatsapp fa-2x" });
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
                this.$message.error(msg);
            } finally {
                this.limpiarForm();
            }
        },
        creatingOrden(number, id, is_room = false) {
            this.isCreatingOrden = true;
            this.clientTableData = {
                ref: undefined,
                table: number,
                table_id: id,
                is_room
            };
        },
        async setPaymentOrden(items, allTables = false) {
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
                items,
                allTables
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
                this.ordens[i].food.item.color_size = item.color_size
                    ? [...item.color_size]
                    : [];
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
            this.form.currency_type_id =
                this.currencyIdChoice == "S/" ? "PEN" : "USD";

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
                            orden.type_price_ranges =
                                unit_type.item_unit_type_price_ranges;
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
            this.setPaymentOrden(orden_items, true);
            // this.idOrden = orden.id;
        },

        //aqui se envia los productos desde la mesa
        sendOrdens(orden) {
            if (this.localOrden.length != 0 && !this.configuration.box_orden) {
                this.$toast.warning("Tiene productos seleccionados.");
                return;
            }
            if (orden.quotation_id) {
                this.quotationId = orden.quotation_id;
                this.cotIdentifier = orden.cot;
            }
            if (orden.mesa != undefined && orden.id != undefined) {
                this.clientTableData = {
                    table: orden.mesa.number,
                    ref: orden.ref ?? "-",
                    table_id: orden.mesa.id,
                    orden_id: orden.id,
                    is_room: orden.mesa.is_room
                };
            }

            // orden.type_id = type ? type.id : null;
            //  orden.type_description = type ? type.description : null;
            // orden.type_quantity = type ? Number(type.quantity_unit) : 0;
            this.ordensItems = [
                ...orden.orden_items.map(o => {
                    let orden = o;
                    if (orden.name_product_pdf) {
                        orden.food.item.name_product_pdf =
                            orden.name_product_pdf;
                    }
                    orden.price = Number(orden.price).toFixed(2);
                    if (orden.unit_type_id) {
                        let { item } = orden.food;

                        let unit_type = item.item_unit_types.find(
                            u => u.id == orden.unit_type_id
                        );
                        if (unit_type) {
                            orden.type_id = unit_type.id;
                            orden.type_description = unit_type.description;
                            orden.type_price_ranges =
                                unit_type.item_unit_type_price_ranges;
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
        async trigerFunction(id) {
            switch (id) {
                case 77:
                    if (!this.localCashId) {
                        this.$showSAlert("Error", "Abra una caja", "error");
                        return;
                    } else {
                        this.showExpensesIncomes = true;
                    }
                    break;
                case 66:
                    if (this.localCashId) {
                        this.showDialogClose = true;
                    } else {
                        this.showDialogCash = true;
                    }
                    break;
                case 256:
                    this.showDialogWarranty = true;
                    break;
                case 74:
                    this.showMonthSales = true;
                    break;
                case 214:
                    this.showQuotationListDialog = true;
                    break;
                case 63:
                    this.showConsolidatedList = true;
                    break;
                case 97:
                    this.showDialogDetraction = true;
                    break;
                case 195:
                    this.showSaleNoteCreditCash = true;
                    break;
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
                case 171:
                    this.roomSeeId = null;
                    this.openTablesRooms();
                    break;
                case 6:
                    if (!this.localCashId) {
                        this.$showSAlert(
                            "Error",
                            "Necesita abrir una caja para poder seleccionar una habitación",
                            "error"
                        );
                        return;
                    }
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
                case 34:
                    this.openCreditReportDaily();
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
        openTablesRooms(id) {
            this.showTablesRooms = true;
        },
        openviewsItemsMobil() {
            this.showDialogViewItems = true;
        },
        cancelOrden() {
            this.clientSaleNoteNumber = null;
            this.clientSaleNoteDiscount = 0;
            this.isConsignment = false;
            this.localOrden = [];
            this.ordensItems = [];
            this.clientTableData = {};
            this.isCreatingOrden = false;
            this.idOrden = undefined;
            this.quotationId = null;
            this.cotIdentifier = null;

            if (
                !this.configuration.all_items_pos &&
                this.configuration.restaurant
            ) {
                this.search_items(null);
            }
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
            this.form.is_room = form.is_room;
            this.form.offert = form.offert;
            this.form.to_carry = form.to_carry;
            this.form.comercial_treatment_id = form.comercial_treatment_id;
            this.form.ref = form.ref;
            if (this.form.is_room) {
                if (form.customer_id) {
                    this.form.customer_id = form.customer_id;
                }
                this.form.vacate = false;
                this.form.credit_line = form.credit_line;
                this.form.promotion_sale = form.promotion_sale;
                this.form.hotel_rent_item_service_id =
                    form.hotel_rent_item_service_id;
                this.form.is_list_credit = form.is_list_credit;
                this.form.orden_ids = form.orden_ids;
                this.form.hotel_rent_item_ids = form.hotel_rent_item_ids;
                this.form.is_advance = form.is_advance;
                this.form.hotel_rent_id = form.hotel_rent_id;
                this.form.is_rent_payment = form.is_rent_payment;
                this.form.hotel_customer_number = form.customer_number;
                //this.form.caja = true;
            }
            let { items } = form;

            this.ordens = [...items];

            let ixd = [];

            for (let i = 0; i < items.length; i++) {
                let item = JSON.parse(JSON.stringify(items[i]));
                this.ordens[i].food.item.categoriaMadera = item.categoriaMadera;
                this.ordens[i].food.item.from_unit_type_id = item.type_id;
                this.ordens[i].food.item.from_unit_type_id_desc =
                    item.type_description;

                this.ordens[i].food.item.quantity = item.quantity;
                this.ordens[i].food.item.lotes = item.lotes;
                this.ordens[i].food.item.lots = item.series;
                this.ordens[i].food.item.color_size = item.color_size
                    ? [...item.color_size]
                    : [];
                this.ordens[i].food.item.sale_unit_price = item.price;
                ixd.push(item.price);
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
                this.formVariation.hotel_customer_number = form.customer_number;
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
            } else {
                this.variation = false;
            }

            this.form.items = this.ordens.map(o =>
                Object.assign({}, o.food.item)
            );
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
                this.form.currency_type_id =
                    this.currencyIdChoice == "S/" ||
                    this.currencyIdChoice == undefined ||
                    this.currencyIdChoice == "PEN"
                        ? "PEN"
                        : "USD";

                /* console.log("this.currencyIdChoice ::::", JSON.stringify(this.currencyIdChoice)); */
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
            if (type.total == null || this.configuration.price_item_unit_type) {
            } else {
                price = Number(type.total);
            }
            return price;
        },
        async insertItemFromNoteSales() {},
        checkDetractionItems(item) {
            if (!this.configuration.detraction) return false;
            let {
                item: { subject_to_detraction }
            } = item;
            let ordenHasDetraction = this.localOrden.some(
                o => o.food.item.subject_to_detraction
            );
            if (
                subject_to_detraction == 1 &&
                !ordenHasDetraction &&
                this.localOrden.length > 0
            ) {
                this.$toast.error(
                    "Este producto esta sujeto a detracción, y existen productos que no lo están"
                );
                return false;
            }
            if (subject_to_detraction == 0 && ordenHasDetraction) {
                this.$toast.error(
                    "Este producto no esta sujeto a detracción, y existen productos que si lo están"
                );
                return false;
            }

            return true;
        },
        insertOrden(
            orden,
            food_id,
            type,
            selectSerie = false,
            categoriaMadera = null,
            color_size = []
        ) {
            let { food: item } = orden;
            let passDetraction = this.checkDetractionItems(item);
            if (!passDetraction && this.configuration.detraction) {
                return;
            }
            let ordenAdded = this.localOrden.filter(ord => ord.id == food_id);

            if (ordenAdded.length == 0 || this.divided_items) {
                orden.to_carry = false;
                orden.change_subtotal = false;
                if (this.clientSaleNoteNumber) {
                } else {
                    orden.series = [];
                }
                orden.color_size = color_size;
                orden.lotes = [];
                let added = false;
                let {
                    food: {
                        item: { lots_group, currency_type_id },
                        series
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
                orden.type_price_ranges = type
                    ? type.item_unit_type_price_ranges
                    : [];
                orden.type_quantity = type ? Number(type.quantity_unit) : 0;
                if (categoriaMadera && categoriaMadera.price) {
                    orden.categoriaMadera = categoriaMadera;
                }
                // esta condicon afecta los precios de la madera
                if (categoriaMadera && categoriaMadera.price) {
                    orden.price = categoriaMadera.price;
                }

                if (selectSerie) {
                    let serie = this.input_item.toLowerCase();
                    let serieFind = series.find(s =>
                        s.series.toLowerCase().includes(serie)
                    );
                    if (serieFind) {
                        orden.series = [serieFind];
                    }
                    orden.quantity = 1;
                }

                orden.original_price = orden.price;
                if (type) {
                    orden.quantity = orden.food.item.series_enabled
                        ? 0
                        : orden.quantity || 1;
                    orden.price = this.getDefaultPrice(type);
                }
                if (
                    this.configuration.price_item_unit_type &&
                    type &&
                    type.id
                ) {
                    let {
                        food: {
                            item: { item_unit_types }
                        }
                    } = orden;
                    let unit_type = item_unit_types.find(
                        iut => iut.id == type.id
                    );
                    if (unit_type) {
                        let prices = [
                            unit_type.price1,
                            unit_type.price2,
                            unit_type.price3
                        ];
                        let default_price = unit_type.price_default - 1;
                        let newPrices = [
                            prices[default_price],
                            ...prices.filter(
                                (_, index) => index !== default_price
                            )
                        ].filter(p => p > 0);

                        orden.prices = newPrices;
                    }
                }
                if (this.configuration.divided_items) {
                    if (this.divided_items) {
                        orden.will_be_divided = true;
                    }
                }
                if (this.configuration.order_desc_items == true) {
                    this.localOrden.push(orden);
                } else {
                    this.localOrden.unshift(orden);
                }
                /* this.$refs.list_orden.changeCurrencyItems(); */
                //this.localOrden = this.changeCurrencyItems();
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
                        if (
                            this.configuration.price_item_unit_type &&
                            type &&
                            type.id
                        ) {
                            let {
                                food: {
                                    item: { item_unit_types }
                                }
                            } = orden;
                            let unit_type = item_unit_types.find(
                                iut => iut.id == type.id
                            );
                            if (unit_type) {
                                let prices = [
                                    unit_type.price1,
                                    unit_type.price2,
                                    unit_type.price3
                                ];
                                let default_price = unit_type.price_default - 1;

                                let newPrices = [
                                    prices[default_price],
                                    ...prices.filter(
                                        (_, index) => index !== default_price
                                    )
                                ].filter(p => p > 0);

                                orden.prices = newPrices;
                            }
                        }
                        // orden.quantity = Number(type.quantity_unit);
                        orden.quantity = orden.food.item.series_enabled
                            ? 0
                            : orden.quantity || 1;

                        orden.price = this.getDefaultPrice(type);
                        orden.type_id = type.id;
                        orden.type_description = type.description;
                        orden.type_price_ranges = type
                            ? type.item_unit_type_price_ranges
                            : [];
                        orden.to_carry = false;
                        orden.change_subtotal = false;
                        orden.series = [];
                        orden.lotes = [];
                        orden.color_size = [];
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
                        orden.original_price = orden.price;
                        orden.type_quantity = type
                            ? Number(type.quantity_unit)
                            : 0;
                        if (this.configuration.order_desc_items == true) {
                            this.localOrden.push(orden);
                        } else {
                            this.localOrden.unshift(orden);
                        }
                        this.$refs.list_orden.changeCurrencyItems();
                    }

                    //y si no agregarla como nueva
                } else if (categoriaMadera) {
                    let indexFind = this.localOrden.findIndex(
                        orden =>
                            orden.categoriaMadera &&
                            orden.categoriaMadera.key == categoriaMadera.key
                    );
                    if (indexFind != -1) {
                        this.localOrden[indexFind].quantity =
                            Number(this.localOrden[indexFind].quantity) +
                            (categoriaMadera.quantity || 1);
                        // Number(type.quantity_unit);
                    } else {
                        // orden.quantity = Number(type.quantity_unit);

                        if (categoriaMadera.price) {
                            orden.quantity = categoriaMadera.quantity;
                            orden.price = categoriaMadera.price;
                            orden.categoriaMadera = categoriaMadera;
                        }
                        orden.to_carry = false;
                        orden.change_subtotal = false;
                        orden.series = [];
                        orden.lotes = [];
                        orden.color_size = [];
                        orden.original_price = orden.price;
                        if (this.configuration.order_desc_items == true) {
                            this.localOrden.push(orden);
                        } else {
                            this.localOrden.unshift(orden);
                        }
                        this.$refs.list_orden.changeCurrencyItems();
                    }
                } else {
                    let {
                        food: { series }
                    } = orden;

                    //si es original, seguir agregando uno
                    let indexFind = this.localOrden.findIndex(
                        p => p.id == food_id && p.type_id == null
                    );
                    if (indexFind != -1) {
                        if (selectSerie) {
                            let serie = this.input_item.toLowerCase();
                            let serieFind = series.find(s =>
                                s.series.toLowerCase().includes(serie)
                            );
                            if (serieFind) {
                                let exist = this.localOrden[
                                    indexFind
                                ].series.find(s => s.id == serieFind.id);
                                if (!exist) {
                                    this.localOrden[indexFind].series = [
                                        ...this.localOrden[indexFind].series,
                                        serieFind
                                    ];
                                } else {
                                    this.$toast.warning(
                                        "La serie ya fue agregada"
                                    );
                                    return;
                                }
                            }
                        }
                        if (color_size.length > 0) {
                            let existingColorSize = this.localOrden[indexFind]
                                .color_size;

                            for (let newColor of color_size) {
                                let existingColor = existingColorSize.find(
                                    c => c.code === newColor.code
                                );

                                if (existingColor) {
                                    if (
                                        existingColor.quantity + 1 >
                                        newColor.stock
                                    ) {
                                        this.$toast.error(
                                            `No hay suficiente stock para ${newColor.code}`
                                        );
                                        return;
                                    }
                                    existingColor.quantity =
                                        Number(existingColor.quantity) + 1;
                                } else {
                                    if (newColor.stock < 1) {
                                        this.$toast.error(
                                            `No hay stock disponible para ${newColor.code}`
                                        );
                                        return;
                                    }
                                    newColor.quantity = 1;
                                    existingColorSize.push(newColor);
                                }
                            }
                        }
                        //actualizamos el elemento que agregamos, pero lo sacamos del objeot y lo volvemos a colocar de primero, de esta manera podemos saber si ya esta el producto que estamos agregando a la lista y saber cuanto tenemos en total
                        this.localOrden[indexFind].quantity =
                            Number(this.localOrden[indexFind].quantity) + 1;
                        let itemAwait = this.localOrden[indexFind];
                        orden.original_price = orden.price;
                        this.localOrden.splice(indexFind, 1);
                        if (this.configuration.order_desc_items == true) {
                            this.localOrden.push(itemAwait);
                        } else {
                            this.localOrden.unshift(itemAwait);
                        }
                    } else {
                        orden.to_carry = false;
                        orden.change_subtotal = false;
                        orden.series = [];
                        orden.lotes = [];
                        orden.color_size = [];
                        orden.original_price = orden.price;
                        if (this.configuration.order_desc_items == true) {
                            this.localOrden.push(orden);
                        } else {
                            this.localOrden.unshift(orden);
                        }
                    }
                }

                // this.localOrden = [...this.localOrden];
                //this.localOrden = this.changeCurrencyItems();
            }
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
            } catch (e) {}
        },
        // reloadDataCustomers(customer_id) {
        //     this.$http
        //         .get(`/document/search/customer/${customer_id}`)
        //         .then(response => {
        //             this.all_customers = response.data.customers;
        //             this.form.customer_id = customer_id;
        //         });
        // },

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
                `/caja/worker/totales_sales?cash_id=${this.localCashId}&send=1`
            );
            let { total_sales } = response.data;
            if (total_sales) {
                this.$toast(
                    ` Venta Acumulada S/ ` +
                        response.data.total_sales.toFixed(2)
                );
            } else {
                this.$toast(`Sin ventas acumuladas en el día`);
            }
            if (this.configuration.other_currency_pos) {
                const response_usd = await this.$http.get(
                    `/caja/worker/totales_sales_usd?cash_id=${this.localCashId}&send=1`
                );
                let { total_sales_usd } = response_usd.data;
                if (total_sales_usd) {
                    this.$toast(
                        ` Venta Acumulada $ ` + total_sales_usd.toFixed(2)
                    );
                }
            }

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
            if (this.$refs.list_foods) {
                this.$refs.list_foods.searchFoodCategories(id);
            }
        },
        fiterBrands(id, mod = false) {
            this.brand_selected = id;
            if (this.$refs.list_foods) {
                this.$refs.list_foods.searchFoodBrands(id);
            }
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
                receive_promotion: false,
                promotion_id: null,
                reference_number: null,
                detraction: {
                    amount: 0,
                    bank_account: this.company.detraction_account
                },
                vacate: false,
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

            this.formQtn = {
                customer_id: null
            };
            this.customer_unit_type_id = null;
            this.formVariation = {
                afectar_caja: true,
                orden_id: null,
                customer_telephone: null,
                restaurant: true,
                total_rounded: 0.0,
                total_payment: 0.0,
                hotel_customer_number: null,
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
            // this.changeDateOfIssue();
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
            this.form.currency_type_id =
                this.currency_id == "S/" ? "PEN" : "USD";
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
                    currency_type_id: this.currency_id == "S/" ? "PEN" : "USD",
                    currency_type: {
                        id: this.currency_id == "S/" ? "PEN" : "USD",
                        description:
                            this.currency_id == "S/" ? "Soles" : "Dolares",
                        symbol: this.currency_id
                    },
                    attributes: i.attributes || [],
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
            // this.calculateTotal();
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
            let userAgent = navigator.userAgent;
            let isFirefox = userAgent.indexOf("Firefox") != -1;
            if (isFirefox) {
                const pdfUrl = linkpdf;
                const pdfFrame = this.$refs.pdfFrame;
                pdfFrame.src = pdfUrl;
                pdfFrame.onload = () => {
                    pdfFrame.contentWindow.print();
                };
                return;
            }
            let paperConfig = {
                scaleContent: false
            };
            let partsUrl = linkpdf.split("/");
            let document = partsUrl[partsUrl.length - 1];
            let isTicket = linkpdf.toLowerCase().includes("ticket");
            let isA4 = document.toLowerCase().includes("a4");
            let isA5 = document.toLowerCase().includes("a5");
            if (!isTicket) {
                let print_service = linkpdf.includes("print_service");
                isTicket = print_service;
            }
            if (!isTicket) {
                let receipt = linkpdf.includes("receipt");
                isTicket = receipt;
            }
            if (!isTicket) {
                let cashOut = linkpdf.includes("cash_out");
                isTicket = cashOut;
            }
            // if(!isTicket){
            //     let simulate = linkpdf.includes("simulate");
            //     isTicket = simulate;
            // }
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
                if (isA5) {
                    let { a5_orientation } = this.configuration;
                    orientation = a5_orientation ? "landscape" : "portrait";
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
                    let margins = {};
                    if (orientation == "landscape") {
                        margins = {
                            top: 1.1,
                            left: 0.95,
                            right: 0.3,
                            bottom: 1.1
                        };
                    } else {
                        margins = {
                            left: 1.5
                        };
                    }
                    paperConfig.margins = margins;
                    // paperConfig.margins = {
                    //     left: orientation == "landscape" ? 0 : 1.5,
                    //     top: orientation == "landscape" ? 1.5 : 0,
                    //     // top:0,
                    // };
                }
            } //FIN IMPRESION DIRECTA A5
            //separa Printer por el espacio, coge el ultimo elemento y verifica si es "POSD"
            let isPosd = Printer.split(" ")[Printer.split(" ").length - 1];
            if (isPosd == "POSD" && isTicket) {
                paperConfig.density = 200;
            }
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
                await new Promise(resolve => setTimeout(resolve, 1500));
                qz.print(config, data).catch(e => {
                    this.$toast.error(e.message);
                });
            }
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
                let t = parseFloat(
                    _.round(
                        parseFloat(orden.food.item.quantity) *
                            parseFloat(orden.food.price),
                        2
                    )
                );
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
                    ["11", "12", "13", "14", "15", "16"].includes(
                        row.affectation_igv_type_id
                    )
                ) {
                    let unit_value = row.total_value / row.quantity;
                    let total_value_partial = unit_value * row.quantity;
                    row.total_taxes =
                        row.total_value -
                        total_value_partial +
                        isNaN(parseFloat(row.total_plastic_bag_taxes))
                            ? 0.0
                            : parseFloat(row.total_plastic_bag_taxes);
                    row.total_igv =
                        total_value_partial * (row.percentage_igv / 100);
                    row.total_base_igv = total_value_partial;
                    total_value -= row.total_value;

                    total += parseFloat(row.total);
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
        getExchange() {
            let date = moment().format("YYYY-MM-DD");
            this.$http(`/service/exchange?date=${date}`).then(response => {
                if (response.status == 200) {
                    let data = response.data;
                    data = data.toString();
                    data = data.replace(",", ".");
                    this.form.exchange_rate_sale = Number(data);
                }
            });
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
            if (this.configuration.color_size_enabled) {
                this.lastQuery = form.value;
            }
            return queryString.stringify({
                page: this.pagination.current_page,
                external_id: this.barcode,
                search_by_series: this.searchSeries,
                customer_unit_type_id: this.customer_unit_type_id,
                search_by_second_name: this.searchSecondName,
                model: this.model,
                quality: this.quality,
                /* brand: this.brand, */
                ...form

                // limit: this.limit
            });
        },
        async getFoods(query = "") {
            try {
                this.loadingItems = true;
                const response = await this.$http.get(
                    `${this.resource}/foods?${query}`
                );
                if (response.status == 200) {
                    const {
                        data: { data, meta }
                    } = response;

                    this.allLocalFoods = data.map(d => {
                        if (d.item.lots_group.length > 0) {
                            d.item.lots_group = d.item.lots_group.filter(
                                lt =>
                                    lt.warehouse_id ==
                                    this.worker.establishment_id
                            );
                        }
                        if (d.categoria_madera_item.length > 0) {
                            d.categoria_madera_item = d.categoria_madera_item.filter(
                                lt => Number(lt.precio) > 0
                            );
                        }
                        return d;
                    });
                    this.listFoods = this.allLocalFoods;
                    this.allFoods = this.allLocalFoods;

                    this.pagination = meta;

                    this.selectOption = 4;
                    this.loadingItems = false;
                }
            } catch (e) {
                this.loadingItems = false;
            } finally {
                this.loadingItems = false;
            }
        },
        async getTablesToLeave() {
            try {
                const response = await this.$http.get(
                    `/caja/rooms/tables_to_leave`
                );
                if (response.status == 200) {
                    const { data } = response.data;
                    this.tablesLeave = data;
                    this.tablesLeave = this.tablesLeave.map(t => ({
                        ...t,
                        timer: null
                    }));
                }
            } catch (e) {}
        },
        async getTablesToClean() {
            try {
                const response = await this.$http.get(
                    `/caja/rooms/tables_to_clean`
                );
                if (response.status == 200) {
                    const { data } = response.data;
                    this.tablesClean = data;
                    this.tablesClean = this.tablesClean.map(t => ({
                        ...t,
                        time_to_finish: null
                    }));
                }
            } catch (e) {}
        },
        async getTables() {
            //this.loadingInstance = Loading.service({fullscreen: false,lock:true,text:"Espere por favor..."});
            await this.$http
                .get(`/${this.resource}/tables-rent`)
                .then(response => {
                    this.sellers = response.data.sellers;
                    this.users = response.data.users;
                    this.types = response.data.types;
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
                    this.all_tables = response.data.tables;
                    this.tables = this.all_tables;
                    this.floors = response.data.floors;
                    this.config = response.data.config;

                    let area = this.areas.find(a => a.id == this.area_id);
                    if (area.description == "HOTEL") {
                        this.isHotelArea = true;
                    }
                    if (area.description == "CAJA PISCINA") {
                        this.isPiscinaArea = true;
                    }
                });

            // this.loadingInstance.close()
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
        renderBrands(source) {
            const contex = this;
            this.brands = source.map((obj, index) => {
                return {
                    id: obj.id,
                    name: obj.name,
                    color: contex.getColor(index)
                };
            });
        },
        async limpiarForm() {
            if (this.isAndroid) {
                this.getLastDocument();
            }

            this.formVariation = {
                afectar_caja: true,
                orden_id: null,
                customer_telephone: null,
                restaurant: true,
                total_rounded: 0.0,
                total_payment: 0.0,
                hotel_customer_number: null,
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
            this.variation = false;
            this.clientSaleNoteNumber = null;
            this.quotationId = null;
            this.clientSaleNoteDiscount = 0;
            this.ordens_all_table = false;
            this.isConsignment = false;
            this.selectOption = 4;
            this.blockCart = false;
            this.variation = false;
            this.form.discounts = [];
            this.form.seller_id = null;
            this.form.receive_promotion = false;
            this.form.total_discount = 0;
            this.form.is_room = false;
            this.form.original_total = undefined;
            this.form.reference_number = null;
            this.form.hotel_customer_number = null;
            this.form.quotation_customer_number = null;
            this.form.hotel_rent_item_service_id = null;
            this.form.hotel_rent_item_ids = null;
            this.form.hotel_rent_id = null;
            this.form.customer_id = this.customer_default.id;
            this.form.observation = null;
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

            await this.calculateTotal();

            this.total_sales_pos = 0;

            this.getExchange();
            this.getTables();
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
            if (this.configuration.all_items_pos) {
                let searchData = data;
                if (searchData == undefined) {
                    searchData = this.input_item;
                }
                searchData = searchData.toUpperCase();
                this.allFoods = this.allLocalFoods.filter(f => {
                    if (f.description.includes(searchData)) {
                        return f;
                    }
                });
            } else {
                let inputitem = this.input_item.toLowerCase();
                if (data == undefined) {
                    let form = {
                        value: inputitem,
                        category: this.category,
                        brand: this.brand
                    };
                    await this.getFoods(this.getQueryParameters(form));
                } else {
                    let form = {
                        value: data,
                        category: this.category,
                        brand: this.brand
                    };
                    await this.getFoods(this.getQueryParameters(form));
                }
            }

            //            this.$refs.list_foods.searchFood(inputitem, this.type_search);
            //
            //  this.listFoods = this.allFoods.filter((f) =>
            //   f.description.toLowerCase().includes(inputitem)
            // );
        },
        async search() {
            /* console.log(
                "🚀 ~ this.time=setTimeout ~ this.selectOption:",
                this.selectOption
            ); */
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
            this.showcustomModal = true;
        },
        formatUrlImage(url) {
            if (!url) return;
            let formated = "storage/uploads/items/" + url;
            return `/${formated}`;
        },
        addFood(index = 0, type = null, categoria = null) {
            /* ; */
            if (!this.canAddItem) {
                this.$showSAlert(
                    "Error",
                    "Debe seleccionar un cliente",
                    "error"
                );

                return;
            }
            let quotation_stock = localStorage.getItem("quotation_stock") || 0;
            quotation_stock = quotation_stock == 1;
            if (this.blockAdd && !this.configuration.box_orden) {
                this.$toast.error("No puede agregar productos a esta orden.");
                this.$showSAlert(
                    "ORDEN",
                    "No puede agregar productos a esta orden.",
                    "error"
                );
                return;
            }
            this.selectedFood = JSON.parse(
                JSON.stringify(this.listFoods[index])
            );
            if (!this.selectedFood) return;
            let { categoria_madera_item } = this.selectedFood;
            if (
                this.configuration.maderera &&
                Array.isArray(categoria_madera_item) &&
                categoria_madera_item.length > 0 &&
                !this.addingType
            ) {
                this.showUnitTypeModal = true;
                this.currentIndex = index;
                return;
            }
            this.currentIndex = null;
            this.addingType = false;

            if (
                Number(this.selectedFood.item.stock) <= 0 &&
                this.configuration.sales_stock == true &&
                !quotation_stock &&
                this.selectedFood.item.unit_type_id != "ZZ"
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
                if (
                    this.configuration.sales_stock == true &&
                    this.selectedFood.item.is_set == 0 &&
                    !quotation_stock &&
                    this.selectedFood.item.unit_type_id != "ZZ"
                ) {
                    if (qty > Number(this.selectedFood.item.stock)) {
                        this.$toast.warning("Limite de stock alcanzado");
                        return;
                    }
                }
            } else {
                if (type) {
                    let qty = type.quantity_unit;
                    if (
                        this.configuration.sales_stock == true &&
                        this.selectedFood.item.is_set == 0 &&
                        !quotation_stock &&
                        this.selectedFood.item.unit_type_id != "ZZ"
                    ) {
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
            this.insertOrden(
                this.currentFood,
                this.selectedFood.id,
                type,
                false,
                categoria
            );

            this.$notify({
                title: this.currentFood.food.description.toLowerCase(),
                duration: 800,
                iconClass: "el-icon-food",
                message: "Agregado con èxito",
                position: "bottom-left"
            });

            // this.$emit(
            //   "insertOrden",
            //   this.currentFood,
            //   this.selectedFood.id,
            //   type,
            //   /* selectSerie, */
            //   categoria
            // );

            this.currentFood = {
                food: null,
                observation: null,
                quantity: 0,
                price: 0,
                categoria: null
            };
            this.selectedFood = null;
            this.item = null;
            this.input_item = null;
            if (this.configuration.all_items_pos) {
                this.search_items(null);
            }
            //this.setFalse();
            //this.$emit("buscarnuevo");
            //this.$forceUpdate();
        },

        viewImages(table) {
            console.log("table", table);
            this.currentImages = table.images;
            this.showImagesDialog = true;
        }
    },
    beforeUnmount() {
        document.removeEventListener("keydown", this.handleKeydown);
    },
    mounted() {
        // this.getCashId();
        setTimeout(() => {
            this.boxOperation = this.localCashId ? "Cerrar" : "Abrir";
        }, 1000);
        document.addEventListener("keydown", this.handleKeydown);

        this.screenWidth = window.innerWidth;
        window.addEventListener("resize", this.handleResize);

        // this.teclasInit();
        Echo.channel("reload").listen(
            `.reload-${this.configuration.socket_channel}`,
            e => {
                this.getTablesToClean();
            }
        );
        Echo.channel("orden_pending").listen(
            `.orden-pending-${this.configuration.socket_channel}`,
            e => {
                console.log("orden_pending", e);
                let num = Number(e.amount);
                this.ordensPending = this.ordensPending + num;

                if (num > 0) {
                    this.$notify({
                        title: "Aviso",
                        duration: 1500,
                        iconClass: "el-icon-star-on",
                        message: "Nueva orden",
                        position: "bottom-left"
                    });
                }
            }
        );
        Echo.channel("stock_orden").listen(
            `.stock-order-${this.configuration.socket_channel}`,
            e => {
                if (this.configuration.all_items_pos) {
                    for (
                        let index = 0;
                        index < e.data.order_item.length;
                        index++
                    ) {
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
            }
        );
        Echo.channel("message").listen(
            `.message-${this.configuration.socket_channel}`,
            e => {
                let { message, area_id } = e;
                if (area_id == this.area_id) {
                    this.$toast.success(message);
                    this.playSound("work_finish.mp3");
                }
            }
        );
        Echo.channel("digitalpay").listen(
            `.digitalpay-${this.configuration.socket_channel}`,
            e => {
                let { message } = e;
                this.$toast({
                    component: DigitalPayComponent,
                    toastClassName: "digital-pay-toast",
                    props: {
                        message
                    },
                    position: "top-right",
                    timeout: 8000,
                    closeOnClick: true,
                    pauseOnFocusLoss: true,
                    pauseOnHover: true,
                    draggable: true,
                    draggablePercent: 0.6,
                    showCloseButtonOnHover: false,
                    hideProgressBar: true,
                    closeButton: "button",
                    icon: true,
                    rtl: false
                });

                this.playSound("yape_notification.mp3");
            }
        );
        this.getLastDocument();

        Echo.channel("print_orden").listen(
            `.print-order-${this.configuration.socket_channel}`,
            async e => {
                /* ; */

                console.log("imprimiendo", e);
                let user_establishment_id = e.data.user_establishment_id;
                let user_establishment_id_printer =
                    e.data.user_establishment_id_printer;
                let area_id = e.data.area_id;
                let isSameEstablishmentPrinter =
                    this.establishments.id == user_establishment_id_printer;
                // console.log("this.establishments.id", this.establishments.id);
                // console.log("user_establishment_id_printer", user_establishment_id_printer);
                // console.log("isSameEstablishmentPrinter", isSameEstablishmentPrinter);
                let isSameEstablishment =
                    this.establishments.id == user_establishment_id;
                // console.log("isSameEstablishment", isSameEstablishment);
                let sameAreas = this.configuration
                    .print_direct_just_different_areas;
                let isHotels = this.configuration.hotels;

                let canPrint = true;
                if (isHotels) {
                    if (isSameEstablishment) {
                        canPrint = true;
                    } else {
                        canPrint = false;
                    }
                } else {
                    if (isSameEstablishmentPrinter) {
                        canPrint = true;
                    } else {
                        canPrint = false;
                    }
                }

                if (sameAreas) {
                    if (area_id != this.area_id) {
                        return;
                    }
                }

                if (e.data.direct_printing == true) {
                    if (e.data.printing == true && canPrint) {
                        let copies = Number(e.data.copies) || 0;
                        if (isNaN(copies)) copies = 0;
                        copies += 1;

                        await this.Printer(
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
                    if (canPrint && e.data.printing) {
                        if (this.isAndroid) {
                            if (!e.data.is_from_box && e.data.orden_id) {
                                if (this.ordenToPrint.length > 5) {
                                    this.ordenToPrint.pop();
                                }
                                this.ordenToPrint.unshift({
                                    id: e.data.orden_id,
                                    url: e.data.print
                                });
                                this.playSound();
                                this.printFileWithRawBT(e.data.print);
                            }

                            if (e.data.is_from_box) {
                                let a = document.createElement("a");
                                a.href = e.data.print;
                                a.target = "_blank";
                                a.click();
                            }
                        } else {
                            window.open(e.data.print, "_blank");
                        }
                    }
                }
            }
        );
    }
};
</script>
