<template>
    <div v-loading="loading" class="container">
        <!-- Title and Top Buttons Start -->
        <div class="page-title-container mb-0">
            <div class="row">
                <div class="col-3" v-if="show != 'tables'">
                    <h1 class="mb-1 pb-0 display-4 user_online">
                        <div class="btn-group">
                            <el-tooltip
                                content="Seleccione Mesa a atender"
                                placement="bottom"
                            >
                                <el-button
                                    v-if="show != 'tables'"
                                    @click="returnToTablesView"
                                    class="btn_guardarsmall"
                                >
                                    <i
                                        class="icofont icofont-dining-table"
                                        style="color: #fff; font-size: 24px;"
                                    ></i>
                                </el-button>
                            </el-tooltip>

                            <el-button
                                class="btn_guardarsmall"
                                v-if="
                                    configuration.chifa_china &&
                                        show == 'create' &&
                                        currentTable
                                "
                                icon="el-icon-plus"
                                type="primary"
                                @click="open"
                            >
                            </el-button>
                            <el-button
                                v-if="currentTable != null"
                                class="btn_guardarsmall"
                                type="primary"
                            >
                                Mesa N° {{ currentTable.number }}
                            </el-button>
                        </div>
                    </h1>
                </div>
                <div class="col-4" v-if="show == 'create' && screenWidth > 878">
                    <template v-if="configuration.category_deslay">
                        <div class="categories-scroll">
                            <div class="categories-wrapper">
                                <div
                                    v-for="item in categories"
                                    :key="item.id"
                                    class="category-card"
                                    :class="{ active: category === item.id }"
                                    @click="select_category(item.id)"
                                >
                                    <div class="category-circle">
                                        <img
                                            v-if="item.icono"
                                            :src="
                                                `/storage/uploads/category/${item.icono}`
                                            "
                                            alt=""
                                            style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%; display: block; overflow: hidden;"
                                        />
                                        <img
                                            v-else
                                            src="/logo/imagen-no-disponible.jpg"
                                            alt="Imagen no disponible"
                                            style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%; display: block; overflow: hidden;"
                                        />

                                        <!-- <i class="fas fa-utensils"></i> -->
                                    </div>
                                    <span class="category-name">{{
                                        item.name
                                    }}</span>
                                </div>
                            </div>
                        </div>
                    </template>
                    <template v-else>
                        <div
                            class="col-12 "
                            v-if="show == 'create' && screenWidth > 678"
                        >
                            <template>
                                <!-- <span slot="label">
                                    <i class="fas fa-list"></i> Categoría
                                </span> -->
                                <el-select
                                    v-model="category"
                                    filterable
                                    placeholder="Selecionar aqui...."
                                    @change="select_category(category)"
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
                    </template>
                </div>
                <div class="col-5" v-if="show == 'create' && screenWidth > 678">
                    <div class="d-flex align-items-center">
                        <el-input
                            class="flex-grow-1 me-2"
                            v-model="item"
                            @focus="clearinput()"
                            @input="searchOrden()"
                            ref="item"
                            placeholder="Buscar Producto"
                        >
                            <i
                                slot="prefix"
                                class="el-input__icon el-icon-search"
                            ></i>
                        </el-input>
                    </div>
                </div>
            </div>
            <!-- <div class="d-flex justify-content-center p-2" v-if="show == 'tables' && configuration.cambiar_mesa_mozo">
                <button type="button" class="btn me-2" :class="`btn ${isDisabling ? 'btn-danger' : 'btn-warning'}`"
                    @click="disablingTable">
                    {{ isDisabling ? "Cancelar" : "Deshabilitar" }}
                </button>

                <button type="button" class="mx-2" :class="`btn ${changingOrden ? 'btn-warning' : 'btn-primary'}`
                    " @click="changeOrden">
                    {{
                        changingOrden
                            ? hasSelectedOrdenToChange
                                ? "Seleccione a la mesa destino"
                                : "Seleccionar mesa"
                            : "Cambiar orden"
                    }}
                </button>
            </div> -->
        </div>

        <el-tabs
            v-model="activeTab"
            class=""
            @tab-click="handleTabClick"
            v-if="show == 'tables'"
            type="card"
        >
            <el-tab-pane label="Mesas" v-if="show == 'tables'" name="tables">
                <div class="row p-1" v-show="show == 'tables'">
                    <!-- <div class="col-12 mb-3">
                        <div class="zones-scroll">
                            <div class="zones-wrapper">
                                <button v-for="(zone, idx) in zones" :key="idx" type="button" class="zone-btn" :class="[
                                    'btn',
                                    zone_id == zone.id
                                        ? 'btn-primary text-Success'
                                        : 'btn-primary'
                                ]" @click="filterZones(zone.id)">
                                    {{ zone.name }}
                                </button>
                            </div>
                        </div>
                    </div> -->
                    <div
                        class="d-flex justify-content-center p-0 mb-1"
                        v-if="
                            show == 'tables' && configuration.cambiar_mesa_mozo
                        "
                    >
                        <el-tooltip
                            content="Deshabilitar mesa para unirlas"
                            placement="top"
                        >
                            <button
                                type="button"
                                style="margin-right:15px;"
                                :class="
                                    ` ${
                                        isDisabling
                                            ? 'btn_cancelarsmall'
                                            : 'btn_dehabilitarsmall'
                                    }`
                                "
                                @click="disablingTable"
                            >
                                {{ isDisabling ? "Cancelar" : "Deshabilitar" }}
                            </button>
                        </el-tooltip>

                        <!-- <button type="button" class="btn me-2" :class="`btn ${isDisabling ? 'btn-danger' : 'btn-warning'}`"
                            @click="disablingTable">
                            {{ isDisabling ? "Cancelar" : "Deshabilitar" }}
                        </button> -->
                        <button
                            type="button"
                            :class="
                                `btn ${
                                    changingOrden
                                        ? 'btn_limpiezasmall'
                                        : 'btn_guardarsmall'
                                }`
                            "
                            @click="changeOrden"
                        >
                            {{
                                changingOrden
                                    ? hasSelectedOrdenToChange
                                        ? "Seleccione a la mesa destino"
                                        : "Seleccionar Mesa"
                                    : "Cambiar Mesa"
                            }}
                        </button>

                        <!-- <button type="button" class="mx-2" :class="`btn ${changingOrden ? 'btn-warning' : 'btn-primary'}`
                            " @click="changeOrden">
                            {{
                                changingOrden
                                    ? hasSelectedOrdenToChange
                                        ? "Seleccione a la mesa destino"
                                        : "Seleccionar mesa"
                                    : "Cambiar orden"
                            }}
                        </button> -->
                    </div>
                    <!-- Zona Responsiva -->
                    <div class="zones-container" style="background: #616161;">
                        <div
                            class="d-flex align-items-center justify-content-between flex-wrap"
                            style="gap:12px;"
                        >
                            <div
                                class="zones-title mb-0"
                                style="text-align:left;margin-bottom:0;"
                            >
                                ZONAS:
                            </div>
                            <div class="zones-buttons-wrapper flex-grow-1">
                                <div
                                    class="zones-buttons-scroll"
                                    style="justify-content:flex-start;"
                                >
                                    <button
                                        v-for="(zone, idx) in zones"
                                        :key="idx"
                                        type="button"
                                        class="zone-button"
                                        :class="
                                            `btn ${
                                                zone_id == zone.id
                                                    ? 'btn_whatsappsmall'
                                                    : 'btn_guardarsmall'
                                            }`
                                        "
                                        @click="filterZones(zone.id)"
                                    >
                                        {{ zone.name }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="d-flex flex-wrap justify-content-center"
                        v-if="tables.length > 0"
                    >
                        <!-- Mesas encontradas tablas -->
                        <div
                            v-for="(data, index) in tables"
                            :key="index"
                            @click="selectedTable(data.id, data)"
                            :style="{
                                width:
                                    screenWidth < 576
                                        ? 'calc(100% - 16px)'
                                        : screenWidth < 768
                                        ? 'calc(50% - 16px)'
                                        : screenWidth < 992
                                        ? 'calc(33.33% - 20px)'
                                        : screenWidth < 1200
                                        ? '220px'
                                        : '270px',
                                maxWidth:
                                    screenWidth < 576
                                        ? '400px'
                                        : screenWidth < 768
                                        ? '350px'
                                        : '270px',
                                borderRadius: '8px',
                                overflow: 'hidden',
                                cursor: 'pointer',
                                boxShadow: '0 6px 14px rgba(0,0,0,0.08)',
                                margin: '8px',
                                background: '#fff'
                            }"
                        >
                            <!-- Header (zona + número circular) -->
                            <div
                                :style="{
                                    display: 'flex',
                                    justifyContent: 'space-between',
                                    alignItems: 'center',
                                    padding: '12px',
                                    color: '#fff',
                                    background:
                                        data.enabled == false
                                            ? '#6b7280'
                                            : data.status_table.id == 1
                                            ? '#073f68'
                                            : data.status_table.id == 2
                                            ? '#c53030'
                                            : '#d97706'
                                }"
                            >
                                <div style="display:flex;align-items:center;">
                                    <i
                                        class="icofont-dining-table"
                                        style="font-size:35px;margin-right:10px;opacity:0.95"
                                    ></i>
                                    <div style="line-height:1;">
                                        <div
                                            class="mb-1"
                                            style="font-size:11px;opacity:0.9"
                                        >
                                            ZONA:
                                        </div>
                                        <div
                                            style="font-weight:600;font-size:14px"
                                        >
                                            {{
                                                (data.zone && data.zone.name) ||
                                                    data.zone_name ||
                                                    "Sin zona"
                                            }}
                                        </div>
                                    </div>
                                </div>

                                <div
                                    style="background:rgba(255,255,255,0.95);color:#0b2433;border-radius:50%;width:60px;height:40px;display:flex;align-items:center;justify-content:center;font-weight:900"
                                >
                                    <span
                                        style="display:flex;align-items:center;justify-content:center;width:100%;height:100%;font-size:17px;font-weight:800;font-family:'Poppins','Helvetica Neue',Arial,sans-serif;line-height:1;"
                                    >
                                        {{
                                            (data.number || "")
                                                .toString()
                                                .slice(0, 4)
                                        }}
                                    </span>
                                </div>
                            </div>

                            <!-- Banda de estado (LIBRE / OCUPADO / OTRO) -->
                            <div
                                :style="{
                                    padding: '8px',
                                    textAlign: 'center',
                                    fontWeight: 800,
                                    letterSpacing: '1px',
                                    background:
                                        data.status_table.id == 1
                                            ? '#d4e4f1'
                                            : data.status_table.id == 2
                                            ? '#f8d7da'
                                            : '#fff4e6',
                                    color:
                                        data.status_table.id == 1
                                            ? '#073f68'
                                            : data.status_table.id == 2
                                            ? '#7b1113'
                                            : '#7a4a00'
                                }"
                            >
                                {{
                                    data.status_table.id == 1
                                        ? "LIBRE"
                                        : data.status_table.id == 2
                                        ? "OCUPADO"
                                        : data.status_table.description.toUpperCase()
                                }}
                            </div>

                            <!-- Footer: usuario / monto / icono -->
                            <div
                                style="display:flex;justify-content:space-between;align-items:center;padding:12px;background:rgba(0,0,0,0.03)"
                            >
                                <div style="min-width: 0;">
                                    <div
                                        style="font-weight:700;white-space:nowrap;overflow:hidden;text-overflow:ellipsis"
                                    >
                                        <div style="white-space:normal;">
                                            <div
                                                style="display:flex;align-items:center;gap:8px;"
                                            >
                                                <div
                                                    :style="{
                                                        width: '40px',
                                                        height: '40px',
                                                        borderRadius: '50%',
                                                        background:
                                                            data.status_table
                                                                .id == 1
                                                                ? '#073f68'
                                                                : '#c53030',
                                                        display: 'flex',
                                                        alignItems: 'center',
                                                        justifyContent:
                                                            'center',
                                                        flex: '0 0 auto',
                                                        boxShadow:
                                                            '0 0 0 1px rgba(0,0,0,.08)'
                                                    }"
                                                >
                                                    <img
                                                        src="/images/imgrestaurant/Mozo.svg"
                                                        alt="Mozo"
                                                        style="width:24px;height:24px;display:block;filter:brightness(0) invert(1);"
                                                    />
                                                </div>
                                                <div
                                                    v-if="
                                                        getUserForTable(data.id)
                                                    "
                                                    style="display:flex;flex-direction:column;align-items:flex-start;gap:4px;overflow:hidden;"
                                                >
                                                    Atendido por:
                                                    <template
                                                        v-if="
                                                            (
                                                                getUserForTable(
                                                                    data.id
                                                                ).usuario || ''
                                                            ).includes(' - ')
                                                        "
                                                    >
                                                        <span
                                                            style="font-weight:700;white-space:normal;overflow:hidden;text-overflow:ellipsis;display:block;"
                                                        >
                                                            {{
                                                                getUserForTable(
                                                                    data.id
                                                                ).usuario
                                                            }}
                                                        </span>
                                                    </template>
                                                    <template v-else>
                                                        <span>{{
                                                            (
                                                                getUserForTable(
                                                                    data.id
                                                                ).usuario || ""
                                                            ).substring(0, 25)
                                                        }}</span>
                                                    </template>
                                                </div>
                                                <div
                                                    v-else
                                                    style="color:rgba(0,0,0,0.45);font-size:14px;"
                                                >
                                                    {{
                                                        data.status_table.id ==
                                                        1
                                                            ? "Disponible"
                                                            : "Mesa ocupada"
                                                    }}
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            v-if="getUserForTable(data.id)"
                                            style="font-size:12px;color:#6b7280;margin-top:4px;"
                                        >
                                            {{
                                                getUserForTable(data.id).ref ||
                                                    ""
                                            }}
                                        </div>
                                    </div>
                                </div>

                                <div style="text-align:right;min-width:80px;">
                                    <div
                                        v-if="
                                            getUserForTable(data.id) &&
                                                getUserForTable(data.id).monto
                                        "
                                        style="font-weight:700"
                                    >
                                        S/.
                                        {{
                                            parseFloat(
                                                getUserForTable(data.id).monto
                                            ).toFixed(2)
                                        }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </el-tab-pane>
            <el-tab-pane
                label="Delivery"
                name="delivery"
                v-if="show == 'tables' && configuration.restaurant_delivery"
                @click="getTablesDelivery"
            >
                <div>
                    <el-button
                        type="primary"
                        class="btn_guardarsmall"
                        @click="createDelivery"
                    >
                        Nuevo Delivery
                    </el-button>
                </div>
                <div
                    v-if="deliveryOrders.length > 0"
                    class="d-flex flex-wrap gap-2"
                >
                    <div
                        v-for="orden in deliveryOrders"
                        :key="orden.id"
                        class="delivery-card-red d-flex flex-column justify-content-between align-items-start"
                        @click="selectOrden(orden.id)"
                        style="cursor: pointer;"
                    >
                        <h2 class="card-title text-white text-center fw-bold">
                            #{{ orden.correlative }}
                        </h2>
                        <p
                            class="card-text text-white mb-1"
                            style="font-size: 0.95rem;"
                        >
                            <!-- <strong>Cliente:</strong>
                            {{ orden.customer ? orden.customer.name : "N/A"
                            }}<br /> -->
                            <strong></strong>
                            {{ orden.ref ? orden.ref : "N/A" }}
                            <br />
                        </p>
                    </div>
                </div>
                <div class="mt-3" v-else>
                    No Existen órdenes de Delivery.
                </div>
            </el-tab-pane>
        </el-tabs>

        <!-- v-show="show == 'ordens'" -->
        <!-- <ListOrden :configuration="configuration" v-if="selectOption == '2'">
    </ListOrden>-->
        <template v-if="currentTable && show == 'create'">
            <!-- Ocultar Ordenes Realizadas si la mesa es de delivery -->
            <detail-orden
                @changeOrdenEvent="changeOrdenEvent"
                :changingOrden.sync="changingOrden"
                ref="detailRef"
                :configuration="configuration"
                :table.sync="currentTable"
                :categories="categories"
                :showMenu.sync="showMenu"
                :tables_row_select.sync="tables_row_select"
                :foods.sync="foods"
                :pagination="pagination"
                @addenfoque="focus"
                @add="tablesrowselect"
                @changePage="changePage"
                @searchOrden="searchitem_modal"
                :category.sync="category"
                :cash_id.sync="cashId"
                :ordenSelectedId.sync="selectedOrdenId"
                :disableEnviarOrdenes.sync="disableEnviarOrdenes"
            ></detail-orden>
        </template>
        <Pos-form
            :showDialog.sync="showDialog"
            :recordId.sync="recordId"
            :external="true"
            @addDataMozo="recibirProducto"
        ></Pos-form>
    </div>
</template>

<style scoped>
.custom-tab-margin {
    padding-left: 0rem !important;
    padding-right: 0rem !important;
}

/* Ajustar el ancho de los tabs al contenido */
::v-deep .el-tabs--card > .el-tabs__header .el-tabs__nav {
    width: auto !important;
    display: inline-flex !important;
}

::v-deep .el-tabs--card > .el-tabs__header .el-tabs__item {
    padding: 0 20px !important;
    width: auto !important;
    min-width: auto !important;
    flex: 0 0 auto !important;
}

::v-deep .el-tabs__nav-wrap {
    width: auto !important;
}

::v-deep .el-tabs__nav-scroll {
    width: auto !important;
}

.delivery-card-red {
    width: 200px;
    height: 200px;
    background: #e53935;
    border-radius: 12px;
    padding: 16px;
    margin-bottom: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    transition: box-shadow 0.2s;
    overflow: hidden;
}

.delivery-card-red:hover {
    box-shadow: 0 4px 16px rgba(229, 57, 53, 0.18);
}

@media (max-width: 600px) {
    .delivery-card-red {
        width: 48%;
        min-width: 140px;
        margin-bottom: 10px;
    }
}

.ttitle {
    font-size: 20px;
    font-weight: bold;
}

.el-tag--small {
    height: 50px;
    padding: 0 12px;
    line-height: 50px;
}

.font-bold {
    font-weight: bold !important;
    color: #1b4c43;
}

.font-normal {
    font-weight: normal;
}

.mr1 {
    margin-right: 5px !important;
}

.hooper-next,
.hooper-prev {
    padding: 0.2em;
}

.categories-scroll {
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: thin;
    padding: 10px 0;
}

.categories-wrapper {
    display: flex;
    gap: 15px;
    padding: 0 10px;
}

.category-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    min-width: 100px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.category-circle {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    background: #f0f0f0;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 8px;
    transition: all 0.3s ease;
}

.category-circle i {
    font-size: 24px;
    color: #666;
}

.category-name {
    font-size: 12px;
    text-align: center;
    max-width: 90px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.category-card.active .category-circle {
    background: #409eff;
}

.category-card.active .category-circle i {
    color: white;
}

.category-card:hover .category-circle {
    transform: scale(1.05);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

/* Custom scrollbar */
.categories-scroll::-webkit-scrollbar {
    height: 4px;
}

.categories-scroll::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

.categories-scroll::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 4px;
}

.categories-scroll::-webkit-scrollbar-thumb:hover {
    background: #555;
}

/* stilos de zona */
.zones-scroll {
    width: 100%;
    overflow-x: auto;
    padding: 15px 0;
    -webkit-overflow-scrolling: touch;
}

.zones-wrapper {
    display: flex;
    gap: 12px;
    padding: 0 15px;
    min-width: min-content;
}

.zone-btn {
    min-width: 120px;
    padding: 12px 20px;
    font-size: 1rem;
    border-radius: 25px;
    white-space: nowrap;
    transition: all 0.3s ease;
}

.zone-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Custom scrollbar styling */
.zones-scroll::-webkit-scrollbar {
    height: 6px;
}

.zones-scroll::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

.zones-scroll::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 3px;
}

.zones-scroll::-webkit-scrollbar-thumb:hover {
    background: #555;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .zone-btn {
        min-width: 100px;
        padding: 10px 16px;
        font-size: 0.9rem;
    }

    .zones-wrapper {
        gap: 8px;
    }
}

/* Estilos para el nuevo contenedor de zonas responsivo */
.zones-container {
    padding: 12px;
}

.zones-title {
    font-size: 20px;
    color: #ffffff;
    font-weight: 700;
    font-family: "Poppins", "Helvetica Neue", Arial, sans-serif;
    letter-spacing: 1px;
    text-align: center;
    margin-bottom: 12px;
}

.zones-buttons-wrapper {
    display: flex;
    justify-content: center;
}

.zones-buttons-scroll {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
    justify-content: center;
}

.zone-button {
    white-space: nowrap;
}

/* Tablet y móvil */
@media (max-width: 768px) {
    .zones-container {
        padding: 10px;
    }

    .zones-title {
        font-size: 18px;
        margin-bottom: 15px;
    }

    .zones-buttons-wrapper {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: thin;
        scrollbar-color: rgba(255, 255, 255, 0.5) rgba(255, 255, 255, 0.1);
    }

    .zones-buttons-scroll {
        display: flex;
        flex-wrap: nowrap;
        gap: 10px;
        padding: 5px 10px;
        width: max-content;
        min-width: 100%;
    }

    .zone-button {
        flex-shrink: 0;
        min-width: 100px;
    }

    /* Scrollbar personalizado para webkit */
    .zones-buttons-wrapper::-webkit-scrollbar {
        height: 6px;
    }

    .zones-buttons-wrapper::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 3px;
    }

    .zones-buttons-wrapper::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.5);
        border-radius: 3px;
    }

    .zones-buttons-wrapper::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.7);
    }
}

/* Móvil pequeño */
@media (max-width: 480px) {
    .zones-title {
        font-size: 16px;
        margin-bottom: 12px;
    }

    .zone-button {
        min-width: 90px;
        font-size: 0.85rem;
    }
}
</style>

<script>
import { Hooper, Slide, Navigation as HooperNavigation } from "hooper";
import "hooper/dist/hooper.css";
import DetailOrden from "./detail_orden.vue";
import ViewTables from "./tables.vue";
import MenuTable from "./menu.vue";
import ListOrden from "./listar_ordens.vue";
import queryString from "query-string";
import swal from "sweetalert2";
import PosForm from "../../../../../../../resources/js/views/items/form_pos.vue";
export default {
    components: {
        ViewTables,
        MenuTable,
        DetailOrden,
        ListOrden,
        Hooper,
        Slide,
        HooperNavigation,
        swal,
        PosForm
    },
    props: [
        "configuration",
        "user",
        "status_table",
        "areas",
        "tables_area",
        "tables_active",
        "categories",
        "cash_id"
    ],
    data() {
        return {
            disableEnviarOrdenes: false,
            selectedOrdenId: null,
            activeTab: "tables",
            zone_id: null,
            showDialog: false,
            recordId: null,
            audio: HTMLAudioElement,
            tableUsers: [],
            ordenToChange: null,
            hasSelectedTableToChange: false,
            hasSelectedOrdenToChange: false,
            changingOrden: false,
            hasTableOcuped: false,
            isDisabling: false,
            screenWidth: 0,
            allFoods: [],
            zones: [],
            listFoods: [],
            pagination: {},
            foods: [],
            show: "tables",
            selectArea: 0,
            selectOption: 1,
            selectedTables: 0,
            item: null,
            input_item: "",
            resource: "dashboard",
            csrf: document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
            optionsSelected: this.configuration.search_type,
            showMenu: false,
            currentTable: null,
            loading: false,
            category: 0,
            tables: [],
            all_tables: [], // Add this line to store all tables
            printerDefault: null,
            currentArea: null,
            allAreas: [],
            ordens: [],
            tables_row_select: null,
            deliveryOrders: [],
            deliveryTable: null, // Agregado para la mesa de delivery
            hooperSettings: {
                centerMode: false,
                trimWhiteSpace: true,
                playSpeed: 3500,
                itemsToShow: 6,
                breakpoints: {
                    2400: {
                        itemsToShow: 4
                    },
                    1800: {
                        itemsToShow: 4
                    },
                    1500: {
                        itemsToShow: 3
                    },
                    1100: {
                        itemsToShow: 2
                    },
                    0: {
                        itemsToShow: 2
                    }
                }
            },
            timer: null
        };
    },

    mounted() {
        this.screenWidth = window.innerWidth;
        window.addEventListener("resize", this.handleResize);

        // Escuchar evento global para habilitar el botón cuando se cree una orden delivery
        this.$eventHub.$on("ordenCreadaYLimpiar", () => {
            this.disableEnviarOrdenes = false;
        });

        Echo.channel("orden_list").listen(
            `.order-list-${this.configuration.socket_channel}`,
            e => {
                let { order_item } = e;
                this.listaOrden(order_item);
                /* console.log("🚀 ~ file: dashboard.vue ~ line 202 ~ Echo.channel ~ order_item edrrrrr", order_item) */
                this.playSound(`pedidos_listo.mp3`);
            }
        );

        Echo.channel("orden_delete").listen(
            `.order-delete-${this.configuration.socket_channel}`,
            e => {
                let { order_item } = e;
                this.deleteOrden(order_item);
            }
        );
        Echo.channel("orden_paid").listen(
            `.order-paid-${this.configuration.socket_channel}`,
            async () => {
                this.$eventHub.$emit("reloadData");
                this.$refs.detailRef.clean();
                await this.userorden();
            }
        );
        Echo.channel("stock_orden").listen(
            `.stock-order-${this.configuration.socket_channel}`,
            e => {
                let ListFoods = this.foods;
                for (let index = 0; index < e.data.order_item.length; index++) {
                    let xFind = _.find(ListFoods, {
                        id: e.data.order_item[index].food_id
                    });
                    let index_find = _.findIndex(ListFoods, {
                        id: xFind.id
                    });
                    if (index_find !== -1) {
                        let nSaldo =
                            parseInt(ListFoods[index_find].item.stock) -
                            e.data.order_item[index].quantity;
                        ListFoods[index_find].item.stock = nSaldo;
                        this.$emit("update:foods", ListFoods);
                    }
                }
            }
        );

        // Agregar listener para actualización de órdenes
        Echo.channel("orden_update").listen(
            `.order-update-${this.configuration.socket_channel}`,
            async () => {
                await this.getTables(true);
                await this.userorden();
            }
        );

        /* this.$notify({
            title: "Sistema de Punto de Venta",
            iconClass: "icofont-waiter icofont-3x",
            message: "Bienvenido " + this.user.name
        }); */
    },

    async created() {
        this.cashId = this.cash_id;
        await this.getFoods();
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
        this.categories.unshift({
            id: 0,
            name: "TODOS LAS CATEGORIAS"
        });
        this.currentArea = this.user.area_id;
        this.allAreas = [
            ...this.areas.map(a => {
                if (this.currentArea == a.id) {
                    a.selected = true;
                } else {
                    a.selected = false;
                }
                return a;
            }),
            {
                id: 0,
                description: "Ver Ordenes",
                selected: false
            }
        ];
        let allAreas_all = _.orderBy(this.allAreas, ["id"], ["asc"]);
        this.allAreas = allAreas_all;
        // this.tables = this.tables_area;
        //this.tables_row_select=this.tables_active
        await this.getTables();
        await this.userorden();
        this.$eventHub.$on("reloadData", () => {
            this.getTables(true);
        });
        this.$notify({
            title: "Sistema de Punto de Venta",
            iconClass: "icofont-waiter icofont-3x",
            message: "Bienvenido " + this.user.name
        });
    },
    beforeDestroy() {
        clearInterval(this.timer);
        // Limpiar listener al destruir componente
        console.log("Destruyendo el componente y limpiando el listener");
        this.$eventHub.$off("cashStatusChanged");
    },
    methods: {
        createDelivery() {
            if (this.deliveryTable) {
                this.currentTable = this.deliveryTable;
                this.selectedOrdenId = null;
                this.show = "create";
                this.disableEnviarOrdenes = true;
            } else if (this.$toast) {
                this.$toast.error("No hay mesa de delivery disponible");
            }
        },

        selectOrden(id, retry = 0) {
            console.log("Seleccionando orden con ID:", id);
            this.selectedOrdenId = id;

            // Busca la mesa que contiene la orden (para mesas normales y delivery)
            let foundTable = null;
            if (this.tables && this.tables.length > 0) {
                foundTable = this.tables.find(
                    t => t.orden && t.orden.some(o => o.id === id)
                );
            }
            if (!foundTable && this.deliveryTable) {
                foundTable = this.deliveryTable;
            }
            if (foundTable) {
                this.currentTable = foundTable;
            }

            this.show = "create";

            this.$nextTick(() => {
                if (
                    this.$refs.detailRef &&
                    typeof this.$refs.detailRef.selectOrden === "function"
                ) {
                    this.$refs.detailRef.selectOrden(id);
                    console.log("Llamando a selectOrden en detailRef");
                } else if (retry < 8) {
                    setTimeout(() => this.selectOrden(id, retry + 1), 100);
                } else {
                    console.warn(
                        "detailRef o selectOrden no está disponible aún"
                    );
                }
            });
        },

        async updateCashId(id) {
            // Cuando se abre la caja
            console.log("Caja abierta con ID:", id);
            this.$eventHub.$emit("cashStatusChanged", {
                status: "open",
                cashId: id
            });
            console.log("Emitiendo evento de cambio de caja:", id);
            this.$emit("update:cash_id", id);
        },
        filterZones(zone_id) {
            if (this.zone_id === zone_id) {
                this.zone_id = null;
                this.tables = this.all_tables;
                return;
            }

            this.zone_id = zone_id;

            // Filter tables by zone_id
            if (this.all_tables && this.all_tables.length > 0) {
                // Check if tables have zone_id property
                const hasZoneId = this.all_tables.some(
                    table => table.zone_id !== undefined
                );
                /* console.log("Tables have zone_id property:", hasZoneId); */

                if (hasZoneId) {
                    this.tables = this.all_tables.filter(table => {
                        return table.zone_id == zone_id;
                    });
                } else {
                    // If tables don't have zone_id property, try to look for a different property
                    /*  console.log("Looking for alternative zone property"); */
                    const sampleTable = this.all_tables[0];
                    /* console.log("Sample table properties:", Object.keys(sampleTable)); */

                    // Try to find any property that could be related to zones
                    this.tables = this.all_tables;
                }

                /*  console.log(`Filtered tables for zone ${zone_id}:`, this.tables.length); */
            } else {
                console.log("No tables available to filter");
                this.tables = [];
            }
        },

        async fetchFood(productId) {
            try {
                const response = await this.$http.get(
                    `${this.resource}/ver/${productId}`
                );
                //console.log("Response data:", response.data);
                this.$root.$emit("productoRecibido", response.data);
            } catch (error) {
                console.error(
                    "Error al obtener el producto del backend:",
                    error
                );
            }
        },

        recibirProducto(data) {
            //console.log("Producto recibido:", data);
            this.fetchFood(data.id);
        },
        open() {
            this.showDialog = true;
        },
        playSound(sound = "services_sound.mp3") {
            let audio = new Audio(`/sounds/${sound}`);
            if (audio) {
                audio.play();
            }
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
        async userorden() {
            try {
                const response = await this.$http.get(`/caja/tables/UserTable`);
                if (response.status === 200 && response.data.success) {
                    this.tableUsers = response.data.data;
                    return response.data.data;
                }
                throw new Error(response.data.error || "Error desconocido");
            } catch (error) {
                this.$toast.error("Error al obtener usuarios de mesas");
                return [];
            }
        },

        getUserForTable(tableId) {
            const tableUser = this.tableUsers.find(
                user => user.table_id === tableId
            );
            return tableUser || null;
        },
        async disabledTable(id) {
            try {
                await this.$confirm(
                    "¿Está seguro de deshabilitar la mesa?",
                    "Advertencia",
                    {
                        confirmButtonText: "Aceptar",
                        cancelButtonText: "Cancelar",
                        icon: "warning"
                    }
                );
                const response = await this.$http.post(
                    `/caja/tables/disabled-table`,
                    {
                        table_id: id
                    }
                );
                console.log(
                    "🚀 ~ file: tables.vue:154 ~ disabledTable ~ response:",
                    response
                );
                swal.fire(
                    "Deshabilitado",
                    "la mesa ha sido deshabilitado Exitosamente",
                    "success"
                );
            } catch (e) {
                console.log(e);
                swal.fire("warning", "deshabilitacion cancelado.", "warning");
            }
        },
        async enabledTable(id) {
            try {
                await this.$confirm(
                    "¿Está seguro de habilitar la mesa?",
                    "Advertencia",
                    {
                        confirmButtonText: "Aceptar",
                        cancelButtonText: "Cancelar",
                        type: "warning"
                    }
                );
                const response = await this.$http.post(
                    `/caja/tables/enabled-table`,
                    {
                        table_id: id
                    }
                );
                console.log(
                    "🚀 ~ file: tables.vue:169 ~ enabledTable ~ response:",
                    response
                );
                swal.fire("Habilitado", "La Mesa a Sido ");
            } catch (e) {
                console.log(e);
            }
        },
        disablingTable() {
            this.isDisabling = !this.isDisabling;
        },
        changeOrdenEvent(id) {
            this.hasSelectedOrdenToChange = true;
            this.currentTable = null; // Reset currentTable when changing table
            this.show = "tables";
            this.ordenToChange = id;
        },
        changeOrden() {
            console.log("object");
            this.changingOrden = !this.changingOrden;
        },
        handleResize() {
            this.screenWidth = window.innerWidth;
        },
        async changePage(currentPage) {
            this.pagination.current_page = currentPage;
            await this.search_items();
        },
        async searchitem_modal(item) {
            if (item == null) {
                item = "";
            }
            let inputitem = item.toLowerCase();
            let form = {
                value: inputitem,
                category: this.category
            };

            await this.getFoods(this.getQueryParameters(form));
        },

        async search_items() {
            if (this.item == null) {
                this.item = "";
            }
            let inputitem = this.item.toLowerCase();
            let form = {
                value: inputitem,
                category: this.category
            };

            await this.getFoods(this.getQueryParameters(form));
        },
        getQueryParameters(form = {}) {
            return queryString.stringify({
                page: this.pagination.current_page,
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
                    this.allFoods = data;
                    this.foods = data;
                    this.pagination = meta;
                    this.selectOption = 4;
                    this.loading = false;
                }
            } catch (e) {
                this.loading = false;
            }
        },
        deleteOrden(id) {
            this.tables = this.tables.map(t => {
                if (t.orden.length > 0) {
                    let ordens = t.orden;
                    for (let i = 0; i < ordens.length; i++) {
                        let orden = ordens[i];
                        if (orden.orden_items.some(ot => ot.id == id)) {
                            t.orden[i].orden_items = t.orden[
                                i
                            ].orden_items.filter(o => o.id != id);
                            break;
                        }
                    }

                    // if (t.orden.orden_items.length == 0) {
                    //   t.status_table.id = 1;
                    //   t.status_table.description = "disponible";
                    // }
                }

                return t;
            });
        },
        async tablesrowselect(value) {
            this.tables_row_select = value;
            this.selectOption = 1;
        },
        clearinput() {
            this.item = null;
        },
        focus() {
            this.$nextTick(() => {
                let input = this.$refs.item;
                input.focus();
                return false;
            });
        },
        createOrden() {
            this.$refs.detailRef.createOrden();
            this.focus();
        },
        select_category(id) {
            this.category = id;
            this.focus();
            this.$refs.detailRef.filterCategory(id);
            this.searchOrden();
        },
        selectSearch(value) {
            this.optionsSelected = value;
            //this.focus();
        },
        async searchOrden() {
            // this.$refs.detailRef.filter_food(
            //     this.item.toLowerCase(),
            //     this.optionsSelected
            // );
            if (this.time) {
                clearTimeout(this.time);
            }
            this.time = setTimeout(() => {
                this.search_items();
            }, 500);
        },
        async printer() {
            // try {
            //         qz.websocket.connect()
            //             .then(qz.printers.getDefault)
            //             .then(function(printer) {
            //                 console.log("defaultPrinter",printer)
            //                 let config = qz.configs.create(printer, {scaleContent : false},{jobName	:"Pedidos"});
            //                  qz.websocket.connect(config);
            //                  let data = [
            //             {
            //                 type: 'pdf',
            //                 format: 'file',
            //                 data: "http://demo.facturadorpro3.oo/caja/worker/print-ticket?id=40"
            //             }
            //         ];
            //         qz.print(config, data).catch((e) => {
            //             this.$toast.error(e.message);
            //         });
            //             })
            //             .catch(function(e) {
            //                 console.error(e);
            //         });
            //         this.$toast.success("se esta imprimiendo el comprobante con exito");
            //     } catch (e) {
            //         this.$toast.error(e.message);
            //     }
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
                    this.ordens = this.ordens.filter(o => o.id != id);
                }
            } catch (e) {
                console.log(e);
                this.$toast.error("Ocurrió un error");
            }
            this.loading = false;
        },
        async ordenCancel(id) {},
        setArea(id) {
            this.currentArea = id;
            this.selectArea = id;
            if (id == 0) {
                this.show = "ordens";
                this.getOrdens();
            } else {
                this.getTables();
                this.show = "create";
            }
            this.allAreas = this.allAreas.map(a => {
                if (a.id == id) {
                    a.selected = true;
                } else {
                    a.selected = false;
                }
                return a;
            });
        },
        calculeTotal(orden = null) {
            if (!orden) return;
            let items = orden.orden_items;
            let prices = items.map(o => Number(o.food.price));
            if (prices.length == 0) return;
            let total = prices.reduce((a, b) => a + b);
            return total;
        },

        async selectedTable(id = null, data = []) {
            let table = this.tables.find(t => t.id == id);
            console.log(table);
            if (this.isDisabling) {
                this.changingOrden = false;
                if (table.enabled) {
                    await this.disabledTable(table.id);
                } else {
                    await this.enabledTable(table.id);
                }
                await this.getTables();
                this.isDisabling = false;
                return;
            }
            if (!table.enabled == true) {
                await this.enabledTable(table.id);
                await this.getTables();
                return;
            }
            if (this.zone_id) {
                // If a zone is already selected, filter by that zone
                this.filterZones(this.zone_id);
            } else {
                // Otherwise show all tables
                this.tables = this.all_tables;
            }

            if (
                this.changingOrden &&
                this.currentTable &&
                this.hasSelectedOrdenToChange
            ) {
                this.sendOrdenToNewTable(this.ordenToChange, id);
                return;
            }
            if (this.changingOrden && table.status_table.id == 1) {
                swal.fire({
                    title: "la mesa no tiene ordenes para trasladar",
                    icon: "warning"
                });
                return;
            }

            this.tables_row_select = id;
            this.selectedTables = id;
            this.currentTable = data;
            this.show = "create";
            // Actualizar usuarios al seleccionar mesa
            await this.userorden();
            if (this.configuration.order_mozo === true) {
                this.handleSelectOrden();
            }

            // this.focus();
            this.allAreas = this.allAreas.map(a => {
                a.selected = false;
                return a;
            });
        },
        handleSelectOrden() {
            if (this.currentTable.orden && this.currentTable.orden.length > 0) {
                this.$nextTick(() => {
                    this.$refs.detailRef.selectOrden(
                        this.currentTable.orden[0].id
                    );
                });
            }
        },

        async sendOrdenToNewTable(orden_id, table_id) {
            try {
                this.loading = true;
                const response = await this.$http.post(`change-orden`, {
                    orden_id,
                    table_id
                });
                if (response.status == 200) {
                    swal.fire({
                        title: "Orden trasladada con exito",
                        icon: "success"
                    });
                    /* this.$toast.success("Orden cambiada con éxito"); */
                    this.changingOrden = false;
                    this.currentTable = null;
                    this.hasSelectedOrdenToChange = false;
                    this.hasSelectedTableToChange = false;
                    // Actualizar mesas y usuarios después de trasladar orden
                    await this.getTables();
                    await this.userorden();
                } else {
                    this.$toast.error("Ocurrió un error, al cambiar la orden");
                }
            } catch (e) {
                console.log(e);
                this.$toast.error("Ocurrió un error, al cambiar la orden");
            } finally {
                this.loading = false;
            }
        },
        async getOrdens() {
            this.loading = true;

            // try {
            //   const response = await this.$http.get("ordens-list");
            //   this.ordens = response.data.data;
            // } catch (e) {
            //   console.log(e);
            // }
            this.show = "ordens";
            this.loading = false;
        },
        async getTables(change = null) {
            this.loading = true;
            try {
                const [tablesResponse, usersResponse] = await Promise.all([
                    this.$http.get(`tables/records-area/${this.currentArea}`),
                    this.userorden()
                ]);

                if (tablesResponse.status == 200) {
                    const { data, zones } = tablesResponse.data;
                    /* console.log("Tables from API:", data);
                    console.log("Zones from API:", zones); */

                    // Check if zone_id exists in tables
                    /* if (data.length > 0) {
                        console.log("Sample table properties:", Object.keys(data[0]));
                        console.log("Sample table zone_id:", data[0].zone_id);
                    } */

                    this.all_tables = data; // Store all tables here
                    this.tables = data;
                    this.zones = zones;

                    // If zone filter is active, apply it
                    if (this.zone_id) {
                        this.tables = this.all_tables.filter(table => {
                            return table.zone_id == this.zone_id;
                        });
                        /* console.log(`Reapplied zone filter for zone ${this.zone_id}, found ${this.tables.length} tables`); */
                    }

                    if (!change) {
                        this.show = "tables";
                    }
                    if (this.currentTable) {
                        let id = this.currentTable.id;
                        this.currentTable = this.tables.find(t => t.id == id);
                    }
                }
            } catch (error) {
                console.error("Error al actualizar mesas y usuarios:", error);
                this.$toast.error("Error al actualizar datos");
            } finally {
                this.loading = false;
            }
        },

        async getTablesDelivery(change = null) {
            this.loading = true;
            try {
                // Solo obtener la mesa delivery, sin modificar this.tables ni this.all_tables
                const tablesResponse = await this.$http.get(
                    `tables/recordsByAreaDelivery/${this.currentArea}`
                );
                if (tablesResponse.status == 200) {
                    const { data } = tablesResponse.data;
                    let deliveryTable = null;
                    if (data && data.length > 0) {
                        deliveryTable = data[0];
                        this.deliveryTable = deliveryTable; // Guardar la mesa delivery
                    } else {
                        this.deliveryTable = null;
                    }
                    // Ahora obtener las órdenes usando el método correcto
                    await this.getDeliveryOrders();
                }
            } catch (error) {
                console.error("Error al actualizar mesas y usuarios:", error);
                this.$toast.error("Error al actualizar datos");
            } finally {
                this.loading = false;
            }
        },
        async getDeliveryOrders() {
            if (!this.deliveryTable) {
                this.deliveryOrders = [];
                return;
            }
            this.loading = true;
            try {
                const deliveryResp = await this.$http(
                    `/caja/tables/orden/${this.deliveryTable.id}`
                );
                if (deliveryResp.status == 200) {
                    this.deliveryOrders = deliveryResp.data.ordens;
                } else {
                    this.deliveryOrders = [];
                }
            } catch (e) {
                this.deliveryOrders = [];
            } finally {
                this.loading = false;
            }
        },
        returnToTablesView() {
            this.selectOption = 1;
            this.tables_row_select = null;
            this.currentTable = null;
            this.show = "tables";
        },
        handleTabClick(tab) {
            if (tab.name === "delivery") {
                this.getTablesDelivery();
            }
        }
    }
};
</script>
