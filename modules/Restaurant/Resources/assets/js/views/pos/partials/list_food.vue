<!-- Productos y Servicios  en Caja los CARDS -->
<template>
    <div>
        <div class="row p-2" v-loading="loadingItems">
            
                <!-- <div class="col-9 d-flex align-items-center">
                    <h2 class="small-title" style="color: blue; font-weight: bold;">
                        Productos
                    </h2>
                    <template v-if="listFoods.length == 0">
                        <div class="col-12 text-center font-weight-bold">
                            <label>No Hay Productos</label>
                        </div>
                    </template>
                </div> -->
                <!-- <div class="col-3">
                    <div v-if="configuration.list_or_card">
                        <button @click="toggleView" class="btn btn-primary btn-sm ml-auto float-right">
                            {{
                                form.show_list
                                    ? "Mostrar Card"
                                    : "Mostrar Tabla"
                            }}
                        </button>
                    </div>
                </div> -->
            
            <!-- Card o Tabla -->
            <template v-if="configuration.list_or_card">
                <!-- Tabla    -->
                <template v-if="form.show_list">
                    <div class="infinite-list-wrapper w-100" style="max-height: 800px; overflow-y: auto;">
                        <ul class="list-group" infinite-scroll-disabled="isDisabled" infinite-scroll-distance="5">
                            <li class="list-group-item p-2">
                                <div id="app" class="container">
                                    <table class="table table-hover table-bordered m-0">
                                        <thead class="sticky-top bg-primary" style="z-index: 1;">
                                            <tr>
                                                <th class="text-white">
                                                    Producto o Servicio
                                                </th>
                                                <th class="text-white text-center">
                                                    Precio
                                                </th>
                                                <th v-if="
                                                    configuration.show_stock_cash ==
                                                    true
                                                " class="text-white text-center">
                                                    Stock
                                                </th>
                                                <th class="text-white text-center" v-if="
                                                    configuration.lotgroup_list_or_card
                                                ">
                                                    Lote
                                                </th>
                                                <th class="text-white" v-if="
                                                    configuration.listprice_list_or_card
                                                ">
                                                    Política de Precios
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(data, index) in foods" :key="index"
                                                @click="handleRowClick(data, index)"
                                                :style="{
                                                    backgroundColor: index % 2 === 0 ? '#fff' : '#afafaf',
                                                    color: 'inherit'
                                                }"
                                            >
                                                <td>
                                                    <div role="button">
                                                        <span :class="`lead-font-weight-700 ${configuration.trunc_txt
                                                            ? 'd-inline-block text-truncate'
                                                            : ''
                                                            }`
                                                            ">
                                                            <span style="font-weight: bold; font-size: 1em;">{{
                                                                data.code }}</span>
                                                            <br />
                                                            <span
                                                                style="font-family: Arial, Helvetica, sans-serif; font-size: 1em;">
                                                                {{ data.description.toUpperCase() }}
                                                            </span>
                                                        </span>
                                                        <template v-if="configuration.trunc_txt">
                                                            <el-tooltip class="item" effect="dark"
                                                                :content="data.description.toUpperCase()"
                                                                placement="top-start">
                                                                <i class="fas fa-ellipsis-h"></i>
                                                            </el-tooltip>
                                                        </template>
                                                    </div>
                                                </td>
                                                <td class="text-right">
                                                    {{
                                                        data.item.currency_type_id == "PEN"
                                                            ? "S/"
                                                            : "$"
                                                    }}
                                                    {{ data.price }}
                                                </td>
                                                <td class="text-center" v-if="configuration.show_stock_cash == true">
                                                    <template v-if="
                                                        data.item.is_set == 0 &&
                                                        data.item.unit_type_id != 'ZZ' &&
                                                        data.item.stock > 0
                                                    ">
                                                        <span class="m-l-0" style="text-align: center !important">
                                                            <template v-if="data.item.max_quantity">
                                                                {{
                                                                    formatedStockPresentation(
                                                                        data.item,
                                                                        data.item.stock
                                                                    )
                                                                }}
                                                            </template>
                                                            <template v-else>
                                                                {{
                                                                    parseFloat(data.item.stock)
                                                                }}
                                                            </template>
                                                        </span>
                                                    </template>
                                                    <template v-else>
                                                        <span class="text-danger m-l-0"
                                                            style="text-align: center !important">
                                                            <template
                                                                v-if="data.item.unit_type_id != 'ZZ'">Agotado</template>
                                                        </span>
                                                    </template>
                                                </td>
                                                <td v-if="configuration.lotgroup_list_or_card">
                                                    <div v-if="data.item.lots_enabled == 1 && data.item.date_of_due">
                                                        <el-tag
                                                            :type="`${isExpired(data.item.date_of_due) ? 'danger' : 'primary'}`">
                                                            {{ data.item.lot_code }} - {{ data.item.date_of_due }}
                                                        </el-tag>
                                                        <!-- <el-button type="primary" size="mini" style="margin-left:8px;" @click.stop="showLotesDialog(data.item, index)">
                                                            Seleccionar Lote
                                                        </el-button> -->
                                                    </div>
                                                </td>
                                                <td v-if="configuration.listprice_list_or_card">
                                                    <div v-if="data.types && data.types.length > 0">
                                                        <el-dropdown @command="clickCommand">
                                                            <span class="el-dropdown-link">
                                                                Precios
                                                                <i class="el-icon-arrow-down el-icon--right"></i>
                                                            </span>
                                                            <el-dropdown-menu slot="dropdown">
                                                                <el-dropdown-item v-for="(type, idx) in data.types"
                                                                    :key="idx" :command="type">
                                                                    {{ formatDescriptionType(type) }}
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
                </template>
                <template v-else>
                    <div class="d-flex flex-wrap">
                        <div class="col-12 col-lg-6 col-xl-4 col-xxl-4 p-1" v-for="(data, index) in foods" :key="index">
                            <el-tooltip effect="dark" :disabled="data.item.warehouses.length == 1 ||
                                !configuration.show_stock_establishment_box
                                ">
                                <div slot="content">
                                    Stock Almacenes
                                    <br />
                                    <span v-for="(info, idx) in data.item
                                        .warehouses" :key="idx">
                                        <label class="text-white" v-if="
                                            info.warehouse.id !=
                                            establishmentId
                                        ">
                                            <template v-if="data.item.max_quantity">
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
                                                    `${info.warehouse
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
                                <!-- Card del Producto o Servicio Primero -->
                                <div id="card"
                                    class="overflow-hidden coupon rounded d-flex flex-column justify-content-between p-1 bg-light"
                                    :style="`${configuration.trunc_txt
                                        ? 'min-height: 190px;'
                                        : 'height: 190px;'
                                        }`
                                        ">
                                    <div @click="
                                        (configuration.consolidated_quotations ||
                                            configuration.direct_unit_type) &&
                                            data.types &&
                                            data.types.length > 0
                                            ? clickCommand(data.types[0])
                                            : addFood(index)
                                        ">

                                        <div class="d-flex justify-content-between align-items-center"
                                             style="width: 100%; 
                                             padding: 0px; 
                                             margin-top: 1px; 
                                             margin-bottom: 0px;">
                                            <!-- Coódigo de Barras -->
                                            <div>
                                                <!-- <i class="fas fa-barcode mr-2"
                                                    style="font-size: 1.2em; color: #073f68;"></i> -->
                                                <span style="font-size: 1.1em;">{{ data.code }}</span>
                                            </div>
                                            <!-- Precio del Producto -->
                                            <div class="d-flex flex-column align-items-end" style="flex: 1;">
                                                <div class="block mb-2">
                                                    <span class="time font-weight-light">
                                                        <span class="lead-font-weight-500"
                                                            style="font-weight: bold; font-family: 'Arial Black', Arial, sans-serif;">
                                                            {{
                                                                data.item.currency_type_id == "PEN"
                                                                    ? "S/"
                                                                    : "$"
                                                            }}
                                                            <span style="font-size: 1.5em;">{{ data.price }}</span>
                                                        </span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div
                                            style="background-color: #073f68; color: #fff; padding: 4px; border-radius: 4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                            <span :class="`lead-font-weight-500 ${configuration.trunc_txt
                                                ? 'd-inline-block text-truncate'
                                                : ''
                                                }`" style="color: #fff; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                {{ data.description.toUpperCase() }}
                                            </span>
                                            <template v-if="configuration.trunc_txt">
                                                <el-tooltip class="item" effect="dark"
                                                    :content="data.description.toUpperCase()" placement="top-start">
                                                    <i class="fas fa-ellipsis-h" style="color: #fff;"></i>
                                                </el-tooltip>
                                            </template>
                                        </div>

                                        <div class="row">
                                            <div class="col-4">
                                                <div class=""
                                                    style="height: 120px; width: 120px; display: flex; align-items: center; justify-content: center;">
                                                    <el-tooltip :disabled="data.second_name == null" effect="dark"
                                                        :content="data.second_name" placement="top-start">
                                                        <template v-if="data.image == 'imagen-no-disponible.jpg'">
                                                            <img src="/images/imagen-no-disponible.jpg" alt="User Img"
                                                                class=""
                                                                style="width: 100%; height: 100%; object-fit: contain; display: block;" />
                                                        </template>
                                                        <template v-else>
                                                            <img :src="formatUrlImage(data.image)" class=""
                                                                style="width: 100%; height: 120%; object-fit: contain; display: block;" />
                                                        </template>
                                                    </el-tooltip>
                                                </div>
                                            </div>
                                            <div class="col-8">
                                                <div class="d-flex justify-content-end align-items-center"
                                                    style="text-align: right; margin-right:4px;">
                                                    <span>Ubc.:</span>
                                                    <span style="color: red; font-weight: bold;">
                                                    :  {{ data.item.location && data.item.location.trim() !== '' ? data.item.location.toUpperCase() : 'S-U' }}
                                                    </span>
                                                </div>
                                                <div v-if="data.types && data.types.length > 0"
                                                    style="width: 100%; display: flex; justify-content: flex-end;">
                                                    <el-dropdown @command="clickCommand">
                                                        <span class="el-dropdown-link"
                                                            style="color: green; font-weight: bold;">
                                                            Precios
                                                            <i class="el-icon-arrow-down el-icon--right"></i>
                                                        </span>
                                                        <el-dropdown-menu slot="dropdown" class="custom-dropdown-menu"
                                                            style="min-width: 200px;">
                                                            <el-dropdown-item v-for="(type, idx) in data.types"
                                                                :key="idx" :command="type" class="custom-dropdown-item">
                                                                <div
                                                                    class="d-flex align-items-center justify-content-between w-100">
                                                                    <div>
                                                                        <span class="font-weight-bold"
                                                                            style="color: #073f68;">
                                                                            {{ type.description.toUpperCase() }}
                                                                        </span>
                                                                        <span class="small text-muted ml-2">
                                                                            ( {{ Number(type.quantity_unit) }} )
                                                                        </span>
                                                                    </div>
                                                                    <span class="badge ml-3"
                                                                        style="font-size: 1em; min-width: 30px; text-align: right; color: #000;">
                                                                        S/ {{ Number(getDefaultPrice(type)).toFixed(2)
                                                                        }}
                                                                    </span>
                                                                </div>
                                                            </el-dropdown-item>
                                                        </el-dropdown-menu>
                                                    </el-dropdown>
                                                </div>
                                                <div v-else>
                                                    <span class="text-muted">.</span>
                                                </div>
                                                 <!-- <div class="d-flex flex-wrap justify-content-center m-1" v-if="
                                                    data.item.lots_enabled == 1 &&
                                                    data.item.date_of_due
                                                    ">
                                                    <el-tag v-for="(lot,idx) in data.item.lots_group.filter(l => l.quantity > 0)"
                                                             :key="idx" :type="`${isExpired(lot.date_of_due)
                                                                ? 'danger'
                                                                : 'primary'
                                                            }`">
                                                            {{ lot.code }} -
                                                            {{ lot.date_of_due }} -
                                                            ({{ lot.quantity }})
                                                    </el-tag>
                                                </div> -->

                                                <!-- Badges (lote / serie / color&talla / servicio) con placeholder -->
                                                <template
                                                    v-if="(data.item.lots_enabled == 1 && data.item.date_of_due) ||
                                                           data.item.series_enabled == 1 ||
                                                           data.item.has_color_size == 1 ||
                                                           data.item.unit_type_id == 'ZZ'"
                                                >
                                                    <!-- Si TIENE Lote -->
                                                    <div v-if="data.item.lots_enabled == 1 && data.item.date_of_due"
                                                         class="col-12 mb-1" style="text-align:right;">
                                                        <span
                                                            class="badge"
                                                            style="background:#6f42c1; color:#fff;
                                                                   font-weight:bold; padding:4px 10px;
                                                                   border-radius:4px; letter-spacing:.5px;
                                                                   display:inline-block; min-width:100px; text-align:center;">
                                                            LOTE
                                                        </span>
                                                    </div>

                                                    <!-- SI TIENE SERIE -->
                                                    <div v-if="data.item.series_enabled == 1"
                                                         class="col-12 mb-1" style="text-align:right;">
                                                        <span
                                                            class="badge"
                                                            style="background:#1e5a85; color:#fff;
                                                                   font-weight:bold; padding:4px 10px;
                                                                   border-radius:4px; letter-spacing:.5px;
                                                                   display:inline-block; min-width:100px; text-align:center;">
                                                            SERIE
                                                        </span>
                                                    </div>

                                                    <!-- SI TIENE COLOR Y TALLA -->
                                                    <div v-if="data.item.has_color_size == 1"
                                                         class="col-12 mb-1" style="text-align:right;">
                                                        <span
                                                            class="badge"
                                                            style="background:#20c997; color:#fff;
                                                                   font-weight:bold; padding:4px 10px;
                                                                   border-radius:4px; letter-spacing:.5px;
                                                                   display:inline-block; min-width:100px; text-align:center;">
                                                            COLOR&TALLA
                                                        </span>
                                                    </div>

                                                    <!-- SI ES SERVICIO -->
                                                    <div v-if="data.item.unit_type_id == 'ZZ'"
                                                         class="col-12 mb-1" style="text-align:right;">
                                                        <span
                                                            class="badge"
                                                            style="background:#0e7ea6; color:#fff;
                                                                   font-weight:bold; padding:4px 10px;
                                                                   border-radius:4px; letter-spacing:.5px;
                                                                   display:inline-block; min-width:100px; text-align:center;">
                                                            SERVICIO
                                                        </span>
                                                    </div>
                                                </template>
                                                <template v-else>
                                                    <!-- Placeholder para conservar la altura/espacio -->
                                                    <div class="col-12 mb-1" style="text-align:right;">
                                                        <span
                                                            class="badge"
                                                            style="background:transparent; color:#fff;
                                                                   font-weight:bold; padding:4px 10px;
                                                                   border-radius:4px; letter-spacing:.5px;
                                                                   display:inline-block; min-width:100px; text-align:center;">
                                                            .
                                                        </span>
                                                    </div>
                                                </template>
                                                <!-- Stock en Caja -->
                                                <div
                                                    v-if="data.item.is_set == 0 && data.item.unit_type_id !='ZZ' && configuration.show_stock_cash == true"
                                                    class="cold-12 d-flex justify-content-end"
                                                    style="margin-left: 2px; margin-right: 2px; margin-bottom: 2px; text-align: right;">
                                                    <template v-if="data.item.stock > 0">
                                                        <div class="d-flex flex-column align-items-end">
                                                            <!-- <span>Stock</span> -->
                                                            <span   class="badge"
                                                                    style="background:#1e5a85; color:#fff; 
                                                                    font-weight:bold; padding:4px 10px; 
                                                                    border-radius:4px; letter-spacing:.5px; display:inline-block; min-width:100px; text-align:center;">
                                                                <template v-if="data.item.max_quantity">
                                                                    {{ formatedStockPresentation(data.item, data.item.stock).replace(/\bNIU\b/g, 'UND').toUpperCase() }}
                                                                </template>
                                                                <template v-else>
                                                                    {{ parseFloat(data.item.stock) }} {{ data.item.unit_type && data.item.unit_type.id ? (data.item.unit_type.id === 'NIU' ? 'UND' : data.item.unit_type.id) : '' }}
                                                                </template>
                                                            </span>
                                                        </div>
                                                    </template>
                                                    <template v-else>
                                                        <template v-if="data.item.unit_type_id !='ZZ'">
                                                            <div class="text-center"
                                                                style="width: 100%; position: relative; height: 20px; text-align: right;">
                                                                <img src="/status_images/stock.png"
                                                                    style="position: absolute; top: 15px; right: 0; transform: translateY(-50%); opacity: 1; pointer-events: none; width: 300px; height: 100px;" class="" />
                                                            </div>
                                                        </template>
                                                        <template v-else>
                                                            <div class="col-12 mb-1" style="text-align:right;">
                                                                <span
                                                                    class="badge"
                                                                    style="background:transparent; color:#fff;
                                                                        font-weight:bold; padding:4px 10px;
                                                                        border-radius:4px; letter-spacing:.5px;
                                                                        display:inline-block; min-width:100px; text-align:center;">
                                                                    .
                                                                </span>
                                                            </div>
                                                        </template>
                                                    </template>
                                                </div>
                                                <div class="d-flex justify-content-end align-items-center" style="margin-right: 8px;">
                                                    <!-- Historial Compra/Venta -->
                                                    <span
                                                        class="button-container"
                                                        v-if="configuration.compra_venta"
                                                        style="margin-left: 4px;"
                                                        @click.stop
                                                    >
                                                        <el-row>
                                                            <el-button
                                                                size="mini"
                                                                class="bg-info custom-el-button"
                                                                round
                                                                title="Ver historial de compra/venta"
                                                                @click.stop.prevent="clickWarehouseDetail(
                                                                    data.id,
                                                                    data.has_series,
                                                                    data.warehouses,
                                                                    data.unit_type,
                                                                    data.item
                                                                )"
                                                            >
                                                                <i class="fas fa-history" style="color: #fff;"></i>
                                                            </el-button>
                                                        </el-row>
                                                    </span>
                                                    <!-- Visualizar imagen grande -->
                                                    <span
                                                        v-if="configuration.zones_workers"
                                                        class="button-container"
                                                        style="margin-left: 4px;"
                                                        @click.stop
                                                    >
                                                        <el-row>
                                                            <el-button
                                                                size="mini"
                                                                class="bg-warning custom-el-button"
                                                                round
                                                                title="Ver imagen ampliada"
                                                                @click.stop.prevent="clickFoodsImages(data.id)"
                                                            >
                                                                <i class="fas fa-search-plus" style="color: #fff;"></i>
                                                            </el-button>
                                                        </el-row>
                                                    </span>
                                                </div>
                                                
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </el-tooltip>
                        </div>
                        <!-- hasta aqui -->
                    </div>
                </template>
            </template>
            <template v-else>
                <!-- Card del Producto o Servicio Primero  RESTAURANT-->
                <div class="d-flex flex-wrap">
                    <div class="col-12 col-lg-6 col-xl-4 col-xxl-4 p-1" v-for="(data, index) in foods" :key="index">
                        <el-tooltip effect="dark" :disabled="data.item.warehouses.length == 1 ||!configuration.show_stock_establishment_box">
                            <div slot="content">
                                Stock Almacenes
                                <br />
                                <span v-for="(info, idx) in data.item.warehouses" :key="idx">
                                    <label class="text-white" v-if="
                                        info.warehouse.id != establishmentId
                                    ">
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
                                                `${info.warehouse.description
                                                }: ${Number(info.stock).toFixed(
                                                    2
                                                )}`
                                            }}
                                        </template>
                                    </label>
                                    <br />
                                </span>
                            </div>
                            <div id="card"
                                 class="overflow-hidden coupon rounded d-flex flex-column justify-content-between p-1 bg-light"
                                 :style="`${configuration.trunc_txt ? 'min-height:190px;' : 'height:190px;'}`">
                                <div @click="
                                    (configuration.consolidated_quotations || configuration.direct_unit_type) &&
                                    data.types && data.types.length > 0
                                        ? clickCommand(data.types[0])
                                        : addFood(index)
                                ">
                                    <!-- Barra superior: código + precio -->
                                    <div class="d-flex justify-content-between align-items-center"
                                         style="width:100%;padding:0;margin-top:1px;margin-bottom:0;">
                                        <div>
                                            <i class="fas fa-barcode mr-2" style="font-size:1.2em;color:#073f68;"></i>
                                            <span style="font-size:1.1em;">{{ data.code }}</span>
                                        </div>
                                        <div class="d-flex flex-column align-items-end" style="flex:1;">
                                            <div class="block mb-2">
                                                <span class="time font-weight-light">
                                                    <span class="lead-font-weight-500"
                                                          style="font-weight:bold;font-family:'Arial Black', Arial, sans-serif;">
                                                        {{ data.item.currency_type_id == 'PEN' ? 'S/' : '$' }}
                                                        <span style="font-size:1.5em;">{{ data.price }}</span>
                                                    </span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Descripción -->
                                    <div style="background-color:#073f68;color:#fff;padding:4px;border-radius:4px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                        
                                        <span :class="`lead-font-weight-500 ${configuration.trunc_txt ? 'd-inline-block text-truncate' : ''}`"
                                              style="color:#fff;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                            {{ data.description.toUpperCase() }}
                                        </span>
                                        <template v-if="configuration.trunc_txt">
                                            <el-tooltip class="item" effect="dark"
                                                        :content="data.description.toUpperCase()"
                                                        placement="top-start">
                                                <i class="fas fa-ellipsis-h" style="color:#fff;"></i>
                                            </el-tooltip>
                                        </template>
                                    </div>

                                    <div class="row">
                                        <!-- Imagen -->
                                        <div class="col-4">
                                            <div style="height:120px;width:120px;display:flex;align-items:center;justify-content:center;">
                                                <el-tooltip :disabled="data.second_name==null" effect="dark"
                                                            :content="data.second_name" placement="top-start">
                                                    <template v-if="data.image=='imagen-no-disponible.jpg'">
                                                        <img src="/images/imagen-no-disponible.jpg"
                                                             style="width:100%;height:100%;object-fit:contain;display:block;" />
                                                    </template>
                                                    <template v-else>
                                                        <img :src="formatUrlImage(data.image)"
                                                             style="width:100%;height:120%;object-fit:contain;display:block;" />
                                                    </template>
                                                </el-tooltip>
                                            </div>
                                        </div>

                                        <!-- Detalles derecha -->
                                        <div class="col-8">
                                            <!-- Ubicación -->
                                            <div class="d-flex justify-content-end align-items-center"
                                                 style="text-align:right;margin-right:4px;">
                                                <span>Ubc.:</span>
                                                <span style="color:red;font-weight:bold;">
                                                    : {{ data.item.location && data.item.location.trim() !== '' ? data.item.location.toUpperCase() : 'S-U' }}
                                                </span>
                                            </div>

                                            <!-- Dropdown de precios -->
                                            <div v-if="data.types && data.types.length > 0"
                                                 style="width:100%;display:flex;justify-content:flex-end;">
                                                <el-dropdown @command="clickCommand">
                                                    <span class="el-dropdown-link"
                                                          style="color:green;font-weight:bold;">
                                                        Precios
                                                        <i class="el-icon-arrow-down el-icon--right"></i>
                                                    </span>
                                                    <el-dropdown-menu slot="dropdown" class="custom-dropdown-menu"
                                                                      style="min-width:200px;">
                                                        <el-dropdown-item v-for="(type,idx) in data.types"
                                                                          :key="idx"
                                                                          :command="type"
                                                                          class="custom-dropdown-item">
                                                            <div class="d-flex align-items-center justify-content-between w-100">
                                                                <div>
                                                                    <span class="font-weight-bold" style="color:#073f68;">
                                                                        {{ type.description.toUpperCase() }}
                                                                    </span>
                                                                    <span class="small text-muted ml-2">
                                                                        ( {{ Number(type.quantity_unit) }} )
                                                                    </span>
                                                                </div>
                                                                <span class="badge ml-3"
                                                                      style="font-size:1em;min-width:30px;text-align:right;color:#000;">
                                                                    S/ {{ Number(getDefaultPrice(type)).toFixed(2) }}
                                                                </span>
                                                            </div>
                                                        </el-dropdown-item>
                                                    </el-dropdown-menu>
                                                </el-dropdown>
                                            </div>
                                            <div v-else>
                                                <span class="text-muted">.</span>
                                            </div>

                                            <!-- Badges (lote, serie, color&talla, servicio) -->
                                            <template
                                                v-if="(data.item.lots_enabled == 1 && data.item.date_of_due) ||
                                                       data.item.series_enabled == 1 ||
                                                       data.item.has_color_size == 1 ||
                                                       data.item.unit_type_id == 'ZZ'">
                                                <div v-if="data.item.lots_enabled == 1 && data.item.date_of_due"
                                                     class="col-12 mb-1" style="text-align:right;">
                                                    <span class="badge"
                                                          style="background:#6f42c1;color:#fff;font-weight:bold;padding:4px 10px;border-radius:4px;letter-spacing:.5px;display:inline-block;min-width:100px;text-align:center;">
                                                        LOTE
                                                    </span>
                                                </div>
                                                <div v-if="data.item.series_enabled == 1"
                                                     class="col-12 mb-1" style="text-align:right;">
                                                    <span class="badge"
                                                          style="background:#1e5a85;color:#fff;font-weight:bold;padding:4px 10px;border-radius:4px;letter-spacing:.5px;display:inline-block;min-width:100px;text-align:center;">
                                                        SERIE
                                                    </span>
                                                </div>
                                                <div v-if="data.item.has_color_size == 1"
                                                     class="col-12 mb-1" style="text-align:right;">
                                                    <span class="badge"
                                                          style="background:#20c997;color:#fff;font-weight:bold;padding:4px 10px;border-radius:4px;letter-spacing:.5px;display:inline-block;min-width:100px;text-align:center;">
                                                        COLOR&TALLA
                                                    </span>
                                                </div>
                                                <div v-if="data.item.unit_type_id == 'ZZ'"
                                                     class="col-12 mb-1" style="text-align:right;">
                                                    <span class="badge"
                                                          style="background:#0e7ea6;color:#fff;font-weight:bold;padding:4px 10px;border-radius:4px;letter-spacing:.5px;display:inline-block;min-width:100px;text-align:center;">
                                                        SERVICIO
                                                    </span>
                                                </div>
                                            </template>
                                            <template v-else>
                                                <div class="col-12 mb-1" style="text-align:right;">
                                                    <span class="badge"
                                                          style="background:transparent;color:#fff;font-weight:bold;padding:4px 10px;border-radius:4px;letter-spacing:.5px;display:inline-block;min-width:100px;text-align:center;">
                                                        .
                                                    </span>
                                                </div>
                                            </template>

                                            <!-- Stock -->
                                            <div v-if="data.item.is_set == 0 && data.item.unit_type_id != 'ZZ' && configuration.show_stock_cash == true"
                                                 class="cold-12 d-flex justify-content-end"
                                                 style="margin:0 2px 2px 2px;text-align:right;">
                                                <template v-if="data.item.stock > 0">
                                                    <div class="d-flex flex-column align-items-end">
                                                        <span class="badge"
                                                              style="background:#1e5a85;color:#fff;font-weight:bold;padding:4px 10px;border-radius:4px;letter-spacing:.5px;display:inline-block;min-width:100px;text-align:center;">
                                                            <template v-if="data.item.max_quantity">
                                                                {{ formatedStockPresentation(data.item, data.item.stock).replace(/\bNIU\b/g,'UND').toUpperCase() }}
                                                            </template>
                                                            <template v-else>
                                                                {{ parseFloat(data.item.stock) }}
                                                                {{ data.item.unit_type && data.item.unit_type.id ? (data.item.unit_type.id === 'NIU' ? 'UND' : data.item.unit_type.id) : '' }}
                                                            </template>
                                                        </span>
                                                    </div>
                                                </template>
                                                <template v-else>
                                                    <template v-if="data.item.unit_type_id != 'ZZ'">
                                                        <div class="text-center"
                                                             style="width:100%;position:relative;height:20px;text-align:right;">
                                                            <img src="/status_images/stock.png"
                                                                 style="position:absolute;top:15px;right:0;transform:translateY(-50%);opacity:1;pointer-events:none;width:300px;height:100px;" />
                                                        </div>
                                                    </template>
                                                    <template v-else>
                                                        <div class="col-12 mb-1" style="text-align:right;">
                                                            <span class="badge"
                                                                  style="background:transparent;color:#fff;font-weight:bold;padding:4px 10px;border-radius:4px;letter-spacing:.5px;display:inline-block;min-width:100px;text-align:center;">
                                                                .
                                                            </span>
                                                        </div>
                                                    </template>
                                                </template>
                                            </div>

                                            <!-- Botones (historial / imagen) -->
                                            <div class="d-flex justify-content-end align-items-center" style="margin-right:8px;">
                                                <span class="button-container"
                                                      v-if="configuration.compra_venta"
                                                      style="margin-left:4px;"
                                                      @click.stop>
                                                    <el-row>
                                                        <el-button size="mini"
                                                                   class="bg-info custom-el-button"
                                                                   round
                                                                   title="Ver historial de compra/venta"
                                                                   @click.stop.prevent="clickWarehouseDetail(
                                                                        data.id,
                                                                        data.has_series,
                                                                        data.warehouses,
                                                                        data.unit_type,
                                                                        data.item
                                                                   )">
                                                            <i class="fas fa-history" style="color:#fff;"></i>
                                                        </el-button>
                                                    </el-row>
                                                </span>
                                                <span v-if="configuration.zones_workers"
                                                      class="button-container"
                                                      style="margin-left:4px;"
                                                      @click.stop>
                                                    <el-row>
                                                        <el-button size="mini"
                                                                   class="bg-warning custom-el-button"
                                                                   round
                                                                   title="Ver imagen ampliada"
                                                                   @click.stop.prevent="clickFoodsImages(data.id)">
                                                            <i class="fas fa-search-plus" style="color:#fff;"></i>
                                                        </el-button>
                                                    </el-row>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Lote simple (cuando aplica y no se muestran grupos) -->
                                <div class="d-flex justify-content-center m-1"
                                     v-if="data.item.lots_enabled == 1 && data.item.date_of_due">
                                    <el-tag :type="`${isExpired(data.item.date_of_due) ? 'danger':'primary'}`">
                                        {{ data.item.lot_code }} - {{ data.item.date_of_due }}
                                    </el-tag>
                                </div>
                            </div>
                        </el-tooltip>
                    </div>
                </div>
            </template>
        </div>
        <unit-type-modal :foods="foods" @addUnitType="addUnitType" @addCategoriaMadera="addCategoriaMadera"
            :showDialog.sync="showUnitTypeModal" :medida_alto="medida_alto" :medida_ancho="medida_ancho"
            :medida_grosor="medida_grosor" :categoria_madera="categoria_madera" :item="selectedFood"
            :currentIndex="currentIndex"></unit-type-modal>
        <warehouses-detail :showDialog.sync="showWarehousesDetail" :warehouses="warehousesDetail"
            :unit_type.sync="unit_type" :itemId="itemId" :hasSerie="hasSerie" :item="currentItem" :config="config"
            :user="user"></warehouses-detail>
        <images-food :showDialog.sync="showImagesFoods" :item="currentItem" :config="config"></images-food>
        <modal-unit-type-id
            @selectUnitType="onSeriesConfirm"
            :showDialog.sync="showDialogUnitType"
            :item="currentItem"
        ></modal-unit-type-id>
        <show-color-size-product
            :limitQty="limitQty"
            :idx="currentIdx"
            :item="currentItem"
            :showDialog.sync="showColorSize"
            :colorSizeSelected.sync="currentColorSize"
            :establishments="establishments"
            @updateColorSize="updateColorSize"
        />
        <show-lotes-product
            :idx="currentIdx"
            :orden="ordenLot"
            :item="currentItem"
            :showDialog.sync="showLotes"
            @updateLotes="updateLotes"
        />
        <show-series-product
            :limitQty="limitQty"
            :idx="currentIdx"
            :item="currentItem"
            :showDialog.sync="showSeries"
            :seriesSelected.sync="seriesSelected"
            :establishments="establishments"
            @updateSeries="onSeriesConfirm"
        />
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
    height: 100%;
    /* Ocupa todo el espacio disponible */
    display: flex;
    flex-direction: column;
}

.table {
    flex: 1;
    overflow-y: auto;
    /* Permite el scroll si hay más filas */
}
</style>

<script>
const ShowLotesProduct = () =>
    import("../partials/show_lotes_product.vue");
const ShowSeriesProduct = () =>
    import("../partials/show_series_product.vue");
import WarehousesDetail from "./warehouses.vue";
import UnitTypeModal from "./unit_type_modal.vue";
import ModalUnitTypeId from "./modal_unit_type_id.vue";
import ImagesFood from "./images_food.vue";
import itemSet from "./itemSet.vue";
const ShowColorSizeProduct = () =>
    import("../partials/show_color_size_product.vue");
import swal from "sweetalert2";
export default {
    components: {
        WarehousesDetail,
        UnitTypeModal,
        ModalUnitTypeId,
        ImagesFood,
        ShowColorSizeProduct,
        ShowLotesProduct,
        ShowSeriesProduct,
        itemSet
    },
    props: [
        "lastQuery",
        "cotizarConfirmado",
        "canAddItem",
        "loadingItems",
        "foods",
        "value",
        "configuration",
        "worker",
        "pagination",
        "blockAdd",
        "localOrden",
        "type_code",
        "barcode",
        "policy",
        "model",
        "quality",
        "searchSeries",
        "medida_ancho",
        "medida_alto",
        "medida_grosor",
        "categoria_madera",
        "establishments"
    ],
    data() {
        return {
            showDialogItemSet: false,
            // Components for item sets (reactive to avoid Vue warn)
            itemSetComponents: [],
            // Context stored when an item-set modal interrupts addFood
            pendingItemSetAdd: null,
            currentColorSize: [],
            limitQty: 0,
            showColorSize: false,
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
            
            currentIdx: null,
            showImagesFoods: false,
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
            listFoods: [], // Initialize listFoods as an empty array
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
            screenWidth: 0,
            stockData: {},
            ordenLot: null,
            showLotes: false,
            showSeries: false,
            seriesSelected: [],
        };
    },
    mounted() {
        this.screenWidth = window.innerWidth;
        this.loadViewPreference();
        window.addEventListener("resize", this.handleResize);

        if (!Array.isArray(this.listFoods)) {
            this.listFoods = [];
        }

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
        },
        listFoods(newVal, oldVal) {
            console.log("🔄 Cambio en listFoods:", oldVal, "➡️", newVal);
        }
    },
    created() {
        this.ordenItems = [];
        this.orden = [];
        this.updateListFoods();
        if (!this.listFoods) {
            this.$set(this, "listFoods", []);
        }
        this.$root.$on("itemnew", this.agregarItem);
    },
    beforeDestroy() {
        this.$root.$off("itemnew", this.agregarItem);
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
        handleRowClick(data, index) {
            console.log('handleRowClick llamado', data, index);
            // Lógica de lote
            if (
                this.configuration.lotgroup_list_or_card &&
                data.item.lots_enabled == 1 &&
                data.item.date_of_due
            ) {
                console.log('Condición lote cumplida');
                this.showLotesDialog(data.item, index);
            }
            // Lógica de color y talla
            if (
                this.configuration.color_size_enabled &&
                data.item.has_color_size
            ) {
                console.log('Condición color/talla cumplida');
                this.currentItem = data.item;
                this.currentIdx = index;
                this.showColorSize = true;
            }
            // Lógica de series
            if (
                this.configuration.series_enabled &&
                data.item.has_series
            ) {
                console.log('Condición series cumplida', data.item, index);
                this.currentItem = data.item;
                this.currentIdx = index;
                this.showSeries = true;
            }
            // Lógica de orden normal
            if (
                (this.configuration.consolidated_quotations ||
                    this.configuration.direct_unit_type) &&
                data.types &&
                data.types.length > 0
            ) {
                console.log('Condición orden normal cumplida');
                this.clickCommand(data.types[0]);
            } else {
                console.log('Condición addFood cumplida');
                this.addFood(index);
            }
        },
        onSeriesConfirm(idx, seriesSelected) {
            this.showSeries = false;
            this.seriesSelected = seriesSelected;
            this.addFood(idx, null, true, null, seriesSelected);
        },
        updateLotes(idx, lotes) {
            // Actualiza la orden con los lotes seleccionados
            let ordens = Array.isArray(this.localOrden) ? [...this.localOrden] : [];
            if (ordens[idx]) {
                ordens[idx].lotes = lotes;
            }
            this.$emit("update:localOrden", ordens);
            this.showLotes = false;
        },
        showLotesDialog(item, idx) {
            this.currentIdx = idx;
            // Adaptar el objeto para que tenga la propiedad 'lotes'
            this.ordenLot = {
                ...item,
                lotes: item.lots_group || []
            };
            this.showLotes = true;
        },
        addconfirm(payload) {
            // Payload esperado: { components: [...], total_quantity: Number, item_id: <id> }
            console.log("addconfirm recibido (item set)", payload);

            // Cerrar modal
            this.showDialogItemSet = false;

            // Validaciones básicas
            if (!payload || !Array.isArray(payload.components) || !payload.total_quantity) {
                console.warn("Payload inválido en addconfirm", payload);
                return;
            }

            // Si por alguna razón no quedó selectedFood (ej: refresco), lo resolvemos por item_id
            if (!this.selectedFood && payload.item_id) {
                const idx = this.listFoods.findIndex(f => f.item && f.item.id == payload.item_id);
                if (idx >= 0) {
                    this.selectedFood = JSON.parse(JSON.stringify(this.listFoods[idx]));
                }
            }

            if (!this.selectedFood) {
                console.warn("No hay selectedFood para completar item set");
                return;
            }

            // Construir currentFood con la cantidad total confirmada
            this.currentFood = {
                id: this.selectedFood.id,
                food: this.selectedFood,
                observation: null,
                price: this.selectedFood.price,
                quantity: Number(payload.total_quantity) || 0,
                // Guardamos los componentes seleccionados del set
                item_set_components: JSON.parse(JSON.stringify(payload.components))
            };

            // Emitimos usando el mismo canal existente. No alteramos la firma para no romper al padre.
            // Los componentes van embebidos en currentFood.item_set_components
            this.$emit(
                "insertOrden",
                this.currentFood,
                this.selectedFood.id,
                null, // type
                false, // selectSerie
                null, // categoria
                [] // color_size
            );

            this.$notify({
                title: this.currentFood.food.description.toLowerCase(),
                duration: 800,
                iconClass: "el-icon-food",
                message: "Item set agregado",
                position: "bottom-left"
            });

            // Limpiar contexto
            this.currentFood = { food: null, observation: null, quantity: 0, price: 0 };
            this.selectedFood = null;
            this.pendingItemSetAdd = null;
        },
        async updateColorSize(idx, color_size) {
            console.log("updateColorSize ver que llega aqui", idx, color_size);
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
                let ordenOriginal = JSON.parse(JSON.stringify(ordens[idx]));
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
            console.log("color_price", color_price);
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
        agregarItem(producto) {
            if (!producto || !producto.food) {
                return;
            }

            const cleanProducto = producto.food;

            if (!Array.isArray(this.listFoods)) {
                console.warn("⚠️ listFoods está indefinido, inicializando...");
                this.$set(this, "listFoods", []);
            }

            let productoIndex = this.listFoods.findIndex(
                f => f.id === cleanProducto.id
            );

            if (productoIndex === -1) {
                this.$set(this.listFoods, this.listFoods.length, cleanProducto);

                productoIndex = this.listFoods.length - 1;
            }

            this.$nextTick(() => {
                this.addFood(productoIndex);
            });
        },

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

        clickFoodsImages(id) {
            this.itemId = id;
            // Find the food item by id and pass it with its full data
            const foodItem = this.foods.find(food => food.id === id);
            if (foodItem) {
                this.currentItem = {
                    ...foodItem,
                    description: foodItem.description
                };
            }
            this.showImagesFoods = true;
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
        nthing() { },
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
            if (!Array.isArray(this.foods)) {
                console.error("🚨 Error: foods is undefined or not an array.");
                this.foods = [];
            }

            this.listFoods = this.foods.map(f => {
                f.price = Number(f.price).toFixed(2);
                return {
                    ...f,
                    select: false
                };
            });
            if (this.barcode && this.listFoods.length === 1 && this.value) {
                let [food] = this.listFoods;
                if (food.types && Array.isArray(food.types)) {
                    let type = food.types.find(
                        t => t.unique_code === this.value
                    );
                    if (type) {
                        this.clickCommand(type);
                        return;
                    }
                }
            }
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
                    if (
                        this.configuration.direct_unit_type &&
                        food.item.item_unit_types.length > 0
                    ) {
                        this.clickCommand(food.item.item_unit_types[0]);
                    } else {
                        this.addFood(0);
                    }
                }
            }
            if (this.searchSeries && this.listFoods.length == 1) {
                this.addFood(0, null, true);
            }

            if (
                this.barcode &&
                this.configuration.color_size_enabled &&
                this.listFoods.length === 1 &&
                this.value
            ) {
                let [food] = this.listFoods;
                if (food.item && food.item.has_color_size) {
                    this.currentItem = food.item;
                    this.showColorSize = true;
                    return;
                }
            }

            if (this.configuration.color_size_enabled) {
                if (this.listFoods.length == 1) {
                    let [food] = this.listFoods;
                    let color_size = food.color_size.find(
                        color => color.code == this.lastQuery
                    );

                    if (color_size) {
                        color_size.quantity = 1;
                        this.addFood(0, null, true, null, [color_size]);
                    }
                }
            }
            if (this.quatity && this.listFoods.length == 1) {
                this.addFood(0, null, true);
            }
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
                console.log(
                    "orden.color_size ver si hay dato aqui",
                    this.currentColorSize,
                    currentOrden
                );
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
            console.log("orden.color_size", this.color_size);

            this.currentIdx = index;
            this.showColorSize = true;
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
            let pass = true;
            const response = await this.$http.get(
                `/receta/check/${id}/${quantity}`
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

        async setItemPolicy(id, quantity) {
            let pass = true;
            const response = await this.$http.get(
                `/item-sets/check/${id}/${quantity}`
            );

            if (response.status === 200) {
                const { success, message, components } = response.data;

                // ✅ Validar si components tiene algo
                if (components && components.length > 0) {
                    this.showDialogItemSet = true;
                    this.itemSetComponents = components;
                } else {
                    this.showDialogItemSet = false;
                }

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
            console.log("addFood llamado con a items");
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

            // Si el producto tiene item_codes y hay barcode, solo pasar el code_barcode escaneado
            if (
                this.selectedFood.item &&
                Array.isArray(this.selectedFood.item.item_codes) &&
                this.barcode
            ) {
                const foundCode = this.selectedFood.item.item_codes.find(
                    c => c.code_barcode === this.barcode
                );
                if (foundCode) {
                    this.selectedFood.item.item_codes = [foundCode];
                    this.selectedFood.item.code_barcode = this.barcode;
                }
            }

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
                    let pass; // declare once and reuse
                    if (this.configuration.restaurant) {
                        pass = await this.setItemCheckStock(
                            this.selectedFood.item.id,
                            qty
                        );
                    } else {
                        pass = await this.setItemPolicy(
                            this.selectedFood.item.id,
                            qty
                        );
                    }
                    if (pass === false) return;
                    // Si el item-set requiere selección (modal abierto) detenemos aquí y guardamos contexto
                    if (this.showDialogItemSet) {
                        this.pendingItemSetAdd = { index, type, selectSerie, categoria, color_size };
                        console.log("addFood pausado esperando confirmación de item set", this.pendingItemSetAdd);
                        return; // Esperar a addconfirm
                    }
                }
            } else {
                if (
                    Number(this.selectedFood.item.stock) <= 0 &&
                    this.configuration.sales_stock == true &&
                    !quotation_stock &&
                    this.selectedFood.item.unit_type_id != "ZZ"
                ) {
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
                    qty += 1;
                } else {
                    qty += 1;
                }

                // Validate stock again before adding
                if (
                    this.configuration.sales_stock == true &&
                    this.selectedFood.item.is_set == 0 &&
                    !quotation_stock &&
                    this.selectedFood.item.unit_type_id != "ZZ"
                ) {
                    if (qty > Number(this.selectedFood.item.stock)) {
                        this.$showSAlert(
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
            if (!this.configuration.chifa_china) {
                this.$emit("buscarnuevo");
            }
        },
        setFalse() {
            this.listFoods = this.listFoods.map(f => {
                f.select = false;
                return f;
            });
            this.allFalse = true;
        },
        selectFood(index) {
            //this.$refs.description.$el.getElementsByTagName("input")[0].focus();
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
