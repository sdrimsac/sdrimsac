<!-- Modulo Etiquetas -->
<template>
    <div class="container-fluid p-l-0 p-r-0">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-6">
                    <h6>
                        <span>Etiquetas</span>
                    </h6>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/dashboard">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <span class="text-muted"
                                >Preparación de etiquetas codigo familia</span
                            >
                        </li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="card" v-loading="loading">
            <div class="card-header bg-primary">
                <h4 class="my-0 text-white">
                    <i class="el-icon-collection-tag"></i> Preparación de
                    Etiquetas codigo familia
                </h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="row">
                            <div
                                class="col-12 col-lg-6 col-md-6 col-sm-12 d-flex flex-column justify-content-center align-items-center mb-2 mx-auto image-upload-container"
                                style="border: 2px solid #000; border-radius: 4px;"
                            >
                                <br />
                                <div
                                    style="width: 150px; height: 100px;"
                                    class="d-flex justify-content-center align-items-center"
                                >
                                    <template v-if="imageSaved">
                                        <img
                                            :src="imageSaved"
                                            alt="imagen"
                                            class="img-thumbnail"
                                            style="width: 150%; height: 100%; object-fit: contain;"
                                        />
                                    </template>
                                    <template v-else>
                                        <el-empty :image-size="100"></el-empty>
                                    </template>
                                </div>
                                <br />
                                <div class="button-container">
                                    <el-button
                                        class="m-2"
                                        type="primary"
                                        @click="$refs.file.click()"
                                        >Subir imagen</el-button
                                    >
                                    <el-button
                                        v-if="imageSaved"
                                        class="m-2"
                                        type="danger"
                                        @click="delete_image"
                                    >
                                        <i class="el-icon-delete"></i>
                                    </el-button>
                                    <p>
                                        <em
                                            >Reconemdado JPG, PNG, JPEG |
                                            150x150</em
                                        >
                                    </p>
                                    <input
                                        accept="image/png, image/jpeg, image/jpg"
                                        type="file"
                                        @change="changeImage"
                                        ref="file"
                                        style="display: none"
                                    />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div
                                    class="d-flex flex-column align-items-center justify-content-center mt-1 text-center"
                                >
                                    <div
                                        class="d-flex flex-row align-items-center mb-3 column-option"
                                    >
                                        <div
                                            role="button"
                                            style="min-height:70px; width: 200px;"
                                            @click="changePaper(1)"
                                            :class="
                                                `d-flex justify-content-center align-items-center rounded m-2 ${
                                                    paperType == 1
                                                        ? 'text-white bg-primary'
                                                        : 'border bg-white'
                                                }`
                                            "
                                        >
                                            1 Columna x Etiqueta
                                        </div>
                                        <div class="ml-3">
                                            <img
                                                src="/storage/etiquetas/1.png"
                                                alt="Column preview"
                                                style="width: 150px; height: 100px; border: 2px solid #000; border-radius: 4px;"
                                            />
                                        </div>
                                    </div>
                                    <div
                                        class="d-flex flex-row align-items-center mb-3 column-option"
                                    >
                                        <div
                                            role="button"
                                            style="min-height:70px; width: 200px;"
                                            @click="changePaper(2)"
                                            :class="
                                                `d-flex justify-content-center align-items-center rounded m-2 ${
                                                    paperType == 2
                                                        ? 'text-white bg-primary'
                                                        : 'border text-black bg-white'
                                                }`
                                            "
                                        >
                                            2 Columnas x Etiqueta
                                        </div>
                                        <div class="ml-3">
                                            <img
                                                src="/storage/etiquetas/2.png"
                                                alt="Column preview"
                                                style="width: 150px; height: 100px; border: 2px solid #000; border-radius: 4px;"
                                            />
                                        </div>
                                    </div>
                                    <div
                                        class="d-flex flex-row align-items-center mb-3 column-option"
                                    >
                                        <div
                                            role="button"
                                            style="min-height:70px; width: 200px;"
                                            @click="
                                                $message.warning(
                                                    'No disponible Por el momento'
                                                )
                                            "
                                            title="En desarrollo"
                                            :class="
                                                `d-flex justify-content-center align-items-center rounded m-2 ${
                                                    paperType == 3
                                                        ? 'text-white bg-primary'
                                                        : 'border bg-white'
                                                }`
                                            "
                                        >
                                            3 Columnas x Etiqueta
                                        </div>
                                        <div class="ml-3">
                                            <img
                                                src="/storage/etiquetas/3.png"
                                                alt="Column preview"
                                                style="width: 150px; height: 100px; border: 2px solid #000; border-radius: 4px;"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="row d-flex justify-content-center">
                                <div
                                    v-if="!product_id"
                                    class="col-12 col-lg-4 col-md-4 text-center"
                                >
                                    <el-alert
                                        :closable="false"
                                        title="Busque y/o seleccione un producto"
                                        type="error"
                                    ></el-alert>
                                </div>
                            </div>
                            <div
                                class="col-12 col-lg-12 col-md-12 col-sm-12 d-flex flex-column align-items-center mb-2"
                            >
                                <div class="responsive-container">
                                    <div
                                        class="el-input el-input-group el-input-group--append mb-2"
                                    >
                                        <!-- Product Search Header -->
                                        <div class="product-search-header mb-3">
                                            <div class="d-flex flex-wrap gap-2 mb-2">
                                                <el-button
                                                    class="bg-primary text-white"
                                                    @click="createItem"
                                                >
                                                    crear nuevo producto
                                                </el-button>
                                                <el-button
                                                    class="bg-success text-white"
                                                    @click.prevent="clickCreate('input')"
                                                >
                                                    cargar stock inicial
                                                </el-button>

                                                <label for="">Filtro 1</label>
                                                <el-select
                                                    v-model="filter1"
                                                    @change="searchItems"
                                                    placeholder="Seleccione filtro 1"
                                                    style="width: 200px"
                                                >
                                                    <el-option
                                                        v-for="option in filters1"
                                                        :key="option.value"
                                                        :value="option.value"
                                                    >{{ option.text }}</el-option>
                                                </el-select>

                                                <label for="">Filtro 2</label>
                                                <el-select
                                                    v-model="filter2"
                                                    @change="searchItems"
                                                    placeholder="Seleccione filtro 2"
                                                    style="width: 200px"
                                                >
                                                    <el-option
                                                        v-for="option in filters2"
                                                        :key="option.value"
                                                        :value="option.value"
                                                    >{{ option.text }}</el-option>
                                                </el-select>
                                            </div>
                                        </div>

                                        <!-- Search and Stock Input -->
                                        <div class="search-stock-container">
                                            <div class="mb-2">
                                                <div class="d-flex gap-2">
                                                    <div class="flex-grow-1">
                                                        <label
                                                            class="d-block mb-2"
                                                            >Ingrese el Nombre
                                                            del Producto:</label
                                                        >
                                                        <el-select
                                                            v-if="
                                                                !lector_barcode
                                                            "
                                                            v-model="product_id"
                                                            @change="changeItem"
                                                            filterable
                                                            remote
                                                            placeholder="Buscar producto"
                                                            popper-class="el-select-items"
                                                            :remote-method="
                                                                searchRemoteItems
                                                            "
                                                            :loading="
                                                                loading_search
                                                            "
                                                            style="width: 100%"
                                                        >
                                                            <el-option
                                                                v-for="option in items"
                                                                :key="option.id"
                                                                :value="
                                                                    option.id
                                                                "
                                                                :label="
                                                                    option.descripcion
                                                                "
                                                            >
                                                            </el-option>
                                                        </el-select>
                                                        <el-input
                                                            v-else
                                                            ref="input_barcode"
                                                            v-model="
                                                                item_for_barcode
                                                            "
                                                            @input="searchItems"
                                                            placeholder="Buscar producto"
                                                        >
                                                        </el-input>
                                                    </div>
                                                    <div
                                                        style="min-width: 120px"
                                                    >
                                                        <label
                                                            class="d-block mb-2"
                                                            >Stock:</label
                                                        >
                                                        <el-input
                                                            v-model="quantity"
                                                            placeholder="Stock"
                                                        ></el-input>
                                                    </div>
                                                </div>
                                                <div class="mt-2">
                                                    <el-checkbox
                                                        v-model="lector_barcode"
                                                    >
                                                        Lector de código de
                                                        barras
                                                    </el-checkbox>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Price Type Selection -->
                                    <div class="price-type-selection my-3">
                                        <div
                                            class="d-flex justify-content-center"
                                        >
                                            <el-radio-group
                                                :fill="
                                                    type == 'Precio venta'
                                                        ? '#E6A23C'
                                                        : '#409EFF'
                                                "
                                                v-model="type"
                                                class="flex-wrap"
                                            >
                                                <el-radio-button
                                                    label="Precio venta"
                                                ></el-radio-button>
                                                <el-radio-button
                                                    label="Precio compra"
                                                ></el-radio-button>
                                            </el-radio-group>
                                        </div>
                                    </div>

                                    <!-- Tabs Container -->
                                    <div class="tab-container">
                                        <el-tabs
                                            v-model="activeTab"
                                            class="responsive-tabs"
                                            tab-position="top"
                                        >
                                            <!-- Normal Tab -->
                                            <el-tab-pane
                                                label="Normal"
                                                name="normal"
                                            >
                                                <div class="tab-content p-2">
                                                    <div class="input-group">
                                                        <label
                                                            class="control-label d-block mb-2"
                                                            >Valor:</label
                                                        >
                                                        <el-input
                                                            :disabled="
                                                                !product_id
                                                            "
                                                            v-model="
                                                                getActiveTabValue
                                                            "
                                                            class="w-100"
                                                        ></el-input>
                                                    </div>
                                                </div>
                                            </el-tab-pane>

                                            <!-- Murcielago Tab -->
                                            <el-tab-pane
                                                label="Codigo Murcielago"
                                                name="murcielago"
                                            >
                                                <div
                                                    v-if="
                                                        activeTab ===
                                                            'murcielago'
                                                    "
                                                    class="tab-content p-2"
                                                >
                                                    <div
                                                        class="input-group mb-3"
                                                    >
                                                        <label
                                                            class="control-label text-primary cursor-pointer mb-2"
                                                            role="button"
                                                            @click="
                                                                openDialogForm
                                                            "
                                                        >
                                                            Nuevo +
                                                        </label>
                                                        <el-select
                                                            @change="debounce"
                                                            v-model="
                                                                getCurrentMurcValue
                                                            "
                                                            class="w-100"
                                                        >
                                                            <el-option
                                                                v-for="word in words"
                                                                :key="word.id"
                                                                :value="word.id"
                                                                :label="
                                                                    `${word.palabra} (${word.indice})`
                                                                "
                                                            >
                                                            </el-option>
                                                        </el-select>
                                                    </div>
                                                    <div
                                                        class="input-group mb-3"
                                                    >
                                                        <label
                                                            class="control-label mb-2"
                                                            >Números:</label
                                                        >
                                                        <el-input
                                                            type="number"
                                                            @input="debounce"
                                                            v-model="
                                                                getCurrentMurcNumberValue
                                                            "
                                                            class="w-100"
                                                        >
                                                        </el-input>
                                                    </div>
                                                    <div class="input-group">
                                                        <label
                                                            class="control-label mb-2"
                                                            >Valor:</label
                                                        >
                                                        <el-input
                                                            :disabled="
                                                                !product_id
                                                            "
                                                            v-model="
                                                                getActiveTabValue
                                                            "
                                                            class="w-100"
                                                        ></el-input>
                                                    </div>
                                                </div>
                                            </el-tab-pane>

                                            <!-- Empty Tab -->
                                            <el-tab-pane
                                                label="Vacio"
                                                name="vacio"
                                            >
                                                <div class="tab-content p-2">
                                                    <div class="input-group">
                                                        <label
                                                            class="control-label mb-2"
                                                            >Valor:</label
                                                        >
                                                        <el-input
                                                            :disabled="
                                                                !product_id
                                                            "
                                                            v-model="
                                                                getActiveTabValue
                                                            "
                                                            class="w-100"
                                                        ></el-input>
                                                    </div>
                                                </div>
                                            </el-tab-pane>
                                        </el-tabs>
                                    </div>
                                </div>
                            </div>
                            <br />
                            <div class="col-md-12">
                                <div class="text-center">
                                    <el-radio-group
                                        v-model="modelType"
                                        size="large"
                                    >
                                        <el-radio-button
                                            v-if="configuration.model_01"
                                            :label="1"
                                            plain
                                            class="mb-2 me-2"
                                            style="font-size: 16px; "
                                        >
                                            50x25
                                            <el-tooltip
                                                class="item"
                                                effect="dark"
                                                content="La medida de la etiqueta de 50mm x 25mm solo esta disponible para 1 columnas x etiqueta"
                                                placement="top-start"
                                            >
                                                <i
                                                    class="fa fa-info-circle"
                                                ></i>
                                            </el-tooltip>
                                        </el-radio-button>
                                        <el-radio-button
                                            v-if="configuration.model_02"
                                            :label="2"
                                            plain
                                            class="mb-2 me-2"
                                            style="font-size: 16px; "
                                        >
                                            60x20
                                            <el-tooltip
                                                class="item"
                                                effect="dark"
                                                content="La medida de la etiqueta de 60mm x 20mm solo esta disponible para 2 columnas x etiqueta"
                                                placement="top-start"
                                            >
                                                <i
                                                    class="fa fa-info-circle"
                                                ></i>
                                            </el-tooltip>
                                        </el-radio-button>
                                        <el-radio-button
                                            v-if="configuration.model_03"
                                            :label="3"
                                            plain
                                            class="mb-2 me-2"
                                            style="font-size: 16px; "
                                        >
                                            60x20
                                            <el-tooltip
                                                class="item"
                                                effect="dark"
                                                content="La medida de la etiqueta de 60mm x 20mm solo esta disponible para 2 columnas x etiqueta"
                                                placement="top-start"
                                            >
                                                <i
                                                    class="fa fa-info-circle"
                                                ></i>
                                            </el-tooltip>
                                        </el-radio-button>
                                        <el-radio-button
                                            v-if="configuration.model_04"
                                            :label="4"
                                            plain
                                            class="mb-2 me-2"
                                            style="font-size: 16px;"
                                        >
                                            60x20
                                            <el-tooltip
                                                class="item"
                                                effect="dark"
                                                content="La medida de la etiqueta de 60mm x 20mm solo esta disponible para 2 columnas x etiqueta"
                                                placement="top-start"
                                            >
                                                <i
                                                    class="fa fa-info-circle"
                                                ></i>
                                            </el-tooltip>
                                        </el-radio-button>
                                        <el-radio-button
                                            v-if="configuration.model_05"
                                            :label="5"
                                            plain
                                            class="mb-2 me-2"
                                            style="font-size: 16px;"
                                        >
                                            100x25
                                            <el-tooltip
                                                class="item"
                                                effect="dark"
                                                content="La medida de la etiqueta de 100mm x 25mm solo esta disponible para 2 columnas x etiqueta"
                                                placement="top-start"
                                            >
                                                <i
                                                    class="fa fa-info-circle"
                                                ></i>
                                            </el-tooltip>
                                        </el-radio-button>
                                        <el-radio-button
                                            v-if="configuration.model_06"
                                            :label="6"
                                            plain
                                            class="mb-2 me-2"
                                            style="font-size: 16px;"
                                        >
                                            60x20
                                            <el-tooltip
                                                class="item"
                                                effect="dark"
                                                content="La medida de la etiqueta de 60mm x 20mm solo esta disponible para 2 columnas x etiqueta"
                                                placement="top-start"
                                            >
                                                <i
                                                    class="fa fa-info-circle"
                                                ></i>
                                            </el-tooltip>
                                        </el-radio-button>
                                        <el-radio-button
                                            v-if="configuration.model_07"
                                            :label="7"
                                            plain
                                            class="mb-2 me-2"
                                            style="font-size: 16px;"
                                        >
                                            60x20
                                            <el-tooltip
                                                class="item"
                                                effect="dark"
                                                content="La medida de la etiqueta de 60mm x 20mm solo esta disponible para 2 columnas x etiqueta brother"
                                                placement="top-start"
                                            >
                                                <i
                                                    class="fa fa-info-circle"
                                                ></i>
                                            </el-tooltip>
                                        </el-radio-button>
                                        <el-radio-button
                                            v-if="configuration.model_08"
                                            :label="8"
                                            plain
                                            class="mb-2 me-2"
                                            style="font-size: 16px;"
                                        >
                                            50x25
                                            <el-tooltip
                                                class="item"
                                                effect="dark"
                                                content="La medida de la etiqueta de 50mm x 25mm solo esta disponible para 1 columnas x etiqueta"
                                                placement="top-start"
                                            >
                                                <i
                                                    class="fa fa-info-circle"
                                                ></i>
                                            </el-tooltip>
                                        </el-radio-button>
                                        <el-radio-button
                                            v-if="configuration.model_09"
                                            :label="9"
                                            plain
                                            class="mb-2 me-2"
                                            style="font-size: 16px;"
                                        >
                                            60x20
                                            <el-tooltip
                                                class="item"
                                                effect="dark"
                                                content="La medida de la etiqueta de 60mm x 20mm solo esta disponible para 2 columnas x etiqueta solo sale nombre y precio"
                                                placement="top-start"
                                            >
                                                <i
                                                    class="fa fa-info-circle"
                                                ></i>
                                            </el-tooltip>
                                        </el-radio-button>
                                    </el-radio-group>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div
                                    class="d-flex flex-column align-items-center justify-content-center mt-1"
                                >
                                    <div
                                        role="button"
                                        style="min-height:50px; width: 100px;"
                                        @click="changeFormat(1)"
                                        :class="
                                            `d-flex justify-content-center bg-white align-items-center rounded m-2 ${
                                                this.QSticker == 1
                                                    ? 'bg-primary'
                                                    : 'border'
                                            }`
                                        "
                                    >
                                        <div
                                            class="col-5 text-center"
                                            :style="{
                                                color:
                                                    this.QSticker == 1
                                                        ? 'white'
                                                        : 'black',
                                                fontSize: '24px'
                                            }"
                                        >
                                            1
                                        </div>
                                    </div>
                                    <div
                                        role="button"
                                        style="min-height:50px; width: 100px;"
                                        @click="changeFormat(2)"
                                        :class="
                                            `d-flex justify-content-center bg-white align-items-center rounded m-2 ${
                                                this.QSticker == 2
                                                    ? 'bg-primary'
                                                    : 'border'
                                            }`
                                        "
                                    >
                                        <div
                                            class="col-5 text-center"
                                            :style="{
                                                color:
                                                    this.QSticker == 2
                                                        ? 'white'
                                                        : 'black',
                                                fontSize: '24px'
                                            }"
                                        >
                                            2
                                        </div>
                                    </div>
                                    <div
                                        role="button"
                                        @click="changeFormat(4)"
                                        style="min-height:50px; width: 100px;"
                                        :class="
                                            `d-flex justify-content-center bg-white align-items-center rounded m-2 ${
                                                this.QSticker == 4
                                                    ? 'bg-primary'
                                                    : 'border'
                                            }`
                                        "
                                    >
                                        <div
                                            class="col-5 text-center"
                                            :style="{
                                                color:
                                                    this.QSticker == 4
                                                        ? 'white'
                                                        : 'black',
                                                fontSize: '24px'
                                            }"
                                        >
                                            4
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <br />
                                <div
                                    v-if="
                                        modeloSeleccionado === 'Modelo1' &&
                                            configuration.model_01
                                    "
                                    class="d-flex flex-row justify-content-center preview-container"
                                >
                                    <div
                                        class="border d-flex flex-row align-items-center h150 w300 overflow-hidden bg-white"
                                    >
                                        <div>
                                            <div
                                                v-if="imageSaved"
                                                class="w100 overflow-hidden"
                                            >
                                                <img
                                                    :src="imageSaved"
                                                    alt="imagen"
                                                    class="img-thumbnail"
                                                    style="width: 100px; height: 100px;"
                                                />
                                            </div>
                                            <div
                                                v-else
                                                class="col-12 d-flex justify-content-center align-items-center"
                                            >
                                                <el-empty
                                                    :image-size="100"
                                                ></el-empty>
                                            </div>
                                        </div>
                                        <div
                                            class="d-flex flex-fill flex-column justify-content-center align-items-center"
                                        >
                                            <span
                                                :style="
                                                    `color:${
                                                        type == 'Precio venta'
                                                            ? '#E6A23C'
                                                            : '#000'
                                                    }`
                                                "
                                                class="text-center"
                                                >S/.
                                                {{ sale_code || "N/D" }}</span
                                            >
                                            <span class="text-center">
                                                {{
                                                    product.descripcion ||
                                                        "DESCRIPCION DEL PRODUCTO"
                                                }}
                                            </span>
                                            <img
                                                v-show="product_id"
                                                id="barcode"
                                                alt="barcode"
                                            />
                                            <div
                                                class="d-flex col-12 justify-content-between p-1"
                                            >
                                                <span>{{
                                                    product.location || "S/L"
                                                }}</span>
                                                <span
                                                    :style="
                                                        `color:${
                                                            type !=
                                                            'Precio venta'
                                                                ? '#409EFF'
                                                                : '#000'
                                                        }`
                                                    "
                                                    >{{
                                                        purchase_code || "N/D"
                                                    }}</span
                                                >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    v-if="
                                        modeloSeleccionado === 'Modelo2' &&
                                            configuration.model_02
                                    "
                                    class="d-flex flex-row justify-content-center preview-container"
                                >
                                    <div
                                        class="border d-flex flex-row align-items-center h150 w300 overflow-hidden bg-white"
                                    >
                                        <div
                                            class="d-flex flex-column p-2"
                                            style="width: 50%;"
                                        >
                                            <div class="d-flex flex-row">
                                                <div style="width: 50%;">
                                                    <div
                                                        v-if="imageSaved"
                                                        class="mb-1 d-flex justify-content-center"
                                                    >
                                                        <img
                                                            :src="imageSaved"
                                                            alt="imagen"
                                                            class="img-thumbnail"
                                                            style="width: 60px; height: 60px;"
                                                        />
                                                    </div>
                                                </div>

                                                <div
                                                    class="d-flex flex-column"
                                                    style="width: 50%;"
                                                >
                                                    <span
                                                        class="text-center text-truncate"
                                                        style="font-size: 14px;"
                                                    >
                                                        {{ sale_code || "N/D" }}
                                                    </span>
                                                    <template
                                                        v-if="
                                                            product.descripcion
                                                        "
                                                    >
                                                        <span
                                                            v-if="
                                                                product
                                                                    .descripcion
                                                                    .length <=
                                                                    15
                                                            "
                                                            class="text-center"
                                                            style="font-size: 12px;"
                                                        >
                                                            {{
                                                                product.descripcion
                                                            }}
                                                        </span>
                                                        <template v-else>
                                                            <span
                                                                class="text-center"
                                                                style="font-size: 12px;"
                                                            >
                                                                {{
                                                                    product.descripcion.substring(
                                                                        0,
                                                                        15
                                                                    )
                                                                }}
                                                            </span>
                                                            <span
                                                                class="text-center"
                                                                style="font-size: 12px;"
                                                            >
                                                                {{
                                                                    product.descripcion.substring(
                                                                        15,
                                                                        30
                                                                    )
                                                                }}
                                                            </span>
                                                        </template>
                                                    </template>
                                                    <span
                                                        v-else
                                                        class="text-center"
                                                        style="font-size: 12px;"
                                                    >
                                                        DESCRIPCION
                                                    </span>
                                                    <span
                                                        class="text-center text-truncate"
                                                        style="font-size: 12px;"
                                                    >
                                                        {{
                                                            purchase_code ||
                                                                "N/D"
                                                        }}
                                                    </span>
                                                </div>
                                            </div>

                                            <div
                                                class="d-flex justify-content-center mt-1"
                                            >
                                                <img
                                                    v-show="product_id"
                                                    id="barcode"
                                                    alt="barcode"
                                                />
                                            </div>
                                        </div>

                                        <div
                                            class="d-flex flex-column p-2"
                                            style="width: 50%;"
                                        >
                                            <div class="d-flex flex-row mb-2">
                                                <div style="width: 60px;">
                                                    <div
                                                        v-if="imageSaved"
                                                        class="mb-1"
                                                    >
                                                        <img
                                                            :src="imageSaved"
                                                            alt="imagen"
                                                            class="img-thumbnail"
                                                            style="width: 60px; height: 60px;"
                                                        />
                                                    </div>
                                                </div>
                                                <div
                                                    class="d-flex flex-column"
                                                    style="width: 50%;"
                                                >
                                                    <span
                                                        class="text-center text-truncate"
                                                        style="font-size: 14px;"
                                                    >
                                                        {{ sale_code || "N/D" }}
                                                    </span>
                                                    <template
                                                        v-if="
                                                            product.descripcion
                                                        "
                                                    >
                                                        <span
                                                            v-if="
                                                                product
                                                                    .descripcion
                                                                    .length <=
                                                                    15
                                                            "
                                                            class="text-center"
                                                            style="font-size: 12px;"
                                                        >
                                                            {{
                                                                product.descripcion
                                                            }}
                                                        </span>
                                                        <template v-else>
                                                            <span
                                                                class="text-center"
                                                                style="font-size: 12px;"
                                                            >
                                                                {{
                                                                    product.descripcion.substring(
                                                                        0,
                                                                        15
                                                                    )
                                                                }}
                                                            </span>
                                                            <span
                                                                class="text-center"
                                                                style="font-size: 12px;"
                                                            >
                                                                {{
                                                                    product.descripcion.substring(
                                                                        15,
                                                                        30
                                                                    )
                                                                }}
                                                            </span>
                                                        </template>
                                                    </template>
                                                    <span
                                                        v-else
                                                        class="text-center"
                                                        style="font-size: 12px;"
                                                    >
                                                        DESCRIPCION
                                                    </span>
                                                    <span
                                                        class="text-center text-truncate"
                                                        style="font-size: 12px;"
                                                    >
                                                        {{
                                                            purchase_code ||
                                                                "N/D"
                                                        }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div
                                                class="d-flex justify-content-center"
                                            >
                                                <img
                                                    v-show="product_id"
                                                    id="barcode"
                                                    alt="barcode"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div
                                    v-if="
                                        modeloSeleccionado === 'Modelo3' &&
                                            configuration.model_03
                                    "
                                    class="d-flex flex-row justify-content-center preview-container"
                                >
                                    <div
                                        class="border d-flex flex-row align-items-center h150 w300 overflow-hidden bg-white"
                                    >
                                        <div
                                            class="d-flex flex-column align-items-center p-2"
                                            style="width: 50%;"
                                        >
                                            <span
                                                class="text-center"
                                                style="font-size: 12px;"
                                            >
                                                {{
                                                    product.descripcion ||
                                                        "DESCRIPCION"
                                                }}
                                            </span>
                                            <span
                                                class="text-center"
                                                style="font-size: 14px;"
                                            >
                                                S/. {{ sale_code || "N/D" }}
                                            </span>
                                            <img
                                                v-show="product_id"
                                                id="barcode"
                                                alt="barcode"
                                            />
                                        </div>
                                        <div
                                            class="d-flex flex-column align-items-center p-2"
                                            style="width: 50%;"
                                        >
                                            <span
                                                class="text-center"
                                                style="font-size: 12px;"
                                            >
                                                {{
                                                    product.descripcion ||
                                                        "DESCRIPCION"
                                                }}
                                            </span>
                                            <span
                                                class="text-center"
                                                style="font-size: 14px;"
                                            >
                                                S/. {{ sale_code || "N/D" }}
                                            </span>
                                            <img
                                                v-show="product_id"
                                                id="barcode"
                                                alt="barcode"
                                            />
                                        </div>
                                    </div>
                                </div>
                                <div
                                    v-if="
                                        modeloSeleccionado === 'Modelo4' &&
                                            configuration.model_04
                                    "
                                    class="d-flex flex-row justify-content-center preview-container"
                                >
                                    <div
                                        class="border d-flex flex-row align-items-center h150 w300 overflow-hidden bg-white"
                                    >
                                        <div
                                            class="d-flex flex-column align-items-center p-2"
                                            style="width: 50%;"
                                        >
                                            <div
                                                v-if="imageSaved"
                                                class="mb-1"
                                                style="width: 60px; height: 60px;"
                                            >
                                                <img
                                                    :src="imageSaved"
                                                    alt="imagen"
                                                    class="img-thumbnail"
                                                    style="width: 100%; height: 100%;"
                                                />
                                            </div>

                                            <span
                                                class="text-center"
                                                style="font-size: 12px;"
                                            >
                                                {{
                                                    product.descripcion ||
                                                        "DESCRIPCION"
                                                }}
                                            </span>
                                            <span
                                                class="text-center"
                                                style="font-size: 14px;"
                                            >
                                                {{ sale_code || "N/D" }}
                                            </span>
                                            <img
                                                v-show="product_id"
                                                id="barcode"
                                                alt="barcode"
                                            />
                                        </div>
                                        <div
                                            class="d-flex flex-column align-items-center p-2"
                                            style="width: 50%;"
                                        >
                                            <div
                                                v-if="imageSaved"
                                                class="mb-1"
                                                style="width: 60px; height: 60px;"
                                            >
                                                <img
                                                    :src="imageSaved"
                                                    alt="imagen"
                                                    class="img-thumbnail"
                                                    style="width: 100%; height: 100%;"
                                                />
                                            </div>

                                            <span
                                                class="text-center"
                                                style="font-size: 12px;"
                                            >
                                                {{
                                                    product.descripcion ||
                                                        "DESCRIPCION"
                                                }}
                                            </span>
                                            <span
                                                class="text-center"
                                                style="font-size: 14px;"
                                            >
                                                {{ sale_code || "N/D" }}
                                            </span>
                                            <img
                                                v-show="product_id"
                                                id="barcode"
                                                alt="barcode"
                                            />
                                        </div>
                                    </div>
                                </div>
                                <div
                                    v-if="
                                        modeloSeleccionado === 'Modelo5' &&
                                            configuration.model_05
                                    "
                                    class="pdf-preview-container border d-flex preview-container"
                                    style="width: 600px; height: 150px; margin: 20px auto; background: white;"
                                >
                                    <div
                                        class="label-preview"
                                        style="width: 50%; height: 200px; padding: 10px; border-right: 1px dashed #ccc;"
                                    >
                                        <div
                                            class="d-flex flex-column h-100 align-items-center"
                                        >
                                            <span
                                                class="text-center small mb-2"
                                            >
                                                {{
                                                    (
                                                        product.descripcion ||
                                                        "DESCRIPCION DEL PRODUCTO"
                                                    ).substring(0, 80)
                                                }}
                                            </span>

                                            <div class="text-center mb-2">
                                                <img
                                                    v-show="product_id"
                                                    id="barcode"
                                                    alt="barcode"
                                                />
                                            </div>
                                            <div
                                                class="d-flex justify-content-between w-100"
                                            >
                                                <span class="fw-bold"
                                                    >P.C.
                                                    {{
                                                        Number(
                                                            purchase_code || 0
                                                        ).toFixed(2)
                                                    }}</span
                                                >
                                                <div
                                                    class="d-flex flex-column align-items-end"
                                                >
                                                    <span class="fw-bold"
                                                        >S/
                                                        {{
                                                            sale_code || 0
                                                        }}</span
                                                    >
                                                    <span class="fw-bold"
                                                        >P.M.
                                                        {{ price2 || 0 }}</span
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="label-preview"
                                        style="width: 50%; height: 200px; padding: 10px;"
                                    >
                                        <div
                                            class="d-flex flex-column h-100 align-items-center"
                                        >
                                            <span
                                                class="text-center small mb-2"
                                            >
                                                {{
                                                    (
                                                        product.descripcion ||
                                                        "DESCRIPCION DEL PRODUCTO"
                                                    ).substring(0, 80)
                                                }}
                                            </span>

                                            <div class="text-center mb-2">
                                                <img
                                                    v-show="product_id"
                                                    id="barcode"
                                                    alt="barcode"
                                                />
                                            </div>

                                            <div
                                                class="d-flex justify-content-between w-100"
                                            >
                                                <span class="fw-bold"
                                                    >P.C.
                                                    {{
                                                        Number(
                                                            purchase_code || 0
                                                        ).toFixed(2)
                                                    }}</span
                                                >
                                                <div
                                                    class="d-flex flex-column align-items-end"
                                                >
                                                    <span class="fw-bold"
                                                        >S/
                                                        {{
                                                            sale_code || 0
                                                        }}</span
                                                    >
                                                    <span class="fw-bold"
                                                        >P.M.
                                                        {{ price2 || 0 }}</span
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    v-if="
                                        modeloSeleccionado === 'Modelo6' &&
                                            configuration.model_06
                                    "
                                    class="d-flex flex-row justify-content-center preview-container"
                                >
                                    <div
                                        class="border d-flex flex-row align-items-center h150 w300 overflow-hidden bg-white"
                                    >
                                        <div
                                            class="d-flex flex-column align-items-center p-2"
                                            style="width: 50%;"
                                        >
                                            <span
                                                class="text-center"
                                                style="font-size: 12px;"
                                            >
                                                {{
                                                    product.descripcion ||
                                                        "DESCRIPCION"
                                                }}
                                            </span>
                                            <img
                                                v-show="product_id"
                                                id="barcode"
                                                alt="barcode"
                                            />
                                            <div
                                                class="d-flex flex-column w-100"
                                            >
                                                <div
                                                    class="d-flex justify-content-start mb-1"
                                                >
                                                    <span
                                                        class="text-center"
                                                        style="font-size: 14px;"
                                                    >
                                                        P.C.
                                                        {{
                                                            purchase_code ||
                                                                "N/D"
                                                        }}
                                                    </span>
                                                </div>
                                                <div
                                                    class="d-flex justify-content-end mb-1"
                                                >
                                                    <span
                                                        class="text-center"
                                                        style="font-size: 14px;"
                                                    >
                                                        S/.
                                                        {{ sale_code || "N/D" }}
                                                    </span>
                                                </div>
                                                <div
                                                    class="d-flex justify-content-end"
                                                >
                                                    <span
                                                        class="text-center"
                                                        style="font-size: 14px;"
                                                    >
                                                        P.M.
                                                        {{ price2 || "N/D" }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            class="d-flex flex-column align-items-center p-2"
                                            style="width: 50%;"
                                        >
                                            <span
                                                class="text-center"
                                                style="font-size: 12px;"
                                            >
                                                {{
                                                    product.descripcion ||
                                                        "DESCRIPCION"
                                                }}
                                            </span>
                                            <img
                                                v-show="product_id"
                                                id="barcode"
                                                alt="barcode"
                                            />
                                            <div
                                                class="d-flex flex-column w-100"
                                            >
                                                <div
                                                    class="d-flex justify-content-start mb-1"
                                                >
                                                    <span
                                                        class="text-center"
                                                        style="font-size: 14px;"
                                                    >
                                                        P.C.
                                                        {{
                                                            purchase_code ||
                                                                "N/D"
                                                        }}
                                                    </span>
                                                </div>
                                                <div
                                                    class="d-flex justify-content-end mb-1"
                                                >
                                                    <span
                                                        class="text-center"
                                                        style="font-size: 14px;"
                                                    >
                                                        S/.
                                                        {{ sale_code || "N/D" }}
                                                    </span>
                                                </div>
                                                <div
                                                    class="d-flex justify-content-end"
                                                >
                                                    <span
                                                        class="text-center"
                                                        style="font-size: 14px;"
                                                    >
                                                        P.M.
                                                        {{ price2 || "N/D" }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    v-if="
                                        modeloSeleccionado === 'Modelo7' &&
                                            configuration.model_07
                                    "
                                    class="d-flex flex-row justify-content-center preview-container"
                                >
                                    <div
                                        class="border d-flex flex-row align-items-center h150 w300 overflow-hidden bg-white"
                                    >
                                        <div
                                            class="d-flex flex-column align-items-center p-2"
                                            style="width: 50%;"
                                        >
                                            <span
                                                class="text-center"
                                                style="font-size: 12px;"
                                            >
                                                {{
                                                    product.descripcion ||
                                                        "DESCRIPCION"
                                                }}
                                            </span>
                                            <img
                                                v-show="product_id"
                                                id="barcode"
                                                alt="barcode"
                                            />
                                        </div>
                                        <div
                                            class="d-flex flex-column align-items-center p-2"
                                            style="width: 50%;"
                                        >
                                            <span
                                                class="text-center"
                                                style="font-size: 12px;"
                                            >
                                                {{
                                                    product.descripcion ||
                                                        "DESCRIPCION"
                                                }}
                                            </span>
                                            <img
                                                v-show="product_id"
                                                id="barcode"
                                                alt="barcode"
                                            />
                                        </div>
                                    </div>
                                </div>
                                <div
                                    v-if="
                                        modeloSeleccionado === 'Modelo8' &&
                                            configuration.model_08
                                    "
                                    class="d-flex flex-row justify-content-center preview-container"
                                >
                                    <div
                                        class="border d-flex flex-column align-items-center h150 w300 overflow-hidden bg-white p-2"
                                    >
                                        <!-- Price at top -->
                                        <!-- <span
                                            :style="
                                                `color:${
                                                    type == 'Precio venta'
                                                        ? '#E6A23C'
                                                        : '#000'
                                                }`
                                            "
                                            class="text-center mb-1"
                                            style="font-size: 14px;"
                                        >
                                            S/. {{ sale_code || "N/D" }}
                                        </span> -->

                                        <!-- Image section immediately below price -->
                                        <div class="mb-2">
                                            <div
                                                v-if="imageSaved"
                                                class="d-flex justify-content-center"
                                            >
                                                <img
                                                    :src="imageSaved"
                                                    alt="imagen"
                                                    class="img-thumbnail"
                                                    style="width: 120px; height: 60px; object-fit: contain;"
                                                />
                                            </div>
                                            <div
                                                v-else
                                                class="d-flex justify-content-center"
                                            >
                                                <el-empty
                                                    :image-size="80"
                                                ></el-empty>
                                            </div>
                                        </div>

                                        <!-- Description below image -->
                                        <span
                                            class="text-center mb-2"
                                            style="font-size: 12px;"
                                        >
                                            {{
                                                product.descripcion ||
                                                    "DESCRIPCION DEL PRODUCTO"
                                            }}
                                        </span>

                                        <!-- Barcode at bottom -->
                                        <img
                                            v-show="product_id"
                                            id="barcode"
                                            alt="barcode"
                                            class="mb-2"
                                        />

                                        <!-- Footer info -->
                                        <div
                                            class="d-flex w-100 justify-content-between"
                                            style="font-size: 12px;"
                                        >
                                            <span>{{
                                                product.location || "S/L"
                                            }}</span>
                                            <span
                                                :style="
                                                    `color:${
                                                        type != 'Precio venta'
                                                            ? '#409EFF'
                                                            : '#000'
                                                    }`
                                                "
                                            >
                                                {{ purchase_code || "N/D" }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    v-if="
                                        modeloSeleccionado === 'Modelo9' &&
                                            configuration.model_09
                                    "
                                    class="d-flex flex-row justify-content-center preview-container"
                                >
                                    <div
                                        class="border d-flex flex-row align-items-center h150 w300 overflow-hidden bg-white"
                                    >
                                        <div
                                            class="d-flex flex-column align-items-center p-2"
                                            style="width: 50%;"
                                        >
                                            <span
                                                class="text-center"
                                                style="font-size: 12px;"
                                            >
                                                {{
                                                    product.descripcion ||
                                                        "DESCRIPCION"
                                                }}
                                            </span>
                                            <span
                                                :style="
                                                    `color:${
                                                        type == 'Precio venta'
                                                            ? '#E6A23C'
                                                            : '#000'
                                                    }`
                                                "
                                                class="text-center"
                                                >S/.
                                                {{ sale_code || "N/D" }}</span
                                            >
                                            <span
                                                :style="
                                                    `color:${
                                                        type != 'Precio venta'
                                                            ? '#409EFF'
                                                            : '#000'
                                                    }; margin-left: auto; display: block; text-align: right;`
                                                "
                                                >{{
                                                    purchase_code || "N/D"
                                                }}</span
                                            >
                                        </div>
                                        <div
                                            class="d-flex flex-column align-items-center p-2"
                                            style="width: 50%;"
                                        >
                                            <span
                                                class="text-center"
                                                style="font-size: 12px;"
                                            >
                                                {{
                                                    product.descripcion ||
                                                        "DESCRIPCION"
                                                }}
                                            </span>
                                            <span
                                                :style="
                                                    `color:${
                                                        type == 'Precio venta'
                                                            ? '#E6A23C'
                                                            : '#000'
                                                    }`
                                                "
                                                class="text-center"
                                                >S/.
                                                {{ sale_code || "N/D" }}</span
                                            >
                                            <span
                                                :style="
                                                    `color:${
                                                        type != 'Precio venta'
                                                            ? '#409EFF'
                                                            : '#000'
                                                    }; margin-left: auto; display: block; text-align: right;`
                                                "
                                                >{{
                                                    purchase_code || "N/D"
                                                }}</span
                                            >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div
                                    v-if="product_id"
                                    class="d-flex justify-content-center"
                                >
                                    <div class="d-flex gap-3">
                                        <el-button
                                            type="success"
                                            size="large"
                                            style="padding: 15px 30px; font-size: 16px;"
                                            @click="generate"
                                        >
                                            <i
                                                class="fas fa-print"
                                                style="margin-right: 8px;"
                                            ></i>
                                            Imprimir
                                        </el-button>

                                        <el-button
                                            type="danger"
                                            size="large"
                                            style="padding: 15px 30px; font-size: 16px;"
                                            @click="generatePdf"
                                        >
                                            <i
                                                class="fas fa-file-pdf"
                                                style="margin-right: 8px;"
                                            ></i>
                                            Exportar
                                        </el-button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header">
                                <h5>Modelos de etiquetas</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!-- Primera fila -->
                                    <div class="col-6 mb-3">
                                        <div
                                            class="image-container border rounded p-2"
                                        >
                                            <img
                                                src="/storage/modelos/modelo1.png"
                                                alt="Preview 1"
                                                class="img-fluid"
                                                @click="modelType = 1"
                                                :class="{
                                                    'border-primary':
                                                        modelType === 1
                                                }"
                                            />
                                            <div class="text-center mt-2">
                                                <small style="color: #ff0000;"
                                                    >Modelo 1 medida de 50x25
                                                    una columna</small
                                                >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <div
                                            class="image-container border rounded p-2"
                                        >
                                            <img
                                                src="/storage/modelos/modelo2.png"
                                                alt="Preview 2"
                                                class="img-fluid"
                                                @click="modelType = 2"
                                                :class="{
                                                    'border-primary':
                                                        modelType === 2
                                                }"
                                            />
                                            <div class="text-center mt-2">
                                                <small style="color: #ff0000;"
                                                    >Modelo 2 mediad de 60x20 2
                                                    columnas</small
                                                >
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Segunda fila -->
                                    <div class="col-6 mb-3">
                                        <div
                                            class="image-container border rounded p-2"
                                        >
                                            <img
                                                src="/storage/modelos/modelo3.png"
                                                alt="Preview 3"
                                                class="img-fluid"
                                                @click="modelType = 3"
                                                :class="{
                                                    'border-primary':
                                                        modelType === 3
                                                }"
                                            />
                                            <div class="text-center mt-2">
                                                <small style="color: #ff0000;"
                                                    >Modelo 3 medida de 60x20 2
                                                    columnas</small
                                                >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <div
                                            class="image-container border rounded p-2"
                                        >
                                            <img
                                                src="/storage/modelos/modelo4.png"
                                                alt="Preview 4"
                                                class="img-fluid"
                                                @click="modelType = 4"
                                                :class="{
                                                    'border-primary':
                                                        modelType === 4
                                                }"
                                            />
                                            <div class="text-center mt-2">
                                                <small style="color: #ff0000;"
                                                    >Modelo 4 medidad de 60x20 2
                                                    columnas</small
                                                >
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="col-6 mb-3">
                                        <div
                                            class="image-container border rounded p-2"
                                        >
                                            <img
                                                src="/storage/modelos/modelo5.png"
                                                alt="Preview 4"
                                                class="img-fluid"
                                                @click="modelType = 5"
                                                :class="{
                                                    'border-primary':
                                                        modelType === 5
                                                }"
                                            />
                                            <div class="text-center mt-2">
                                                <small>Modelo 5</small>
                                            </div>
                                        </div>
                                    </div> -->
                                    <div class="col-6 mb-3">
                                        <div
                                            class="image-container border rounded p-2"
                                        >
                                            <img
                                                src="/storage/modelos/modelo6.png"
                                                alt="Preview 4"
                                                class="img-fluid"
                                                @click="modelType = 6"
                                                :class="{
                                                    'border-primary':
                                                        modelType === 6
                                                }"
                                            />
                                            <div class="text-center mt-2">
                                                <small style="color: #ff0000;"
                                                    >Modelo 6 medida de 60x20 2
                                                    columnas</small
                                                >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <div
                                            class="image-container border rounded p-2"
                                        >
                                            <img
                                                src="/storage/modelos/modelo7.png"
                                                alt="Preview 4"
                                                class="img-fluid"
                                                @click="modelType = 7"
                                                :class="{
                                                    'border-primary':
                                                        modelType === 7
                                                }"
                                            />
                                            <div class="text-center mt-2">
                                                <small style="color: #ff0000;"
                                                    >Modelo 7 la medida es de
                                                    60x20 2 columnas</small
                                                >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <div
                                            class="image-container border rounded p-2"
                                        >
                                            <img
                                                src="/storage/modelos/modelo5.png"
                                                alt="Preview 4"
                                                class="img-fluid"
                                                @click="modelType = 5"
                                                :class="{
                                                    'border-primary':
                                                        modelType === 5
                                                }"
                                            />
                                            <div class="text-center mt-2">
                                                <small
                                                    class="fw-bold"
                                                    style="color: #ff0000;"
                                                    >modelo 5 medida es de
                                                    100x25 2 columnas</small
                                                >
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="col-12 mb-3"
                                        style="border-top: 2px solid #000;"
                                        v-if="typeUser == 'superadmin'"
                                    >
                                        <div class="text-center">
                                            <label
                                                ><b
                                                    >Configuración de
                                                    impresión</b
                                                ></label
                                            >
                                        </div>
                                        <template>
                                            <div class="row">
                                                <div class="col-md-6 col-12">
                                                    <label for="density"
                                                        >Densidad</label
                                                    >
                                                    <el-input
                                                        type="number"
                                                        v-model="config.density"
                                                    ></el-input>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <label for="orientation"
                                                        >Orientación</label
                                                    >
                                                    <el-select
                                                        v-model="
                                                            config.orientation
                                                        "
                                                    >
                                                        <el-option
                                                            label="Vertical"
                                                            value="portrait"
                                                        ></el-option>
                                                        <el-option
                                                            label="Horizontal"
                                                            value="landscape"
                                                        ></el-option>
                                                    </el-select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 col-12">
                                                    <label for="top"
                                                        >Arriba</label
                                                    >
                                                    <el-input
                                                        type="number"
                                                        v-model="
                                                            config.margins.top
                                                        "
                                                    ></el-input>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <label for="left"
                                                        >Izquierda</label
                                                    >
                                                    <el-input
                                                        type="number"
                                                        v-model="
                                                            config.margins.left
                                                        "
                                                    ></el-input>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <label for="right"
                                                        >Derecha</label
                                                    >
                                                    <el-input
                                                        type="number"
                                                        v-model="
                                                            config.margins.right
                                                        "
                                                    ></el-input>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <label for="bottom"
                                                        >Abajo</label
                                                    >
                                                    <el-input
                                                        type="number"
                                                        v-model="
                                                            config.margins
                                                                .bottom
                                                        "
                                                    ></el-input>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <form-word :words.sync="words" :showDialog.sync="showForm"></form-word>
        <items-form
            v-if="showDialogNewItem"
            :showDialog.sync="showDialogNewItem"
            :external="true"
            @add="handleItemCreated"
        ></items-form>
        <inventories-form
            :showDialog.sync="showDialog"
            :type.sync="typeTransaction"
            ref="cargarStock"
            :external="true"
            @stock="stockReal"
        ></inventories-form>
    </div>
</template>
<style scoped>
.h150 {
    height: 150px;
}
.w150 {
    width: 150px;
}
.w300 {
    width: 350px;
}
.tab-container {
    width: 100%;
    margin: 1rem 0;
}

.responsive-tabs {
    width: 100%;
}

.tab-content {
    padding: 1rem;
}

.input-group {
    margin-bottom: 1rem;
    width: 100%;
}

.input-group label {
    display: block;
    margin-bottom: 0.5rem;
}

.responsive-input,
.responsive-select {
    width: 100%;
    max-width: 400px;
}

/* Mobile styles */
@media (max-width: 768px) {
    .tab-content {
        padding: 0.5rem;
    }

    .input-group {
        margin-bottom: 0.8rem;
    }

    .responsive-input,
    .responsive-select {
        max-width: 100%;
    }

    :deep(.el-tabs__header) {
        margin-bottom: 1rem;
    }

    :deep(.el-tabs__item) {
        padding: 0 10px;
        font-size: 14px;
    }
}

/* Tablet styles */
@media (min-width: 769px) and (max-width: 1024px) {
    .responsive-input,
    .responsive-select {
        max-width: 300px;
    }
}

/* Nuevos estilos responsivos */
@media (max-width: 800px) {
    .w300 {
        width: 100%;
        max-width: 350px;
    }

    .card-body .row {
        flex-direction: column;
    }

    .col-md-3,
    .col-md-6 {
        width: 100%;
        margin-bottom: 20px;
    }

    .preview-container {
        overflow-x: auto;
    }

    .el-radio-group {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
    }

    .el-radio-button {
        width: 100%;
    }

    /* Ajustes para el contenedor de imagen */
    .image-upload-container {
        width: 100%;
        max-width: 300px;
        margin: 0 auto;
    }

    /* Ajustes para los selectores y controles */
    .el-select,
    .el-input {
        width: 100% !important;
    }

    /* Ajustes para los botones */
    .button-container {
        display: flex;
        flex-direction: column;
        gap: 10px;
        align-items: center;
    }

    .button-container .el-button {
        width: 100%;
        max-width: 200px;
    }
}

/* Ajustes específicos para móviles */
@media (max-width: 480px) {
    .el-radio-group {
        grid-template-columns: 1fr;
    }

    .preview-label {
        transform: scale(0.8);
    }

    .card-header h4 {
        font-size: 1.2rem;
    }

    .breadcrumb {
        font-size: 0.8rem;
    }

    /* Ajustar layout de columnas para móvil */
    .d-flex.flex-row {
        flex-direction: column !important;
    }

    .col-md-4,
    .col-md-8,
    .col-md-12 {
        padding: 0 10px;
    }

    /* Ajustes para los modelos de etiquetas */
    .label-preview {
        transform: scale(0.9);
        transform-origin: top center;
    }
}

/* Ajustes para tablets */
@media (min-width: 481px) and (max-width: 800px) {
    .preview-label {
        transform: scale(0.9);
    }

    .el-radio-group {
        grid-template-columns: repeat(2, 1fr);
    }

    /* Mejorar espaciado en tablets */
    .card-body {
        padding: 15px;
    }

    .row > div {
        margin-bottom: 15px;
    }
}

/* Nuevos breakpoints para mejorar la responsividad */
@media (max-width: 1400px) {
    .card-body .row {
        margin: 0;
    }

    .col-md-3,
    .col-md-6 {
        padding: 10px;
    }

    .preview-container {
        max-width: 100%;
        overflow-x: auto;
    }

    .el-radio-group {
        flex-wrap: wrap;
    }

    .image-upload-container {
        max-width: 100%;
    }
}

@media (max-width: 1200px) {
    .w300 {
        width: 100%;
        max-width: 300px;
        margin: 0 auto;
    }

    .d-flex.flex-row.justify-content-center.preview-container {
        justify-content: flex-start !important;
        padding: 10px;
    }

    .el-radio-button {
        margin-bottom: 5px;
    }

    .button-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
    }

    .image-container img {
        max-width: 100%;
        height: auto;
    }
}

@media (max-width: 992px) {
    .card-body .row > div {
        width: 100%;
    }

    .col-md-3,
    .col-md-6 {
        flex: 0 0 100%;
        max-width: 100%;
    }

    .preview-container {
        justify-content: center !important;
    }

    .el-select,
    .el-input {
        width: 100% !important;
    }
}

/* Ajuste específico para mantener el layout entre 800px y 992px */
@media (min-width: 800px) and (max-width: 991px) {
    .col-md-3 {
        flex: 0 0 30%;
        max-width: 30%;
    }

    .col-md-6 {
        flex: 0 0 70%;
        max-width: 70%;
    }
}

/* Estilos para el layout de columnas */
.column-selector {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

/* Estilos para el contenedor de columnas x etiquetas */
.column-option {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
}

/* Mejoras para los tabs responsivos */
:deep(.el-tabs__header) {
    margin-bottom: 1rem;
}

:deep(.el-tabs__nav-wrap) {
    padding: 0;
}

:deep(.el-tabs__item) {
    padding: 0 15px;
}

/* Nuevos breakpoints específicos */
@media (max-width: 1400px) {
    .d-flex.flex-row.align-items-center.mb-3 {
        flex-wrap: wrap;
        gap: 10px;
    }

    [role="button"][style*="width: 200px"] {
        width: 150px !important;
        min-height: 60px !important;
        font-size: 0.9rem;
    }

    .preview-container {
        transform: scale(0.9);
        transform-origin: left center;
    }

    :deep(.el-tabs__nav) {
        transform: scale(0.95);
        transform-origin: left center;
    }
}

@media (max-width: 1200px) {
    .col-md-3,
    .col-md-6 {
        padding: 5px;
    }

    [role="button"][style*="width: 200px"] {
        width: 130px !important;
        min-height: 50px !important;
        font-size: 0.85rem;
    }

    .ml-3 img {
        width: 120px;
        height: 80px;
    }

    :deep(.el-tabs__item) {
        padding: 0 10px;
        font-size: 14px;
    }

    .input-group {
        flex-direction: column;
    }

    .el-radio-group {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 5px;
    }

    .el-radio-button {
        margin: 2px;
    }
}

@media (max-width: 1024px) {
    .d-flex.flex-row.align-items-center.mb-3 {
        flex-direction: column !important;
        align-items: center !important;
    }

    [role="button"][style*="width: 200px"] {
        width: 100% !important;
        max-width: 200px;
        margin: 5px 0;
    }

    .ml-3 {
        margin-left: 0 !important;
        margin-top: 10px;
    }

    .preview-container {
        transform: scale(0.85);
    }

    :deep(.el-tabs__nav) {
        width: 100%;
        display: flex;
        justify-content: space-between;
    }

    :deep(.el-tabs__item) {
        flex: 1;
        text-align: center;
    }
}

/* Ajustes específicos para inputs y controles */
.el-input-group {
    margin-bottom: 1rem;
}

.el-input,
.el-select {
    width: 100%;
    max-width: none;
}

/* Ajuste para los botones de radio */
.el-radio-button__inner {
    padding: 8px 15px;
    white-space: normal;
    height: auto;
    line-height: 1.2;
}
.responsive-container {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 1rem;
}

.product-search-header {
    width: 100%;
}

.search-stock-container {
    width: 100%;
}

.price-type-selection {
    width: 100%;
}

.tab-container {
    width: 100%;
    margin-top: 1rem;
}

.input-group {
    width: 100%;
}

/* Small devices (phones) */
@media (max-width: 576px) {
    .responsive-container {
        padding: 0.5rem;
    }

    .el-radio-group {
        flex-direction: column;
        width: 100%;
    }

    .el-radio-button {
        width: 100%;
        margin-bottom: 0.5rem;
    }

    .tab-content {
        padding: 0.5rem;
    }
}

/* Medium devices (tablets) */
@media (min-width: 577px) and (max-width: 768px) {
    .search-stock-container .el-select,
    .search-stock-container .el-input {
        width: 100%;
    }
}

/* Large devices (desktops) */
@media (min-width: 769px) {
    .search-stock-container {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
}

.cursor-pointer {
    cursor: pointer;
}

/* Element UI overrides */
:deep(.el-tabs__content) {
    overflow: visible;
}

:deep(.el-select) {
    width: 100%;
}

:deep(.el-input__inner) {
    width: 100%;
}

:deep(.el-radio-button__inner) {
    white-space: normal;
    height: auto;
    padding: 8px 15px;
}
</style>
<script>
import FormWord from "../form.vue";
import ItemsForm from "../../../../../../../resources/js/views/items/form.vue";
import InventoriesForm from "../../../../../../../modules/Inventory/Resources/assets/js/inventory/form.vue";
/* import InventoriesFormOutput from "../../../../../../modules/Inventory/Resources/assets/js/inventory/form_output.vue"; */
import JsBarcode from "jsbarcode";
export default {
    props: ["configuration", "typeUser"],
    components: { FormWord, ItemsForm, InventoriesForm },
    data() {
        return {
            typeTransaction: null,
            showDialog: false,
            showDialogNewItem: false,
            establishment: [],
            activeTab: "normal", // Default tab
            establishment: null,
            lector_barcode: false,
            item_for_barcode: null,
            limitFormat: false,
            QSticker: 1,
            paperType: 1,
            config: {
                scaleContent: false,
                density: 200,
                orientation: "portrait",
                margins: {
                    top: 0,
                    left: 0,
                    right: 0,
                    bottom: 0
                }
            },
            loading: false,
            imageSaved: null,
            image: null,
            time: null,
            showForm: false,
            type: "Precio venta",
            type_barcode: "Cod. murcielago",
            loading_search: false,
            quantity: 0,
            typeBarcode: null,
            disabled: true,
            sale_type: null,
            sale_code: null,
            sale_murc: null,
            sale_murc_val: null,
            purchase_murc: null,
            purchase_murc_val: null,
            purchase_type: null,
            purchase_code: null,
            sale_price_format: null,
            price1: null,
            murcielagoCode: null,
            product: {},
            codes: [],
            words: [],
            product_id: null,
            company_name: null,
            items: [],
            resource: "etiquetas",
            modelType: 1,
            timer: null,
            configSave: {}
        };
    },
    computed: {
        modeloSeleccionado() {
            switch (this.modelType) {
                case 1:
                    return "Modelo1";
                case 2:
                    return "Modelo2";
                case 3:
                    return "Modelo3";
                case 4:
                    return "Modelo4";
                case 5:
                    return "Modelo5";
                case 6:
                    return "Modelo6";
                case 7:
                    return "Modelo7";
                case 8:
                    return "Modelo8";
                case 9:
                    return "Modelo9";
                default:
                    return null;
            }
        },
        getCurrentMurcValue: {
            get() {
                return this.type === "Precio venta"
                    ? this.sale_murc
                    : this.purchase_murc;
            },
            set(value) {
                if (this.type === "Precio venta") {
                    this.sale_murc = value;
                } else {
                    this.purchase_murc = value;
                }
            }
        },
        getCurrentMurcNumberValue: {
            get() {
                return this.type === "Precio venta"
                    ? this.sale_murc_val
                    : this.purchase_murc_val;
            },
            set(value) {
                if (this.type === "Precio venta") {
                    this.sale_murc_val = value;
                } else {
                    this.purchase_murc_val = value;
                }
            }
        },
        getActiveTabValue: {
            get() {
                if (!this.product_id) return "";

                const isVenta = this.type === "Precio venta";
                const price = isVenta
                    ? this.product.price
                    : this.product.purchase;

                switch (this.activeTab) {
                    case "normal":
                        return Number(price).toFixed(2);
                    case "murcielago":
                        const murcId = isVenta
                            ? this.sale_murc
                            : this.purchase_murc;
                        const murcVal = isVenta
                            ? this.sale_murc_val
                            : this.purchase_murc_val;
                        return this.murciType(murcId, murcVal || price);
                    case "vacio":
                        return "";
                    default:
                        return "";
                }
            },
            set(value) {
                if (this.type === "Precio venta") {
                    this.sale_code = value;
                } else {
                    this.purchase_code = value;
                }
            }
        }
    },
    async created() {
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
    async mounted() {
        await this.getTables();
        this.changeConfig();
    },
    watch: {
        activeTab(newVal) {
            // Actualizar el tipo correspondiente cuando cambia el tab
            if (this.type === "Precio venta") {
                this.sale_type =
                    newVal === "normal" ? 2 : newVal === "murcielago" ? 1 : 3;
            } else {
                this.purchase_type =
                    newVal === "normal" ? 2 : newVal === "murcielago" ? 1 : 3;
            }
            this.formatValueCode();
        },
        type(newVal) {
            // Actualizar el tab activo cuando cambia entre venta y compra
            if (newVal === "Precio venta") {
                this.activeTab =
                    this.sale_type === 2
                        ? "normal"
                        : this.sale_type === 1
                        ? "murcielago"
                        : "vacio";
            } else {
                this.activeTab =
                    this.purchase_type === 2
                        ? "normal"
                        : this.purchase_type === 1
                        ? "murcielago"
                        : "vacio";
            }
        },
        modelType: {
            handler(newVal) {
                if (this.product_id && this.product.barras) {
                    setTimeout(() => {
                        this.regenerateBarcode();
                    }, 100);
                }
            }
        }
    },
    methods: {
        stockReal(quantity) {
            console.log("🚀 ~ stockReal ~ newItem", quantity);
            this.quantity = quantity;
            this.$toast.success(
                "Stock actualizado correctamente en el producto seleccionado"
            );
        },
        clickCreate(type) {
            console.log("🚀 ~ clickCreate ~ type:", type);
            this.recordId = null;
            this.typeTransaction = type;
            this.showDialog = true;
        },
        async handleItemCreated(newItem) {
            try {
                // Initial formatting of the new item
                const formattedItem = {
                    id: newItem.id,
                    descripcion: newItem.description || newItem.name,
                    barras: newItem.barras || newItem.internal_id,
                    tipo_barras: newItem.tipo_barras || "CODE-128",
                    stock: newItem.stock || 0,
                    price: newItem.sale_unit_price || newItem.price || 0,
                    purchase:
                        newItem.purchase_unit_price || newItem.purchase || 0,
                    location: newItem.location || "",
                    item_unit_type: Array.isArray(newItem.item_unit_type)
                        ? newItem.item_unit_type
                        : [newItem.item_unit_type].filter(Boolean)
                };

                // Set the product_id to trigger a search
                this.product_id = formattedItem.id;

                // Fetch complete product information
                const response = await this.$http.get(
                    `/${this.resource}/items/?input=${formattedItem.descripcion}`
                );

                if (response.data.items && response.data.items.length > 0) {
                    // Update items array with complete product information
                    this.items = response.data.items;

                    // Find the newly created product in the response
                    const completeProduct = this.items.find(
                        item => item.id === formattedItem.id
                    );

                    if (completeProduct) {
                        // Process the complete product information
                        let price1 = null;
                        let price2 = null;
                        let price3 = null;

                        if (
                            Array.isArray(completeProduct.item_unit_types) &&
                            completeProduct.item_unit_types.length > 0
                        ) {
                            const validPrices = completeProduct.item_unit_types
                                .map(ut => parseFloat(ut.price1))
                                .filter(p => !isNaN(p) && p > 0)
                                .sort((a, b) => a - b);

                            if (validPrices.length > 0) price1 = validPrices[0];
                            if (validPrices.length > 1) price2 = validPrices[1];
                            if (validPrices.length > 2) price3 = validPrices[2];
                        }

                        completeProduct.price1 = price1;
                        completeProduct.price2 = price2;
                        completeProduct.price3 = price3;

                        if (price1 && this.words && this.words.length > 0) {
                            const firstWord = this.words[0];
                            completeProduct.murcielagoCode = this.murciType(
                                firstWord.id,
                                price1.toFixed(2)
                            );
                        }

                        // Trigger changeItem with complete product information
                        await this.$nextTick();
                        this.changeItem();

                        if (this.$refs.cargarStock) {
                            this.$refs.cargarStock.setProduct([formattedItem]);
                        }
                    }
                }

                this.$toast.success(
                    "Producto creado y seleccionado correctamente"
                );
                this.showDialogNewItem = false;
            } catch (error) {
                console.error("Error al procesar el nuevo producto:", error);
                this.$toast.error("Error al procesar el nuevo producto");
            }
        },

        createItem() {
            this.value = null;
            this.showDialogNewItem = true;
        },
        getBarcodeId(modelo, index) {
            return `barcode-${modelo}-${index || 0}`;
        },
        /*regenerateBarcode() {
            if (!this.product || !this.product.barras) return;

            this.$nextTick(() => {
                const barcodes = document.querySelectorAll("#barcode");
                if (!barcodes.length) return;

                const config = {
                    height: 30,
                    textPosition: "bottom",
                    fontSize: 12,
                    width: 1.5,
                    margin: 0
                };

                barcodes.forEach(element => {
                    try {
                        if (this.typeBarcode === "EAN-8") {
                            JsBarcode(element)
                                .EAN8(this.product.barras, config)
                                .render();
                        } else {
                            JsBarcode(element)
                                .CODE128(this.product.barras, config)
                                .render();
                        }
                    } catch (error) {
                        console.error(
                            "Error al generar código de barras:",
                            error
                        );
                    }
                });
            });
        },*/

        /*regenerateBarcode() {
            if (!this.product || !this.product.barras) return;

            // Asegurarse de que barras sea un array
            const barcodesArray = Array.isArray(this.product.barras) ? this.product.barras : [this.product.barras];

            this.$nextTick(() => {
                const config = {
                    height: 30,
                    textPosition: "bottom",
                    fontSize: 12,
                    width: 1.5,
                    margin: 0
                };

                // Busca todos los elementos con clase .barcode
                const barcodeElements = document.querySelectorAll(".barcode");

                barcodeElements.forEach((element, index) => {
                    const code = barcodesArray[index % barcodesArray.length];
                    if (!code) return;

                    try {
                        if (this.typeBarcode === "EAN-8") {
                            JsBarcode(element)
                                .EAN8(code, config)
                                .render();
                        } else {
                            JsBarcode(element)
                                .CODE128(code, config)
                                .render();
                        }
                    } catch (error) {
                        console.error(
                            "Error al generar código de barras:",
                            error,
                            "para código:",
                            code
                        );
                    }
                });
            });
        },*/

        regenerateBarcode() {
            if (!this.product || !this.product.barras) return;

            // Asegurarse de que barras sea un array
            const barcodesArray = Array.isArray(this.product.barras)
                ? this.product.barras
                : [this.product.barras];

            this.$nextTick(() => {
                const config = {
                    height: 30,
                    textPosition: "bottom",
                    fontSize: 12,
                    width: 1.5,
                    margin: 0
                };

                // Busca todos los elementos con clase .barcode
                const barcodeElements = document.querySelectorAll(".barcode");

                barcodeElements.forEach((element, index) => {
                    const code = barcodesArray[index % barcodesArray.length];
                    if (!code) return;

                    try {
                        if (this.typeBarcode === "EAN-8") {
                            JsBarcode(element)
                                .EAN8(code, config)
                                .render();
                        } else {
                            JsBarcode(element)
                                .CODE128(code, config)
                                .render();
                        }
                    } catch (error) {
                        console.error(
                            "Error al generar código de barras:",
                            error,
                            "para código:",
                            code
                        );
                    }
                });
            });
        },

        initConfig() {
            this.config = {
                scaleContent: false,
                density: 200,
                orientation: "portrait",
                margins: {
                    top: 0,
                    left: 0,
                    right: 0,
                    bottom: 0
                }
            };
        },

        changeConfig() {
            let { config_etiquetas } = this.configuration;
            if (config_etiquetas && config_etiquetas.length > 0) {
                let config = config_etiquetas.find(
                    c =>
                        c.paperType == this.paperType &&
                        c.modelType == this.modelType &&
                        c.QSticker == this.QSticker
                );
                if (config) {
                    this.config = config;
                } else {
                    this.initConfig();
                }
            }
        },

        saveConfig() {
            let config = {
                ...this.config,
                QSticker: this.QSticker,
                paperType: this.paperType,
                modelType: this.modelType
            };

            this.$http
                .post("/configurations/etiquetas", config)
                .then(response => {
                    // this.$toast.success('Configuración guardada');
                })
                .catch(e => {
                    const {
                        data: { message }
                    } = e.response;
                    this.$toast.error(message);
                });
        },

        changeModel(type) {
            this.modelType = type;
            this.changeConfig();
            if (this.product_id && this.product.barras) {
                // Dar tiempo al DOM para actualizarse
                setTimeout(() => {
                    this.regenerateBarcode();
                }, 100);
            }
        },

        generateBarcode(barcode, type) {
            this.typeBarcode = type || "CODE128";
            if (barcode) {
                this.product.barras = barcode;
                this.regenerateBarcode();
            }
        },

        async delete_image() {
            try {
                this.loading = true;
                const response = await this.$http.get(
                    `${this.resource}/delete_image`
                );
                this.$toast.success("Imagen eliminada");
                const {
                    data: { image }
                } = response;
                this.imageSaved = image;
                this.loading = false;
            } catch (e) {
                const {
                    data: { message }
                } = e.response;
                this.$toast.error(message);
                this.loading = false;
            }
        },

        quantityToPaper(quantity) {
            let f = this.QSticker; //1 2 4
            let p = this.paperType; // 1 2

            if (f == 1) {
                if (p == 1) {
                    return quantity;
                } else {
                    return Math.ceil(quantity / 2) * 2;
                }
            }
            if (f == 2) {
                if (p == 1) {
                    return Math.ceil(quantity / 2) * 2;
                } else {
                    return Math.ceil(quantity / 4) * 4;
                }
            }

            if (f == 4) {
                if (p == 1) {
                    return Math.ceil(quantity / 4) * 4;
                } else {
                    return Math.ceil(quantity / 8) * 8;
                }
            }
        },

        async generatePdf() {
            if (this.quantity == 0 || this.quantity.length == 0) {
                this.$toast.error("La cantidad es obligatoria.");
                return;
            }

            if (this.quantity > 100) {
                try {
                    await this.$confirm(
                        `Está apunto de imprimir ${this.quantity} stickers, si desea puede cambiar la cantidad de manera
                        manual. En caso contrario de click en 'Continuar'.`,
                        "Mensaje de Advertencia",
                        {
                            confirmButtonText: "Continuar",
                            cancelButtonText: "Cambiar cantidad",
                            type: "warning"
                        }
                    );
                } catch (e) {
                    return;
                }
            }
            try {
                this.loading = true;
                this.quantity = this.quantityToPaper(this.quantity);
                const config = { responseType: "blob" };

                // Asegurarse de que barras sea un array
                const barcodesArray = Array.isArray(this.product.barras)
                    ? this.product.barras
                    : [this.product.barras];
                // Convertir el array de códigos en una cadena separada por comas y codificarla
                const barcodesParam = barcodesArray
                    .map(code => encodeURIComponent(code))
                    .join(",");

                let endPoint = `codes/generate?stock=${
                    this.quantity
                }&salecode=${this.sale_code}&price1=${this.price1}&price2=${
                    this.price2
                }&purchasecode=${
                    this.purchase_code
                }&description=${encodeURIComponent(
                    this.product.descripcion
                )}&paper=${this.paperType}&format=${
                    this.QSticker
                }&barcode=${barcodesParam}&type_barcode=${encodeURIComponent(
                    this.typeBarcode
                )}&location=${this.product.location || ""}
                &type=${this.modelType || ""}
                `;
                console.log(endPoint);

                const response = await axios.get(endPoint, config);
                console.log(response);
                console.log(this.configuration);
                const url = window.URL.createObjectURL(
                    new Blob([response.data])
                );
                const link = document.createElement("a");
                link.href = url;
                console.log(url);
                link.setAttribute("download", "file.pdf");
                document.body.appendChild(link);
                link.click();

                this.loading = false;
            } catch (e) {
                console.log(e);
                const {
                    data: { message }
                } = e.response;
                this.$toast.error(message);
                this.loading = false;
            }
            if (this.lector_barcode) {
                this.$refs.input_barcode.focus();
                this.item_for_barcode = null;
            }
        },

        async generate() {
            if (this.quantity == 0 || this.quantity.length == 0) {
                this.$toast.error("La cantidad es obligatoria.");
                return;
            }

            if (this.quantity > 100) {
                try {
                    await this.$confirm(
                        `Está apunto de imprimir ${this.quantity} stickers, si desea puede cambiar la cantidad de manera
                        manual. En caso contrario de click en 'Continuar'.`,
                        "Mensaje de Advertencia",
                        {
                            confirmButtonText: "Continuar",
                            cancelButtonText: "Cambiar cantidad",
                            type: "warning"
                        }
                    );
                } catch (e) {
                    return;
                }
            }
            try {
                this.loading = true;
                this.quantity = this.quantityToPaper(this.quantity);
                const config = { responseType: "blob" };

                // Asegurarse de que barras sea un array
                const barcodesArray = Array.isArray(this.product.barras)
                    ? this.product.barras
                    : [this.product.barras];
                // Convertir el array de códigos en una cadena separada por comas y codificarla
                const barcodesParam = barcodesArray
                    .map(code => encodeURIComponent(code))
                    .join(",");

                let endPoint = `codes/generate?stock=${
                    this.quantity
                }&salecode=${this.sale_code}&price1=${this.price1}&price2=${
                    this.price2
                }&purchasecode=${
                    this.purchase_code
                }&description=${encodeURIComponent(
                    this.product.descripcion
                )}&paper=${this.paperType}&format=${
                    this.QSticker
                }&barcode=${barcodesParam}&type_barcode=${encodeURIComponent(
                    this.typeBarcode
                )}&location=${this.product.location || ""}
                &type=${this.modelType || ""}
                `;
                console.log(endPoint);
                let { etiquetadora } = this.establishment;
                this.saveConfig();
                if (etiquetadora) {
                    this.Printer(etiquetadora, endPoint);
                } else {
                    this.$toast.error(
                        "No se ha configurado la impresora de etiquetas."
                    );
                }

                this.loading = false;
            } catch (e) {
                console.log(e);
                const {
                    data: { message }
                } = e.response;
                this.$toast.error(message);
                this.loading = false;
            }
            if (this.lector_barcode) {
                this.$refs.input_barcode.focus();
                this.item_for_barcode = null;
            }
        },

        async Printer(Printer, linkpdf) {
            // let paperConfig = {
            //     scaleContent: false
            // };
            // let partsUrl = linkpdf.split("/");
            // let document = partsUrl[partsUrl.length - 1];

            let config = qz.configs.create(Printer, this.config);
            console.log(
                "🚀 ~ file: index.vue:868 ~ Printer ~ linkpdf:",
                linkpdf
            );

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
        },

        changeFormat(quantity) {
            if (this.limitFormat && quantity != 1) {
                this.$toast.error(
                    "Código de barra largo, formato no disponible."
                );
                return;
            }
            this.QSticker = quantity;
            this.changeConfig();
        },

        changePaper(type) {
            this.paperType = type;
            this.changeConfig();
        },

        async changeImage() {
            let files = this.$refs.file.files;
            if (files.length > 0) {
                let file = files[0];
                const formData = new FormData();
                formData.append("file", file);
                try {
                    this.loading = true;
                    const response = await this.$http.post(
                        `${this.resource}/image`,
                        formData
                    );
                    this.$toast.success("Imagen actualizada");
                    const {
                        data: { image }
                    } = response;
                    this.imageSaved = image;
                    this.loading = false;
                } catch (e) {
                    const {
                        data: { message }
                    } = e.response;
                    this.$toast.error(message);
                    this.loading = false;
                }
            }
        },

        debounce() {
            if (this.time) {
                clearTimeout(this.time);
            }
            this.time = setTimeout(() => {
                this.formatValueCode();
            }, 150);
        },

        formatValueCode() {
            if (this.type == "Precio venta") {
                if (this.sale_type == 2) {
                    // this.sale_code = this.normalType(this.product.price);
                    this.sale_code = Number(this.product.price).toFixed(2);
                }
                if (this.sale_type == 1 && this.sale_murc) {
                    if (
                        !this.sale_murc_val ||
                        this.sale_murc_val == 0 ||
                        this.sale_murc_val == ""
                    ) {
                        this.sale_murc_val = Number(this.product.price).toFixed(
                            2
                        );
                    }
                    this.sale_code = this.murciType(
                        this.sale_murc,
                        this.sale_murc_val
                    );
                }
                if (this.sale_type == 3) {
                    this.sale_code = "";
                }
            } else {
                if (this.purchase_type == 2) {
                    this.purchase_code = this.normalType(this.product.purchase);
                }
                if (this.purchase_type == 1 && this.purchase_murc) {
                    if (
                        !this.purchase_murc_val ||
                        this.purchase_murc_val == 0 ||
                        this.purchase_murc_val == ""
                    ) {
                        this.purchase_murc_val = Number(
                            this.product.purchase
                        ).toFixed(2);
                    }
                    this.purchase_code = this.murciType(
                        this.purchase_murc,
                        this.purchase_murc_val
                    );
                }
                if (this.purchase_type == 3) {
                    this.purchase_code = "";
                }
            }
        },

        openDialogForm() {
            this.showForm = true;
        },

        murciType(id, value) {
            console.log("murciType recibió:", { id, value });

            if (!value || value.length === 0) {
                console.log("murciType: valor vacío");
                return "";
            }

            if (!id || !this.words) {
                console.log("murciType: id inválido o words no disponible");
                return "";
            }

            let word = this.words.find(w => w.id == id);
            if (!word || !word.indice) {
                console.log("murciType: palabra o índice no encontrado");
                return "";
            }

            let indice = word.indice.split("");
            let nums = value.toString().split("");
            let result = "";

            console.log("murciType procesando:", { indice, nums });

            for (let i = 0; i < nums.length; i++) {
                let num = nums[i];
                if (num === ".") {
                    result += ".";
                    continue;
                }
                let v = 9;
                if (num !== "0") {
                    v = (Number(num) || 1) - 1;
                }
                result += indice[v];
            }

            console.log("murciType resultado:", result);
            return result;
        },

        normalType(price) {
            let iniciales = this.company_name.toUpperCase();
            iniciales = iniciales
                .split(" ")
                .map(i => i[0])
                .join("");

            return `${iniciales}${Number(price) || 0}${iniciales}`;
        },

        async getTables() {
            try {
                const response = await this.$http(`${this.resource}/tables`);
                let {
                    codigos,
                    palabras,
                    company_name,
                    etiqueta,
                    establishment,
                    configuration
                } = response.data;
                this.establishment = establishment;
                this.codes = codigos;
                this.words = palabras;
                this.company_name = company_name;
                this.imageSaved = etiqueta;
            } catch (e) {
                const {
                    data: { message }
                } = e.response;
                this.$toast.error(message);
                this.loading = false;
            }
        },

        changeItem() {
            this.product = this.items.find(i => i.id == this.product_id);

            if (!this.product) {
                console.error(
                    "Producto no encontrado en items:",
                    this.product_id
                );
                return;
            }

            /* console.log("ver los productos si llegan", this.product); */

            this.generateBarcode(this.product.barras);
            if (this.product.barras) {
                this.generateBarcode(this.product.barras);
            } else {
                console.warn("El producto no tiene código de barras.");
            }

            this.quantity = Number(this.product.stock) ?? 0;
            this.typeBarcode = this.product.tipo_barras ?? "CODE-128";
            this.purchase_type = 2;
            this.sale_type = 2;
            this.sale_code = Number(this.product.price).toFixed(2);
            if (this.product.price1 != null) {
                this.price1 = Number(this.product.price1).toFixed(2);
            } else {
                this.price1 = 0;
                console.log(this.price1);
            }
            if (this.product.price2 != null) {
                this.price2 = Number(this.product.price2).toFixed(2);
            } else {
                this.price2 = 0;
                console.log("VER SIN ESTA LEENDO EL CONSOLE", this.price2);
            }
            if (
                this.product.item_unit_types &&
                this.product.item_unit_types.length > 0
            ) {
                let unit_types = this.product.item_unit_types;
                let first_unit_type = unit_types[0];
                let default_price = first_unit_type.price_default;
                let prices = [
                    first_unit_type.price1,
                    first_unit_type.price2,
                    first_unit_type.price3
                ];
                let price_default = prices[default_price - 1];
                this.price1 = price_default;
                if (unit_types.length > 1) {
                    let second_unit_type = unit_types[1];
                    let default_price_2 = second_unit_type.price_default;
                    let prices_2 = [
                        second_unit_type.price1,
                        second_unit_type.price2,
                        second_unit_type.price3
                    ];
                    let price_default_2 = prices_2[default_price_2 - 1];
                    this.price2 = price_default_2;
                }
            }
            this.murcielagoCode = this.product.murcielagoCode;
            this.purchase_code = Number(this.product.purchase).toFixed(2);
            this.formatValueCode();
            if (
                this.product.barras.length > 8 &&
                this.typeBarcode == "CODE-128"
            ) {
                this.limitFormat = true;
                this.QSticker = 1;
            } else {
                this.limitFormat = false;
            }
            this.activeTab =
                this.type === "Precio venta"
                    ? this.sale_type === 2
                        ? "normal"
                        : this.sale_type === 1
                        ? "murcielago"
                        : "vacio"
                    : this.purchase_type === 2
                    ? "normal"
                    : this.purchase_type === 1
                    ? "murcielago"
                    : "vacio";
        },

        async searchRemoteItems(input) {
            if (input.length > 2) {
                this.loading_search = true;
                let parameters = `input=${input}`;
                try {
                    let response = await this.$http.get(
                        `/codes/items/?${parameters}`
                    );
                    let { items } = response.data;
                    this.items = items;

                    this.items = this.items.map(item => {
                        let originalPrice1 = null;
                        let originalPrice2 = null;

                        // Mantener el price1 original sin modificar
                        if (
                            Array.isArray(item.item_unit_types) &&
                            item.item_unit_types.length > 0
                        ) {
                            const validPrices = item.item_unit_types
                                .map(ut => parseFloat(ut.price1))
                                .filter(p => !isNaN(p) && p > 0)
                                .sort((a, b) => a - b);

                            if (validPrices.length > 0) {
                                originalPrice1 = validPrices[0];
                            }
                            if (validPrices.length > 1) {
                                originalPrice2 = validPrices[1];
                            }
                        }

                        // Generar código murcielago solo si tenemos price1 y words
                        let murcielagoCode = null;
                        if (
                            originalPrice1 !== null &&
                            this.words &&
                            this.words.length > 0
                        ) {
                            const firstWord = this.words[0];
                            const priceStr = originalPrice1.toFixed(2);
                            murcielagoCode = this.murciType(
                                firstWord.id,
                                priceStr
                            );
                        }

                        return {
                            ...item,
                            price1: originalPrice1,
                            price2: originalPrice2,

                            murcielagoCode
                        };
                    });

                    console.log("Items procesados:", this.items);
                    this.loading_search = false;
                } catch (e) {
                    console.error("Error en searchRemoteItems:", e);
                    if (e.response) {
                        this.$toast.error(e.response.data.message);
                    } else {
                        this.$toast.error("Error al procesar la solicitud");
                    }
                    this.loading_search = false;
                }
            }
        },

        async searchItems() {
            if (this.timer) {
                clearTimeout(this.timer);
            }
            this.timer = setTimeout(async () => {
                let input = this.item_for_barcode;
                if (input.length > 2) {
                    this.loading_search = true;
                    let parameters = `input=${input}`;
                    try {
                        let response = await this.$http.get(
                            `/${this.resource}/items/?${parameters}`
                        );
                        let { items } = response.data;
                        this.items = items;
                        if (items.length == 1) {
                            this.product_id = items[0].id;
                            this.changeItem();
                        }

                        this.loading_search = false;
                    } catch (e) {
                        const {
                            data: { message }
                        } = e.response;
                        this.$toast.error(message);
                        this.loading = false;
                    }
                }
            }, 300);
        }
    }
};
</script>
