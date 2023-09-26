<template>
    <div class="container-fluid p-l-0 p-r-0">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-6">
                    <h6><span>Etiquetas</span></h6>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/dashboard">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <span class="text-muted"
                                >Preparacion de etiquetas</span
                            >
                        </li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="card" v-loading="loading">
            <div class="card-header bg-primary">
                <h6 class="my-0 text-white">Preparacion de Etiquetas</h6>
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
                        </div> -->
                        <div
                            v-if="imageSaved"
                            class="col-12 mb-2 d-flex  justify-content-center "
                            style="max-width:150px"
                        >
                            <img
                                :src="imageSaved"
                                alt="imagen"
                                class="img-thumbnail"
                            />
                        </div>
                        <div v-else>
                            <el-empty :image-size="150"></el-empty>
                        </div>
                        <el-button
                            class="m-2"
                            type="success"
                            @click="$refs.file.click()"
                        >
                            Subir imagen
                        </el-button>
                        <el-button v-if="imageSaved"
                            class="m-2"
                            type="danger"

                            @click="delete_image"
                        >
                        <i class="el-icon-delete"></i>
                        </el-button>
                        <p><em>JPG, PNG, JPEG | 150x150 </em></p>
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
                                v-model="item_for_barcode"
                                @input="searchItems"
                                placeholder="Buscar producto"
                                popper-class="el-select-items"
                            ></el-input>
                            <el-checkbox
                            v-model="lector_barcode"
                            >

                                Lector de código de barras
                            </el-checkbox>
                        </div>

                        <div
                            class="d-flex flex-row justify-content-center align-items-center"
                        >
                            <div class="col-3">
                                <label for="a">
                                    Stock:
                                </label>
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
                                    >
                                    </el-option>
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
                                    >
                                    </el-option>
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
                <div class="row d-flex  justify-content-center">
                    <div
                        v-if="!product_id"
                        class="col-12 col-lg-4 col-md-4 text-center"
                    >
                        <el-alert
                            :closable="false"
                            title="Busque y/o seleccione un producto"
                            type="error"
                        >
                        </el-alert>
                    </div>
                </div>
                <el-divider></el-divider>
                <!-- <div class="row d-flex justify-content-between">
                    <span>Compra: {{ purchase_code }}</span>
                    <span>Venta: {{ sale_code }}</span>
                </div> -->
                <!--    
                <div class="d-flex flex-row justify-content-center">
                    <div
                        class="d-flex flex-row  col-12  col-lg-4 col-md-10 border overflow-hidden justify-content-start "
                    >
                        <div>
                            <div
                                v-if="imageSaved"
                                class="col-12 d-flex  justify-content-center align-items-center "
                            >
                                <img
                                    :src="imageSaved"
                                    alt="imagen"
                                    class="img-thumbnail"
                                />
                            </div>
                            <div
                                v-else
                                class="col-12 d-flex  justify-content-center align-items-center "
                            >
                                <el-empty :image-size="100"></el-empty>
                            </div>
                        </div>

                        <div
                            class="d-flex flex-column flex-fill justify-content-center align-items-center"
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
                            >
                                {{ sale_code || "N/D" }}</span
                            >
                            <span class="text-center">{{
                                product.descripcion ||
                                    "DESCRIPCION DEL PRODUCTO"
                            }}</span>
                            <img id="barcode" alt="barcode" />
                            <div class="d-flex col-12 justify-content-end p-1">
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
                </div> -->

                <div class="d-flex flex-row justify-content-center">
                    <div
                        class="  border d-flex flex-row align-items-center h150 w300 overflow-hidden"
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
                                class="col-12 d-flex  justify-content-center align-items-center "
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
                            >
                                {{ sale_code || "N/D" }}</span
                            >
                            <span class="text-center">{{
                                product.descripcion ||
                                    "DESCRIPCION DEL PRODUCTO"
                            }}</span>
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
                <div class="d-flex justify-content-center mt-2">
                    <span class="h4">
                        <u>
                            Tipo de papel
                        </u>
                    </span>
                </div>
                <div></div>
                <div
                    class="d-flex flex-column flex-lg-row flex-md-row align-items-center justify-content-center mt-1 "
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
                    class="d-flex flex-column flex-lg-row flex-md-row align-items-center justify-content-center mt-1 "
                ></div>
                <div class="d-flex justify-content-center mt-2">
                    <span class="h4">
                        <u>
                            Cantidad de impresión por etiqueta (und)
                        </u>
                    </span>
                </div>
                <div
                    class="d-flex flex-column flex-lg-row flex-md-row align-items-center justify-content-center mt-1 "
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
                        <div class="bg-white m-1  border col-5 text-center ">
                            1
                        </div>
                        <div class="bg-white m-1 border col-5 text-center ">
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

                <div class="d-flex justify-content-center">
                    <div v-if="product_id" class="col-4 text-center">
                        <el-button type="success" @click="generate">
                            Generar
                        </el-button>
                        
                    </div>
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
    props: ["configuration"],
    components: { FormWord },
    data() {
        return {
            establishment: null,
            lector_barcode:false,
            item_for_barcode: null,
            limitFormat: false,
            QSticker: 1,
            paperType: 1,
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
            product: {},
            codes: [],
            words: [],
            product_id: null,
            company_name: null,
            items: [],
            resource: "etiquetas"
        };
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
    },
    methods: {
        async delete_image(){
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
        async generate() {
            if (this.quantity == 0 || this.quantity.length == 0) {
                this.$toast.error("La cantidad es obligatoria.");
                return;
            }
            
            if (
                this.sale_code == undefined ||
                this.purchase_code == undefined
            ) {
                this.$toast.error(
                    "Los códigos de venta y compra son obligatorios"
                );
                return;
            } else {
                if (
                    this.sale_code.length == 0 ||
                    this.purchase_code.length == 0
                ) {
                    this.$toast.error(
                        "Los códigos de venta y compra son obligatorios"
                    );
                    return;
                }
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
                }&salecode=${this.sale_code}&purchasecode=${
                    this.purchase_code
                }&description=${encodeURIComponent(
                    this.product.descripcion
                )}&paper=${this.paperType}&format=${
                    this.QSticker
                }&barcode=${encodeURIComponent(
                    this.product.barras
                )}&type_barcode=${encodeURIComponent(
                    this.typeBarcode
                )}&location=${this.product.location || ""}`;
                let {print_direct} = this.configuration;
                let {etiquetadora } = this.establishment;
                if(print_direct && etiquetadora){
                    this.Printer(etiquetadora, endPoint);
                }else{
                const response = await axios.get(endPoint, config);
                console.log(response);
                console.log(this.configuration);
                const url = window.URL.createObjectURL(
                    new Blob([response.data])
                );
                const link = document.createElement("a");
                link.href = url;
                link.setAttribute("download", "file.pdf");
                document.body.appendChild(link);
                link.click();
                }
            
                this.loading = false;
            } catch (e) {
                const {
                    data: { message }
                } = e.response;
                this.$toast.error(message);
                this.loading = false;
            }
        },
          async Printer(
            Printer,
            linkpdf,

        ) {
            let paperConfig = {
                scaleContent: false
            };
            let partsUrl = linkpdf.split("/");
            let document = partsUrl[partsUrl.length - 1];
            let isTicket = document.toLowerCase().includes("ticket");

            let tipoBandejaImpresora = this.configuration.new_old_printer;

            // if (!isTicket && tipoBandejaImpresora == 1) {
            //     paperConfig.density = 600;
            //     paperConfig.orientation = "portrait";
            //     paperConfig.margins = { left: 2 };
            // } else if (!isTicket && tipoBandejaImpresora == 0) {
            //     paperConfig.density = 350;
            //     paperConfig.orientation = "portrait";
            // }
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
         
        },
        changeFormat(quantity) {
            if (this.limitFormat && quantity != 1) {
                this.$toast.error(
                    "Código de barra largo, formato no disponible."
                );
                return;
            }
            this.QSticker = quantity;
        },
        changePaper(type) {
            this.paperType = type;
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
                    this.sale_code = this.normalType(this.product.price);
                }
                if (this.sale_type == 1 && this.sale_murc) {
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
            if (value && value.length != 0) {
                let word = this.words.find(w => w.id == id);
                let indice = word.indice.split("");
                let nums = value.split("");

                let result = "";
                for (let i = 0; i < nums.length; i++) {
                    let num = nums[i];
                    let v = 9;
                    if (num != "0") {
                        v = (Number(num) || 1) - 1;
                    }
                    result += indice[v];
                }
                return result;
            } else {
                return "";
            }
        },
        normalType(price) {
            let iniciales = this.company_name.toUpperCase();
            iniciales = iniciales
                .split(" ")
                .map(i => i[0])
                .join("");

            return `${iniciales}0${Number(price) || 0}${iniciales}`;
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
            this.sale_code = this.normalType(this.product.price);
            this.purchase_code = this.normalType(this.product.purchase);
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

                    this.loading_search = false;
                } catch (e) {
                    const {
                        data: { message }
                    } = e.response;
                    this.$toast.error(message);
                    this.loading = false;
                }
            }
        },
           async searchItems() {
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
                    if(items.length == 1){
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
        }
    }
};
</script>
