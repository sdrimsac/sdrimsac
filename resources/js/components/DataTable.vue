<!-- Datatable de Listado de Compras -->
<template>
    <div>
        <!-- Filtros y buscador siempre visibles -->
        <div class="row mb-0">
            <div class="col-md-12">
                
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-12 pb-2" v-if="
                            resource == 'caja/cash-transfer/report'
                        ">
                            <label for="value" class="d-flex align-items-center mb-1">
                                <span class="mr-2"><i class="el-icon-bank-card"></i></span>
                                <span>Caja principal</span>
                            </label>
                            <el-select v-model="search.cash_id" @change="getRecords" placeholder="Seleccione la caja">
                                <el-option v-for="item in cashes" :key="item.id" :label="`${item.user_name}-${item.description}`
                                    " :value="item.id">
                                </el-option>
                            </el-select>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 pb-2">
                            <label class="d-flex align-items-center mb-1" style="width:100%">
                                <span class="mr-2"><i class="el-icon-filter"></i></span>
                                <span>Filtrar por:</span>
                            </label>
                            <el-select v-model="search.column" placeholder="Select" @change="changeClearInput">
                                <el-option v-for="(label, key) in columns" :key="key" :value="key" :label="label">
                                </el-option>
                            </el-select>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 pb-2">
                            <label for="value" class="d-flex align-items-center mb-1">
                                <span class="mr-2"><i class="el-icon-search"></i></span>
                                <span>Buscar</span>
                            </label>
                            <template v-if="
                                search.column == 'date_of_issue' ||
                                search.column ==
                                'date_of_due' ||
                                search.column ==
                                'date_of_payment' ||
                                search.column ==
                                'delivery_date' ||
                                search.column == 'date'
                            ">
                                <template v-if="
                                    resource !=
                                    'caja/worker/expenses'
                                ">
                                    <el-date-picker v-model="search.value" type="date" style="width: 100%;"
                                        placeholder="Buscar" value-format="yyyy-MM-dd" @change="getRecords">
                                    </el-date-picker>
                                </template>
                                <template v-else>
                                    <el-date-picker v-model="search.value" type="daterange" range-separator="A"
                                        start-placeholder="Desde" value-format="yyyy-MM-dd" end-placeholder="Hasta"
                                        @change="getRecords">
                                    </el-date-picker>
                                </template>
                            </template>
                            <template v-else-if="
                                search.column == 'district_id'
                            ">
                                <el-select v-model="search.value" @change="getRecords"
                                    placeholder="Seleccione el Distrito">
                                    <el-option v-for="item in array_district" :key="item.id" :label="item.description"
                                        :value="item.id">
                                    </el-option>
                                </el-select>
                            </template>
                            <template v-else-if="search.column == 'seller_id'">
                                <el-select v-model="search.value" @change="getRecords"
                                    placeholder="Seleccione el vendedor">
                                    <el-option v-for="(item, idx) in sellers" :key="idx" :label="item.name"
                                        :value="item.id">
                                    </el-option>
                                </el-select>
                            </template>
                            <template v-else-if="
                                search.column == 'active' &&
                                resource == 'caja/workers-type'
                            ">
                                <el-select v-model="search.value" @change="getRecords"
                                    placeholder="Seleccione el estado">
                                    <el-option v-for="(item, idx) in [
                                        {
                                            id: 1,
                                            description: 'Activado'
                                        },
                                        {
                                            id: 0,
                                            description:
                                                'Desactivado'
                                        }
                                    ]" :key="idx" :label="item.description" :value="item.id">
                                    </el-option>
                                </el-select>
                            </template>
                            <template v-else>
                                <el-input placeholder="Buscar" v-model="search.value" style="width: 100%;"
                                    prefix-icon="el-icon-search" @input="getRecords">
                                </el-input>
                            </template>
                        </div>
                        <div v-if="
                            search.column == 'date_of_issue' ||
                            search.column == 'date_of_due' ||
                            search.column ==
                            'date_of_payment' ||
                            search.column == 'delivery_date' ||
                            (search.column == 'date' &&
                                resource == 'purchases' &&
                                search.value)
                        " class="col-lg-3 col-md-3 col-sm-12 pb-2">
                            <label for="value" class="d-flex align-items-center mb-1">
                                <span class="mr-2"><i class="el-icon-date"></i></span>
                                <span>Hasta</span>
                            </label>
                            <el-date-picker v-model="search.end_date" type="date" style="width: 100%;"
                                placeholder="Buscar" value-format="yyyy-MM-dd" @change="getRecords">
                            </el-date-picker>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 pb-2" v-if="
                            resource == 'items' ||
                            resource == 'item-color-size'
                        ">
                            <label for="warehouse" class="d-flex align-items-center mb-1">
                                <span class="mr-2"><i class="el-icon-office-building"></i></span>
                                <span>Almacén</span>
                            </label>
                            <el-select clearable v-model="search.warehouse_id" @change="getRecords"
                                placeholder="Seleccione el Almacén">
                                <el-option v-for="item in warehouses" :key="item.id" :label="item.description"
                                    :value="item.id">
                                </el-option>
                            </el-select>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 pb-2" v-if="resource == 'items' && configuration.restaurant">
                            <label for="warehouse" class="d-flex align-items-center mb-1">
                                <span class="mr-2"><i class="el-icon-location-outline"></i></span>
                                <span>Área/Zona</span>
                            </label>
                            <el-select clearable filterable v-model="search.area_id" @change="getRecords"
                                placeholder="Seleccione el Almacén">
                                <el-option v-for="item in areas" :key="item.id" :label="item.description"
                                    :value="item.id">
                                </el-option>
                            </el-select>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 pb-2" v-if="resource == 'summaries'"> 
                            <label for="warehouse" class="d-flex align-items-center mb-1">
                                <span class="mr-2"><i class="el-icon-location-outline"></i></span>
                                <span>Filtro por Identificador</span>
                            </label>
                            <el-input v-model="search.identifier" placeholder="" @input="getRecords"></el-input>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 pb-2" v-if="resource == 'items'">
                            <label class="d-flex align-items-center mb-1">
                                <span class="mr-2"><i class="el-icon-s-check"></i></span>
                                <span>Estados</span>
                            </label>
                            <el-select v-model="search.active" @change="getRecords" clearable
                                placeholder="Seleccione el estado">
                                <el-option v-for="(item, idx) in [
                                    { id: 1, active: 'Habilitado' },
                                    {
                                        id: 0,
                                        active: 'Inhabilitado'
                                    }
                                ]" :key="idx" :label="item.active" :value="item.active">
                                </el-option>
                            </el-select>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-12 pb-2" v-if="resource == 'item-color-size'">
                            <label class="d-flex align-items-center mb-1">
                                <span class="mr-2"><i class="el-icon-s-flag"></i></span>
                                <span>Estados</span>
                            </label>
                            <el-select v-model="search.status" @change="getRecords" clearable
                                placeholder="Seleccione el estado">
                                <el-option v-for="(item, idx) in [
                                    { id: 1, active: 'Disponible' },
                                    { id: 0, active: 'Agotado' }
                                ]" :key="idx" :label="item.active" :value="item.active">
                                </el-option>
                            </el-select>
                        </div>
                    </div>
                    <div class="col-md-12 d-flex justify-content-end" v-if="resource !== 'caja/cash-transfer'">
                        <el-tooltip content="Exportar en PDF" placement="top" v-if="resource == 'caja/worker/expenses'">
                            <el-button class="btn_pdfsmall" type="" icon="icofont-file-pdf"
                                @click.prevent="clickDownload('pdf')">Exportar
                                PDF
                            </el-button>
                        </el-tooltip>
                        <el-tooltip v-if="resource !== 'restaurant'" :content="resource === 'items'
                                ? 'Exportar productos al formato excel'
                                : 'Exportar Excel'
                            " placement="top">
                            <el-button class="btn_excelsmall" type="" v-if="
                                resource !== 'item-color-size' &&
                                resource !==
                                'caja/worker/expenses' && resource !== 'caja/tables'
                            " icon="icofont-file-excel" @click.prevent="clickDownload('excel')">
                                Exportar
                            </el-button>
                        </el-tooltip>
                        <el-tooltip content="Exportar tallas y colores" placement="top">
                            <el-button class="btn_excelsmall" type="" v-if="resource == 'item-color-size'"
                                icon="icofont-file-excel" @click.prevent="
                                    clickDownloadColor('excel')
                                    ">Exportar TyC
                            </el-button>
                        </el-tooltip>
                        <el-tooltip content="Exportar formato excel para migración de productos" placement="top">
                            <el-button class="btn_excelsmall" type="" v-if="
                                search.warehouse_id &&
                                typeUser == 'superadmin'
                            " icon="icofont-file-excel" @click.prevent="
                                    clickDownloadForImport('excel')
                                    ">Exportar 2</el-button>
                        </el-tooltip>
                        <el-tooltip content="Agregar todos los productos a los almacenes faltantes" placement="top">
                            <el-button class="btn_politicasmall" type="" v-if="typeUser == 'superadmin'"
                                icon="el-icon-tickets" @click.prevent="
                                    clickAddProductsToWarehouses
                                ">Item/Almacenes
                            </el-button>
                        </el-tooltip>

                        <el-tooltip content="Agregar todas las políticas de precio de productos en todo los almacenes"
                            placement="top">
                            <el-button class="btn_politicasmall" type="" v-if="typeUser == 'superadmin'"
                                icon="el-icon-tickets" @click.prevent="
                                    clickAddProductsToPolitica
                                ">PPP/Almacenes
                            </el-button>
                        </el-tooltip>
                    </div>
               
            </div>
        </div>
        <!-- Tabla y resultados -->
        <!-- <div class="row " v-loading="loading">
            <div v-if="resource == 'caja/worker/expenses' || ('purchases' && records.length != 0)" class="row mb-3">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="card p-3">
                            <div class="row">
                                <div
                                    class="col-lg-3 col-md-3 col-sm-12 pb-2"
                                    v-if="
                                        resource == 'caja/cash-transfer/report'
                                    "
                                >
                                    <label
                                        for="value"
                                        class="d-flex align-items-center mb-1"
                                    >
                                        <span class="mr-2"
                                            ><i class="el-icon-bank-card"></i
                                        ></span>
                                        <span>Caja principal</span>
                                    </label>
                                    <el-select
                                        v-model="search.cash_id"
                                        @change="getRecords"
                                        placeholder="Seleccione la caja"
                                    >
                                        <el-option
                                            v-for="item in cashes"
                                            :key="item.id"
                                            :label="
                                                `${item.user_name}-${item.description}`
                                            "
                                            :value="item.id"
                                        >
                                        </el-option>
                                    </el-select>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-12 pb-2">
                                    <label
                                        class="d-flex align-items-center mb-1"
                                        style="width:100%"
                                    >
                                        <span class="mr-2"
                                            ><i class="el-icon-filter"></i
                                        ></span>
                                        <span>Filtrar por:</span>
                                    </label>
                                    <el-select
                                        v-model="search.column"
                                        placeholder="Select"
                                        @change="changeClearInput"
                                    >
                                        <el-option
                                            v-for="(label, key) in columns"
                                            :key="key"
                                            :value="key"
                                            :label="label"
                                        >
                                        </el-option>
                                    </el-select>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-12 pb-2">
                                    <label
                                        for="value"
                                        class="d-flex align-items-center mb-1"
                                    >
                                        <span class="mr-2"
                                            ><i class="el-icon-search"></i
                                        ></span>
                                        <span>Buscar</span>
                                    </label>
                                    <template
                                        v-if="
                                            search.column == 'date_of_issue' ||
                                                search.column ==
                                                    'date_of_due' ||
                                                search.column ==
                                                    'date_of_payment' ||
                                                search.column ==
                                                    'delivery_date' ||
                                                search.column == 'date'
                                        "
                                    >
                                        <template
                                            v-if="
                                                resource !=
                                                    'caja/worker/expenses'
                                            "
                                        >
                                            <el-date-picker
                                                v-model="search.value"
                                                type="date"
                                                style="width: 100%;"
                                                placeholder="Buscar"
                                                value-format="yyyy-MM-dd"
                                                @change="getRecords"
                                            >
                                            </el-date-picker>
                                        </template>
                                        <template v-else>
                                            <el-date-picker
                                                v-model="search.value"
                                                type="daterange"
                                                range-separator="A"
                                                start-placeholder="Desde"
                                                value-format="yyyy-MM-dd"
                                                end-placeholder="Hasta"
                                                @change="getRecords"
                                            >
                                            </el-date-picker>
                                        </template>
                                    </template>
                                    <template
                                        v-else-if="
                                            search.column == 'district_id'
                                        "
                                    >
                                        <el-select
                                            v-model="search.value"
                                            @change="getRecords"
                                            placeholder="Seleccione el Distrito"
                                        >
                                            <el-option
                                                v-for="item in array_district"
                                                :key="item.id"
                                                :label="item.description"
                                                :value="item.id"
                                            >
                                            </el-option>
                                        </el-select>
                                    </template>
                                    <template
                                        v-else-if="search.column == 'seller_id'"
                                    >
                                        <el-select
                                            v-model="search.value"
                                            @change="getRecords"
                                            placeholder="Seleccione el vendedor"
                                        >
                                            <el-option
                                                v-for="(item, idx) in sellers"
                                                :key="idx"
                                                :label="item.name"
                                                :value="item.id"
                                            >
                                            </el-option>
                                        </el-select>
                                    </template>
                                    <template
                                        v-else-if="
                                            search.column == 'active' &&
                                                resource == 'caja/workers-type'
                                        "
                                    >
                                        <el-select
                                            v-model="search.value"
                                            @change="getRecords"
                                            placeholder="Seleccione el estado"
                                        >
                                            <el-option
                                                v-for="(item, idx) in [
                                                    {
                                                        id: 1,
                                                        description: 'Activado'
                                                    },
                                                    {
                                                        id: 0,
                                                        description:
                                                            'Desactivado'
                                                    }
                                                ]"
                                                :key="idx"
                                                :label="item.description"
                                                :value="item.id"
                                            >
                                            </el-option>
                                        </el-select>
                                    </template>
                                    <template v-else>
                                        <el-input
                                            placeholder="Buscar"
                                            v-model="search.value"
                                            style="width: 100%;"
                                            prefix-icon="el-icon-search"
                                            @input="getRecords"
                                        >
                                        </el-input>
                                    </template>
                                </div>
                                <div
                                    v-if="
                                        search.column == 'date_of_issue' ||
                                            search.column == 'date_of_due' ||
                                            search.column ==
                                                'date_of_payment' ||
                                            search.column == 'delivery_date' ||
                                            (search.column == 'date' &&
                                                resource == 'purchases' &&
                                                search.value)
                                    "
                                    class="col-lg-3 col-md-3 col-sm-12 pb-2"
                                >
                                    <label
                                        for="value"
                                        class="d-flex align-items-center mb-1"
                                    >
                                        <span class="mr-2"
                                            ><i class="el-icon-date"></i
                                        ></span>
                                        <span>Hasta</span>
                                    </label>
                                    <el-date-picker
                                        v-model="search.end_date"
                                        type="date"
                                        style="width: 100%;"
                                        placeholder="Buscar"
                                        value-format="yyyy-MM-dd"
                                        @change="getRecords"
                                    >
                                    </el-date-picker>
                                </div>
                                <div
                                    class="col-lg-3 col-md-3 col-sm-12 pb-2"
                                    v-if="
                                        resource == 'items' ||
                                            resource == 'item-color-size'
                                    "
                                >
                                    <label
                                        for="warehouse"
                                        class="d-flex align-items-center mb-1"
                                    >
                                        <span class="mr-2"
                                            ><i
                                                class="el-icon-office-building"
                                            ></i
                                        ></span>
                                        <span>Almacén</span>
                                    </label>
                                    <el-select
                                        clearable
                                        v-model="search.warehouse_id"
                                        @change="getRecords"
                                        placeholder="Seleccione el Almacén"
                                    >
                                        <el-option
                                            v-for="item in warehouses"
                                            :key="item.id"
                                            :label="item.description"
                                            :value="item.id"
                                        >
                                        </el-option>
                                    </el-select>
                                </div>
                                <div
                                    class="col-lg-3 col-md-3 col-sm-12 pb-2"
                                    v-if="resource == 'items'"
                                >
                                    <label
                                        for="warehouse"
                                        class="d-flex align-items-center mb-1"
                                    >
                                        <span class="mr-2"
                                            ><i
                                                class="el-icon-location-outline"
                                            ></i
                                        ></span>
                                        <span>Área/Zona</span>
                                    </label>
                                    <el-select
                                        clearable
                                        filterable
                                        v-model="search.area_id"
                                        @change="getRecords"
                                        placeholder="Seleccione el Almacén"
                                    >
                                        <el-option
                                            v-for="item in areas"
                                            :key="item.id"
                                            :label="item.description"
                                            :value="item.id"
                                        >
                                        </el-option>
                                    </el-select>
                                </div>
                                <div
                                    class="col-lg-3 col-md-3 col-sm-12 pb-2"
                                    v-if="resource == 'items'"
                                >
                                    <label
                                        class="d-flex align-items-center mb-1"
                                    >
                                        <span class="mr-2"
                                            ><i class="el-icon-s-check"></i
                                        ></span>
                                        <span>Estados</span>
                                    </label>
                                    <el-select
                                        v-model="search.active"
                                        @change="getRecords"
                                        clearable
                                        placeholder="Seleccione el estado"
                                    >
                                        <el-option
                                            v-for="(item, idx) in [
                                                { id: 1, active: 'Habilitado' },
                                                {
                                                    id: 0,
                                                    active: 'Inhabilitado'
                                                }
                                            ]"
                                            :key="idx"
                                            :label="item.active"
                                            :value="item.active"
                                        >
                                        </el-option>
                                    </el-select>
                                </div>
                                <div
                                    class="col-lg-2 col-md-2 col-sm-12 pb-2"
                                    v-if="resource == 'item-color-size'"
                                >
                                    <label
                                        class="d-flex align-items-center mb-1"
                                    >
                                        <span class="mr-2"
                                            ><i class="el-icon-s-flag"></i
                                        ></span>
                                        <span>Estados</span>
                                    </label>
                                    <el-select
                                        v-model="search.status"
                                        @change="getRecords"
                                        clearable
                                        placeholder="Seleccione el estado"
                                    >
                                        <el-option
                                            v-for="(item, idx) in [
                                                { id: 1, active: 'Disponible' },
                                                { id: 0, active: 'Agotado' }
                                            ]"
                                            :key="idx"
                                            :label="item.active"
                                            :value="item.active"
                                        >
                                        </el-option>
                                    </el-select>
                                </div>
                            </div>
                            <div
                                class="col-md-12 d-flex justify-content-end"
                                v-if="resource !== 'caja/cash-transfer'"
                            >
                                <el-tooltip
                                    content="Exportar en PDF"
                                    placement="top"
                                    v-if="resource == 'caja/worker/expenses'"
                                >
                                    <el-button
                                        class="btn_pdfsmall"
                                        type=""
                                        icon="icofont-file-pdf"
                                        @click.prevent="clickDownload('pdf')"
                                        >Exportar PDF
                                    </el-button>
                                </el-tooltip>
                                <el-tooltip
                                    v-if="resource !== 'restaurant'"
                                    :content="
                                        resource === 'items'
                                            ? 'Exportar productos al formato excel'
                                            : 'Exportar Excel'
                                    "
                                    placement="top"
                                >
                                    <el-button
                                        class="btn_excelsmall"
                                        type=""
                                        v-if="
                                            resource !== 'item-color-size' &&
                                                resource !==
                                                    'caja/worker/expenses'
                                        "
                                        icon="icofont-file-excel"
                                        @click.prevent="clickDownload('excel')"
                                    >
                                        Exportar
                                    </el-button>
                                </el-tooltip>
                                <el-tooltip
                                    content="Exportar tallas y colores"
                                    placement="top"
                                >
                                    <el-button
                                        class="btn_excelsmall"
                                        type=""
                                        v-if="resource == 'item-color-size'"
                                        icon="icofont-file-excel"
                                        @click.prevent="
                                            clickDownloadColor('excel')
                                        "
                                        >Exportar TyC
                                    </el-button>
                                </el-tooltip>
                                <el-tooltip
                                    content="Exportar formato excel para migración de productos"
                                    placement="top"
                                >
                                    <el-button
                                        class="btn_excelsmall"
                                        type=""
                                        v-if="
                                            search.warehouse_id &&
                                                typeUser == 'superadmin'
                                        "
                                        icon="icofont-file-excel"
                                        @click.prevent="
                                            clickDownloadForImport('excel')
                                        "
                                        >Exportar 2</el-button
                                    >
                                </el-tooltip>
                                <el-tooltip
                                    content="Agregar todos los productos a los almacenes faltantes"
                                    placement="top"
                                >
                                    <el-button
                                        class="btn_politicasmall"
                                        type=""
                                        v-if="typeUser == 'superadmin'"
                                        icon="el-icon-tickets"
                                        @click.prevent="
                                            clickAddProductsToWarehouses
                                        "
                                        >Item/Almacenes
                                    </el-button>
                                </el-tooltip>

                                <el-tooltip
                                    content="Agregar todas las políticas de precio de productos en todo los almacenes"
                                    placement="top"
                                >
                                    <el-button
                                        class="btn_politicasmall"
                                        type=""
                                        v-if="typeUser == 'superadmin'"
                                        icon="el-icon-tickets"
                                        @click.prevent="
                                            clickAddProductsToPolitica
                                        "
                                        >PPP/Almacenes
                                    </el-button>
                                </el-tooltip>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->

        <div class="col-md-12">
            <div class="table-responsive mt-0">
                <br />
                <table class="table table-striped" id="scroll2" style="overflow-x: auto">
                    <thead>
                        <slot name="heading"></slot>
                    </thead>
                    <tbody>
                        <slot v-for="(row, index) in records" :row="row" :index="customIndex(index)"></slot>
                    </tbody>
                    <tfoot>
                        <slot name="footer"> </slot>
                    </tfoot>
                </table>
                <div>
                    <el-pagination v-if="resource !== 'caja/cash-transfer/report'" @current-change="getRecords"
                        layout="total, prev, pager, next" :total="pagination.total"
                        :current-page.sync="pagination.current_page" :page-size="pagination.per_page">
                    </el-pagination>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import moment from "moment";
import queryString from "query-string";
import Configuration_numbers from "../views/configurations/configuration_numbers.vue";

export default {
    props: {
        typeUser: {
            type: String,
            default: "admin"
        },
        sellers: {
            type: Array,
            default: () => []
        },
        resource: String,
        applyFilter: {
            type: Boolean,
            default: true,
            required: false
        },
        fromAdmin: {
            type: Boolean,
            default: false,
            required: false
        },
        config: Object
    },
    data() {
        return {
            cashes: [],
            search: {
                warehouse_id: 1,
                column: null,
                value: null,
                active: null,
                status: null,
                identifier: null

            },
            columns: [],
            records: [],
            pagination: {},
            array_district: [],
            time: null,
            warehouses: [],
            areas: [],
            loading: false,
            configuration: {}
        };

    },
    computed: {},
    created() {
        //realiza una peticion get para obtener los datos de la tabla
         if (this.resource == "items") {
            this.$http.get("items/tables").then(response => {
                this.configuration = response.data.configuration;
            });
        }
        this.$eventHub.$on("reloadData", () => {
            this.getRecords();
        });
        if (this.resource == "caja/cash-transfer/report") {
            this.getCashes();
        }
        if (this.resource == "items") {
            this.$http.get(`/warehouses/records`).then(response => {
                this.warehouses = response.data.data;
            });

            this.$http.get(`/caja/areas/records`).then(response => {
                this.areas = response.data.data;
            });
        }

        if (this.resource == "item-color-size") {
            this.$http.get(`item-color-size/tables`).then(response => {
                this.warehouses = response.data.warehouses;
            });
        }
    },
    async mounted() {
        let column_resource = this.resource; // _.split(this.resource, '/')
        await this.$http.get(`/${this.resource}/columns`).then(response => {
            this.columns = response.data;
            this.search.column = _.head(Object.keys(this.columns));
        });
        if (this.resource !== "caja/cash-transfer/report") {
            await this.getRecords();
        }
    },
    methods: {
        clickAddProductsToPolitica() {
            this.loading = true;
            this.$http
                .get(`/items/warehouse`)
                .then(response => {
                    this.$showSAlert(
                        "EXITO",
                        "Politicas agreagadas correctamente a todos los almacenes",
                        "success"
                    );
                    /* this.$toast.success("Politicas agregadas correctamente a todos los almacenes"); */
                    this.getRecords();
                })
                .catch(error => {
                    this.loading = false;
                })
                .finally(() => {
                    this.loading = false;
                });
        },

        clickAddProductsToWarehouses() {
            this.loading = true;
            this.$http
                .get(`/items/warehouses/add-products`)
                .then(response => {
                    this.$toast.success(
                        "Productos agregados correctamente a todos los almacenes"
                    );
                    this.getRecords();
                })
                .catch(error => {
                    this.loading = false;
                })
                .finally(() => {
                    this.loading = false;
                });
        },

        total_income() {
            return this.records.reduce(
                (acc, item) => acc + Number(item.income),
                0
            );
        },
        total_expense() {
            return this.records.reduce(
                (acc, item) => acc + Number(item.expense),
                0
            );
        },
        getCashes() {
            this.$http
                .get(`/caja/cash-transfer/cashes-principal`)
                .then(response => {
                    this.cashes = response.data.cashes;
                    let [cash] = this.cashes;
                    if (cash) {
                        this.search.cash_id = cash.id;
                        this.getRecords();
                    }
                });
        },
        clickDownload(type) {
            this.$emit("clickReport", this.search, type);
        },

        /* clickDownloadColor() {
            this.$http
                .get("/item-color-size/export_excel")
                .then(response => {})
                .catch(error => {
                    this.loading = false;
                })
                .finally(() => {
                    this.loading = false;
                });
        }, */
        clickDownloadColor() {
            let parameters = this.getQueryParameters();
            window.open(
                `/item-color-size/export_excel?${parameters}`,
                "_blank"
            );
        },

        clickDownloadForImport() {
            this.$emit("clickReportForImport", this.search);
        },

        customIndex(index) {
            if (this.resource == "caja/cash-transfer/report") {
                return index + 1;
            }
            return (
                this.pagination.per_page * (this.pagination.current_page - 1) +
                index +
                1
            );
        },
        getRecords() {
            if (this.time) {
                clearTimeout(this.time);
            }
            this.time = setTimeout(async () => {
                this.loading = true;
                let url = `/${this.resource
                    }/records?${this.getQueryParameters()}`;
                if (this.fromAdmin) {
                    url = `/${this.resource
                        }/records?${this.getQueryParameters()}&fromAdmin=true`;
                }
                return this.$http
                    .get(url)
                    .then(response => {
                        if (this.resource !== "caja/cash-transfer/report") {
                            this.records = response.data.data;
                            this.pagination = response.data.meta;
                            this.pagination.per_page = parseInt(
                                response.data.meta.per_page
                            );
                        } else {
                            let data = response.data;
                            this.records = data.data;
                        }
                    })
                    .catch(error => {
                        this.loading = false;
                    })
                    .finally(() => {
                        this.loading = false;
                    });
            }, 350);
        },
        getQueryParameters() {
            if (
                this.search.column == "date" &&
                this.search.value &&
                typeof this.search.value == "object"
            ) {
                this.search.value = this.search.value.join(",");
            }
            return queryString.stringify({
                page: this.pagination.current_page,
                limit: this.limit,
                value: this.search.value,
                column: this.search.column,
                active: this.search.active,
                cash_id: this.search.cash_id,
                end_date: this.search.end_date,
                warehouse_id: this.search.warehouse_id,
                area_id: this.search.area_id,
                status: this.search.status
                    ,identifier: this.search.identifier
            });
        },
        changeClearInput() {
            this.search.value = "";
            this.getRecords();
        }
    }
};
</script>
