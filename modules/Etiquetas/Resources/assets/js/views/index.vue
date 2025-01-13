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
                                >Preparación de etiquetas</span
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
                    Etiquetas
                </h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div
                        class="col-12 col-lg-6 col-md-6 col-sm-12 d-flex flex-column justify-content-center align-items-center mb-2"
                    >
                        <!-- <div
                            v-if="image"
                            class="col-12 mb-2 d-flex  justify-content-center "
                            style="max-width:150px"
                        >
                            <img
                                :src="image"
                                alt="imagen"
                                class="img-thumbnail"
                            />
            </div>-->
                        <div
                            v-if="imageSaved"
                            class="col-12 mb-2 d-flex justify-content-center"
                            style="max-width:150px"
                        >
                            <img
                                :src="imageSaved"
                                alt="imagen"
                                class="img-thumbnail"
                            />
                        </div>
                        <div v-else>
                            <el-empty :image-size="250"></el-empty>
                        </div>
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
                            <i class="el-icon-delete"></i> Eliminar Imagen
                        </el-button>
                        <p>
                            <em>Reconemdado JPG, PNG, JPEG | 150x150</em>
                        </p>
                        <input
                            accept="image/png, image/jpeg, image/jpg"
                            type="file"
                            @change="changeImage"
                            ref="file"
                            style="display: none"
                        />
                    </div>
                    <div
                        class="col-12 col-lg-6 col-md-6 col-sm-12 d-flex flex-column align-items-center mb-2"
                    >
                        <div>
                            <label for="productSearch"
                                >Ingrese el Nombre del Producto:</label
                            >
                        </div>
                        <div
                            class="el-input el-input-group el-input-group--append mb-2"
                        >
                            <el-select
                                v-if="!lector_barcode"
                                v-model="product_id"
                                @change="changeItem"
                                filterable
                                remote
                                placeholder="Buscar producto"
                                popper-class="el-select-items"
                                :remote-method="searchRemoteItems"
                                :loading="loading_search"
                            >
                                <el-option
                                    v-for="option in items"
                                    :key="option.id"
                                    :value="option.id"
                                    :label="option.descripcion"
                                ></el-option>
                            </el-select>
                            <el-input
                                v-else
                                ref="input_barcode"
                                v-model="item_for_barcode"
                                @input="searchItems"
                                placeholder="Buscar producto"
                                popper-class="el-select-items"
                            ></el-input>

                            <el-checkbox v-model="lector_barcode"
                                >Lector de código de barras</el-checkbox
                            >
                        </div>

                        <div
                            class="d-flex flex-row justify-content-center align-items-center"
                        >
                            <div class="col-3">
                                <label for="a">Stock:</label>
                            </div>
                            <div class="col-6">
                                <el-input v-model="quantity"></el-input>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-center mt-2">
                            <el-radio-group
                                :fill="
                                    type == 'Precio venta'
                                        ? '#E6A23C'
                                        : '#409EFF'
                                "
                                v-model="type"
                            >
                                <el-radio-button
                                    label="Precio venta"
                                ></el-radio-button>
                                <el-radio-button
                                    label="Precio compra"
                                ></el-radio-button>
                            </el-radio-group>
                        </div>
                        <div
                            v-if="type == 'Precio venta'"
                            class="col-12 d-flex flex-column justify-content-between align-items-center"
                        >
                            <div class="mt-2 col-12 col-lg-8 col-md-8">
                                <label class="control-label">Tipo</label>
                                <el-select
                                    v-model="sale_type"
                                    @change="debounce"
                                    :disabled="!product_id"
                                >
                                    <el-option
                                        v-for="code in codes"
                                        :key="code.id"
                                        :value="code.id"
                                        :label="code.description"
                                    ></el-option>
                                </el-select>
                            </div>
                            <div
                                v-if="sale_type == 1"
                                class="mt-1 col-12 col-lg-8 col-md-8"
                            >
                                <label
                                    class="control-label text-primary"
                                    role="button"
                                    @click="openDialogForm"
                                    >Nuevo +</label
                                >
                                <el-select
                                    @change="debounce"
                                    v-model="sale_murc"
                                >
                                    <el-option
                                        v-for="word in words"
                                        :key="word.id"
                                        :value="word.id"
                                        :label="
                                            `${word.palabra} (${word.indice})`
                                        "
                                    ></el-option>
                                </el-select>
                            </div>
                            <div
                                v-if="sale_type == 1"
                                class="mt-1 col-12 col-lg-8 col-md-8"
                            >
                                <label class="control-label">Números:</label>
                                <el-input
                                    type="number"
                                    @input="debounce"
                                    v-model="sale_murc_val"
                                ></el-input>
                            </div>
                            <div class="mt-1 col-12 col-lg-8 col-md-8">
                                <label class="control-label">Valor:</label>
                                <el-input
                                    :disabled="!product_id"
                                    v-model="sale_code"
                                ></el-input>
                            </div>
                        </div>
                        <div
                            v-else
                            class="col-12 d-flex flex-column justify-content-between align-items-center"
                        >
                            <div class="mt-2 col-12 col-lg-8 col-md-8">
                                <label class="control-label"
                                    >Tipo de código</label
                                >
                                <el-select
                                    :disabled="!product_id"
                                    @change="debounce"
                                    v-model="purchase_type"
                                >
                                    <el-option
                                        v-for="code in codes"
                                        :key="code.id"
                                        :value="code.id"
                                        :label="code.description"
                                    ></el-option>
                                </el-select>
                            </div>
                            <div
                                v-if="purchase_type == 1"
                                class="mt-1 col-12 col-lg-8 col-md-8"
                            >
                                <label
                                    class="control-label text-primary"
                                    role="button"
                                    @click="openDialogForm"
                                    >Palabras base [Agregar +]</label
                                >
                                <el-select
                                    @change="debounce"
                                    v-model="purchase_murc"
                                >
                                    <el-option
                                        v-for="word in words"
                                        :key="word.id"
                                        :value="word.id"
                                        :label="word.palabra"
                                    ></el-option>
                                </el-select>
                            </div>
                            <div
                                v-if="purchase_type == 1"
                                class="mt-1 col-12 col-lg-8 col-md-8"
                            >
                                <label class="control-label">Números:</label>
                                <el-input
                                    type="number"
                                    @input="debounce"
                                    v-model="purchase_murc_val"
                                ></el-input>
                            </div>
                            <div class="mt-1 col-12 col-lg-8 col-md-8">
                                <label class="control-label">Valor</label>
                                <el-input
                                    :disabled="!product_id"
                                    v-model="purchase_code"
                                ></el-input>
                            </div>
                        </div>
                    </div>
                </div>
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
                <el-divider></el-divider>
                <div></div>
                <div class="row">
                    <div class="col-12 text-center">
                        <el-button-group>
                            <el-button
                                type="success"
                                @click="changeModel(1)"
                                plain
                                >Modelo 1</el-button
                            >
                            <el-button
                                type="success"
                                @click="changeModel(2)"
                                plain
                                >Modelo 2</el-button
                            >
                            <el-button
                                type="success"
                                @click="changeModel(3)"
                                plain
                                >Modelo 3</el-button
                            >
                            <el-button
                                type="success"
                                @click="changeModel(4)"
                                plain
                                >Modelo 4</el-button
                            >
                            <el-button
                                type="success"
                                @click="changeModel(5)"
                                plain
                                >Modelo 5</el-button
                            >
                        </el-button-group>
                    </div>
                    <!-- <div class="col-3 text-center">
            <el-button @click="changeModel(1)">Modelo 1</el-button>
          </div>
          <div class="col-3 text-center">
            <el-button @click="changeModel(2)">Modelo 2</el-button>
          </div>
          <div class="col-3 text-center">
            <el-button @click="changeModel(3)">Modelo 3</el-button>
          </div>
          <div class="col-3 text-center">
            <el-button @click="changeModel(4)">Modelo 4</el-button>
          </div>
          <div class="col-3 text-center">
            <el-button @click="changeModel(5)">Modelo 5</el-button>
          </div>-->
                </div>
                <br />
                <div
                    v-if="modeloSeleccionado === 'Modelo1'"
                    class="d-flex flex-row justify-content-center"
                >
                    <div
                        class="border d-flex flex-row align-items-center h150 w300 overflow-hidden"
                    >
                        <div>
                            <div v-if="imageSaved" class="w150 overflow-hidden">
                                <img
                                    style="border:none !important;"
                                    :src="imageSaved"
                                    alt="imagen"
                                    class="img-thumbnail"
                                />
                            </div>
                            <div
                                v-else
                                class="col-12 d-flex justify-content-center align-items-center"
                            >
                                <el-empty :image-size="150"></el-empty>
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
                                >{{ sale_code || "N/D" }}</span
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
                                <span>{{ product.location || "S/L" }}</span>
                                <span
                                    :style="
                                        `color:${
                                            type != 'Precio venta'
                                                ? '#409EFF'
                                                : '#000'
                                        }`
                                    "
                                    >{{ purchase_code || "N/D" }}</span
                                >
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    v-if="modeloSeleccionado === 'Modelo2'"
                    class="d-flex flex-row justify-content-center"
                >
                    <div
                        class="border d-flex flex-column align-items-center h150 w300 overflow-hidden"
                    >
                        <div>
                            <div v-if="imageSaved" class="w150 overflow-hidden">
                                <img
                                    style="border:none !important;"
                                    :src="imageSaved"
                                    alt="imagen"
                                    class="img-thumbnail"
                                />
                            </div>
                            <div
                                v-else
                                class="col-12 d-flex justify-content-center align-items-center"
                            >
                                <el-empty :image-size="150"></el-empty>
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
                                >{{ sale_code || "N/D" }}</span
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
                                <!-- <span>{{ product.location || "S/L" }}</span> -->
                                <span></span>
                                <span>
                                    S/
                                    {{ Number(product.price || 0).toFixed(0) }}
                                </span>
                                <!-- <span
                                    :style="
                                        `color:${
                                            type != 'Precio venta'
                                                ? '#409EFF'
                                                : '#000'
                                        }`
                                    >{{ purchase_code || "N/D" }}</span
                >-->
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    v-if="modeloSeleccionado === 'Modelo4'"
                    class="d-flex flex-row justify-content-center"
                >
                    <div
                        class="border d-flex flex-column align-items-center h150 w300 overflow-hidden"
                    >
                        <div
                            class="d-flex flex-fill flex-column justify-content-center align-items-center"
                        >
                            <div>
                                <div
                                    v-if="imageSaved"
                                    class="w150 overflow-hidden"
                                >
                                    <img
                                        style="border:none !important;"
                                        :src="imageSaved"
                                        alt="imagen"
                                        class="img-thumbnail"
                                    />
                                </div>
                                <div
                                    v-else
                                    class="col-12 d-flex justify-content-center align-items-center"
                                >
                                    <el-empty :image-size="150"></el-empty>
                                </div>
                            </div>
                            <img
                                v-show="product_id"
                                id="barcode"
                                alt="barcode"
                            />
                            <span></span>
                            <span
                                :style="
                                    `color:${
                                        type == 'Precio venta'
                                            ? '#E6A23C'
                                            : '#000'
                                    }`
                                "
                                class="text-center"
                                >{{ sale_code || "N/D" }}</span
                            >
                            <span class="text-center">
                                {{
                                    product.descripcion ||
                                        "DESCRIPCION DEL PRODUCTO"
                                }}
                            </span>

                            <div
                                class="d-flex col-12 justify-content-between p-1"
                            >
                                <span></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    v-if="modeloSeleccionado === 'Modelo3'"
                    class="d-flex flex-row justify-content-center"
                >
                    <div
                        class="border d-flex flex-column align-items-center h150 w300 overflow-hidden"
                    >
                        <div
                            class="d-flex flex-fill flex-column justify-content-center align-items-center"
                        >
                            <img
                                v-show="product_id"
                                id="barcode"
                                alt="barcode"
                            />
                            <span></span>
                            <span
                                :style="
                                    `color:${
                                        type == 'Precio venta'
                                            ? '#E6A23C'
                                            : '#000'
                                    }`
                                "
                                class="text-center"
                                >{{ sale_code || "N/D" }}</span
                            >
                            <span class="text-center">
                                {{
                                    product.descripcion ||
                                        "DESCRIPCION DEL PRODUCTO"
                                }}
                            </span>

                            <div
                                class="d-flex col-12 justify-content-between p-1"
                            >
                                <span></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    v-if="modeloSeleccionado === 'Modelo5'"
                    class="d-flex flex-row justify-content-center"
                >
                    <div
                        class="border d-flex flex-column align-items-center h150 w300 overflow-hidden"
                    >
                        <div
                            class="d-flex flex-fill flex-column justify-content-center align-items-center"
                        >
                            <div>
                                <!-- <div v-if="imageSaved" class="w150 overflow-hidden">
                  <img
                    style="border:none !important;"
                    :src="imageSaved"
                    alt="imagen"
                    class="img-thumbnail"
                  />
                </div> -->
                                <!-- <div v-else class="col-12 d-flex justify-content-center align-items-center">
                  <el-empty :image-size="150"></el-empty>
                </div> -->
                            </div>
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
                            <span></span>
                            <span
                                :style="
                                    `color:${
                                        type == 'Precio venta'
                                            ? '#E6A23C'
                                            : '#000'
                                    }`
                                "
                                class="text-center"
                                >{{ sale_code || "N/D" }}</span
                            >

                            <div
                                class="d-flex col-12 justify-content-between p-1"
                            >
                                <span></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center mt-2">
                    <span class="h4">
                        <u>TIPO DE PAPEL</u>
                    </span>
                </div>
                <div></div>
                <div
                    class="d-flex flex-column flex-lg-row flex-md-row align-items-center justify-content-center mt-1"
                >
                    <div
                        role="button"
                        style="min-height:70px"
                        @click="changePaper(1)"
                        :class="
                            `rounded col-5 col-lg-2 col-md-2 m-2 d-flex flex-row justify-content-center align-items-center
                 ${paperType == 1 ? 'text-white bg-primary' : 'border'}
                 `
                        "
                    >
                        1 etiqueta x papel
                    </div>
                    <div
                        role="button"
                        style="min-height:70px"
                        @click="changePaper(2)"
                        :class="
                            `rounded col-5 col-lg-2 col-md-2 m-2 d-flex flex-row justify-content-center align-items-center
                 ${paperType == 2 ? 'text-white bg-primary' : 'border'}
                 `
                        "
                    >
                        2 etiquetas x papel
                    </div>
                </div>

                <div
                    class="d-flex flex-column flex-lg-row flex-md-row align-items-center justify-content-center mt-1"
                ></div>
                <div class="d-flex justify-content-center mt-2">
                    <span class="h4">
                        <u>CANTIDAD DE IMPRESIÓN POR ETIQUETA (Und)</u>
                    </span>
                </div>
                <div
                    class="d-flex flex-column flex-lg-row flex-md-row align-items-center justify-content-center mt-1"
                >
                    <div
                        role="button"
                        style="min-height:70px"
                        @click="changeFormat(1)"
                        :class="
                            `col-5 col-lg-2 col-md-2 m-2 d-flex flex-row justify-content-center align-items-center  rounded m-2 ${
                                this.QSticker == 1 ? 'bg-primary' : 'border'
                            }`
                        "
                    >
                        <div class="col-6 text-center border bg-white">1</div>
                    </div>
                    <div
                        role="button"
                        style="min-height:70px"
                        @click="changeFormat(2)"
                        :class="
                            `col-5 col-lg-2 p-1 col-md-2 m-2 d-flex flex-row justify-content-center align-items-center  rounded m-2 ${
                                this.QSticker == 2 ? 'bg-primary' : 'border'
                            }`
                        "
                    >
                        <div class="bg-white m-1 border col-5 text-center">
                            1
                        </div>
                        <div class="bg-white m-1 border col-5 text-center">
                            2
                        </div>
                    </div>
                    <div
                        role="button"
                        @click="changeFormat(4)"
                        style="min-height:70px"
                        :class="
                            `d-flex  flex-column justify-content-center col-5 col-lg-2 col-md-2 rounded m-2 ${
                                this.QSticker == 4 ? 'bg-primary ' : 'border'
                            }`
                        "
                    >
                        <div
                            class="d-flex flex-row col-12 justify-content-center"
                        >
                            <div
                                class="bg-white border col-5 m-1 d-flex justify-content-center align-items-center"
                            >
                                1
                            </div>
                            <div
                                class="bg-white border col-5 m-1 d-flex justify-content-center align-items-center"
                            >
                                2
                            </div>
                        </div>
                        <div
                            class="d-flex flex-row col-12 justify-content-center"
                        >
                            <div
                                class="bg-white border col-5 m-1 d-flex justify-content-center align-items-center"
                            >
                                3
                            </div>
                            <div
                                class="bg-white border col-5 m-1 d-flex justify-content-center align-items-center"
                            >
                                4
                            </div>
                        </div>
                    </div>
                </div>
                <template v-if="typeUser == 'superadmin'">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <label for="density">Densidad</label>
                            <el-input
                                type="number"
                                v-model="config.density"
                            ></el-input>
                        </div>

                        <div class="col-md-6 col-12">
                            <label for="orientation">Orientación</label>
                            <el-select v-model="config.orientation">
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
                        <div class="col-md-3 col-12">
                            <label for="top">Arriba</label>
                            <el-input
                                type="number"
                                v-model="config.margins.top"
                            ></el-input>
                        </div>
                        <div class="col-md-3 col-12">
                            <label for="left">Izquierda</label>
                            <el-input
                                type="number"
                                v-model="config.margins.left"
                            ></el-input>
                        </div>
                        <div class="col-md-3 col-12">
                            <label for="right">Derecha</label>
                            <el-input
                                type="number"
                                v-model="config.margins.right"
                            ></el-input>
                        </div>
                        <div class="col-md-3 col-12">
                            <label for="bottom">Abajo</label>
                            <el-input
                                type="number"
                                v-model="config.margins.bottom"
                            ></el-input>
                        </div>
                    </div>
                </template>
                <div
                    v-if="product_id"
                    class="d-flex justify-content-center mt-2"
                >
                    <el-button type="success" @click="generate"
                        >Imprimir</el-button
                    >
                    <el-button type="danger" @click="generatePdf"
                        >Exportar</el-button
                    >
                </div>
            </div>
        </div>
        <form-word :words.sync="words" :showDialog.sync="showForm"></form-word>
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
</style>
<script>
import FormWord from "./form.vue";
import JsBarcode from "jsbarcode";
export default {
    props: ["configuration", "typeUser"],
    components: { FormWord },
    data() {
        return {
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
                default:
                    return null;
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
    methods: {
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
        generateBarcode(barcode, type) {
            if (type == "EAN-8") {
                JsBarcode("#barcode")
                    .EAN8(barcode, {
                        height: 30,
                        textPosition: "bottom",
                        fontSize: 12,
                        width: 1.5,
                        margin: 0
                    })
                    .render();
            } else {
                JsBarcode("#barcode")
                    .CODE128(barcode, {
                        height: 30,
                        textPosition: "bottom",
                        fontSize: 12,
                        width: 1.5,
                        margin: 0
                    })
                    .render();
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
                let endPoint = `${this.resource}/generate?stock=${
                    this.quantity
                }&salecode=${this.sale_code}&price1=${
                    // Aquí usamos el código murciélago almacenado en lugar del valor numérico
                    this.product.price1
                }&purchasecode=${
                    this.purchase_code
                }&description=${encodeURIComponent(
                    this.product.descripcion
                )}&paper=${this.paperType}&format=${
                    this.QSticker
                }&barcode=${encodeURIComponent(
                    this.product.barras
                )}&type_barcode=${encodeURIComponent(
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
                let endPoint = `${this.resource}/generate?stock=${
                    this.quantity
                }&salecode=${this.sale_code}&price1=${
                    
                    this.product.price1
                }&purchasecode=${
                    this.purchase_code
                }&description=${encodeURIComponent(
                    this.product.descripcion
                )}&paper=${this.paperType}&format=${
                    this.QSticker
                }&barcode=${encodeURIComponent(
                    this.product.barras
                )}&type_barcode=${encodeURIComponent(
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
                    establishment
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
            this.generateBarcode(this.product.barras);
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
        },
        async searchRemoteItems(input) {
            if (input.length > 2) {
                this.loading_search = true;
                let parameters = `input=${input}`;
                try {
                    let response = await this.$http.get(
                        `/${this.resource}/items/?${parameters}`
                    );
                    let { items } = response.data;
                    this.items = items;

                    console.log("Items recibidos:", items);

                    this.items = this.items.map(item => {
                        let originalPrice1 = null;
                
                        // Mantener el price1 original sin modificar
                        if (Array.isArray(item.item_unit_types) && item.item_unit_types.length > 0) {
                            const validPrices = item.item_unit_types
                                .map(ut => parseFloat(ut.price1))
                                .filter(p => !isNaN(p) && p > 0);
                            
                            if (validPrices.length > 0) {
                                originalPrice1 = Math.min(...validPrices);
                            }
                        }

                        // Generar código murcielago solo si tenemos price1 y words
                        let murcielagoCode = null;
                        if (originalPrice1 !== null && this.words && this.words.length > 0) {
                            const firstWord = this.words[0];
                            const priceStr = originalPrice1.toFixed(2);
                            murcielagoCode = this.murciType(firstWord.id, priceStr);
                        }

                        return {
                            ...item,
                            price1: originalPrice1, // Mantener el precio original sin formatear
                            murcielagoCode // Agregar el código murcielago como propiedad adicional
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
