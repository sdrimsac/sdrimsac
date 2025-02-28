<template>
    <div>
        <div class="row p-2" v-loading="loadingItems">
            <h2 class="small-title">Productos</h2>
            <template v-if="listFoods.length == 0">
                <div class="col-12 text-center font-weight-bold">
                    <label>No Hay Productos</label>
                </div>
            </template>
            <template v-if="configuration.list_or_card">
                <div>
                    <div>
                        <button
                            @click="toggleView"
                            class="btn btn-primary btn-sm ml-auto"
                        >
                            {{
                                form.show_list
                                    ? "Mostrar Card"
                                    : "Mostrar Tabla"
                            }}
                        </button>
                    </div>
                </div>
                <template v-if="form.show_list">
                    <div class="row card mx-1 mt-2">
                        <div class>
                            <div
                                class="infinite-list-wrapper"
                                style="max-height: 800px; overflow-y: auto;"
                            >
                                <ul
                                    class="list-group"
                                    infinite-scroll-disabled="isDisabled"
                                    infinite-scroll-distance="5"
                                >
                                    <li class="list-group-item">
                                        <div id="app" class="container">
                                            <table
                                                class="table table-hover table-bordered"
                                            >
                                                <thead>
                                                    <tr class="bg-primary">
                                                        <th class="text-white">
                                                            CODIGO
                                                        </th>
                                                        <th class="text-white">
                                                            DESCRIPCION
                                                        </th>
                                                        <th class="text-white">
                                                            PRECIO
                                                        </th>
                                                        <th
                                                            v-if="
                                                                configuration.show_stock_cash ==
                                                                    true
                                                            "
                                                            class="text-white"
                                                        >
                                                            STOCK
                                                        </th>
                                                        <th
                                                            class="text-white text-center"
                                                            v-if="
                                                                configuration.lotgroup_list_or_card
                                                            "
                                                        >
                                                            LOTE
                                                        </th>
                                                        <th
                                                            class="text-white"
                                                            v-if="
                                                                configuration.listprice_list_or_card
                                                            "
                                                        >
                                                            POLITICA PRECIO
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr
                                                        v-for="(data,
                                                        index) in foods"
                                                        :key="index"
                                                        @click="
                                                            (configuration.consolidated_quotations || configuration.direct_unit_type) &&
                                                            data.types.length >
                                                                0
                                                                ? clickCommand(
                                                                      data
                                                                          .types[0]
                                                                  )
                                                                : addFood(index)
                                                        "
                                                    >
                                                        <td>{{ data.code }}</td>
                                                        <td>
                                                            <div role="button">
                                                                <span
                                                                    :class="
                                                                        `lead-font-weight-700 ${
                                                                            configuration.trunc_txt
                                                                                ? 'd-inline-block text-truncate'
                                                                                : ''
                                                                        }`
                                                                    "
                                                                >
                                                                    {{
                                                                        data.description.toUpperCase()
                                                                    }}
                                                                </span>
                                                                <template
                                                                    v-if="
                                                                        configuration.trunc_txt
                                                                    "
                                                                >
                                                                    <el-tooltip
                                                                        class="item"
                                                                        effect="dark"
                                                                        :content="
                                                                            data.description.toUpperCase()
                                                                        "
                                                                        placement="top-start"
                                                                    >
                                                                        <i
                                                                            class="fas fa-ellipsis-h"
                                                                        ></i>
                                                                    </el-tooltip>
                                                                </template>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            {{
                                                                data.item
                                                                    .currency_type_id ==
                                                                "PEN"
                                                                    ? "S/"
                                                                    : "$"
                                                            }}
                                                            {{ data.price }}
                                                        </td>
                                                        <td
                                                            v-if="
                                                                configuration.show_stock_cash ==
                                                                    true
                                                            "
                                                        >
                                                            <template
                                                                v-if="
                                                                    data.item
                                                                        .is_set ==
                                                                        0 &&
                                                                        data
                                                                            .item
                                                                            .unit_type_id !=
                                                                            'ZZ' &&
                                                                        data
                                                                            .item
                                                                            .stock >
                                                                            0
                                                                "
                                                            >
                                                                <span
                                                                    class="m-l-0"
                                                                    style="text-align: center !important"
                                                                >
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
                                                            <template v-else>
                                                                <span
                                                                    class="text-danger m-l-0"
                                                                    style="text-align: center !important"
                                                                >
                                                                    <template
                                                                        v-if="
                                                                            data
                                                                                .item
                                                                                .unit_type_id !=
                                                                                'ZZ'
                                                                        "
                                                                        >Agotado</template
                                                                    >
                                                                </span>
                                                            </template>
                                                        </td>
                                                        <td
                                                            v-if="
                                                                configuration.lotgroup_list_or_card
                                                            "
                                                        >
                                                            <div
                                                                class
                                                                v-if="
                                                                    data.item
                                                                        .lots_enabled ==
                                                                        1 &&
                                                                        data
                                                                            .item
                                                                            .date_of_due
                                                                "
                                                            >
                                                                <el-tag
                                                                    :type="
                                                                        `${
                                                                            isExpired(
                                                                                data
                                                                                    .item
                                                                                    .date_of_due
                                                                            )
                                                                                ? 'danger'
                                                                                : 'primary'
                                                                        }`
                                                                    "
                                                                >
                                                                    {{
                                                                        data
                                                                            .item
                                                                            .lot_code
                                                                    }}
                                                                    -
                                                                    {{
                                                                        data
                                                                            .item
                                                                            .date_of_due
                                                                    }}
                                                                </el-tag>
                                                            </div>
                                                        </td>
                                                        <td
                                                            v-if="
                                                                configuration.listprice_list_or_card
                                                            "
                                                        >
                                                            <div
                                                                v-if="
                                                                    data.types
                                                                        .length >
                                                                        0
                                                                "
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
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </template>
                <template v-else>
                    <div class="d-flex flex-wrap">
                        <div
                            class="col-12 col-lg-6 col-xl-4 col-xxl-4 p-1"
                            v-for="(data, index) in foods"
                            :key="index"
                        >
                            <el-tooltip
                                effect="dark"
                                :disabled="
                                    data.item.warehouses.length == 1 ||
                                        !configuration.show_stock_establishment_box
                                "
                            >
                                <div slot="content">
                                    Stock Almacenes
                                    <br />
                                    <span
                                        v-for="(info, idx) in data.item
                                            .warehouses"
                                        :key="idx"
                                    >
                                        <label class="text-white"
                                            v-if="
                                                info.warehouse.id !=
                                                    establishmentId
                                            "
                                        >
                                            <template
                                                v-if="data.item.max_quantity"
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
                                            <template v-else>
                                                {{
                                                    `${
                                                        info.warehouse
                                                            .description
                                                    }: ${Number(
                                                        info.stock
                                                    ).toFixed(2)}`
                                                }}
                                            </template>
                                        </label>
                                        <br />
                                    </span>
                                </div>
                                <div
                                    id="card"
                                    class="overflow-hidden coupon rounded d-flex flex-column justify-content-between p-1 bg-light"
                                    :style="
                                        `${
                                            configuration.trunc_txt
                                                ? 'min-height: 190px;'
                                                : 'height: 190px;'
                                        }`
                                    "
                                >
                                    <div
                                        @click="
                                            (configuration.consolidated_quotations || configuration.direct_unit_type) &&
                                            data.types.length > 0
                                                ? clickCommand(data.types[0])
                                                : addFood(index)
                                        "
                                    >
                                
                                        <div>
                                            <span
                                                :class="
                                                    `lead-font-weight-700 ${
                                                        configuration.trunc_txt
                                                            ? 'd-inline-block text-truncate'
                                                            : ''
                                                    }`
                                                "
                                            >
                                                {{
                                                    data.description.toUpperCase()
                                                }}
                                            </span>
                                            <template
                                                v-if="configuration.trunc_txt"
                                            >
                                                <el-tooltip
                                                    class="item"
                                                    effect="dark"
                                                    :content="
                                                        data.description.toUpperCase()
                                                    "
                                                    placement="top-start"
                                                >
                                                    <i
                                                        class="fas fa-ellipsis-h"
                                                    ></i>
                                                </el-tooltip>
                                            </template>
                                        </div>
                                        <div
                                            class="d-flex align-items-end justify-content-between"
                                        >
                                            <div class="p-1">
                                                <div
                                                    class="icon-container"
                                                    style="  height: 64px;  width: 64px;"
                                                >
                                                    <div
                                                        class="icon-container_box"
                                                    >
                                                        <el-tooltip
                                                            :disabled="
                                                                data.second_name ==
                                                                    null
                                                            "
                                                            effect="dark"
                                                            :content="
                                                                data.second_name
                                                            "
                                                            placement="top-start"
                                                        >
                                                            <template
                                                                v-if="
                                                                    data.image ==
                                                                        'imagen-no-disponible.jpg'
                                                                "
                                                            >
                                                                <img
                                                                    src="/images/imagen-no-disponible.jpg"
                                                                    alt="User Img"
                                                                    class="thumbail"
                                                                />
                                                            </template>
                                                            <template v-else>
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
                                                        </el-tooltip>
                                                    </div>
                                                </div>
                                            </div>
                                            <div v-if="data.item.location">
                                                <span>UBC.</span>
                                                <br />
                                                {{ data.item.location }}
                                            </div>
                                            <div>
                                                COD.
                                                <span>{{ data.code }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="d-flex justify-content-between"
                                        style="padding-right: 10px; margin-top: 2px"
                                    >
                                        <div
                                            class="d-flex flex-column align-items-end"
                                        >
                                            <div class="block mb-2">
                                                <span
                                                    class="time font-weight-light"
                                                >
                                                    <span
                                                        class="lead-font-weight-900" 
                                                        style="font-weigth: bold; font-family: 'Arial Black', Arial, sans-serif;"
                                                    >
                                                        {{
                                                            data.item
                                                                .currency_type_id ==
                                                            "PEN"
                                                                ? "S/"
                                                                : "$"
                                                        }}
                                                        {{ data.price }}
                                                    </span>
                                                </span>
                                            </div>
                                            <div></div>
                                        </div>

                                        <div v-if="data.types.length > 0">
                                            <el-dropdown
                                                @command="clickCommand"
                                            >
                                                <span class="el-dropdown-link">
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
                                                        :key="idx"
                                                        :command="type"
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
                                    <div
                                        class="d-flex flex-wrap justify-content-center m-1"
                                        v-if="data.item.lots_enabled == 1"
                                    >
                                        <el-tag
                                            v-for="(lot, idx) in data.item
                                                .lots_group"
                                            :key="idx"
                                            :type="
                                                `${
                                                    isExpired(lot.date_of_due)
                                                        ? 'danger'
                                                        : 'primary'
                                                }`
                                            "
                                        >
                                            {{ lot.code }} -
                                            {{ lot.date_of_due }}
                                        </el-tag>
                                    </div>
                                    <div
                                        v-if="
                                            data.item.is_set == 0 &&
                                                data.item.unit_type_id !=
                                                    'ZZ' &&
                                                configuration.show_stock_cash ==
                                                    true
                                        "
                                        class="row justify-content-end"
                                        style="margin-left: 2px; margin-right: 2px; margin-bottom: 2px;"
                                    >
                                        <template v-if="data.item.stock > 0">
                                            <span
                                                class="badge rounded-pill bg-primary m-l-0"
                                                style="text-align: center !important"
                                            >
                                                Stock
                                                <template
                                                    v-if="
                                                        data.item.max_quantity
                                                    "
                                                >
                                                    {{
                                                        formatedStockPresentation(
                                                            data.item,
                                                            data.item.stock
                                                        )
                                                    }}
                                                </template>
                                                <template v-else>
                                                    {{
                                                        parseFloat(
                                                            data.item.stock
                                                        )
                                                    }}
                                                </template>
                                            </span>
                                        </template>
                                        <!-- <template v-else>
                                            <span
                                                class="badge rounded-pill bg-danger m-l-0"
                                                style="text-align: center !important"
                                            >
                                                <template
                                                    v-if="
                                                        data.item
                                                            .unit_type_id !=
                                                            'ZZ'
                                                    "
                                                    >Agotado 3333</template
                                                >
                                                
                                            </span>
                                        </template> -->
                                        <template v-else>
                                            <template
                                                v-if="
                                                    data.item.unit_type_id !=
                                                        'ZZ'
                                                "
                                            >
                                                <div
                                                    class="text-center"
                                                    style="width: 100%; position: relative; height: 50px;"
                                                >
                                                    <img
                                                        src="/status_images/stock.png"
                                                        style="position: absolute; top: -50px; left: 50%; 
                                                    transform: translate(-50%, -50%); opacity: 0.5;
                                                     pointer-events: none; 
                                                     width: 400px; height: 200px;"
                                                        class=""
                                                    />
                                                </div>
                                            </template>
                                        </template>
                                    </div>
                                </div>
                            </el-tooltip>
                        </div>
                        <!-- hasta aqui -->
                    </div>
                </template>
            </template>
            <template v-else>
                <div class="d-flex flex-wrap">
                    <div
                        class="col-12 col-lg-6 col-xl-4 col-xxl-4 p-1"
                        v-for="(data, index) in foods"
                        :key="index"
                    >
                        <el-tooltip
                            effect="dark"
                            :disabled="
                                data.item.warehouses.length == 1 ||
                                    !configuration.show_stock_establishment_box
                            "
                        >
                            <div slot="content">
                                Stock Almacenes
                                <br />
                                <span
                                    v-for="(info, idx) in data.item.warehouses"
                                    :key="idx"
                                >
                                    <label 
                                        class="text-white"
                                        v-if="
                                            info.warehouse.id != establishmentId
                                        "
                                    >
                                        <template v-if="data.item.max_quantity">
                                            {{
                                                formatedStockPresentation(
                                                    data.item,
                                                    info.stock
                                                )
                                            }}
                                        </template>
                                        <template v-else>
                                            {{
                                                `${
                                                    info.warehouse.description
                                                }: ${Number(info.stock).toFixed(
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
                                class="overflow-hidden coupon rounded d-flex flex-column justify-content-between p-1 bg-light"
                                :style="
                                    `${
                                        configuration.trunc_txt
                                            ? 'min-height: 190px;'
                                            : 'height: 190px;'
                                    }`
                                "
                            >
                                <div
                                    @click="
                                        (configuration.consolidated_quotations || configuration.direct_unit_type) &&
                                        data.types.length > 0
                                            ? clickCommand(data.types[0])
                                            : addFood(index)
                                    "
                                >
                                    <div>
                                        <span
                                            :class="
                                                `lead-font-weight-700 ${
                                                    configuration.trunc_txt
                                                        ? 'd-inline-block text-truncate'
                                                        : ''
                                                }`
                                            "
                                            >{{
                                                data.description.toUpperCase()
                                            }}</span
                                        >
                                        <template
                                            v-if="configuration.trunc_txt"
                                        >
                                            <el-tooltip
                                                class="item"
                                                effect="dark"
                                                :content="
                                                    data.description.toUpperCase()
                                                "
                                                placement="top-start"
                                            >
                                                <i
                                                    class="fas fa-ellipsis-h"
                                                ></i>
                                            </el-tooltip>
                                        </template>
                                    </div>
                                    <div
                                        class="d-flex align-items-end justify-content-between"
                                    >
                                        <div class="p-1">
                                            <div
                                                class="icon-container"
                                                style="  height: 64px;  width: 64px;"
                                            >
                                                <div class="icon-container_box">
                                                    <el-tooltip
                                                        :disabled="
                                                            data.second_name ==
                                                                null
                                                        "
                                                        effect="dark"
                                                        :content="
                                                            data.second_name
                                                        "
                                                        placement="top-start"
                                                    >
                                                        <template
                                                            v-if="
                                                                data.image ==
                                                                    'imagen-no-disponible.jpg'
                                                            "
                                                        >
                                                            <img
                                                                src="/images/imagen-no-disponible.jpg"
                                                                alt="User Img"
                                                                class="thumbail"
                                                            />
                                                        </template>
                                                        <template v-else>
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
                                                    </el-tooltip>
                                                </div>
                                            </div>
                                        </div>
                                        <div v-if="data.item.location">
                                            <span>UBC.</span>
                                            <br />
                                            {{ data.item.location }}
                                        </div>
                                        <div>
                                            <span>COD.</span>
                                            <br />
                                            {{ data.code }}
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="d-flex justify-content-between"
                                    style="padding-right: 10px; margin-top: 2px"
                                >
                                    <div
                                        class="d-flex flex-column align-items-end"
                                    >
                                        <div class="block mb-2">
                                            <span
                                                class="time font-weight-light"
                                            >
                                                <span
                                                    class="lead-font-weight-900"
                                                    style="font-weigth: bold; font-family: 'Arial Black', Arial, sans-serif;"
                                                >
                                                    {{ data.currency }}
                                                    {{ data.price }}
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                    <div v-if="data.types.length > 0">
                                        <el-dropdown @command="clickCommand">
                                            <span class="el-dropdown-link">
                                                Precios
                                                <i
                                                    class="el-icon-arrow-down el-icon--right"
                                                ></i>
                                            </span>
                                            <el-dropdown-menu slot="dropdown">
                                                <el-dropdown-item
                                                    v-for="(type,
                                                    idx) in data.types"
                                                    :key="idx"
                                                    :command="type"
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
                                <div
                                    class="d-flex justify-content-center m-1"
                                    v-if="
                                        data.item.lots_enabled == 1 &&
                                            data.item.date_of_due
                                    "
                                >
                                    <el-tag
                                        :type="
                                            `${
                                                isExpired(data.item.date_of_due)
                                                    ? 'danger'
                                                    : 'primary'
                                            }`
                                        "
                                    >
                                        {{ data.item.lot_code }} -
                                        {{ data.item.date_of_due }}
                                    </el-tag>
                                </div>
                                <div
                                    v-if="
                                        data.item.is_set == 0 &&
                                            data.item.unit_type_id != 'ZZ' &&
                                            configuration.show_stock_cash ==
                                                true
                                    "
                                    class="row justify-content-end"
                                    style="margin-left: 2px; margin-right: 2px; margin-bottom: 2px;"
                                >
                                    <template v-if="data.item.stock > 0">
                                        <div class="container">
                                            <span
                                                class="badge rounded-pill bg-primary w-50 col-10 fw-bold"
                                                style="text-align: center !important; justify-content: center;"
                                            >
                                                Stock
                                                <template
                                                    v-if="
                                                        data.item.max_quantity
                                                    "
                                                >
                                                    {{
                                                        formatedStockPresentation(
                                                            data.item,
                                                            data.item.stock
                                                        )
                                                    }}
                                                </template>
                                                <template v-else>
                                                    {{
                                                        parseFloat(
                                                            data.item.stock
                                                        )
                                                    }}
                                                </template>
                                            </span>
                                            <span
                                                class="col-2 button-container"
                                                v-if="
                                                    configuration.compra_venta
                                                "
                                            >
                                                <el-row>
                                                    <el-button
                                                        size="mini"
                                                        class="bg-succes"
                                                        round
                                                        @click.prevent="
                                                            clickWarehouseDetail(
                                                                data.id,
                                                                data.has_series,
                                                                data.warehouses,
                                                                data.unit_type
                                                            )
                                                        "
                                                    >
                                                        <i
                                                            class="el-icon-view"
                                                        ></i>
                                                    </el-button>
                                                </el-row>
                                            </span>
                                        </div>
                                    </template>
                                    <!-- <template v-else>
                                        <span
                                            class="badge rounded-pill bg-danger m-l-0"
                                            style="text-align: center !important"
                                            >Agotado</span
                                        >
                                    </template> -->
                                    <template v-else>
                                        <div
                                            class="text-center"
                                            style="width: 100%; position: relative; height: 50px;"
                                        >
                                            <img
                                                src="/status_images/stock.png"
                                                style="position: absolute; top: -50px; left: 50%; 
                                                    transform: translate(-50%, -50%); opacity: 0.5;
                                                     pointer-events: none; 
                                                     width: 400px; height: 200px;"
                                                class=""
                                            />
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </el-tooltip>
                    </div>
                </div>
            </template>
        </div>
        <unit-type-modal
            :foods="foods"
            @addUnitType="addUnitType"
            @addCategoriaMadera="addCategoriaMadera"
            :showDialog.sync="showUnitTypeModal"
            :medida_alto="medida_alto"
            :medida_ancho="medida_ancho"
            :medida_grosor="medida_grosor"
            :categoria_madera="categoria_madera"
            :item="selectedFood"
            :currentIndex="currentIndex"
        ></unit-type-modal>
        <warehouses-detail
            :showDialog.sync="showWarehousesDetail"
            :warehouses="warehousesDetail"
            :unit_type.sync="unit_type"
            :itemId="itemId"
            :hasSerie="hasSerie"
            :item="currentItem"
            :config="config"
            :user="user"
        ></warehouses-detail>
        <modal-unit-type-id
            @selectUnitType="selectUnitType"
            :showDialog.sync="showDialogUnitType"
            :item="foodWithTypes"
        ></modal-unit-type-id>
    </div>
</template>
<style>
.container {
    display: flex;
    align-items: center;
}

.badge {
    flex: 1;
    text-align: center;
    padding: 0.4rem;
}

.button-container {
    flex-shrink: 0;
}

.custom-el-button {
    padding: 2px 6px;
    font-size: 12px;
}
.table-container {
    height: 100%; /* Ocupa todo el espacio disponible */
    display: flex;
    flex-direction: column;
}

.table {
    flex: 1;
    overflow-y: auto; /* Permite el scroll si hay más filas */
}
</style>

<script>
import WarehousesDetail from "./warehouses.vue";
import UnitTypeModal from "./unit_type_modal.vue";
import ModalUnitTypeId from "./modal_unit_type_id.vue";
import swal from "sweetalert2";
export default {
    components: { WarehousesDetail, UnitTypeModal, ModalUnitTypeId },
    props: [
        "lastQuery",
        "cotizarConfirmado",
        "canAddItem",
        "loadingItems",
        "foods",
        "configuration",
        "worker",
        "pagination",
        "blockAdd",
        "localOrden",
        "type_code",
        "barcode",
        "model",
        "quality",
        "searchSeries",
        "medida_ancho",
        "medida_alto",
        "medida_grosor",
        "categoria_madera"
    ],
    data() {
        return {
            localCotizarConfirmado: this.cotizarConfirmado,
            foodWithTypes: null,
            showDialogUnitType: false,
            showUnitTypeModal: false,
            addingType: false,
            currentIndex: null,
            itemId: null,
            currentItem: null,
            unit_type: [],
            hasSerie: false,
            user: false,
            config: {},
            showWarehousesDetail: false,
            warehousesDetail: [],
            form: {
                show_list: false
            },
            selectCategory: 0,
            /* user: {}, */
            activeName: "menu",
            loading: true,
            ordenItems: [],
            orden: [],
            currentFood: {},
            item: null,
            search: "Buscar por Codigo",
            currentImage: null,
            showImage: false,
            listFoods: [],
            selectedFood: null,
            /* isAnalist: false, */
            allFalse: true,
            title: null,
            total: null,
            ordenId: null,
            optionsSelected: 0,
            generalOrdens: 1,
            establishmentId: this.worker.establishment_id,
            settings: {
                dots: false,
                dotsClass: "slick-dots custom-dot-class",
                edgeFriction: 0.35,
                infinite: false,
                speed: 500,
                centerMode: true,
                centerPadding: "10px",
                focusOnSelect: true,
                infinite: true,
                slidesToShow: 3,
                slidesToScroll: 3,
                swipeToSlide: true,
                speed: 500,
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 3,
                            infinite: true,
                            dots: true
                        }
                    },
                    {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2,
                            initialSlide: 2
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                ]
            },
            settings_tables: {
                dots: true,
                dotsClass: "slick-dots custom-dot-class",
                infinite: false,
                speed: 500,
                centerMode: true,
                centerPadding: "10px",
                focusOnSelect: true,
                infinite: true,
                slidesToShow: 5,
                slidesToScroll: 5,
                swipeToSlide: true,
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2,
                            infinite: true,
                            dots: true
                        }
                    },
                    {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2,
                            initialSlide: 2
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    }
                ]
            },
            screenWidth: 0
        };
    },
    mounted() {
        this.screenWidth = window.innerWidth;
        this.loadViewPreference();
        window.addEventListener("resize", this.handleResize);

        if (this.foods.length > 0) {
            this.loading = false;
        }
        Echo.channel("orden_list").listen(
            `.order-list-${this.configuration.socket_channel}`,
            e => {
            let { order_item } = e;
            this.listaOrden(order_item);
            this.playSound("pedidos_listo.mp3");
            }
        );
    },
    /* watch: {
        cotizarConfirmado(newVal) {
            this.localCotizarConfirmado = newVal;
        },
        cotizarConfirmado(newVal) {
            console.log("cotizarConfirmado ha cambiado en ListFood:", newVal);
            if (!newVal) {
                this.configuration.sales_stock = true;
                console.log("Sales stock restablecido a true");
            }
        },
        configuration: {
            handler(newConfig) {
                console.log("Configuración actualizada:", newConfig);
            },
            deep: true
        },
        foods(__, _) {
            this.updateListFoods();
        }
    }, */
    watch: {
        cotizarConfirmado(newVal) {
            // Actualiza el estado local
            this.localCotizarConfirmado = newVal;

            // Confirma si debe restablecer sales_stock
            console.log("cotizarConfirmado ha cambiado en ListFood:", newVal);
            if (!newVal) {
                this.configuration.sales_stock = true;
                console.log("Sales stock restablecido a true");
            }
            // Emit the event to notify the parent component
            this.$emit("cotizarConfirmadoChanged", newVal);
        },
        configuration: {
            handler(newConfig) {
                console.log("Configuración actualizada:", newConfig);
            },
            deep: true // Observa cambios en todas las propiedades anidadas
        },
        foods(__, _) {
            this.updateListFoods();
        }
    },
    created() {
        this.ordenItems = [];
        this.orden = [];
        this.updateListFoods();
    },
    computed: {
        madereraItms() {
            return this.foods.filter(item => item.category === "MADERERA");
        },
        cotizarConfirmadoState() {
            return this.cotizarConfirmado;
        }
    },
    methods: {
        listaOrden(order_item) {
            this.$notify({
            title: "Orden Lista",
            message: `La orden ${order_item.id} está lista para ser entregada. Pedido por: <span style="color: blue; text-transform: uppercase">${order_item.mozo_name}</span>`,
            type: "success",
            duration: 0,
            dangerouslyUseHTMLString: true
            });
        },
        selectUnitType(unit_type) {
            this.showDialogUnitType = false;

            this.addFood(0, unit_type);
        },
        addUnitType(type) {
            this.addFood(this.currentIndex, type);
        },
        addCategoriaMadera(categoria, index) {
            this.currentIndex = index;
            this.addingType = true;
            this.addFood(this.currentIndex, null, false, categoria);
        },
        clickWarehouseDetail(id, hasSerie, warehouses, unit_type, item) {
            this.currentItem = item;
            this.itemId = id;
            this.hasSerie = hasSerie;
            this.warehousesDetail = warehouses;
            this.unit_type = unit_type;
            this.showWarehousesDetail = true;
        },

        isExpired(date) {
            let today = new Date();
            let dateOfDue = new Date(date);
            if (today > dateOfDue) {
                return true;
            }
            return false;
        },
        handleResize() {
            this.screenWidth = window.innerWidth;
        },
        nthing() {},
        getDefaultPrice(type) {
            let listPricesDescription = ["price1", "price2", "price3"];
            let currentPriceIndx =
                listPricesDescription[type.price_default - 1];
            let price = type[currentPriceIndx];
            if (this.configuration.price_item_unit_type) {
                return price;
            }
            if (type.total == null) {
                // this.$toast.error(
                //     "Politica de precio sin total: Tomando precio unitario.."
                // );
            } else {
                price = Number(type.total);
            }
            return price;
        },
        formatDescriptionType(type) {
            let price = this.getDefaultPrice(type);
            return `${type.description} (${Number(
                type.quantity_unit
            )}) - S/ ${price}`;
        },

        clickCommand(type) {
            /* ; */
            // if (this.configuration.maderera) {
            //   return;
            // }
            let idxFood = this.listFoods.findIndex(
                food => food.item.id == type.item_id
            );
            if (idxFood >= 0) {
                this.addFood(idxFood, type);
            }
        },
        updateListFoods() {
            this.listFoods = this.foods.map(f => {
                f.price = Number(f.price).toFixed(2);
                return {
                    ...f,
                    select: false
                };
            });
            if (
                (this.barcode && this.listFoods.length == 1) ||
                (this.type_code && this.listFoods.length == 1)
            ) {
                let [food] = this.listFoods;
                let { types } = food;
                if (
                    types.length > 1 &&
                    this.configuration.unit_type_select_barcode
                ) {
                    this.foodWithTypes = food;
                    this.showDialogUnitType = true;
                } else {

                    if(this.configuration.direct_unit_type && food.item.item_unit_types.length > 0){
                        this.clickCommand(food.item.item_unit_types[0]);
                    }else{
                        this.addFood(0);
                    }
                }
            }
            if (this.searchSeries && this.listFoods.length == 1) {
                this.addFood(0, null, true);
            }

            if(this.configuration.color_size_enabled){
                if ( this.listFoods.length == 1) {
                    let [food] = this.listFoods;
                    let color_size = food.color_size.find(color => color.code == this.lastQuery);
                    
                    if(color_size){
                        color_size.quantity = 1;
                        this.addFood(0, null, true, null, [color_size]);
                    }
                    
                }                
            }
            if (this.quatity && this.listFoods.length == 1) {
                this.addFood(0, null, true);
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
        getRecords() {
            let currentPage = this.pagination.current_page;
            this.$emit("changePage", currentPage);
        },
        deleteOrden(id) {
            this.ordenItems = this.ordenItems.filter(o => o.id != id);
        },
        calculateOrden() {
            // this.$refs.ordenRef.calculateTotal();
        },
        selectSearch(value) {
            this.optionsSelected = value;
        },

        deleteFood(idx) {
            this.orden.splice(idx, 1);
        },
        setCategory(id) {
            this.selectCategory = id;
            !this.allFalse && this.setFalse();
            if (id == 0) {
                this.listFoods = this.foods;
            } else {
                this.listFoods = [];
                this.listFoods = _.filter(this.foods, {
                    category_food_id: id
                });
            }
        },
        async setItemCheckStock(id, quantity) {
            //item-sets/check/{id}
            let pass = true;
            const response = await this.$http.get(
                `/item-sets/check/${id}/${quantity}`
            );
            if (response.status == 200) {
                const { success, message } = response.data;
                if (!success) {
                    this.$toast.error(message);
                    pass = false;
                }
            }
            return pass;
        },
        async addFood(
            index = 0,
            type = null,
            selectSerie = false,
            categoria = null,
            color_size = []
        ) {
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

            if (
                this.blockAdd &&
                !this.configuration.box_orden &&
                this.configuration.restaurant
            ) {
                /* this.$toast.error("No puede agregar productos a esta orden."); */
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
            /* if (this.selectedFood.category === 'MADERERA'){

            } */
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

            let foodFound = this.localOrden.filter(
                f => f.id == this.selectedFood.id
            );

            if (this.selectedFood.item.is_set == 1) {
                if (
                    this.configuration.sales_stock == true &&
                    !quotation_stock &&
                    this.selectedFood.item.unit_type_id != "ZZ"
                ) {
                    let qty = 1;
                    if (foodFound.length != 0) {
                        qty = foodFound.reduce(
                            (a, b) => a + Number(b.quantity),
                            0
                        );
                        qty += 1;
                    }
                    let pass = await this.setItemCheckStock(
                        this.selectedFood.item.id,
                        qty
                    );
                    if (!pass) {
                        return;
                    }
                }
            } else {
                if (
                    Number(this.selectedFood.item.stock) <= 0 &&
                    this.configuration.sales_stock == true &&
                    !quotation_stock &&
                    this.selectedFood.item.unit_type_id != "ZZ"
                ) {
                    /* this.$toast.warning("Stock insuficiente"); */
                    /* this.$showSAlert("STOCK", "Stock insuficiente ", "warning");
                    return; */
                    swal.fire({
                        title: "Stock insuficiente",
                        text: "Stock insuficiente. ¿Desea cotizar?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        cancelButtonText: "Cancelar",
                        confirmButtonText: "Cotizar"
                    }).then(result => {
                        if (result.isConfirmed) {
                            this.configuration.sales_stock = false;
                            swal.fire({
                                title: "COTIZAR",
                                text: "Cotizar",
                                icon: "success",
                                allowOutsideClick: false,
                                showConfirmButton: false
                            });
                            this.localCotizarConfirmado = true;
                            this.$emit(
                                "cotizarConfirmado",
                                this.localCotizarConfirmado
                            );
                            swal.close();
                        } else {
                            if (
                                this.cotizarConfirmado === false &&
                                this.configuration.sales_stock !== true
                            ) {
                                this.configuration.sales_stock = true;
                            }
                        }
                    });
                    this.$emit("disableButtons", true);
                    return;
                }
            }

            // let foodFound = this.localOrden.filter(
            //     f => f.id == this.selectedFood.id
            // );

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
                    if (item.item_unit_types.length == 0 && !selectSerie) {
                        let message = "Producto con serie, ya  agregado";
                        this.$toast.warning(message);
                        return;
                    } else {
                        if (type) {
                            if (foodFound.some(i => i.type_id == type.id)) {
                                let message = "Tipo de producto agregado";
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
                        /* this.$toast.warning("Limite de stock alcanzado"); */
                        this.$$showSAlert(
                            "LIMITE",
                            "Limite de stock alcanzado",
                            "warning"
                        );
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
                            /* this.$toast.warning("Limite de stock alcanzado"); */
                            this.$showSAlert(
                                "LIMITE",
                                "Limite de stock alcanzado",
                                "warning"
                            );
                            return;
                        }
                    }
                }
            }
            let setQuantity = 1;
            if (this.selectedFood.item.series_enabled) {
                setQuantity = 0;
            }
            if (this.selectedFood.item.has_color_size) {
                setQuantity = 0;
            }
            if (categoria) {
                setQuantity = categoria.quantity;
            }
            this.currentFood = {
                id: this.selectedFood.id,
                food: this.selectedFood,
                observation: null,
                price: this.selectedFood.price,
                // quantity: !!this.selectedFood.item.series_enabled ? 0 : 1
                quantity: setQuantity
            };

            this.$emit(
                "insertOrden",
                this.currentFood,
                this.selectedFood.id,
                type,
                selectSerie,
                categoria,
                color_size
            );
            let { item } = this.selectedFood;
            if (item.subject_to_detraction == 1) {
                this.$showSAlert(
                    "DETRACCION",
                    "Este producto esta sujeto a detracción",
                    "warming"
                );
            }
            /* if (this.configuration.restaurant == true){ */
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
            this.$emit("buscarnuevo");
            //this.$forceUpdate();
        },
        setFalse() {
            this.listFoods = this.listFoods.map(f => {
                f.select = false;
                return f;
            });
            this.allFalse = true;
        },
        selectFood(index) {
            //  this.$refs.description.$el.getElementsByTagName("input")[0].focus();
            if (this.listFoods[index].select) {
                this.listFoods[index].select = false;
                this.allFalse = true;
                this.selectedFood = null;
                return;
            }

            !this.allFalse && this.setFalse();
            this.listFoods[index].select = true;
            this.selectedFood = this.listFoods[index];
            this.allFalse = false;
        },
        searchFoodCategories(value) {
            if (value == 0) {
                this.listFoods = this.foods;
            } else {
                this.listFoods = _.filter(this.foods, {
                    category_food_id: value
                });
            }
        },
        searchFood(value = null, optionsSelected = "Descripcion") {
            !this.allFalse && this.setFalse();
            if (value) {
                if (optionsSelected == "Descripcion") {
                    this.listFoods = this.foods.filter(f =>
                        f.description.toLowerCase().includes(value)
                    );
                } else {
                    //this.listFoods=_.filter(this.foods,{'code':value})
                    this.listFoods = this.foods.filter(ff =>
                        ff.code.toLowerCase().includes(value)
                    );
                }
            } else {
                this.listFoods = this.foods;
            }
        },
        formatUrlImage(url) {
            if (!url) return;
            let formated = "storage/uploads/items/" + url;
            return `/${formated}`;
        },
        open() {
            this.ordenItems = [];
            this.orden = [];
            if (this.table.orden.length != 0) {
                this.ordenItems = this.table.orden.orden_items;

                // this.activeName = "orden";
                this.ordenId = this.table.orden.id;
                setTimeout(() => this.calculateOrden(), 50);
            }
            if (!this.categories.some(c => c.id == 0)) {
                if (!this.categories.some(c => c.id == 0)) {
                    this.categories.unshift({
                        id: 0,
                        description: "todos"
                    });
                }
                this.listFoods = this.foods.map(f => ({
                    ...f,
                    select: false
                }));
                this.title = `Mesa N°${this.table.number}`;
            }
        },
        /* agregado para cambiar de forma los div card a table */
        toggleView() {
            this.form.show_list = !this.form.show_list;
            localStorage.setItem(
                "viewPreference",
                JSON.stringify(this.form.show_list)
            );
            /* ; */
        },
        loadViewPreference() {
            const savedPreference = localStorage.getItem("viewPreference");
            if (savedPreference !== null) {
                this.form.show_list = JSON.parse(savedPreference);
                /* ; */
            }
        }
    }
};
</script>
