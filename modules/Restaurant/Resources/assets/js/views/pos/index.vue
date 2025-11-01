<!-- Padre de Caja  -->
<template>
    <div style="position: relative" v-loading.fullscreen="loading" element-loading-text="Espere...">
        <!-- Hora y Fecha del sistema -->
        <div class="row" style="margin-top: 10px;">
            <div class="row">
                <div class="col-4" v-if="limitAmount">
                    <div :class="[
                        `alert alert-${limitAmount.color}`,
                        'pos-alert-warning'
                    ]"
                        style="padding: 0.2rem 0.7rem; margin-bottom: 0.3rem; display: flex; align-items: center; background: #fff;">
                        <i class="fas fa-exclamation-triangle me-2" style="font-size: 1.3em; color: #ff9800;"></i>
                        <p style="font-size: 15px; font-weight: bold; margin: 0; color: #9f1019;" :class="{
                            'blink-alert-text':
                                limitAmount.tipo === 'critico'
                        }">
                            {{ limitAmount.mensaje }}
                        </p>
                    </div>
                </div>
            </div>

            <div v-if="screenWidth > 678" class="d-flex flex-row justify-content-start card mb-2">
                <div class="col-7 col-sm-5 col-lg-6 col-md-5 col-xl-7 col-xxl-7">
                    <div class="card-body p-1">
                        <div class="row">
                            <div class="d-flex flex-wrap">
                                <div class="dropdown-as-select d-inline-block mb-1" data-childselector="span">
                                    <button class="btn p-0" type="button" id="menu-actions" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false" style="margin-right: 12px;">
                                        <span class="btn_guardarsmall dropdown-toggle" data-bs-toggle="tooltip"
                                            data-bs-placement="top" data-bs-delay="0" title
                                            data-bs-original-title="Item Count" aria-label="Item Count">Acciones
                                        </span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end col-md-2 col-1" style="width: 153px;">
                                        <div class="col-12" v-for="(option, idx) in optionsMenu" :key="idx"
                                            v-show="option.visible">
                                            <el-button v-if="option.visible" @click="
                                                trigerFunction(option.id)
                                                "
                                                class="btn btn-light m-1 rounded d-flex flex-column align-items-center justify-content-center col-12"
                                                style="max-width: 150px;">
                                                <div class="text-center" style="margin-bottom: 2px">
                                                    <p style="margin: 0 !important; padding: 0 !important ; font-size: 15px;"
                                                        v-for="(title,
                                                            idx2) in option.title" :key="idx2">
                                                        {{ title }}
                                                    </p>
                                                    <i :class="option.icon"></i>
                                                </div>
                                                <div></div>
                                            </el-button>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center flex-row flex-wrap gap-2">
                                    <template v-if="configuration.restaurant && !this.isSeller">
                                        <!-- Boton de Mesa en Restaurante  o cuartos en Hotel -->
                                        <template
                                            v-if="!configuration.hotels || (configuration.hotels && !isPiscinaArea)">
                                            <button class="btn_guardarsmall" type="primary" @click="buttonSmTables"
                                                :title="isHotelArea
                                                    ? '[F2] Cuartos para Alquilar'
                                                    : '[F2] Mesas de Atención'
                                                    ">
                                                <i v-if="isHotelArea" class="fas fa-hotel"
                                                    style="font-size: 15px; margin-top:-5px; color: white; display: flex; justify-content: center; align-items: center;"></i>
                                                <i v-else class="icofont-dining-table"
                                                    style="font-size: 15px; margin-top:-5px; color: white; display: flex; justify-content: center; align-items: center;"></i>
                                            </button>
                                        </template>

                                        <template v-if="configuration.created_items">
                                            <el-tooltip content="Crear Producto" placement="top">
                                                <button class="btn_guardarsmall" type="primary" @click="createdNew">
                                                    <i class="fas fa-plus" style="font-size: 10px;"></i>
                                                </button>
                                            </el-tooltip>
                                        </template>
                                        <!-- <template v-if="restaurant_library">
                                            <el-tooltip content="Crear Producto" placement="top">
                                                <button class="btn_guardarsmall" type="primary" @click="createdNewLibrary">
                                                    <i class="fas fa-plus" style="font-size: 20px;">prod</i>
                                                </button>
                                            </el-tooltip>
                                            </template> -->
                                           
                                        
                                        

                                        <template v-if="isAndroid">
                                            <button class="btn_guardarsmall" type="primary" @click="printLastDocument">
                                                <i class="fas fa-print" style="font-size: 35px;"></i>
                                                <template v-if="lastDocument">
                                                    {{
                                                        lastDocument.numberPrint
                                                    }}
                                                </template>
                                            </button>

                                            <button class="btn_guardarsmall" type="primary"
                                                v-for="orden in ordenToPrint" :key="orden.id" @click="
                                                    printOrden(
                                                        orden.url,
                                                        orden.id
                                                    )
                                                    ">
                                                N° {{ orden.id }}
                                            </button>
                                        </template>
                                    </template>
                                    <!-- Finanzas -->
                                    <template v-if="!this.isSeller">
                                        <el-tooltip content="Finanzas" placement="top">
                                            <button class="btn_guardarsmall" type="primary" @click="trigerFunction(195)"
                                                style="height:42px; min-width:42px; padding:0 10px; margin-right:8px;">
                                                <i class="fas fa-cash-register"></i>
                                            </button>
                                        </el-tooltip>
                                    </template>

                                    <template v-if="isHotelArea">
                                        <!-- Limpieza Hotel -->
                                        <el-badge :value="tablesClean.length" :hidden="tablesClean.length === 0">
                                            <button style="margin-right: 2px;margin-left: 2px;" type="button"
                                                class="btn_limpiezasmall" @click="showCleanDialog = true">
                                                <img src="/images/imghotel/5.png" alt="Imagen" width="20" height="20" />
                                                
                                            </button>
                                        </el-badge>
                                        <!-- Habitaciones Vencidas -->
                                        <el-badge :value="tablesLeave.length" :hidden="tablesLeave.length === 0">
                                            <button style="margin-right: 2px;margin-left: 2px;" type="button"
                                                class="btn_cancelarsmall" :title="'Habitaciones vencidas'"
                                                @click="showExpiredDialog = true">
                                                <i class="fas fa-exclamation-triangle" style="margin-right: 6px;"></i>
                                                
                                            </button>
                                        </el-badge>
                                    </template>
                                </div>
                                <div class="d-flex align-items-center" style="gap:12px; flex-wrap:nowrap;">
                                    <!-- <el-tooltip content="Crear Productos" placement="top">
                                        <button
                                            class="btn_guardarsmall d-flex align-items-center justify-content-center"
                                            type="button"
                                            @click="createdNewLibrary"
                                            style="height:42px; min-width:42px; padding:0 10px;">
                                            <i class="fas fa-box-open" style="font-size:18px;"></i>
                                            
                                        </button>
                                    </el-tooltip> -->

                                    <el-tooltip content="Historial" placement="top">
                                        <button
                                            class="btn_guardarsmall d-flex align-items-center justify-content-center"
                                            type="button"
                                            @click="trigerFunction(7)"
                                            style="height:42px; min-width:42px; padding:0 10px;">
                                            <i class="fas fa-history" style="font-size:18px;"></i>
                                        </button>
                                    </el-tooltip>

                                    <!-- Tiempo restante -->
                                    
                                        <button
                                            class="btn_excelsmall d-flex align-items-center justify-content-center"
                                            type="button"
                                            style=" min-width:42px; padding:0 10px;">
                                            <i class="fas fa-clock me-2"  style="font-size:18px;"></i>
                                            <small>{{ formattedCountdown }}</small>
                                        </button>
                                    

                                    <!-- Estado Internet / Latencia -->
                                    <el-tooltip content="Estado de Estabilidad de Internet" placement="top">
                                        <button
                                            class="btn d-flex align-items-center justify-content-center"
                                            type="button"
                                            :style="{ backgroundColor: getPingBackground(), color: 'white', height: '28px', padding: '0 12px' }">
                                            <i class="fas fa-wifi me-2" style="font-size:18px;"></i>
                                            <small>{{ latencia }} ms</small>
                                        </button>
                                    </el-tooltip>
                                </div>


                            </div>
                        </div>
                        <div class="row card mx-1 mt-2" v-if="configuration.sale_note_credit_confirm
                            ? isAnalist ||
                            user.can_accept_credit_sale_note
                            : true">
                            <div>
                                <!-- Busqueda de Categorias  Chifa China -->
                                <template v-if="configuration.category_deslay">
                                    <div class="d-flex row align-items-center">
                                        <!-- Categorías Scroll -->
                                        <div class="col-12 p-2">
                                            <div class="categories-scroll">
                                                <div class="categories-wrapper">
                                                    <!-- Add All Categories circle -->
                                                    <div class="category-card" :class="{
                                                        active:
                                                            category ===
                                                            null
                                                    }" @click="
                                                        category = null;
                                                    search_items(null);
                                                    ">
                                                        <div class="category-circle">
                                                            <i class="fas fa-th text-primary"
                                                                style="font-size: 24px;"></i>
                                                        </div>
                                                        <span class="category-name">Todo
                                                            Categoria</span>
                                                    </div>

                                                    <!-- Existing categories -->
                                                    <div v-for="item in categories" :key="item.id" class="category-card"
                                                        :class="{
                                                            active:
                                                                category ===
                                                                item.id
                                                        }" @click="
                                                            category = item.id;
                                                        search_items(null);
                                                        ">
                                                        <div class="category-circle">
                                                            <img v-if="
                                                                item.icono
                                                            " :src="`/storage/uploads/category/${item.icono}`
                                                                " alt=""
                                                                style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%; display: block; overflow: hidden;" />
                                                            <img v-else src="/logo/imagen-no-disponible.jpg"
                                                                alt="Imagen no disponible"
                                                                style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%; display: block; overflow: hidden;" />
                                                        </div>
                                                        <span class="category-name">{{
                                                            item.name
                                                            }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Buscar -->
                                        <div class="col-12 col-lg-4 p-2" v-if="configuration.category_deslay">
                                            <h2 class="font-weight-bold custom-text-size">
                                                Buscar
                                            </h2>
                                            <template v-if="selectOption == 4">
                                                <el-input ref="input_items" size="small" v-model="input_item"
                                                    @input="search()" @focus="clear_input()" autofocus clearable>
                                                    <el-button class="bg-light" slot="append" icon="el-icon-search"
                                                        @click="search"></el-button>
                                                </el-input>
                                            </template>
                                            <template v-else>
                                                <el-input ref="input_item" size="small" v-model="input_item"
                                                    @input="search()" @focus="clear_input()" autofocus>
                                                    <el-button class="bg-light" slot="append" icon="el-icon-search"
                                                        @click="search"></el-button>
                                                </el-input>
                                            </template>
                                        </div>
                                    </div>
                                </template>

                                <template v-else>
                                    <!-- Card de Búsqueda -->
                                    <div class="row">
                                        <div class="col-2 mt-1">
                                            <!-- Series -->
                                            <div v-if="configuration.search_series_pos"
                                                class="d-flex align-items-center justify-content-start">
                                                <el-checkbox v-model="searchSeries"
                                                    @change="saveInLocalStorageSearchSeries"
                                                    class="d-flex align-items-center">
                                                    <span>Series</span>
                                                </el-checkbox>
                                            </div>

                                            <!-- Barcode -->
                                            <div v-if="configuration.barcode"
                                                class="align-items-center justify-content-center">
                                               
                                                    
                                                    <el-checkbox v-model="barcode" @change="saveInLocalStorageBarcode"
                                                        class="d-flex align-items-center">
                                                        <span>Barcode</span>
                                                    </el-checkbox>
                                               
                                            </div>

                                            <!-- Calidad -->
                                            <div v-if="configuration.quality"
                                                class=" align-items-center justify-content-center">
                                                <el-tooltip content="Filtrar por calidad del producto" placement="top">
                                                    <el-checkbox v-model="quality" @change="
                                                        saveInLocalStorageQuality
                                                    " class="d-flex align-items-center">

                                                        <span>Calidad</span>
                                                    </el-checkbox>
                                                </el-tooltip>
                                            </div>

                                            <!-- Modelo -->

                                            <div v-if="configuration.model"
                                                class="align-items-center justify-content-center">
                                                <el-tooltip content="Filtrar por modelo del producto" placement="top">
                                                    <el-checkbox v-model="model" @change="
                                                        saveInLocalStorageModel
                                                    " class="d-flex align-items-center">

                                                        <span>Modelo</span>
                                                    </el-checkbox>
                                                </el-tooltip>
                                            </div>

                                        </div>

                                        <div class="col-10">
                                            <!-- Categorías y Marca -->

                                            <div class="row align-items-center">
                                                <div class="row">
                                                    <div class="mb-1 mt-1 col-8">
                                                        <!-- Categorías -->
                                                        <div style="padding: 0;">
                                                            <template>
                                                                <el-select v-model="category" filterable clearable
                                                                    placeholder="Seleccionar Categoría"
                                                                    @change="search_items(null)" size="small">
                                                                    <el-option v-for="item in categories" :key="item.id"
                                                                        :label="item.name" :value="item.id">
                                                                    </el-option>
                                                                </el-select>
                                                            </template>
                                                        </div>
                                                    </div>
                                                    <div v-if="configuration.list_or_card" class="col-3">
                                                        <button @click="toggleView"
                                                            class="btn btn-primary btn-sm ml-auto float-right">
                                                            {{ showList ? "Mostrar Card" : "Tabla - Card" }}
                                                        </button>
                                                    </div>


                                                </div>
                                                <div class="mb-1">
                                                    <!-- Marca -->
                                                    <div v-if="configuration.brand">
                                                        <template>
                                                            <el-select v-model="brand" filterable clearable
                                                                placeholder="Marca..." @change="search_items(null)"
                                                                size="small">
                                                                <el-option v-for="item in brands" :key="item.id
                                                                    " :label="item.name
                                                                        " :value="item.id">
                                                                </el-option>
                                                            </el-select>
                                                        </template>
                                                    </div>
                                                </div>
                                                <!-- Buscar -->

                                                <div class="mb-1" style="display: flex; 
                                                    justify-content: center; 
                                                    align-items: center; height: 100%;">
                                                    <template v-if="selectOption == 4">
                                                        <el-input ref="input_items" size="small" v-model="input_item"
                                                            placeholder="producto a buscar..." @input="search()"
                                                            @focus="clear_input()" autofocus clearable
                                                            style="border: 2px solid #FFC107; border-radius: 4px;">
                                                        </el-input>
                                                    </template>
                                                    <template v-else>
                                                        <el-input ref="input_item" size="small" v-model="input_item"
                                                            @input="search()" @focus="clear_input()" autofocus>
                                                        </el-input>
                                                    </template>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </template>
                            </div>
                        </div>
                        <div class="row" v-if="selectOption == 4 || selectOption == 3">
                            <div class="col-md-12 p-1">
                                <ListFood :lastQuery="lastQuery" :canAddItem.sync="canAddItem"
                                    :loadingItems.sync="loadingItems" :localOrden="localOrden"
                                    :blockAdd.sync="blockCart" ref="list_foods" :barcode.sync="barcode"
                                    :policy.sync="policy" :searchSeries.sync="searchSeries"
                                    :searchSecondName.sync="searchSecondName" :model.sync="model"
                                    :quality.sync="quality" :type_code.sync="type_code" :worker="worker"
                                    @insertOrden="insertOrden" :configuration="configuration" :foods.sync="allFoods"
                                    :value="input_item" @buscarnuevo="buscarnuevo" :medida_alto="medida_alto"
                                    :medida_ancho="medida_ancho" :medida_grosor="medida_grosor"
                                    :categoria_madera="categoria_madera" @cotizarConfirmado="handleCotizarConfirmado"
                                    :cotizarConfirmado.sync="cotizarConfirmado" :establishments="establishments"
                                    @cotizarConfirmadoChanged="
                                        handleCotizarConfirmado
                                    "></ListFood>
                            </div>
                        </div>
                        <div class="row" v-if="selectOption == 1 || selectOption == 2">
                            <div class="col-12 mb-1">
                                <div class="card mb-2 bg-transparent no-shadow d-none d-lg-block">
                                    <div class="row g-0 sh-3">
                                        <div class="col">
                                            <div class="card-body pt-0 pb-0 h-100">
                                                <div class="row g-0 h-100 align-content-center">
                                                    <div
                                                        class="col-6 col-lg-2 d-flex align-items-center justify-content-start text-alternate text-medium text-muted text-small">
                                                        CANTIDAD
                                                    </div>
                                                    <div
                                                        class="col-6 col-lg-5 d-flex align-items-center justify-content-start text-alternate text-medium text-muted text-small">
                                                        DESCRIPCION
                                                    </div>
                                                    <div
                                                        class="col-6 col-lg-2 d-flex align-items-center justify-content-center text-alternate text-medium text-muted text-small">
                                                        PRECIO
                                                    </div>
                                                    <div
                                                        class="col-6 col-lg-2 d-flex align-items-center justify-content-center text-alternate text-medium text-muted text-small">
                                                        IMPORTE
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="checkboxTable">
                                    <div class="card mb-2 hover-border-secondary border" v-for="(row, index) in ordens"
                                        :key="index">
                                        <div class="card-body p-2">
                                            <div class="row g-0 h-100 align-content-center">
                                                <div
                                                    class="col-6 col-lg-2 d-flex flex-column justify-content-start mb-2 mb-lg-0 order-lg-2">
                                                    <div class="text-muted text-small d-lg-none">
                                                        <h1>CANTIDAD</h1>
                                                    </div>
                                                    <div class="text-alternate">
                                                        <template>
                                                            <el-input-number :disabled="disableCantidad
                                                                " :min="1" size="mini" v-model="row.food
                                                                    .item
                                                                    .quantity
                                                                    " controls-position="right" @change="
                                                                        calculateItem(
                                                                            index,
                                                                            row.food
                                                                                .item
                                                                                .quantity,
                                                                            row.food
                                                                                .price_sale
                                                                        )
                                                                        "></el-input-number>
                                                        </template>
                                                    </div>
                                                </div>
                                                <div
                                                    class="col-12 col-lg-5 d-flex flex-column justify-content-start mb-2 mb-lg-0 order-lg-3">
                                                    <div class="text-muted text-small d-lg-none">
                                                        DESCRIPCION
                                                    </div>

                                                    <template v-if="
                                                        row.food.item
                                                            .name_product_pdf !=
                                                        null
                                                    ">
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
                                                    class="col-6 col-lg-2 d-flex flex-column justify-content-center mb-2 mb-lg-0 order-lg-4">
                                                    <div class="text-muted text-small d-lg-none">
                                                        PRECIO
                                                    </div>
                                                    <div class="text-alternate">
                                                        <span>
                                                            <el-input v-model="row.food
                                                                .price
                                                                " :disabled="disableCantidad
                                                                    " size="mini" @input="
                                                                        calculateItem(
                                                                            index,
                                                                            row.food
                                                                                .item
                                                                                .quantity,
                                                                            row.food
                                                                                .price
                                                                        )
                                                                        ">
                                                                <template slot="prepend">S/.</template>
                                                            </el-input>
                                                        </span>
                                                    </div>
                                                </div>

                                                <div
                                                    class="col-6 col-lg-2 d-flex flex-column justify-content-center mb-2 mb-lg-0 order-lg-5 text-center">
                                                    <div class="text-muted text-small d-lg-none mb-1">
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
                                                    class="col-12 col-lg-1 d-flex flex-column justify-content-center align-items-lg-end mb-2 mb-lg-0 text-end order-lg-last pr-2">
                                                    <button type="button"
                                                        class="btn waves-effect waves-light btn-sm btn-danger" @click="
                                                            removeFood(
                                                                index,
                                                                row.id
                                                            )
                                                            ">
                                                        <i class="fas fa-times"></i>
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

                        <div class="row" v-loading="loading" v-if="selectOption == 0">
                            <div class="col-12 col-lg-6 col-xxl-2 mb-2" v-for="(row, index) in listar_tables"
                                :key="index">
                                <div class="card hover-border-secondary" :class="selecttables == row.id
                                    ? 'border-secondary'
                                    : ''
                                    " @click="selectTable(row, index)" data-bs-toggle="offcanvas"
                                    data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                                    <div class="h-100 row g-0 card-body align-items-center">
                                        <div class="col-auto">
                                            <div
                                                class="bg-gradient-2 sw-6 sh-6 rounded-md d-flex justify-content-center align-items-center">
                                                <i class="icofont icofont-dining-table icofont-2x text-white"></i>
                                            </div>
                                        </div>
                                        <div class="col sh-6 ps-3 d-flex flex-column justify-content-center">
                                            <div class="heading mb-0 d-flex align-items-center lh-1-25">
                                                Mesa {{ row.number }}
                                            </div>
                                            <div class="row g-0">
                                                <div class="col-auto">
                                                    <div class="cta-2 text-primary">
                                                        <template v-if="
                                                            row.ordens
                                                                .length == 1
                                                        ">
                                                            {{
                                                                (
                                                                    "00" +
                                                                    row.ordens
                                                                        .length
                                                                ).slice(-2)
                                                            }}
                                                        </template>
                                                        <template v-else>
                                                            <template v-if="
                                                                row.ordens
                                                                    .length +
                                                                1 <=
                                                                9
                                                            ">
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
                        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight"
                            aria-labelledby="offcanvasRightLabel">
                            <div class="offcanvas-header">
                                <h5 id="offcanvasRightLabel">
                                    Mesa Nº {{ tableSelect.number }} /
                                    {{ ("00" + OrdenLength).slice(-2) }}
                                    Ordenes
                                </h5>
                                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body">
                                <section class="scroll-section" id="checkboxes">
                                    <div class="d-flex justify-content-between">
                                        <h2 class="small-title">
                                            Ordenes de Pedido
                                        </h2>
                                        <div class="btn-group check-all-container mt-n1">
                                            <div class="btn btn-sm btn-outline-primary btn-custom-control"
                                                id="checkAllforCheckboxTable" data-target="#checkboxTable"
                                                @click="selectAllCats">
                                                <span class="form-check mb-0 pe-1">
                                                    <input type="checkbox" class="form-check-input" id="checkAll"
                                                        v-model="isAllSelected" />
                                                </span>
                                            </div>
                                            <button type="button"
                                                class="btn btn-sm btn-outline-primary dropdown-toggle dropdown-toggle-split"
                                                data-bs-offset="0,3" data-bs-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false"></button>
                                            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-end">
                                                <a class="dropdown-item" href="javascript:void(0)"
                                                    @click="status_orden_id(0)">Cancelar
                                                    Ordenes</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="javascript:void(0)"
                                                    @click="status_orden_id(3)">Orden de Pedidos
                                                    Listo</a>
                                                <a class="dropdown-item" href="javascript:void(0)"
                                                    @click="facturar_orden()">Facturar</a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="scroll-out">
                                        <div class="scroll-by-count os-host os-theme-dark os-host-overflow os-host-overflow-y os-host-resize-disabled os-host-scrollbar-horizontal-hidden os-host-transition"
                                            data-count="4" id="checkboxTable" style="height: calc(100vh - 7rem)">
                                            <div class="os-resize-observer-host observed">
                                                <div class="os-resize-observer" style="left: 0px; right: auto"></div>
                                            </div>
                                            <div class="os-size-auto-observer observed"
                                                style="height: calc(100% + 1px); float: left">
                                                <div class="os-resize-observer"></div>
                                            </div>
                                            <div class="os-content-glue" style="margin: 0px -15px"></div>
                                            <div class="os-padding">
                                                <div class="os-viewport os-viewport-native-scrollbars-invisible"
                                                    style="overflow-y: scroll">
                                                    <div class="os-content"
                                                        style="padding: 0px 15px; height: 100%; width: 100%">
                                                        <div v-for="(data,
                                                            index) in tableSelect.ordens" :key="index">
                                                            <div class="row g-0 h-100 align-content-center" v-if="
                                                                data.status_id ==
                                                                1
                                                            " :class="data.status_id ==
                                                                0
                                                                ? 'animate__animated animate__backOutUp animate__delay-2s'
                                                                : ''
                                                                ">
                                                                <div
                                                                    class="col-12 d-flex align-items-center mb-2 mb-md-0 p-2 font-weight-bold">
                                                                    ORDEN Nº
                                                                    {{
                                                                        data.id
                                                                    }}
                                                                    <!-- </div>
                                  </div>-->
                                                                </div>
                                                            </div>

                                                            <div v-for="(ordersItem,
                                                                indexx) in data.orden_items" :key="indexx">
                                                                <div class="card mb-1 pt-2 pb-2 border" :class="data.status_orden_id ==
                                                                    3
                                                                    ? 'animate__animated animate__backOutUp animate__delay-2s'
                                                                    : ''
                                                                    " v-if="
                                                                        ordersItem.status_orden_id ==
                                                                        1
                                                                    ">
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
                                                                                    <input type="checkbox"
                                                                                        class="form-check-input" :value="ordersItem.id
                                                                                            " v-model="selectedCatIds
                                                                                                " @click="
                                                                                                    select
                                                                                                " />
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
                    <div class="">
                        <list-orden :divided_items.sync="divided_items" @searchFoodByCustomerUnitTypeId="
                            searchFoodByCustomerUnitTypeId
                        " :formQtn.sync="formQtn" @updateCurrencyChoice="updateCurrencyChoice"
                            :exchange_rate_sale="form.exchange_rate_sale" :users.sync="users" :user.sync="user"
                            :quotationId.sync="quotationId" :cotIdentifier.sync="cotIdentifier"
                            :isSeller.sync="isSeller" :isAnalist.sync="isAnalist" @sendOrdens="sendOrdens"
                            :isHotelArea.sync="isHotelArea" :clientSaleNoteNumber.sync="clientSaleNoteNumber"
                            :clientSaleNoteDiscount.sync="clientSaleNoteDiscount
                                " :sellers="sellers" @sendOrdensAllTables="sendOrdensAllTables" ref="list_orden"
                            :affectation_igv_types="affectation_igv_types" :all_series.sync="all_series"
                            @resetOrden="resetOrden" :areas.sync="areas" :company.sync="company"
                            :customers.sync="all_customers" :customer_variation="customer_variation"
                            :variationShow.sync="variation" :establishments="establishments"
                            :itemDefault.sync="itemDefault" :cash_id.sync="cashId" :ordenId.sync="ordenId"
                            :ordensPending.sync="ordensPending" :area_id="area_id"
                            :isCreatingOrden.sync="isCreatingOrden" :blockCart.sync="blockCart"
                            :total2.sync="form.total" :configuration.sync="configuration" :localOrden.sync="localOrden"
                            :ordens.sync="ordensItems" @total_sales="total_sales" @updateOrdens="updateOrdens"
                            @paymentsOrden="paymentsOrden" @deletedFood="deletedFood" @cancelOrden="cancelOrden"
                            @ordenDeleted="createOrden" @limpiarForm="limpiarForm"
                            :clientTableData.sync="clientTableData" @reloadProduct="search_items"
                            @cotizarConfirmado="handleCotizarConfirmado" :cotizarConfirmado.sync="cotizarConfirmado"
                            :isRestaurantWarehouse="isRestaurantWarehouse" @cotizarConfirmadoChanged="
                                handleCotizarConfirmadoRegreso
                            " :currencyIdChoice.sync="currencyIdChoice" :percentage_igv="percentage_igv"></list-orden>
                    </div>
                </div>
            </div>
            <div v-else>
                <!-- Modo Celular/ Movil -->
                <div class="d-flex flex-wrap">
                    <button v-if="
                        isSellerConsolidated
                            ? customer_unit_type_id != null &&
                            customer_unit_type_id != ''
                            : true
                    " type="button" class="btn settings-button bg-primary text-white border border-white"
                        data-bs-toggle="modal" data-bs-target="#settings" id="settingsButton">
                        <i class="fas fa-cart-plus"></i>
                    </button>
                    <div class="modal fade modal-right scroll-out-negative" id="settings" data-bs-backdrop="true"
                        tabindex="-1" role="dialog" aria-labelledby="settings" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable full" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-primary">
                                    <h5 class="modal-title" style="color: var(--light-text) !important;">
                                        Visualizacion de Productos
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="scroll-track-visible" style="overflow-y: auto;">
                                        <div class="row">
                                            <div class="col-12"></div>

                                            <div class="col-12">
                                                <template>
                                                    <h2 class="text-muted text-small">
                                                        Categorias
                                                    </h2>
                                                    <el-select v-model="category" filterable clearable
                                                        placeholder="Selecionar aqui....">
                                                        <el-option v-for="item in categories" :key="item.id"
                                                            :label="item.name" :value="item.id"></el-option>
                                                    </el-select>
                                                </template>
                                            </div>
                                            <div class="col-12">
                                                <h2 class="text-muted text-small">
                                                    Buscar
                                                </h2>
                                                <template v-if="selectOption == 4">
                                                    <el-input ref="input_items" size="small" v-model="input_item"
                                                        @input="search()" @focus="clear_input()" autofocus
                                                        placeholder="Ingrese aca Un Producto">
                                                        <el-button slot="append" icon="el-icon-search"
                                                            @click="receiveData"></el-button>
                                                    </el-input>
                                                </template>

                                                <template v-else>
                                                    <el-input ref="input_itemMobil" size="small" v-model="input_item"
                                                        @input="search()" @focus="clear_input()" autofocus
                                                        placeholder="Ingrese Un Producto">
                                                        <el-button slot="append" icon="el-icon-search"
                                                            @click="receiveData"></el-button>
                                                    </el-input>
                                                </template>
                                            </div>
                                            <div class="col-12">
                                                <el-checkbox v-model="barcode" @change="
                                                    saveInLocalStorageBarcode
                                                ">
                                                    <h2 class="text-muted text-small">
                                                        Barcode
                                                    </h2>
                                                </el-checkbox>
                                            </div>
                                        </div>
                                        <div class="row d-flex flex-wrap">
                                            <div class="col-12 p-1" v-for="(data,
                                                index) in allFoods" :key="index">
                                                <el-tooltip effect="dark" :disabled="data.item.warehouses
                                                    .length == 1 ||
                                                    !configuration.show_stock_establishment_box
                                                    ">
                                                    <div slot="content">
                                                        Stock Almacenes
                                                        <br />
                                                        <span v-for="(info,
                                                            idx) in data.item
                                                                .warehouses" :key="idx">
                                                            <label v-if="
                                                                info
                                                                    .warehouse
                                                                    .id !=
                                                                establishmentId
                                                            ">
                                                                <template v-if="
                                                                    data
                                                                        .item
                                                                        .max_quantity
                                                                ">
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
                                                                        `${info
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
                                                    <div id="card"
                                                        class="overflow-hidden coupon rounded d-flex flex-column justify-content-between p-1"
                                                        style="height: 125px; width: 297px ; margin-left: 9px; ">
                                                        <div @click="
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
                                                            ">
                                                            <div>
                                                                <span class="lead-font-weight-700 h5">
                                                                    {{
                                                                        data.description.toUpperCase()
                                                                    }}
                                                                </span>
                                                            </div>
                                                            <div class="d-flex align-items-end justify-content-between">
                                                                <div class="p-1">
                                                                    <div class="icon-container">
                                                                        <div class="icon-container_box">
                                                                            <template v-if="
                                                                                data.image ==
                                                                                'imagen-no-disponible.jpg'
                                                                            ">
                                                                                <img hidden
                                                                                    src="/images/imagen-no-disponible.jpg"
                                                                                    alt="User Img" class="thumbail" />
                                                                            </template>
                                                                            <template v-else>
                                                                                <img :src="formatUrlImage(
                                                                                    data.image
                                                                                )
                                                                                    " class="thumbail"
                                                                                    style="  max-height: 69px;  max-width: 69px;" />
                                                                            </template>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div>
                                                                    {{
                                                                        data.code
                                                                    }}
                                                                </div>
                                                                <div class="d-flex flex-column align-items-end">
                                                                    <!-- <div class="text-uppercase font-weight-light h5">
                                                    {{ data.category.name }}
                                  </div>-->
                                                                    <div class="block mb-2">
                                                                        <span class="time font-weight-light">
                                                                            <span
                                                                                class="text-muted lead-font-weight-700">
                                                                                S/
                                                                                {{
                                                                                    data.price
                                                                                }}
                                                                            </span>
                                                                        </span>
                                                                    </div>
                                                                    <div v-if="
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
                                                                    ">
                                                                        <template v-if="
                                                                            data
                                                                                .item
                                                                                .stock >
                                                                            0
                                                                        ">
                                                                            <span
                                                                                class="badge rounded-pill bg-primary m-l-0">
                                                                                Stock
                                                                                <template v-if="
                                                                                    data
                                                                                        .item
                                                                                        .max_quantity
                                                                                ">
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
                                                                                <template v-else>
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
                                                                                class="badge rounded-pill bg-danger m-l-0">Agotado</span>
                                                                        </template>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div v-if="
                                                            isSellerConsolidated
                                                                ? data.types
                                                                    .length >
                                                                1
                                                                : data.types
                                                                    .length >
                                                                0
                                                        " class="d-flex justify-content-end"
                                                            style="padding-right: 10px; margin-top: 5px">
                                                            <el-dropdown @command="
                                                                clickCommand
                                                            ">
                                                                <span class="el-dropdown-link">
                                                                    Precios
                                                                    <i class="el-icon-arrow-down el-icon--right"></i>
                                                                </span>
                                                                <el-dropdown-menu slot="dropdown">
                                                                    <el-dropdown-item v-for="(type,
                                                                        idx) in data.types" :key="idx
                                                                            " :command="type
                                                                                ">
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
                    <div class="dropdown-as-select d-inline-block" data-childselector="span">
                        <button class="btn p-0" type="button" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <span class="btn btn-primary dropdown-toggle" data-bs-toggle="tooltip"
                                data-bs-placement="top" data-bs-delay="0" title data-bs-original-title="Item Count"
                                aria-label="Item Count">
                                <i class="fas fa-list"></i>
                            </span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end col-md-2 col-1">
                            <div class="col-12" v-for="(option, idx) in optionsMenu" :key="idx" v-show="option.visible">
                                <el-button v-if="option.visible" @click="trigerFunction(option.id)"
                                    class="btn btn-light m-1 rounded d-flex flex-column align-items-center justify-content-center col-12"
                                    style="max-width: 150px;">
                                    <div class="text-center" style="margin-bottom: 2px">
                                        <p style="margin: 0 !important; padding: 0 !important" v-for="(title,
                                            idx2) in option.title" :key="idx2">
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
                    <list-orden :divided_items.sync="divided_items" @searchFoodByCustomerUnitTypeId="
                        searchFoodByCustomerUnitTypeId
                    " :formQtn.sync="formQtn" :exchange_rate_sale="form.exchange_rate_sale" :users.sync="users"
                        :user.sync="user" :isSeller.sync="isSeller" @sendOrdens="sendOrdens" :company.sync="company"
                        :customer_variation="customer_variation" :variationShow.sync="variation"
                        :customers.sync="all_customers" :establishments="establishments" :itemDefault.sync="itemDefault"
                        :cash_id.sync="cashId" :ordenId.sync="ordenId" :ordensPending.sync="ordensPending"
                        :area_id="area_id" :isCreatingOrden.sync="isCreatingOrden" :blockCart.sync="blockCart"
                        :total2.sync="form.total" :configuration.sync="configuration" :localOrden.sync="localOrden"
                        :ordens.sync="ordensItems" @limpiarForm="limpiarForm" @total_sales="total_sales"
                        @updateOrdens="updateOrdens" @paymentsOrden="paymentsOrden" @deletedFood="deletedFood"
                        @cancelOrden="cancelOrden" @ordenDeleted="createOrden" :clientTableData.sync="clientTableData"
                        :categories.sync="categories" @reloadProduct="search_items" :percentage_igv="percentage_igv"
                        :isRestaurantWarehouse="isRestaurantWarehouse" :currencyIdChoice.sync="currencyIdChoice"
                        ref="listOrdens"></list-orden>
                </div>
                <template>
                    <list-food-mobiles :canAddItem.sync="canAddItem" :loadingItems.sync="loadingItems"
                        :localOrden="localOrden" :blockAdd.sync="blockCart" ref="list_foods" :worker="worker"
                        @insertOrden="insertOrden" :configuration="configuration" :foods.sync="allFoods"
                        @buscarnuevo="buscarnuevo" :category.sync="category"
                        :showDialogViewItems.sync="showDialogViewItems" :categories.sync="categories"
                        :selectOption.sync="selectOption" @data-received="receiveData"
                        @changeCategory="changeCategory"></list-food-mobiles>
                </template>
            </div>
        </div>

        <DrawerOrdens ref="ordenRef" :configuration.sync="configuration" :localOrden.sync="localOrden"
            :ordens.sync="ordensItems" @total_sales="total_sales" @updateOrdens="updateOrdens"
            @paymentsOrden="paymentsOrden" @deletedFood="deletedFood" @ordenDeleted="createOrden"></DrawerOrdens>

        <template>
            <payment-form :user="user" :currencyIdChoice.sync="currencyIdChoice" @clearVariation="clearVariation"
                :promotions_document="promotions_document" :itemDefault.sync="itemDefault"
                :quotationId.sync="quotationId" :clientSaleNoteNumber.sync="clientSaleNoteNumber"
                :clientSaleNoteDiscount.sync="clientSaleNoteDiscount" :sellers.sync="sellers"
                :ordens_all_table.sync="ordens_all_table" :consignment_id="consignment_id"
                @removeConsignment="removeConsignment" :isConsignment.sync="isConsignment" :printer.sync="printer"
                :personalWhatsapp="personalWhatsapp" @getFile="getFile" :customer_default="customer_default"
                :variation.sync="variation" :documentsType="documentsType" :cash_id.sync="cashId"
                :percentage_igv="percentage_igv" :is_payment.sync="is_payment" :form="form" :orden_items="orden_items"
                :establishments="establishments" :company.sync="company" :idOrden="idOrden"
                :all_series.sync="all_series" :payments.sync="payments" :direct_printing="direct_printing"
                :currency-type-id-active="form.currency_type_id" :currency-type-active="currency_type"
                :exchange-rate-sale="form.exchange_rate_sale" :customer="customer" :auth_login="auth_login"
                :configuration="configuration" :desarrollador.sync="desarrollador" @limpiarForm="limpiarForm"
                :orden="ordenId" @openDrawer="openDrawer" @printer="Printer" :all_customers.sync="all_customers"
                :formVariation.sync="formVariation" :customer_variation="customer_variation"
                :affectation_igv_types="affectation_igv_types" @reloadItems="getFoods"
                ref="paymentComponent"></payment-form>
        </template>
        <template v-if="configuration.college">
            <college-parents v-if="showDialogNewPerson" :showDialog.sync="showDialogNewPerson"
                :fromPos="true"></college-parents>
        </template>
        <template v-else>
            <person-form v-if="showDialogNewPerson" :external="false" :showDialog.sync="showDialogNewPerson"
                :fromPos="true"></person-form>
        </template>
        <cash-history :configuration="configuration" :cash_id.sync="cashId" :showHistoryCash.sync="showHistoryCash"
            :area_id="area_id" :sender="personalWhatsapp ? sender : 'sdrimsac'"></cash-history>
        <item-form v-if="showDialogNewItem" :showDialog.sync="showDialogNewItem" :external="true" :worker="worker"
            :fromPos="true"></item-form>
        <college v-if="configuration.college" :showDialog.sync="showDialogCollege" :configuration="configuration"
            :fromPos="true"></college>
        <warehouses-detail v-if="showWarehousesDetail" :showDialog.sync="showWarehousesDetail"
            :warehouses="warehousesDetail" :unit_type="unittypeDetail" :fromPos="true"></warehouses-detail>
        <tables :configuration="configuration" @creatingOrden="creatingOrden" @sendOrdens="sendOrdens"
            :showTables.sync="showTables"></tables>
        <tables-rooms v-if="configuration.hotels" :cash_id.sync="cashId" :configuration="configuration"
            :printer.sync="printer" @getTablesToClean="getTablesToClean" @paymentsOrden="paymentsOrden"
            @creatingOrden="creatingOrden" @roomWasCleaned="roomWasCleaned" @sendOrdens="sendOrdens"
            :roomSeeId="roomSeeId" @modal-closed="modalClosed" :showTables.sync="showTablesRooms"
            :itemDefault.sync="itemDefault" :fromPos="true"></tables-rooms>
        <documents-print :sender="personalWhatsapp ? sender : 'sdrimsac'" :company="company"
            :showDialog.sync="showDocumentsPrint" :config.sync="config" @sendOrdens="sendOrdens"
            @insertOrdenQuotation="insertOrdenQuotation" @sendItems="sendItems" :establishment.sync="establishments"
            :area_id="area_id" :printer.sync="printer" :cash_id.sync="cashId"></documents-print>
        <PromotionCanje :showDialog.sync="showdialogPromocion" :config.sync="config"
            :establishment.sync="establishment">
        </PromotionCanje>
        <credits-list v-if="configuration.sale_note_credit_penalty" :showDialog.sync="showCredits"
            :configuration="configuration" :isAnalist="isAnalist" :user="user" :fromPos="true"></credits-list>
        <unit-type-modal @addUnitType="addUnitType" @addCategoriaMadera="addCategoriaMadera"
            :showDialog.sync="showUnitTypeModal" :medida_alto="medida_alto" :medida_ancho="medida_ancho"
            :medida_grosor="medida_grosor" :categoria_madera="categoria_madera" :item="selectedFood"
            :currentIndex="currentIndex"></unit-type-modal>

        <dispatch-modal :configuration="configuration" :showDialog.sync="showDispatch"></dispatch-modal>
        <category-drag :showDialog.sync="showCategoryDrag"></category-drag>
        <edit-product @getFoods="getFoods" :showDialog.sync="showEditProduct" :allItems="allFoods"></edit-product>

        <el-dialog v-loading="showDailyCashLoading" width="450px" :visible.sync="showPinRequest" title="Ingrese su PIN"
            append-to-body>
            <div class="row mt-1">
                <h5>
                    Para poder visualizar la venta del día de hoy, ingrese su
                    PIN
                </h5>
            </div>

            <div class="row mt-2 d-flex justify-content-center">
                <div class="col-8">
                    <el-input v-model="pin" placeholder="Ingrese su PIN" type="password" maxlength="4"
                        readonly></el-input>
                </div>
                <div class="col-12 d-flex flex-wrap justify-content-center">
                    <el-button v-for="num in [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]" :key="num" class="m-2"
                        @click="generatePin(num)">{{
                            num }}</el-button>
                    <el-button @click="pin = ''" class="m-2" type="danger" icon="el-icon-delete"></el-button>
                </div>
            </div>
            <div slot="footer" class="dialog-footer">
                <el-button @click="showPinRequest = false">Cancelar</el-button>
                <el-button type="primary" @click="checkPin">Enviar</el-button>
            </div>
        </el-dialog>
        <consignment-list @setItemsToLiquidate="setItemsToLiquidate"
            :showDialog.sync="showDialogConsignment"></consignment-list>
        <products-due :showDialog.sync="showDialogDueProducts"></products-due>
        <item-set :showDialog.sync="showDialogItemSet" :external="true"
            :establishment_id.sync="establishmentId"></item-set>
        <sale-note-credit-cash :configuration="configuration" :showDialog.sync="showSaleNoteCreditCash"
            :isCreditCash="isCreditCash"></sale-note-credit-cash>
        <consolidated-list-modal @cancelOrden="cancelOrden" :showDialog.sync="showConsolidatedList"
            @insertOrdenQuotation="insertOrdenQuotation" :configuration="configuration"></consolidated-list-modal>
        <quotation-list-modal :showDialog.sync="showQuotationListDialog"></quotation-list-modal>
        <month-sales :showDialog.sync="showMonthSales"></month-sales>
        <iframe ref="pdfFrame" style="display: none;"></iframe>
        <el-dialog class="no-header" width="90%" top="5vh" title :header="null"
            :visible.sync="showDialogCreditReportDaily" style="color:blue">
            <div style="text-align: right;">
                <el-button type="primary" icon="el-icon-close" @click="closeModal"></el-button>
            </div>
            <x-report-credit-daily-cash></x-report-credit-daily-cash>
            <br />
        </el-dialog>
        <detraction-payment v-if="configuration.detraction" :showDialog.sync="showDialogDetraction"
            :fromPos="true"></detraction-payment>
        <Warranty :showDialog.sync="showDialogWarranty" :fromPos="true"></Warranty>
        <!-- Modal para limpiar mesas/habitaciones -->
        <CleanModal v-if="isHotelArea" :showDialog.sync="showCleanDialog" :tablesClean="tablesClean"
            @cleanTable="onCleanTableFromModal" />
        <!-- Modal de habitaciones vencidas -->
        <ExpiredRoomModal v-if="isHotelArea" :showDialog.sync="showExpiredDialog" :tablesClean="tablesLeave"
            @openRoom="tableOpen" :cash_id.sync="cashId" />
        <Pos-form :showDialog.sync="showDialog" :recordId.sync="recordId" :external="true"
            @addDataMozo="recibirItem"></Pos-form>
        <Pos-library :showDialog.sync="showDialogLibrary" :recordId.sync="recordId" :external="true"></Pos-library>
        <Stock-min :showDialog.sync="showDialogStockMin" :fromPos="true"></Stock-min>
    </div>
</template>

<style>
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
    background-color: #1025e6;
    border-radius: 8px;
    padding: 0;
}

/* estylos para las categorias */
.categories-scroll {
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: thin;
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
// cotizaciones de modal
const Warranty = () => import("./partials/warranty.vue");
const QuotationListModal = () => import("./partials/quotation_list_modal.vue");
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
const DetractionPayment = () => import("./partials/detraction_payment.vue");
const Tables = () => import("./partials/tables.vue");
const TablesRooms = () => import("./partials/tables_rooms.vue");
const CashHistory = () => import("./partials/cash_history.vue");
const DocumentsPrint = () => import("./partials/documents_print.vue");
const PromotionCanje = () =>
    import(
        /* webpackChunkName:"js/promotionscanje"*/
        "./partials/promotionscanje.vue"
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
const MonthSales = () => import("./partials/month_sales.vue");
const SaleNoteCreditCash = () => import("./partials/sale_note_credit_cash.vue")
const CategoryDrag = () => import("./partials/category_drag.vue");
const ProductsDue = () => import("./partials/products_due.vue");
const ItemSet = () =>
    import("../../../../../../../resources/js/views/item_sets/form.vue");
const ConsolidatedListModal = () =>
    import("./partials/consolidated_list_modal.vue");
import UnitTypeModal from "../pos/partials/unit_type_modal.vue";

import DigitalPayComponent from "./partials/digital_pay_component.vue";

import PosForm from "../../../../../../../resources/js/views/items/form_pos.vue";
import PosLibrary from "../../../../../../../resources/js/views/items/form_library.vue";
import StockMin from "./partials/stock_min.vue";
import Swal from "sweetalert2";
const CleanModal = () => import("./partials/clean.vue");
const ExpiredRoomModal = () => import("./partials/expired_room.vue");

const options = {
    text: "Loading ...",
    customClass: "login_loading",
    spinner: "el-icon-loading",
    lock: true
};
export default {
    props: [
        "limit_month_amount",
        "month_amount",
        "pending_order",
        "cash_id",
        "worker",
        "configuration",
        "establishments",
        "auth_login",
        "desarrollador",
        "company",
        "lareaId",
        "area",
        "areaId"
    ],

    computed: {
        canShowHistory() {
            return (
                !this.isSeller &&
                (!this.configuration.kitchen_mozo || !this.cashId)
            );
        }
    },

    watch: {
        cashId: {
            handler() {
                this.setMenuOptions();
            }
        }
    },
    components: {
        StockMin,
        PosLibrary,
        PosForm,
        Warranty,
        MonthSales,
        QuotationListModal,
        UnitTypeModal,
        ConsolidatedListModal,
        DetractionPayment,
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
        PromotionCanje,
        TablesRooms,
        SaleNoteCreditCash,
        Swal,
        CleanModal,
        ExpiredRoomModal
    },
    mixins: [functions, exchangeRate],

    data() {
        return {
            // Control local para alternar el texto del botón (Tabla/Card)
            showDialogLibrary: false,
            showList: false,
            countdown: 0,
            latencia: 0,
            latenciaInterval: null,
            showDialogStockMin: false,
            showDialog: false,
            recordId: null,
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
            policy: false,
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
            showCleanDialog: false,
            showExpiredDialog: false,
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
            printQueue: [],
            isPrinting: false,
            printDelay: 1500
        };
    },
    beforeDestroy() {
        clearInterval(this.timer);
        // Limpiar listener al destruir componente
        this.$eventHub.$off("cashStatusChanged");
    },

    async created() {
        // LOG para ver el valor inicial de percentage_igv
        this.$watch('percentage_igv', function (val) {
            console.log('[LOG] WATCH percentage_igv cambió a:', val, typeof val);
        });
        this.iniciarMedicionLatencia();

        // Sincronizar valor inicial desde el hijo (si ya viene con un estado)
        this.$nextTick(() => {
            if (this.$refs.list_foods && this.$refs.list_foods.form) {
                this.showList = !!this.$refs.list_foods.form.show_list;
            }
        });

        /* await this.$http.get(`/companies/record`).then(response => {
            if (response.data !== "") {
                this.company = response.data.data;
            }
        }); */

        console.log("this.establishments", this.establishments);
        this.area_id = this.worker.area_id;
        this.getExchange();
        this.isSeller = this.checkWorkerType("vendedor");
        /* ; */ this.isAnalist = this.checkWorkerType("analista");
        localStorage.setItem("quotation_stock", 0);
        let type_code = localStorage.getItem("type_code");
        let barcode = localStorage.getItem("barcode");
        let policy = localStorage.getItem("policy");
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
        if (policy) {
            this.policy = policy == "1" ? true : false;
        }
        // ;
        this.conf = this.establishments.conf ?? {};
        this.cashId = this.cash_id;
        this.ordensPending = this.pending_order;
        this.loading = true;
        //this.socketWhatsappConfig();
        await this.getTables();
        await this.initForm(this.customer_default.id);
        await this.getFoods();
        await this.filterCategorie(0, false);
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
            console.log("reloadDataPersons pasa por aqui", customer_id);
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
        console.log("this.percentage_igv", this.percentage_igv, response.data);
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

        if (this.configuration.user_unit) {
            (function () {
                function generateUUID() {
                    return "xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx".replace(
                        /[xy]/g,
                        function (c) {
                            const r = (Math.random() * 16) | 0,
                                v = c === "x" ? r : (r & 0x3) | 0x8;
                            return v.toString(16);
                        }
                    );
                }

                let tabId = sessionStorage.getItem("tab_id");
                if (!tabId) {
                    tabId = generateUUID();
                    sessionStorage.setItem("tab_id", tabId);
                }

                const windowId = generateUUID();

                const basePath = window.location.pathname.split("/")[1];
                const presenceKeyByRoute = `tab_presence_route_${basePath}`;
                const presenceKeyByTab = `tab_presence_tab_${tabId}`;

                let blockerVisible = false;
                let hasDuplicate = false;

                let justLoaded = true;
                setTimeout(() => {
                    justLoaded = false;
                }, 1000);

                function updatePresence() {
                    const now = Date.now();
                    updateKey(presenceKeyByRoute, now);
                    updateKey(presenceKeyByTab, now);
                }

                function updateKey(key, now) {
                    let list = JSON.parse(localStorage.getItem(key) || "[]");

                    const index = list.findIndex(p => p.windowId === windowId);
                    if (index === -1) {
                        list.push({ windowId, time: now });
                    } else {
                        list[index].time = now;
                    }

                    list = list.filter(p => now - p.time < 1000);
                    localStorage.setItem(key, JSON.stringify(list));

                    checkForDuplicates(list);
                }

                function checkForDuplicates(allLists) {
                    if (justLoaded) return;

                    const now = Date.now();
                    const hasDupRoute =
                        JSON.parse(
                            localStorage.getItem(presenceKeyByRoute) || "[]"
                        ).filter(p => now - p.time < 1000).length > 1;

                    const hasDupTab =
                        JSON.parse(
                            localStorage.getItem(presenceKeyByTab) || "[]"
                        ).filter(p => now - p.time < 1000).length > 1;

                    hasDuplicate = hasDupRoute || hasDupTab;

                    if (hasDuplicate && !blockerVisible) {
                        blockerVisible = true;
                        Swal.fire({
                            title: "¡Pestaña duplicada detectada!",
                            text:
                                "Ya tienes una ventana activa en este módulo o con esta sesión. Por favor, cierra las demás para evitar errores.",
                            icon: "warning",
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            showConfirmButton: false,
                            backdrop: true,
                            didOpen: () => {
                                document.body.style.pointerEvents = "none";
                            }
                        });
                    }

                    // Solo cerramos si no hay duplicados y el Swal está visible
                    if (!hasDuplicate && blockerVisible) {
                        blockerVisible = false;
                        Swal.close();
                        document.body.style.pointerEvents = "auto";
                    }
                }

                setTimeout(updatePresence, 100);
                setInterval(updatePresence, 500);

                window.addEventListener("storage", function (event) {
                    if (
                        (event.key === presenceKeyByRoute ||
                            event.key === presenceKeyByTab) &&
                        !justLoaded
                    ) {
                        checkForDuplicates();
                    }
                });
            })();
        }
    },
    sockets: {},
    computed: {
        formattedCountdown() {
            // Convierte los segundos a minutos y segundos
            const minutes = Math.floor(this.countdown / 60);
            const seconds = this.countdown % 60;
            return `${minutes
                .toString()
                .padStart(2, "0")}:${seconds.toString().padStart(2, "0")}`;
        },
        formattedLatencia() {
            if (this.latencia === -1) {
                return "Sin conexión";
            } else if (this.latencia === 0) {
                return "Midiendo...";
            } else {
                return `${this.latencia}ms`;
            }
        },
        canShowHistory() {
            return (
                !this.isSeller &&
                (!this.configuration.kitchen_mozo || !this.cashId)
            );
        },
        limitAmount() {
            if (this.limit_month_amount == 0) {
                return null;
            }
            const porcentaje =
                (this.month_amount / this.limit_month_amount) * 100;

            if (porcentaje < 70) {
                return null;
            }

            if (porcentaje >= 70 && porcentaje < 100) {
                return {
                    tipo: "advertencia",
                    mensaje: `¡Facturación casi al tope!`,
                    color: "warning"
                };
            }

            return {
                tipo: "critico",
                mensaje: `¡Límite mensual superado!`,
                color: "danger"
            };
        },
        isAndroid() {
            return this.establishments.android_configuration;
        },
        isCreditCash() {
            return this.establishments.credit_warehouse;
        },
        isRestaurantWarehouse() {
            return this.establishments.account_workers;
        },
        isSellerConsolidated() {
            return (
                this.isSeller &&
                this.configuration.consolidated_quotations &&
                !this.configuration.consolidated_quotation_details
            );
        },
        canAddItem() {
            if (
                this.isSeller &&
                this.configuration.consolidated_quotations &&
                !this.configuration.consolidated_quotation_details
            ) {
                return !(
                    this.customer_unit_type_id == null ||
                    this.customer_unit_type_id == ""
                );
            }
            return true;
        }
    },

    methods: {
        toggleView() {
            // Alternar estado local
            this.showList = !this.showList;
            // Propagar al hijo si existe
            if (this.$refs.list_foods && this.$refs.list_foods.form) {
                this.$refs.list_foods.form.show_list = this.showList;
            }
        },
        formatUrlImage(url) {
            if (!url) return;
            let formated = "storage/uploads/items/" + url;
            return `/${formated}`;
        },
        modalClosed() {
            // Cerrar el modal de habitaciones si sigue abierto
            this.showTablesRooms = false;
            this.getTablesToClean();
            this.getTablesToLeave();
        },
        iniciarMedicionLatencia() {
            // Guardar el id del intervalo para poder detenerlo después
            try {
                if (this._latencyIntervalId) {
                    clearInterval(this._latencyIntervalId);
                }
            } catch (e) {}

            this._latencyIntervalId = setInterval(async () => {
                const valor = await this.medirLatencia();
                this.latencia = valor;
                //console.log("⏱️ Latencia medida:", valor, "ms");
            }, 2000); // Cada 2 segundos

            // Fallback global reference (algunos componentes pueden usar ventana global)
            try {
                window.__latencyIntervalId = this._latencyIntervalId;
            } catch (e) {}
        },
        async medirLatencia() {
            // Usa la función existente para medir la latencia con una imagen
            return await this.medirLatenciaConImagen();
        },
        getPingBackground() {
            if (this.latencia === -1) return "#6b7280"; // Gris: sin datos
            if (this.latencia < 90) return "#22c55e"; // Verde
            if (this.latencia < 150) return "#facc15"; // Amarillo
            return "#ef4444"; // Rojo
        },
        medirLatenciaConImagen(url = "https://i.imgur.com/ZKnb2Tt.png") {
            return new Promise(resolve => {
                const start = performance.now();
                const img = new Image();

                img.onload = () => {
                    const end = performance.now();
                    resolve(Math.round((end - start) / 2));
                };

                img.onerror = () => {
                    resolve(-1);
                };

                // Prevenir caché
                img.src = `${url}?_=${Date.now()}`;
            });
        },

        iniciarMedicionLatencia() {
            // Guardar el id del intervalo para poder detenerlo después
            try {
                if (this._latencyIntervalId) {
                    clearInterval(this._latencyIntervalId);
                }
            } catch (e) {}

            this._latencyIntervalId = setInterval(async () => {
                const valor = await this.medirLatencia();
                this.latencia = valor;
                //console.log("⏱️ Latencia medida:", valor, "ms");
            }, 2000); // Cada 2 segundos

            // Fallback global reference (algunos componentes pueden usar ventana global)
            try {
                window.__latencyIntervalId = this._latencyIntervalId;
            } catch (e) {}
        },
        async ItemNew(productId) {
            try {
                const response = await this.$http.get(
                    `${this.resource}/item/${productId}`
                );
                console.log("Response data:", response.data);

                const checkListFoods = () => {
                    if (this.$refs.list_foods) {
                        console.log(
                            "📩 list_foods está listo, emitiendo evento"
                        );
                        this.$root.$emit("itemnew", response.data);
                    } else {
                        console.log(
                            "⏳ Esperando a que list_foods esté listo..."
                        );
                        setTimeout(checkListFoods, 100); // Revisar cada 100ms
                    }
                };

                checkListFoods();
            } catch (error) {
                console.error(
                    "Error al obtener el producto del backend:",
                    error
                );
            }
        },
        recibirItem(data) {
            console.log("Producto recibido:", data);
            this.ItemNew(data.id);
        },

        createdNew() {
            this.showDialog = true;
        },
        createdNewLibrary() {
            this.showDialogLibrary = true;
        },
        async updateCashId(id) {
            // Cuando se abre la caja
            this.$eventHub.$emit("cashStatusChanged", {
                status: "open",
                cashId: id
            });
            this.$emit("update:cash_id", id);
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
                caches.keys().then(function (cacheNames) {
                    console.log(cacheNames);
                    cacheNames.forEach(function (cacheName) {
                        caches.delete(cacheName);
                    });
                });
            }

            navigator.serviceWorker
                ?.getRegistrations()
                .then(function (registrations) {
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
            console.log(
                "insertOrdenQuotation como llega los items aqui",
                quotation_id,
                identifier,
                item,
                customer_number
            );
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
                console.log(
                    "categoriaMadera ver si llegan los datos correctos",
                    categoriaMadera,
                    item.categoriaMadera
                );
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
            if (!this.cashId) {
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
            /* if (response.status == 200) {
                this.tablesClean = this.tablesClean.filter(t => t.id != id);
            } */
            if (response.status == 200) {
                // Si el backend retorna success: false, mostramos el mensaje de error
                if (response.data && response.data.success === false) {
                    this.$showSAlert(
                        "ALERTA",
                        response.data.message,
                        "warning"
                    );
                    return;
                }
                this.tablesClean = this.tablesClean.filter(t => t.id != id);
            }
        },
        roomWasCleaned(id) {
            this.tablesClean = this.tablesClean.filter(t => t.id != id);
        },
        onCleanTableFromModal(table) {
            if (!table || !table.id) return;
            this.isCleaned(table.id);
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
            } catch (e) { }
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
                            t.timer = `${hours < 10 ? "0" : ""}${hours}:${minutes < 10 ? "0" : ""
                                }${minutes}:${seconds < 10 ? "0" : ""}${seconds}`;
                        } else {
                            t.timer = `${minutes < 10 ? "0" : ""}${minutes}:${seconds < 10 ? "0" : ""
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
                        t.time_to_finish = `${minutes < 10 ? "0" : ""
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
                    id: 256,
                    title: ["Garantia"],
                    icon: "fa fa-guarantee",
                    visible: true && this.configuration.warranty_product
                },
                {
                    id: 74,
                    title: ["Venta del mes"],
                    icon: "fas fa-history ",
                    visible:
                        true && this.establishments.is_product && this.cashId
                },
                {
                    id: 63,
                    title: ["Cot.", "Consolidaciones"],
                    icon: "fas fa-money-check-alt",
                    visible:
                        this.configuration.consolidated_quotations &&
                        !this.isSeller
                },
                {
                    id: 214,
                    title: ["Cotizaciones"],
                    icon: "fas fa-money-check-alt",
                    visible: this.configuration.consolidated_quotations
                },
                {
                    id: 97,
                    title: ["Pagos", "Detracciones"],
                    icon: "fas fa-money-check-alt",
                    visible: this.configuration.detraction && this.cashId
                },
                {
                    id: 1,
                    title: ["Comprobantes"],
                    icon: "fas fa-print ",
                    visible: true && !this.isSeller
                },

                {
                    id: 3,
                    title: ["Productos"],
                    icon: "fas fa-box-open",
                    visible: this.configuration.product_cash && this.cashId
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
                    id: 5,
                    title: [" Zona "],
                    icon: "fas fa-map-pin ",
                    visible:
                        !this.isSeller &&
                        this.cashId &&
                        this.configuration.restaurant &&
                        !this.configuration.college &&
                        this.worker.area.description.toUpperCase() !==
                        "HOTEL" &&
                        this.worker.area.description.toUpperCase() !==
                        "CAJA PISCINA"
                },

                {
                    id: 195,
                    title: [" Créditos", "Nota de venta "],
                    icon: "fas fa-cash-register",
                    visible:
                        this.cashId &&
                        this.isCreditCash &&
                        !this.isSeller
                },
                {
                    id: 171,
                    title: [" Habitaciones "],
                    icon: "fas fa-map-pin ",
                    visible:
                        this.configuration.hotels &&
                        this.cashId &&
                        this.worker.area.description.toUpperCase() == "HOTEL" &&
                        !this.isSeller &&
                        !this.isAnalist
                },
                {
                    id: 6,
                    title: ["Venta", "del Dia"],
                    icon: "icofont-money-bag",
                    visible:
                        (this.configuration.view_daily_cash ||
                            this.configuration.view_daily_cash_pin) &&
                        this.cashId &&
                        !this.isSeller
                },

                {
                    id: 7,
                    title: ["Historial", ""],
                    icon: "fas fa-history ",
                    visible:
                        !this.isSeller &&
                        (!this.configuration.kitchen_mozo || !this.cashId)
                },

                {
                    id: 9,
                    title: ["Matriculas", "Mensualidades"],
                    icon: "fas fa-user-edit",
                    visible:
                        this.configuration.college &&
                        !this.isSeller &&
                        this.cashId
                },
                {
                    id: 10,
                    title: ["Canjear", "Promocion"],
                    icon: "fas fa-user-tag",
                    visible:
                        this.configuration.promotions_sell &&
                        !this.isSeller &&
                        this.cashId
                },
                {
                    id: 33,
                    title: ["Créditos"],
                    icon: "fas fa-credit-card",
                    visible: this.configuration.credits && !this.isSeller
                },
                /* {
                    id: 25,
                    title: ["Guías", "Remisión"],
                    icon: "fas fa-file",
                    visible: this.configuration.dispatch && !this.isSeller && this.cashId
                }, */
                {
                    id: 102,
                    title: ["Cambiar", "Categorías"],
                    icon: "fa fa-bars",
                    visible:
                        this.configuration.pos_drag_category &&
                        !this.isSeller &&
                        this.cashId
                },
                {
                    id: 103,
                    title: ["Editar", "Productos"],
                    icon: "fa fa-edit",
                    visible: this.configuration.edit_product_pos && this.cashId
                },
                {
                    id: 109,
                    title: ["Ver", "Consignaciones"],
                    icon: "fa fa-edit",
                    visible: this.configuration.consignment && !this.isSeller
                },
                {
                    id: 42,
                    title: ["Productos", "Por vencer", this.products_to_due],
                    icon: "far fa-calendar-alt",
                    visible: this.configuration.items_due_caja && !this.isSeller
                },
                {
                    id: 32,
                    title: ["Crear", "Producto compuesto"],
                    icon: "el-icon-connection",
                    visible: this.configuration.item_set_caja && !this.isSeller
                },
                {
                    id: 34,
                    title: ["Reporte", "Diario Crédito"],
                    icon: "el-icon-connection",
                    visible: this.configuration.sale_note_credit_confirm
                }
                /* {
                    id: 35,
                    title: ["Stock Minimo"],
                    icon: "el-icon-set-up",
                    visible: true && !this.isSeller
                } */

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
        saveInLocalStoragePolicy(policy) {
            localStorage.setItem("policy", policy ? "1" : "0");
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
            if (!this.cashId) {
                this.$message({
                    showClose: true,
                    message:
                        "Debe abrir una caja para poder realizar operaciones",
                    type: "warning"
                });
                return;
            }

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
            } catch (e) { }
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
                    this.establishment.description +
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
            console.log(
                "creatingOrden",
                number,
                id,
                is_room,
                this.clientTableData
            );
            // Limpiar localOrden y clientTableData en el padre
            this.localOrden = [];
            this.clientTableData = {};
            // Luego setear la nueva mesa seleccionada (si aplica)
            this.clientTableData = {
                ref: undefined,
                table: number,
                table_id: id,
                is_room,
                customer_id: undefined,
                correlative: undefined
            };
            console.log(
                "clientTableData después de crear orden",
                this.clientTableData
            );
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
                this.ordens[i].food.item.item_codes = item.item_codes
                    ? [...item.item_codes]
                    : [];
                this.ordens[i].food.item.sale_unit_price = item.price;
                this.ordens[i].food.price = item.price;
                // this.ordens[i].food.item.price = item.price;
                this.ordens[i].food.item.toWarehouse = item.toWarehouse;
                this.ordens[i].food.item.consignment_item_id =
                    item.consignment_item_id;
                // --- Propagación de descuentos hacia el pago ---
                // Intentar obtener el valor de descuento total ya calculado
                // Reiniciar total_discount por defecto
                let discountValue = 0;
                // Solo asignar si hay descuento explícito
                const discountFieldNames = [
                    'discount_total',
                    'discount',
                    'discount_amount',
                    '_discount_amount',
                    'item_discount',
                    'dscto',
                    'descuento'
                ];
                for (let df of discountFieldNames) {
                    if (item[df] !== undefined && item[df] !== null && Number(item[df]) > 0) {
                        discountValue = Number(item[df]);
                        break;
                    }
                }
                // Si no hay descuento explícito, limpiar total_discount
                this.ordens[i].food.item.total_discount = discountValue;
                // Clonar el arreglo de descuentos si existe, sino arreglo vacío
                this.ordens[i].food.item.discounts = item.discounts ? JSON.parse(JSON.stringify(item.discounts)) : [];
                if (possibleOriginalPrice && !this.ordens[i].food.item.original_price) {
                    this.ordens[i].food.item.original_price = possibleOriginalPrice;
                }
                // ------------------------------------------------
            }

            this.form.items = this.ordens.map(o => o.food.item);
            this.formatItems();

            this.calculateTotal();
            this.form.enter_amount = this.form.total;
            this.form.difference = 0;
            let flag = 0;
            this.form.establishment_id = this.establishment.id;
            // Si no hay cliente válido, usar el cliente por defecto del establecimiento
            if (
                !this.form.customer_id ||
                !this.all_customers?.some(c => c.id === this.form.customer_id)
            ) {
                const varios = this.all_customers?.find(a =>
                    a.name?.toLowerCase()?.includes("varios")
                );
                this.form.customer_id =
                    (this.customer_default && this.customer_default.id) ||
                    (varios && varios.id) ||
                    (this.all_customers && this.all_customers[0]?.id) ||
                    null;

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

            if (orden.customer_id) {
                this.customerId = orden.customer_id;
                console.log(
                    "orden.customer_id si tiene datos",
                    orden.customer_id
                );
            }

            if (orden.mesa != undefined && orden.id != undefined) {
                this.clientTableData = {
                    table: orden.mesa.number,
                    ref: orden.ref ?? "-",
                    table_id: orden.mesa.id,
                    orden_id: orden.id,
                    is_room: orden.mesa.is_room,
                    customer_id: orden.customer_id,
                    correlative: orden.correlative
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
        trigerFunction(id) {
            switch (id) {
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
                    if (this.cashId) {
                        this.showSaleNoteCreditCash = true;
                    } else {
                        this.$toast.warning(
                            "No puede abrir créditos mientras la caja está cerrada"
                        );
                        return;
                    }
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
                case 35:
                    this.showDialogStockMin = true;
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
            if (!this.isAndroid) {
                this.$refs.input_items.$el
                    .getElementsByTagName("input")[0]
                    .focus();
            }
            this.$refs.input_items.$el.getElementsByTagName("input")[0].value =
                "";
            if (this.configuration.all_items_pos) {
                this.search_items();
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
                total_discount: Number(i.total_discount || 0),
                total: i.sale_unit_price * i.quantity,
                price_type_id: "01",
                unit_price: i.sale_unit_price,
                unit_price_value: i.sale_unit_price,
                has_igv: i.has_igv,
                affectation_igv_type_id: i.sale_affectation_igv_type_id,
                unit_price: i.sale_unit_price,
                presentation: null,
                charges: [],
                discounts: i.discounts ? JSON.parse(JSON.stringify(i.discounts)) : [],
                attributes: [],
                affectation_igv_type: i.sale_affectation_igv_type_id
            };
        },

        async paymentsOrden(form, variationItem = []) {
            console.log("paymentsOrden recibida:", form);
            console.log("variationItem recibida:", variationItem);
            this.orden_items = form;
            console.log("orden_items seteada:", this.orden_items);
            this.form.printDocument = form.printDocument;
            this.form.is_room = form.is_room;
            this.form.advance = form.advance;
            this.form.is_reserve = form.is_reserve;
            this.form.offert = form.offert;
            this.form.to_carry = form.to_carry;
            this.form.comercial_treatment_id = form.comercial_treatment_id;
            this.form.ref = form.ref;
            this.form.customer_id = form.customer_id ? form.customer_id : 1;

            // Propagar banderas de impresión opcionales
            this.form.printerDefault = form.printerDefault;
            if (this.form.is_room) {
                if (form.customer_id) {
                    this.form.customer_id = form.customer_id;
                }
                this.form.vacate = false;
                this.form.credit_line = form.credit_line;
                this.form.promotion_sale = form.promotion_sale;
                this.form.printerOn = form.printerOn;
                this.form.hotel_rent_item_service_id =
                    form.hotel_rent_item_service_id;
                this.form.is_list_credit = form.is_list_credit;
                this.form.orden_ids = form.orden_ids;
                this.form.hotel_rent_item_ids = form.hotel_rent_item_ids;
                this.form.is_advance = form.is_advance;
                this.form.hotel_rent_id = form.hotel_rent_id;
                this.form.hotel_customer_number = form.customer_number;
                //this.form.advance = form.advance;
                //this.form.is_reserve = form.is_reserve;

                //this.form.caja = true;
            }
            let { items } = form;
            console.log("items recibidos en paymentsOrden:", items);

            this.ordens = [...items];

            let ixd = [];

            for (let i = 0; i < items.length; i++) {
                let item = JSON.parse(JSON.stringify(items[i]));
                // Solo asignar descuento si hay campo explícito
                let discountValue = 0;
                const discountFieldNames = [
                    'total_discount',
                    'discount_total',
                    'discount',
                    'discount_amount',
                    '_discount_amount',
                    'item_discount',
                    'dscto',
                    'descuento'
                ];
                for (let df of discountFieldNames) {
                    if (item[df] !== undefined && item[df] !== null && Number(item[df]) > 0) {
                        discountValue = Number(item[df]);
                        break;
                    }
                }
                this.ordens[i].food.item.categoriaMadera = item.categoriaMadera;
                this.ordens[i].food.item.from_unit_type_id = item.type_id;
                this.ordens[i].food.item.from_unit_type_id_desc = item.type_description;
                this.ordens[i].food.item.quantity = item.quantity;
                this.ordens[i].food.item.lotes = item.lotes;
                this.ordens[i].food.item.lots = item.series;
                this.ordens[i].food.item.color_size = item.color_size ? [...item.color_size] : [];
                this.ordens[i].food.item.sale_unit_price = item.price;
                ixd.push(item.price);
                this.ordens[i].food.price = item.price;
                // this.ordens[i].food.item.price = item.price;
                this.ordens[i].food.item.toWarehouse = item.toWarehouse;
                this.ordens[i].food.item.consignment_item_id = item.consignment_item_id;
                // Copiar montos precalculados si llegan desde list_ordens
                if (item._total_line !== undefined) {
                    this.ordens[i].food.item._total_line = item._total_line;
                    console.log("Asignado total_line:", this.ordens[i].food.item._total_line);
                }
                if (item._base !== undefined) {
                    this.ordens[i].food.item._base = item._base;
                    console.log("Asignado base:", this.ordens[i].food.item._base);
                }
                if (item._igv !== undefined) {
                    this.ordens[i].food.item._igv = item._igv;
                    console.log("Asignado igv:", this.ordens[i].food.item._igv);
                }
                if (item.total !== undefined) {
                    this.ordens[i].food.item.total = item.total;
                }
                if (item.total_value !== undefined) {
                    this.ordens[i].food.item.total_value = item.total_value;
                }
                if (item.affectation_igv_type_id !== undefined && !this.ordens[i].food.item.sale_affectation_igv_type_id) {
                    this.ordens[i].food.item.sale_affectation_igv_type_id = item.affectation_igv_type_id;
                }
                if (item.sale_affectation_igv_type_id !== undefined) {
                    this.ordens[i].food.item.sale_affectation_igv_type_id = item.sale_affectation_igv_type_id;
                }
                // Asignar descuento solo si es explícito, si no limpiar
                this.ordens[i].food.item.total_discount = discountValue;
                // Preservar arreglo de descuentos si existe
                this.ordens[i].food.item.discounts = item.discounts ? JSON.parse(JSON.stringify(item.discounts)) : [];
                console.log("Descuento asignado al item:", this.ordens[i].food.item.total_discount, this.ordens[i].food.item.discounts);
                // Guardar precio original si estaba y no lo teníamos
                const possibleOriginalPrice = item.original_price || item.sale_unit_price_original || item.price_original || item.sale_unit_price_before || item.unit_price_before || null;
                if (possibleOriginalPrice && !this.ordens[i].food.item.original_price) {
                    this.ordens[i].food.item.original_price = possibleOriginalPrice;
                }
            }
            if (variationItem.length > 0) {
                this.variation = true;
                // Log antes de mapear
                const itemsFormateados = variationItem.map(o => this.formatVariation(o));
                this.formVariation.items = [
                    ...itemsFormateados
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
            // Si no hay cliente válido, usar el cliente por defecto del establecimiento
            if (
                !this.form.customer_id ||
                !this.all_customers?.some(c => c.id === this.form.customer_id)
            ) {
                const varios = this.all_customers?.find(a =>
                    a.name?.toLowerCase()?.includes("varios")
                );
                this.form.customer_id =
                    (this.customer_default && this.customer_default.id) ||
                    (varios && varios.id) ||
                    (this.all_customers && this.all_customers[0]?.id) ||
                    null;
                if (!this.form.customer_id) {
                    this.is_payment = false;
                    return this.$toast.error("Seleccione un cliente");
                }
            } else {
            }

            // A partir de aquí se finaliza el flujo para ambos casos (con cliente válido o asignado por defecto)
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
            this.is_payment = true;

            if (this.form.is_room && this.form.promotion_sale) {
                await this.$nextTick();

                setTimeout(() => {
                    if (this.$refs.paymentComponent) {
                        this.$refs.paymentComponent.$emit("auto-payment");
                    } else {
                        console.warn("Componente de pago no encontrado");
                    }
                }, 500);
            }
        },

        formatVariation(i) {
            console.log("[LOG] formatVariation recibe:", i);
            const result = {
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
            console.log("[LOG] formatVariation retorna:", result);
            return result;
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
        async insertItemFromNoteSales() { },
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
            color_size = [],
            value = null
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
                if (color_size.length > 0 && color_size[0].price) {
                    orden.price = color_size[0].price;
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
                            unit_type.price3,
                            unit_type.unique_code
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

                // LOGS para depuración de códigos
                console.log("[SCAN] input_item:", this.input_item);

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
                    let realIndex = this.localOrden.findIndex(
                        p => p.id == food_id && p.type_id == type.id
                    );
                    let realItem =
                        realIndex !== -1
                            ? this.localOrden[realIndex].food.item
                            : orden.food.item;
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
                                    unit_type.price3,
                                    unit_type.unique_code
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
                        // Unificar lógica de escaneo de códigos de barras
                        /* if (
                            Array.isArray(orden?.food?.item?.item_codes) &&
                            this.barcode === true &&
                            this.input_item
                        ) {
                            // Buscar el objeto real en localOrden (para presentaciones usar type_id)
                            let realIndex = this.localOrden.findIndex(
                                p => p.id == food_id && p.type_id == type.id
                            );
                            let realItem =
                                realIndex !== -1
                                    ? this.localOrden[realIndex].food.item
                                    : orden.food.item;

                            const scanned = String(this.input_item)
                                .trim()
                                .toLowerCase();

                            // Inicializar _all_item_codes si no existe o está vacía
                            if (
                                !Array.isArray(realItem._all_item_codes) ||
                                realItem._all_item_codes.length === 0
                            ) {
                                realItem._all_item_codes = [
                                    ...realItem.item_codes
                                ];
                            } else {
                                // Si el código escaneado no está en _all_item_codes pero sí en item_codes, agregarlo
                                const existsInAll = realItem._all_item_codes.some(
                                    c =>
                                        String(c.code_barcode)
                                            .trim()
                                            .toLowerCase() === scanned
                                );
                                const existsInItemCodes = realItem.item_codes.some(
                                    c =>
                                        String(c.code_barcode)
                                            .trim()
                                            .toLowerCase() === scanned
                                );
                                if (!existsInAll && existsInItemCodes) {
                                    const codeToAdd = realItem.item_codes.find(
                                        c =>
                                            String(c.code_barcode)
                                                .trim()
                                                .toLowerCase() === scanned
                                    );
                                    realItem._all_item_codes.push(codeToAdd);
                                    console.log(
                                        "[SCAN] Se agregó el código escaneado a _all_item_codes:",
                                        codeToAdd
                                    );
                                }
                            }

                            if (!Array.isArray(realItem.item_codes_scanned)) {
                                this.$set(realItem, "item_codes_scanned", []);
                            }

                            console.log(
                                "[SCAN] _all_item_codes:",
                                realItem._all_item_codes
                            );
                            console.log(
                                "[SCAN] item_codes_scanned antes:",
                                realItem.item_codes_scanned
                            );

                            const foundCode = realItem._all_item_codes.find(
                                c =>
                                    String(c.code_barcode)
                                        .trim()
                                        .toLowerCase() === scanned
                            );

                            if (!foundCode) {
                                this.$toast.error(
                                    "Código no válido para este producto."
                                );
                                this.input_item = "";
                                return;
                            }

                            const alreadyScanned = realItem.item_codes_scanned.some(
                                c =>
                                    String(c.code_barcode)
                                        .trim()
                                        .toLowerCase() === scanned
                            );

                            if (alreadyScanned) {
                                this.$toast.warning(
                                    "Este código ya fue escaneado."
                                );
                                this.input_item = "";
                                return;
                            }

                            realItem.item_codes_scanned.push(foundCode);
                            // Mostrar el contenido real del array, no el Observer
                            try {
                                console.log(
                                    "[SCAN] item_codes_scanned después (raw):",
                                    JSON.parse(
                                        JSON.stringify(
                                            realItem.item_codes_scanned
                                        )
                                    )
                                );
                                console.log(
                                    "[SCAN] item_codes_scanned count:",
                                    realItem.item_codes_scanned.length
                                );
                                console.log(
                                    "[SCAN] Último agregado:",
                                    foundCode
                                );
                                console.log(
                                    "[SCAN] Todos los code_barcode:",
                                    realItem.item_codes_scanned.map(
                                        c => c.code_barcode
                                    )
                                );
                            } catch (e) {
                                console.log(
                                    "[SCAN] item_codes_scanned después (fallback):",
                                    realItem.item_codes_scanned
                                );
                            }
                        } */

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
                        console.log("color_size pasa por aqui", color_size);
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
                    /* let indexFind = this.localOrden.findIndex(
                        orden =>
                            orden.categoriaMadera &&
                            orden.categoriaMadera.key == categoriaMadera.key
                    ); */
                    let indexFind = this.localOrden.findIndex(
                        orden =>
                            orden.categoriaMadera &&
                            orden.categoriaMadera.key == categoriaMadera.key &&
                            orden.categoriaMadera.medida ==
                            categoriaMadera.medida &&
                            orden.categoriaMadera.price == categoriaMadera.price
                    );
                    if (indexFind != -1) {
                        this.localOrden[indexFind].quantity =
                            Number(this.localOrden[indexFind].quantity) +
                            (categoriaMadera.quantity || 1);
                        // Number(type.quantity_unit);
                    } else {
                        // orden.quantity = Number(type.quantity_unit);

                        /* if (categoriaMadera.price) {
                            orden.quantity = categoriaMadera.quantity;
                            orden.price = categoriaMadera.price;
                            orden.categoriaMadera = categoriaMadera;
                        } */

                        if (categoriaMadera.price) {
                            orden.quantity = Number(orden.quantity) || 1; // <-- BIEN: usa el quantity del item principal
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
                    let realIndex = this.localOrden.findIndex(
                        p => p.id == food_id && p.type_id == null
                    );
                    let realItem =
                        realIndex !== -1
                            ? this.localOrden[realIndex].food.item
                            : orden.food.item;
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
                        /* if (color_size.length > 0) {
                            let existingColorSize = this.localOrden[indexFind]
                                .color_size;
                            console.log("existingColorSize", existingColorSize);

                            for (let newColor of color_size) {
                                let existingColor = existingColorSize.find(
                                    c =>
                                        c.code === newColor.code &&
                                        c.price === newColor.price
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
                        } */

                        if (color_size && color_size.length > 0) {
                            // Agrupar color_size por precio
                            let prices = Array.from(
                                new Set(color_size.map(c => c.price))
                            );
                            for (let price of prices) {
                                let color_size_group = color_size.filter(
                                    c => c.price == price
                                );
                                // Buscar si ya existe una orden con ese food_id y ese precio
                                let indexFind = this.localOrden.findIndex(
                                    o =>
                                        o.id == food_id &&
                                        o.price == Number(price)
                                );
                                if (indexFind !== -1) {
                                    // Sumar cantidades de color_size existentes
                                    for (let newColor of color_size_group) {
                                        let existingColor = this.localOrden[
                                            indexFind
                                        ].color_size.find(
                                            c =>
                                                c.code === newColor.code &&
                                                c.price === newColor.price
                                        );
                                        if (existingColor) {
                                            existingColor.quantity =
                                                Number(existingColor.quantity) +
                                                Number(newColor.quantity || 1);
                                        } else {
                                            this.localOrden[
                                                indexFind
                                            ].color_size.push({
                                                ...newColor,
                                                quantity: Number(
                                                    newColor.quantity || 1
                                                )
                                            });
                                        }
                                    }
                                    // Actualizar cantidad total
                                    this.localOrden[
                                        indexFind
                                    ].quantity = this.localOrden[
                                        indexFind
                                    ].color_size.reduce(
                                        (a, b) => a + Number(b.quantity),
                                        0
                                    );
                                } else {
                                    // Crear nueva orden para este grupo de color_size y precio
                                    let newOrden = JSON.parse(
                                        JSON.stringify(orden)
                                    );
                                    newOrden.color_size = [...color_size_group];
                                    newOrden.price = Number(price);
                                    newOrden.quantity = color_size_group.reduce(
                                        (a, b) => a + Number(b.quantity || 1),
                                        0
                                    );
                                    newOrden.original_price = newOrden.price;
                                    if (
                                        this.configuration.order_desc_items ==
                                        true
                                    ) {
                                        this.localOrden.push(newOrden);
                                    } else {
                                        this.localOrden.unshift(newOrden);
                                    }
                                }
                            }
                            return;
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
                        this.$refs.list_orden.changeCurrencyItems();
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
                        this.$refs.list_orden.changeCurrencyItems();
                    }
                }

                this.localOrden = [...this.localOrden];
                this.localOrden = this.changeCurrencyItems();
            }
            this.$refs.ordenRef.calculateTotal();
            // Aseguramos recalcular el total en el propio componente
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
            } catch (e) { }
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
        selectTable(row, index) {
            console.log("Mesa seleccionada:", row, index);
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

            // Limpia las órdenes si la mesa seleccionada no tiene órdenes
            if (
                !this.tableSelect.ordens ||
                this.tableSelect.ordens.length === 0
            ) {
                console.log("No hay órdenes para esta mesa");
                this.ordensItems = [];
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
                    `/caja/worker/totales_sales_usd?cash_id=${this.cashId}&send=1`
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
        clickClose: function () {
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
                due_date: null,
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
            console.log('[LOG] index.vue clickPayment - percentage_igv:', this.percentage_igv);
            this.formatItems();
            this.form.enter_amount = this.form.total;
            this.form.difference = 0;
            let flag = 0;

            if (this.ordens[0].food.price == 0 && this.selectOption == 2) {
                return this.$toast.error("Ingrese el Precio por consumo");
            }
            // Si no hay cliente válido, usar el cliente por defecto del establecimiento
            if (
                !this.form.customer_id ||
                !this.all_customers?.some(c => c.id === this.form.customer_id)
            ) {
                const varios = this.all_customers?.find(a =>
                    a.name?.toLowerCase()?.includes("varios")
                );
                this.form.customer_id =
                    (this.customer_default && this.customer_default.id) ||
                    (varios && varios.id) ||
                    (this.all_customers && this.all_customers[0]?.id) ||
                    null;
                if (!this.form.customer_id) {
                    return this.$toast.error("Seleccione un cliente");
                }
            }
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
            console.log('[LOG] index.vue formatItems - percentage_igv:', this.percentage_igv, typeof this.percentage_igv);
            this.form.items = this.form.items.map(i => {
                // Si vienen montos precalculados desde la lista de órdenes, respétalos
                const comesPrecalc = (
                    i._base !== undefined && i._igv !== undefined && i._total_line !== undefined
                ) || (i.total !== undefined && i.total_value !== undefined);
                const hasTotalOnly = (
                    i.total !== undefined && i._total_line === undefined && i.total_value === undefined
                );
                // Permitir que 'discount' (campo simple) alimente total_discount si total_discount viene vacío
                const discountRaw = (i.total_discount !== undefined && i.total_discount !== null)
                    ? i.total_discount
                    : (i.discount !== undefined ? i.discount : 0);
                const discount = Number(discountRaw || 0);
                const qty = Number(i.quantity || 0);
                const price = Number(
                    i.sale_unit_price ?? i.unit_price ?? i.price ?? i.item?.sale_unit_price ?? 0
                );
                const gross = price * qty;
                const affectationId = String(
                    i.sale_affectation_igv_type_id ??
                    i.affectation_igv_type_id ??
                    i.item?.sale_affectation_igv_type_id ??
                    i.item?.affectation_igv_type_id ??
                    ''
                );
                const taxable = affectationId === '10';
                const percentage = this.percentage_igv / 100;
                const hasPrecalc = (
                    i._base !== undefined &&
                    i._igv !== undefined &&
                    i._total_line !== undefined
                );

                let appliedDiscount = discount;
                if (hasPrecalc && i._discount_amount !== undefined) {
                    appliedDiscount = Number(i._discount_amount) || 0;
                } else if (!appliedDiscount && Array.isArray(i.discounts) && i.discounts.length) {
                    // Fallback: sumar montos de descuentos del arreglo si existe
                    appliedDiscount = i.discounts.reduce((acc, d) => {
                        const v = Number(
                            d.amount ?? d.amount_value ?? d.discount ?? 0
                        );
                        return acc + (isNaN(v) ? 0 : v);
                    }, 0);
                }

                // Reconstruir/normalizar discounts y asegurar montos netos (sin IGV) para tipo '00'
                let discountsArray = Array.isArray(i.discounts) ? JSON.parse(JSON.stringify(i.discounts)) : [];
                // Precalcular bases para normalización: base después de descuento y base antes de descuento (ambas netas)
                const discountedGrossPreview = (comesPrecalc || hasTotalOnly)
                    ? Number(i._total_line ?? i.total) || 0
                    : Math.max(gross - appliedDiscount, 0);
                const baseAfterDiscountNet = taxable ? (discountedGrossPreview / (1 + percentage)) : discountedGrossPreview;
                const amountNetForNormalize = taxable ? (appliedDiscount / (1 + percentage)) : appliedDiscount;
                const preDiscountBaseNet = baseAfterDiscountNet + amountNetForNormalize;

                let unit_value, total_base_igv, total_igv, total_taxes, total_value, lineTotal;

                if (hasPrecalc) {
                    // Confiar en los valores precalculados provenientes del backend / cálculo previo
                    total_value = Number(i._base) || 0; // base imponible o valor sin IGV
                    total_igv = Number(i._igv) || 0;
                    lineTotal = Number(i._total_line) || 0;
                    if (taxable) {
                        total_base_igv = total_value;
                        total_taxes = total_igv; // solo IGV
                        // unit_value debe ser base antes del descuento (sin IGV)
                        unit_value = qty ? preDiscountBaseNet / qty : 0;
                    } else {
                        total_base_igv = total_value; // para exonerado / inafecto se usa igual
                        total_taxes = 0;
                        // unit_value debe ser base antes del descuento
                        unit_value = qty ? preDiscountBaseNet / qty : 0;
                    }
                } else if (comesPrecalc && i.total !== undefined && i.total_value !== undefined) {
                    // Caso: vienen totales simples (total y total_value) desde list_ordens. Respetarlos.
                    lineTotal = Number(i.total) || 0;
                    total_value = Number(i.total_value) || 0;
                    if (taxable) {
                        total_base_igv = total_value;
                        total_igv = _.round(total_base_igv * percentage, 2);
                        total_taxes = total_igv;
                        // unit_value debe ser base antes del descuento (sin IGV)
                        unit_value = qty ? preDiscountBaseNet / qty : 0;
                    } else {
                        total_base_igv = total_value;
                        total_igv = 0;
                        total_taxes = 0;
                        // unit_value debe ser base antes del descuento
                        unit_value = qty ? preDiscountBaseNet / qty : 0;
                    }
                } else if (hasTotalOnly) {
                    // Viene sólo el total (bruto). Calcular base/igv a partir de él, manteniendo el total intacto
                    lineTotal = Number(i.total) || 0;
                    if (taxable) {
                        total_base_igv = lineTotal / (1 + percentage);
                        total_igv = _.round(total_base_igv * percentage, 2);
                        total_value = total_base_igv;
                        total_taxes = total_igv;
                        // unit_value debe ser base antes del descuento (sin IGV)
                        unit_value = qty ? preDiscountBaseNet / qty : 0;
                    } else {
                        total_base_igv = lineTotal;
                        total_igv = 0;
                        total_value = lineTotal;
                        total_taxes = 0;
                        // unit_value debe ser base antes del descuento
                        unit_value = qty ? preDiscountBaseNet / qty : 0;
                    }
                } else {
                    // Calcular localmente si no tenemos precálculo
                    const discountedGross = Math.max(gross - appliedDiscount, 0);
                    console.log('[LOG] CÁLCULO LOCAL: percentage_igv actual:', this.percentage_igv, typeof this.percentage_igv, '| percentage usado:', percentage, typeof percentage, '| taxable:', taxable, '| price:', price, '| gross:', gross, '| appliedDiscount:', appliedDiscount);
                    if (taxable) {
                        total_base_igv = discountedGross / (1 + percentage);
                        total_igv = total_base_igv * percentage;
                        unit_value = price / (1 + percentage);
                        total_value = total_base_igv;
                        total_taxes = total_igv;
                        lineTotal = discountedGross;
                        console.log('[LOG] IGV calculado para item', i.name || i.description || i.id, ':', total_igv, '| base:', total_base_igv, '| porcentaje:', percentage, '| discountedGross:', discountedGross);
                    } else {
                        unit_value = price;
                        total_base_igv = discountedGross;
                        total_igv = 0;
                        total_value = discountedGross;
                        total_taxes = 0;
                        lineTotal = discountedGross;
                    }
                }
                return {
                    ...i,
                    currency_type_id: this.currency_id == 'S/' ? 'PEN' : 'USD',
                    currency_type: {
                        id: this.currency_id == 'S/' ? 'PEN' : 'USD',
                        description: this.currency_id == 'S/' ? 'Soles' : 'Dolares',
                        symbol: this.currency_id
                    },
                    attributes: i.attributes || [],
                    toWarehouse: i.toWarehouse || 0,
                    consignment_item_id: i.consignment_item_id,
                    warehouse_id: null,
                    item: i,
                    item_id: i.id,
                    unit_value: _.round(unit_value, 6),
                    quantity: qty,
                    aux_quantity: qty,
                    total_base_igv: _.round(total_base_igv, 2),
                    percentage_igv: this.percentage_igv,
                    total_igv: _.round(total_igv, 2),
                    total_base_isc: 0.0,
                    percentage_isc: 0.0,
                    total_isc: 0.0,
                    total_base_other_taxes: 0.0,
                    percentage_other_taxes: 0.0,
                    total_other_taxes: 0.0,
                    total_taxes: _.round(total_taxes, 2),
                    total_value: _.round(total_value, 2),
                    total_charge: 0.0,
                    total_discount: (comesPrecalc || hasTotalOnly) ? Number(i.total_discount || appliedDiscount || 0) : appliedDiscount,
                    total: _.round(lineTotal, 2),
                    price_type_id: '01',
                    unit_price: price,
                    unit_price_value: price,
                    has_igv: i.has_igv,
                    affectation_igv_type_id: i.sale_affectation_igv_type_id,
                    presentation: null,
                    charges: [],
                    discounts: discountsArray.map(d => ({
                        ...d,
                        amount: _.round(Number(d.amount) || 0, 2),
                        base: _.round(Number(d.base) || 0, 2),
                        factor: Number((Number(d.factor) || 0).toFixed(5))
                    })),
                    affectation_igv_type: i.sale_affectation_igv_type_id
                };

            });
            /* console.log('[DEBUG] Mapped item:', item); */
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
            console.log(
                "Linea 5008 - Printer",
                "Se esta imprimiendo: " + new Date().toLocaleTimeString()
            );
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
            console.log("Print job data:", data);

            qz.print(config, data).catch(e => {
                this.$toast.error(e.message);
            });
            for (let index = 0; index < copies; index++) {
                await new Promise(resolve => setTimeout(resolve, 1500));
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
            //     ;
            //     ;
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
            //     ;
            //     ;
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
                if (!row) return;
                total_discount += parseFloat(row.total_discount || 0);
                total_charge += parseFloat(row.total_charge || 0);
                total += parseFloat(row.total || 0);
                total_taxes += parseFloat(row.total_taxes || 0);
                if (row.sale_affectation_igv_type_id === "10") {
                    total_igv += _.round(
                        parseFloat(row.total_value || 0) *
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
                const itemObj = orden.food.item;
                let lineTotal;
                if (itemObj._total_line !== undefined) {
                    lineTotal = Number(itemObj._total_line) || 0;
                } else if (itemObj.total !== undefined) {
                    lineTotal = Number(itemObj.total) || 0;
                } else {
                    lineTotal = parseFloat(
                        _.round(
                            parseFloat(itemObj.quantity) *
                            parseFloat(orden.food.price),
                            2
                        )
                    );
                }
                total += lineTotal;
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
            // No restar aquí total_discount porque los items ya vienen netos si había descuento
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
                unique_code: this.policy,
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
        /**
         * Agrega automáticamente un ítem según el unique_code recibido en value.
         * Si el value es un unique_code válido, llama a getFoods con ese código.
         */
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
                                    this.worker.establishment_id &&
                                    lt.quantity > 0
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
            } catch (e) { }
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
            } catch (e) { }
        },
        async getTables() {
            //this.loadingInstance = Loading.service({fullscreen: false,lock:true,text:"Espere por favor..."});
            await this.$http.get(`/${this.resource}/tables`).then(response => {
                // this.all_items = response.data.items;
                this.sellers = response.data.sellers;
                this.users = response.data.users;
                this.tablesClean = response.data.tablesClean;
                this.tablesClean = this.tablesClean.map(t => ({
                    ...t,
                    time_to_finish: null
                }));
                this.tablesLeave = response.data.tablesLeave;
                this.tablesLeave = this.tablesLeave.map(t => ({
                    ...t,
                    timer: null
                }));
                this.products_to_due = response.data.products_to_due;
                this.categories = response.data.categories;
                this.brands = response.data.brands;
                this.areas = response.data.areas;
                this.medida_alto = response.data.medida_alto;
                this.medida_ancho = response.data.medida_ancho;
                this.medida_grosor = response.data.medida_grosor;
                this.categoria_madera = response.data.categoria_madera;
                this.promotions_document = response.data.promotions_document.filter(
                    p => {
                        if (this.configuration.promotions_by_points) {
                            return p.is_points;
                        }
                        return !p.is_points;
                    }
                );
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
                this.user = response.data.user; // this.desarrollador=response.data.desarrollador
                /* ; */ this.currency_types.length > 0
                    ? this.currency_types[0].id
                    : null;
                this.renderCategories(response.data.categories);
                this.renderBrands(response.data.brands);
                // this.currency_type = _.find(this.currency_types, {'id': this.form.currency_type_id})
                // this.changeCurrencyType();
                // this.filterItems();
                // this.changeDateOfIssue();
                // this.changeExchangeRate();
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
                    icono: obj.icono,
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
            if (this.configuration.hotels) {
                this.getTablesToLeave();
            }
            if (this.$refs.list_orden) {
                this.$refs.list_orden.commercialTreatmentId = null;
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
            if (!this.configuration.all_items_pos) {
                await this.getFoods();
            }
            await this.calculateTotal();
            if (!this.isAndroid) {
                this.$refs.input_items.$el
                    .getElementsByTagName("input")[0]
                    .focus();
            }
            this.total_sales_pos = 0;
            if (this.configuration.sale_note_credit_confirm) {
                this.openCredit();
            }
            this.getExchange();
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
                    console.log(
                        "🚀 ~ this.$http.get ~ this.all_customers pasa por ahi:",
                        this.all_customers
                    );
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
        formatVariationImageUrl(i) {
            if (!i || !i.url) return;
            let formated = "storage/uploads/items/" + i.url;
            return `/${formated}`;
        },
        addFood(index = 0, type = null, categoria = null) {
            if (!this.canAddItem) {
                this.$showSAlert(
                    "Error",
                    "Debe seleccionar un cliente",
                    "error"
                );

                return;
            }

            let foodItem = this.listFoods[index]?.item;
            // Si es producto de familia y hay código escaneado, restringir al código exacto
            if (foodItem && foodItem.codes_family && this.barcode) {
                const foundCode = Array.isArray(foodItem.item_codes)
                    ? foodItem.item_codes.find(c => c.code_barcode === this.barcode)
                    : null;
                if (!foundCode) {
                    this.$message.error(
                        "El código de familia escaneado no es válido para este producto."
                    );
                    return;
                }
                foodItem.item_codes = [foundCode];
                foodItem.code_barcode = this.barcode;
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
            if (
                this.selectedFood &&
                this.selectedFood.item &&
                this.selectedFood.item.codes_family &&
                this.barcode
            ) {
                this.selectedFood.item.item_code = this.barcode; // Solo el código escaneado
                if (Array.isArray(this.selectedFood.item.item_codes)) {
                    this.selectedFood.item.item_codes = [this.barcode]; // Opcional: solo el escaneado
                }
            }
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

        async processPrintQueue() {
            if (this.isPrinting || this.printQueue.length === 0) return;

            this.isPrinting = true;
            const printJob = this.printQueue.shift();

            try {
                await this.Printer(
                    printJob.printer,
                    printJob.print,
                    printJob.copies,
                    printJob.user_id,
                    printJob.multiple_boxes,
                    printJob.typeuser,
                    printJob.printing
                );
                if (this.printQueue.length > 0) {
                    await new Promise(resolve =>
                        setTimeout(resolve, this.printDelay)
                    );
                }
            } catch (error) {
                console.error("Error printing:", error);
            } finally {
                this.isPrinting = false;
                this.processPrintQueue();
            }
        },

        addToPrintQueue(printJob) {
            this.printQueue.push(printJob);
            console.log("Print job added to queue:", printJob);
            this.processPrintQueue();
        },
        // Alterna la vista delegando en el componente hijo (opción 1 descrita al usuario)
        toggleView() {
            if (this.$refs.list_foods && this.$refs.list_foods.toggleView) {
                this.$refs.list_foods.toggleView();
            }
        }
    },
    beforeUnmount() {
        document.removeEventListener("keydown", this.handleKeydown);
    },
    mounted() {
        this.syncCountdown = setInterval(() => {
            this.countdown = window.globalCountdown || 0;
        }, 1000);
        this;
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
                        this.addToPrintQueue({
                            printer: e.data.printer,
                            print: e.data.print,
                            copies: e.data.copies,
                            user_id: e.data.user_id,
                            multiple_boxes: e.data.multiple_boxes,
                            typeuser: e.data.typeuser,
                            printing: e.data.printing
                        });
                        // await this.Printer(
                        //     e.data.printer,
                        //     e.data.print,
                        //     e.data.copies,
                        //     e.data.user_id,
                        //     e.data.multiple_boxes,
                        //     e.data.typeuser,
                        //     e.data.printing
                        // );
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
