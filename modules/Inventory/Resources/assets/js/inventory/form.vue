<template>
    <el-dialog :title="titleDialog" :visible="showDialog" @close="close" @open="create" :close-on-click-modal="false"
        class="rounded-dialog responsive-dialog" append-to-body>

        <!-- Mensaje para móviles -->
        <div class="mobile-only-message">
            <div class="mobile-alert">
                <i class="fas fa-mobile-alt fa-3x mb-3"></i>
                <h4>Opción no disponible en móvil</h4>
                <p>Por favor, acceda desde un dispositivo de escritorio o tablet para utilizar esta funcionalidad.</p>
            </div>
        </div>

        <!-- Contenido del formulario (oculto en móvil) -->
        <form autocomplete="off" @submit.prevent="submit" class="desktop-only-content">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <el-checkbox v-model="barcodeMode">¿Usar lector de código de barras?</el-checkbox>
                        </div>
                        <div class="form-group" :class="{ 'has-danger': errors.item_id }">
                            <!-- <label class="control-label">
                                <i class="fas fa-box"></i> Producto
                            </label> -->
                            <template v-if="!barcodeMode">
                                <el-select v-model="form.item_id" ref="itemSelect" class="w-100" filterable clearable
                                    remote :remote-method="searchRemoteItems" :loading="loading_search_item"
                                    @change="changeItem" placeholder=" Seleccione un Producto">
                                    <el-option v-for="option in items" :key="option.id" :value="option.id"
                                        :label="option.description"></el-option>
                                </el-select>
                            </template>
                            <template v-else>
                                <el-input v-model="barcodeInput" placeholder="Escanee el código de barras aquí"
                                    @keydown.native="handleBarcodeInput" clearable></el-input>
                            </template>
                            <small class="form-control-feedback" v-if="errors.item_id"
                                v-text="errors.item_id[0]"></small>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mt-4">
                                <div class="form-group" :class="{ 'has-danger': errors.warehouse_id }">
                                    <el-select v-model="form.warehouse_id" filterable @change="changeItem">
                                        <el-option v-for="option in warehouses" :key="option.id" :value="option.id"
                                            :label="option.description"></el-option>
                                    </el-select>
                                    <small class="form-control-feedback" v-if="errors.warehouse_id"
                                        v-text="errors.warehouse_id[0]"></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" :class="{ 'has-danger': errors.inventory_transaction_id }">
                                    <label class="control-label">
                                        <i class="fas fa-exchange-alt"></i>
                                        Motivo Traslado
                                    </label>
                                    <el-select v-model="form.inventory_transaction_id" filterable>
                                        <el-option v-for="option in inventory_transactions" :key="option.id" :value="option.id"
                                            :label="option.name"></el-option>
                                    </el-select>
                                    <small class="form-control-feedback" v-if="errors.inventory_transaction_id"
                                        v-text="errors.inventory_transaction_id[0]"></small>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-2">
                            <!-- <label>
                                <i class="fas fa-boxes"></i> Stock en Almacén
                            </label> -->
                            <table class="table table-bordered">
                                <!-- <thead style="background-color: #073f68;">
                                    <tr>
                                        <th style="color: white;">Almacén</th>
                                        <th style="color: white;">Stock</th>
                                    </tr>
                                </thead> -->
                                <tbody>
                                    <tr v-for="warehouse in selectedWarehouses" :key="warehouse.id">
                                        <td>
                                            {{ warehouse.warehouse_description.replace('Almacén - ', '') }}
                                        </td>
                                        <td>{{ warehouse.stock }} {{ warehouse.unit_type_id || 'UND' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group" :class="{ 'has-danger': errors.quantity }">
                            <label class="control-label">
                                <i class="fas fa-sort-numeric-up"></i> Cantidad
                            </label>
                            <template v-if="form.has_color_size || form.series_enabled">
                                <el-input v-model="form.quantity" :disabled="true">
                                    <i slot="prefix" class="el-icon-edit-outline"></i>
                                </el-input>
                                <div class="text-muted small pt-1">
                                    Cantidad total: {{ form.quantity }}
                                </div>
                            </template>
                            <template v-else>
                                <el-input v-model="form.quantity">
                                    <i slot="prefix" class="el-icon-edit-outline"></i>
                                </el-input>
                            </template>
                            <small class="form-control-feedback" v-if="errors.quantity"
                                v-text="errors.quantity[0]"></small>
                        </div>
                        <div class="col-md-12" v-if="type == 'input' && form.lots_enabled">
                            <div class="form-group" :class="{ 'has-danger': errors.lot_code }">
                                <label class="control-label">
                                    <i class="fas fa-barcode"></i> Código de Lote
                                </label>
                                <el-input v-model="form.lot_code">
                                    <i slot="prefix" class="el-icon-edit-outline"></i>
                                </el-input>
                                <small class="form-control-feedback" v-if="errors.lot_code"
                                    v-text="errors.lot_code[0]"></small>
                            </div>
                        </div>

                        <div class="col-md-12" v-show="form.lots_enabled">
                            <div class="form-group" :class="{ 'has-danger': errors.date_of_due }">
                                <label class="control-label">
                                    <i class="fas fa-calendar-alt"></i>
                                    Fec. Vencimiento
                                </label>
                                <el-date-picker v-model="form.date_of_due" type="date" value-format="yyyy-MM-dd"
                                    :clearable="true"></el-date-picker>
                                <small class="form-control-feedback" v-if="errors.date_of_due"
                                    v-text="errors.date_of_due[0]"></small>
                            </div>
                        </div>

                        <div style="padding-top: 3%" class="col-md-12" v-if="form.warehouse_id && form.series_enabled">
                            <el-button class="btnsdr-series"
                                style="border-radius: 8px; color: white !important;" @click.prevent="clickLotcode">
                                <i class="fas fa-list-ol" style="color: white"></i>
                                Ingresar Series
                            </el-button>
                        </div>
                        <div style="padding-top: 3%" class="col-md-12" v-if="form.warehouse_id && form.has_color_size">
                            <el-button class="btnsdr-tallas-colores"
                                style="border-radius: 8px; color: white !important;" @click.prevent="clickColorSize">
                                <i class="fas fa-palette" style="color: white"></i>
                                Ingresar Color & Talla
                            </el-button>
                        </div>
                        <!-- Botón para agregar producto a la lista -->
                        <div class="col-md-12 mt-3">
                            <el-button class="btn_guardarsmall" @click.prevent="addProductToList"
                                :disabled="!form.item_id || !form.quantity">
                                Agregar a la lista
                            </el-button>
                        </div>
                        <div class="col-md-12 mt-4" v-if="productList.length > 0">
                            <label class="mb-0">
                                <i class="fas fa-list-ul"></i> Productos a procesar ({{ productList.length }})
                            </label>
                            <!-- <el-button type="success" icon="el-icon-share" size="small" @click.prevent="sendWhatsApp">
                                <i class="fab fa-whatsapp"></i> Enviar WhatsApp
                            </el-button> -->
                        </div>
                    </div>


                    <!-- Lista de productos agregados -->
                    <div class="col-md-12 mt-4" v-if="productList.length > 0">
                        <div class="products-grid-container">
                            <table class="products-grid-table">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Almacén</th>
                                        <!-- <th class="text-center">Stock Ant.</th> -->
                                        <th class="text-center">{{ type === 'input' ? 'Ingreso' : 'Salida' }}</th>
                                        <th class="text-center">Stock Act.</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(product, index) in productList" :key="index">
                                        <td>
                                            <div class="product-name">
                                                <!-- <i class="fas fa-box-open mr-1"></i> -->
                                                <div class="d-flex flex-column">

                                                    <span class="product-desc">{{ product.description.split(' - ')[0]
                                                        }}</span>
                                                    <span v-if="product.description.includes(' - ')"
                                                        class="text-muted d-block">
                                                        {{ product.description.split(' - ')[1] }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="product-extra" v-if="product.lot_code || product.date_of_due">
                                                <span v-if="product.lot_code" class="badge-lote">
                                                    <i class="fas fa-barcode"></i> {{ product.lot_code }}
                                                </span>
                                                <span v-if="product.date_of_due" class="badge-fecha">
                                                    <i class="fas fa-calendar"></i> {{ product.date_of_due }}
                                                </span>
                                            </div>
                                        </td>
                                        <td>{{ product.warehouse_name.replace('Almacén - ', '') }}</td>
                                        <!-- <td class="text-center">
                                            <span class="badge badge-stock-anterior">{{ product.stock_anterior }}</span>
                                        </td> -->
                                        <td class="text-center">
                                            <span class="badge"
                                                :class="type === 'input' ? 'badge-ingreso' : 'badge-salida'">
                                                {{ type === 'input' ? '+' : '-' }}{{ product.quantity }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-stock-actual">{{ product.stock_actual }}</span>
                                        </td>
                                        <td class="text-center">
                                            <el-button type="danger" icon="el-icon-delete" size="mini" circle
                                                @click.prevent="removeProduct(index)">
                                            </el-button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-actions d-flex justify-content-end gap-3 pt-2 pb-2">
                <!-- Botón Cancelar -->
                <el-button class="btn_cancelarsmall" icon="fas fa-times fa-lg" @click.prevent="close()">
                    <span>Cancelar</span>
                </el-button>
                <!-- Botón Guardar -->
                <el-button class="btn_guardarsmall" icon="fas fa-save fa-lg" type="primary" native-type="submit"
                    :loading="loading_submit">
                    <span>Aceptar</span>
                </el-button>
            </div>
        </form>

        <input-lots-form :showDialog.sync="showDialogLots" :stock="form.quantity" @addRowLot="addRowLot">
        </input-lots-form>

        <output-lots-form :showDialog.sync="showDialogLotsOutput" :lots="form.lots" @addRowOutputLot="addRowOutputLot">
        </output-lots-form>
        <color-size :showDialog.sync="showDialogColorSizeInput" :stock="form.quantity" :recordId="form.item_id"
            @addRowColorSize="updateColorSize"></color-size>
    </el-dialog>
</template>



<script>
/* import InputLotsForm from "../../../../../../resources/js/views/items/partials/lots.vue"; */
import InputLotsForm from "./partials/lots_input.vue";
import OutputLotsForm from "./partials/lots.vue";
import ColorSize from "./partials/color_size.vue";
/* import lotsInput from "./partials/lots_input.vue"; */
export default {
    components: { OutputLotsForm, InputLotsForm, ColorSize },
    props: ["showDialog", "recordId", "type"],
    data() {
        return {
            loading_submit: false,
            showDialogLots: false,
            showDialogLotsOutput: false,
            showDialogColorSizeInput: false,
            titleDialog: null,
            resource: "inventory",
            errors: {},
            form: {},
            items: [],
            item: null,
            warehouses: [],
            inventory_transactions: [],
            loading_search_item: false,
            product: null,
            barcodeBuffer: "",
            lastKeyTime: 0,
            barcodeMode: false,
            barcodeInput: "",
            productList: [], // Lista de productos agregados
            whatsappPhone: "" // Número de teléfono del dueño
        };
    },
    created() {
        this.initForm();
    },
    computed: {
        selectedWarehouses() {
            return this.item && this.item.warehouse ? this.item.warehouse : [];
        }
    },

    methods: {
        addProductToList() {
            if (!this.form.item_id || !this.form.quantity) {
                this.$toast.warning('Seleccione un producto y cantidad válida');
                return;
            }

            const warehouse = this.warehouses.find(w => w.id === this.form.warehouse_id);
            const currentStock = this.getCurrentStock();
            const quantity = parseFloat(this.form.quantity);

            let stockActual;
            if (this.type === 'input') {
                stockActual = currentStock + quantity;
            } else {
                stockActual = currentStock - quantity;
                if (stockActual < 0) {
                    this.$toast.error('Stock insuficiente para realizar la salida');
                    return;
                }
            }

            const productData = {
                item_id: this.form.item_id,
                description: this.item.description,
                warehouse_id: this.form.warehouse_id,
                warehouse_name: warehouse ? warehouse.description : 'N/A',
                quantity: quantity,
                stock_anterior: currentStock,
                stock_actual: stockActual,
                inventory_transaction_id: this.form.inventory_transaction_id,
                lot_code: this.form.lot_code,
                date_of_due: this.form.date_of_due,
                lots: this.form.lots ? [...this.form.lots] : [],
                color_size: this.form.color_size ? [...this.form.color_size] : [],
                lots_enabled: this.form.lots_enabled,
                series_enabled: this.form.series_enabled,
                has_color_size: this.form.has_color_size
            };

            this.productList.push(productData);
            this.$toast.success('Producto agregado a la lista');

            // Limpiar formulario para agregar otro producto
            this.resetFormFields();
        },

        getCurrentStock() {
            if (!this.item || !this.item.warehouse) return 0;
            const warehouse = this.item.warehouse.find(w => w.warehouse_id === this.form.warehouse_id);
            return warehouse ? parseFloat(warehouse.stock) : 0;
        },

        removeProduct(index) {
            this.$confirm('¿Está seguro de eliminar este producto de la lista?', 'Confirmar', {
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                type: 'warning'
            }).then(() => {
                this.productList.splice(index, 1);
                this.$toast.success('Producto eliminado de la lista');
            }).catch(() => { });
        },

        resetFormFields() {
            this.form.item_id = null;
            this.form.quantity = 0;
            this.form.lot_code = null;
            this.form.date_of_due = null;
            this.form.lots = [];
            this.form.color_size = [];
            this.item = null;
            this.barcodeInput = '';
        },

        sendWhatsApp() {
            if (this.productList.length === 0) {
                this.$toast.warning('No hay productos en la lista');
                return;
            }

            const tipoMovimiento = this.type === 'input' ? 'INGRESO' : 'SALIDA';
            const fecha = new Date().toLocaleDateString('es-PE', {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });

            let mensaje = `*📦 REPORTE DE ${tipoMovimiento} DE INVENTARIO*%0A`;
            mensaje += `📅 Fecha: ${fecha}%0A`;
            mensaje += `━━━━━━━━━━━━━━━━━━━━%0A%0A`;

            this.productList.forEach((product, index) => {
                mensaje += `*${index + 1}. ${product.description}*%0A`;
                mensaje += `🏪 Almacén: ${product.warehouse_name}%0A`;
                mensaje += `📊 Stock Anterior: *${product.stock_anterior}*%0A`;

                if (this.type === 'input') {
                    mensaje += `➕ Ingreso: *+${product.quantity}*%0A`;
                } else {
                    mensaje += `➖ Salida: *-${product.quantity}*%0A`;
                }

                mensaje += `📈 Stock Actual: *${product.stock_actual}*%0A`;

                if (product.lot_code) {
                    mensaje += `🏷️ Lote: ${product.lot_code}%0A`;
                }
                if (product.date_of_due) {
                    mensaje += `📆 Vencimiento: ${product.date_of_due}%0A`;
                }

                mensaje += `%0A`;
            });

            mensaje += `━━━━━━━━━━━━━━━━━━━━%0A`;
            mensaje += `📋 Total productos: ${this.productList.length}%0A`;

            const totalCantidad = this.productList.reduce((sum, p) => sum + p.quantity, 0);
            mensaje += `📦 Total unidades: ${totalCantidad}`;

            // Puedes configurar el número de teléfono del dueño aquí
            // O pedirlo dinámicamente
            this.$prompt('Ingrese el número de teléfono (con código de país, ej: 51987654321)', 'Enviar WhatsApp', {
                confirmButtonText: 'Enviar',
                cancelButtonText: 'Cancelar',
                inputPattern: /^[0-9]{10,15}$/,
                inputErrorMessage: 'Número de teléfono inválido'
            }).then(({ value }) => {
                const url = `https://wa.me/${value}?text=${mensaje}`;
                window.open(url, '_blank');
            }).catch(() => { });
        },

        clickColorSize() {
            this.showDialogColorSizeInput = true;
        },
        updateColorSize(color_size) {
            console.log("Color y Talla seleccionados:", color_size);
            this.form.color_size = color_size;
            if (Array.isArray(color_size)) {
                // Sumar la cantidad total de todas las tallas y colores (usando 'stock')
                const total = color_size.reduce(
                    (acc, c) => acc + Number(c.stock || 0),
                    0
                );
                this.form.quantity = total;
                // Forzar actualización del input si es necesario
                this.$forceUpdate && this.$forceUpdate();
            }
        },
        handleBarcode(event) {
            const currentTime = new Date().getTime();
            if (currentTime - this.lastKeyTime > 100) {
                this.barcodeBuffer = "";
            }
            this.lastKeyTime = currentTime;
            this.barcodeBuffer += event.key;
            if (event.key === "Enter" && this.barcodeBuffer.length > 0) {
                event.preventDefault();
                // Solo buscar el producto, no limpiar el modelo ni el input visual aquí
                this.searchRemoteItems(this.barcodeBuffer);
                this.barcodeBuffer = "";
            }
        },
        handleBarcodeInput(event) {
            if (!this.barcodeMode) return;
            const currentTime = new Date().getTime();
            if (currentTime - this.lastKeyTime > 100) {
                this.barcodeBuffer = "";
            }
            this.lastKeyTime = currentTime;
            // Solo agregar caracteres imprimibles
            if (
                event.key.length === 1 &&
                !event.ctrlKey &&
                !event.altKey &&
                !event.metaKey
            ) {
                this.barcodeBuffer += event.key;
            }
            if (event.key === "Enter" && this.barcodeBuffer.length > 0) {
                event.preventDefault();
                this.loading_search_item = true;
                this.$http
                    .get(`/${this.resource}/items?value=${this.barcodeBuffer}`)
                    .then(response => {
                        this.items = response.data;
                        if (this.items.length > 0) {
                            // Si se encuentra producto, agregarlo como válido y mostrar la descripción en el input
                            this.setProduct([this.items[0]]);
                            this.barcodeInput =
                                this.items[0].descripcion ||
                                this.items[0].description ||
                                "";
                            this.form.quantity = this.items[0].stock || 0; // Actualizar el stock
                        } else {
                            // Si no hay resultados, limpia la selección y el input
                            this.form.item_id = null;
                            this.item = null;
                            this.barcodeInput = "";
                        }
                        this.loading_search_item = false;
                    })
                    .finally(() => {
                        this.barcodeBuffer = "";
                    });
            }
        },
        searchRemoteItems(input) {
            if (!input || input.length < 3) {
                this.items = [];
                this.loading_search_item = false;
                return;
            }
            clearTimeout(this.timer);
            this.loading_search_item = true;
            this.timer = setTimeout(() => {
                this.$http
                    .get(`/${this.resource}/items?value=${input}`)
                    .then(response => {
                        this.items = response.data;
                        this.loading_search_item = false;
                    })
                    .catch(() => {
                        this.items = [];
                        this.loading_search_item = false;
                    });
            }, 300);
        },
        async changeItem() {
            let item = await _.find(this.items, { id: this.form.item_id });
            console.log("Producto seleccionado:", item);
            this.item = item;
            this.form.lots_enabled = item.lots_enabled;
            let lots = await _.filter(item.lots, {
                warehouse_id: this.form.warehouse_id
            });
            // console.log(item)
            this.form.lots = lots;
            this.form.lots_enabled = item.lots_enabled;
            this.form.series_enabled = item.series_enabled;
            this.form.has_color_size = item.has_color_size;
        },
        addRowOutputLot(lots) {
            this.form.lots = lots;
        },
        addRowLot(lots) {
            this.form.lots = lots;
            // Cada serie es 1 cantidad, así que la cantidad es igual al número de series
            this.form.quantity = Array.isArray(lots) ? lots.length : 0;
        },
        clickLotcode() {
            this.showDialogLots = true;
        },
        clickLotcodeOutput() {
            this.showDialogLotsOutput = true;
        },
        initForm() {
            this.errors = {};
            this.form = {
                id: null,
                item_id: null,
                warehouse_id: 1,
                inventory_transaction_id: "02",
                quantity: 0,
                type: this.type,
                lot_code: null,
                lots_enabled: false,
                series_enabled: false,
                lots: [],
                date_of_due: null,
                color_size: []
            };
        },
        async create() {
            console.log("🚀 ~ create ~ this.type:", this.type);
            this.titleDialog =
                this.type == "input"
                    ? "Ingreso de producto al almacén"
                    : "Salida de producto del almacén";

            await this.$http
                .get(`/${this.resource}/tables/transaction/${this.type}`)
                .then(response => {
                    this.items = response.data.items;
                    this.warehouses = response.data.warehouses;
                    this.inventory_transactions =
                        response.data.inventory_transactions;
                });
        },
        async submit() {
            // Validar que hay productos en la lista
            if (this.productList.length === 0) {
                return this.$toast.error('Debe agregar al menos un producto a la lista');
            }

            this.loading_submit = true;

            try {
                // Procesar cada producto de la lista
                for (const product of this.productList) {
                    if (this.type == "input") {
                        if (product.lots_enabled) {
                            if (!product.lot_code) {
                                this.$toast.error(`Código de lote requerido para ${product.description}`);
                                this.loading_submit = false;
                                return;
                            }

                            if (!product.date_of_due) {
                                this.$toast.error(`Fecha de vencimiento requerida para ${product.description}`);
                                this.loading_submit = false;
                                return;
                            }
                        }

                        if (product.series_enabled) {
                            if (product.lots.length > product.quantity) {
                                this.$toast.error(`La cantidad de series registradas es superior al stock en ${product.description}`);
                                this.loading_submit = false;
                                return;
                            }

                            if (product.lots.length != product.quantity) {
                                this.$toast.error(`La cantidad de series registradas son diferentes al stock en ${product.description}`);
                                this.loading_submit = false;
                                return;
                            }
                        }
                    } else {
                        if (product.lots.length > 0 && product.lots_enabled) {
                            let select_lots = await _.filter(product.lots, {
                                has_sale: true
                            });

                            if (select_lots.length != product.quantity) {
                                this.$toast.error(`La cantidad ingresada es diferente a las series seleccionadas en ${product.description}`);
                                this.loading_submit = false;
                                return;
                            }
                        }
                    }

                    // Preparar datos para enviar
                    const dataToSend = {
                        item_id: product.item_id,
                        warehouse_id: product.warehouse_id,
                        inventory_transaction_id: product.inventory_transaction_id,
                        quantity: product.quantity,
                        type: this.type,
                        lot_code: product.lot_code,
                        date_of_due: product.date_of_due,
                        lots: product.lots,
                        color_size: product.color_size,
                        lots_enabled: product.lots_enabled,
                        series_enabled: product.series_enabled,
                        has_color_size: product.has_color_size
                    };

                    console.log("Enviando producto:", dataToSend);

                    await this.$http
                        .post(`/${this.resource}/transaction`, dataToSend)
                        .then(response => {
                            if (response.data.success) {
                                console.log(`Producto ${product.description} procesado exitosamente`);
                            } else {
                                throw new Error(response.data.message);
                            }
                        });
                }

                this.$toast.success(`Se procesaron ${this.productList.length} producto(s) exitosamente`);
                this.$eventHub.$emit("reloadData");
                this.close();

            } catch (error) {
                if (error.response && error.response.status === 422) {
                    this.errors = error.response.data;
                } else {
                    this.$toast.error(error.message || 'Error al procesar los productos');
                    console.log(error);
                }
            } finally {
                this.loading_submit = false;
            }
        },
        close() {
            this.$emit("update:showDialog", false);
            this.initForm();
            this.barcodeInput = "";
            this.productList = []; // Limpiar la lista de productos
        },
        setProduct(items) {
            if (items && items.length > 0) {
                const item = items[0];

                if (item.warehouses && !item.warehouse) {
                    item.warehouse = item.warehouses;
                }

                // Agregar el item al array de items si no existe
                if (!this.items.some(i => i.id === item.id)) {
                    this.items.push({
                        id: item.id,
                        description: item.descripcion,
                        stock: item.stock || 0,
                        lots_enabled: item.lots_enabled || false,
                        series_enabled: item.series_enabled || false,
                        has_color_size: item.has_color_size || false,
                        warehouse: item.warehouse || item.warehouses || [] // Asegura almacenes
                    });
                }

                this.form.item_id = item.id;
                this.form.description = item.descripcion;
                // Solo actualizar la cantidad si NO es talla/color
                if (!item.has_color_size) {
                    this.form.quantity = item.stock || 0;
                } else {
                    this.form.quantity = 0;
                }
                this.item = item; // Asegura que selectedWarehouses se actualice

                this.$nextTick(() => {
                    if (this.$refs.itemSelect) {
                        this.$refs.itemSelect.blur();
                        this.$refs.itemSelect.$el.querySelector("input").value =
                            "";
                    }
                });
                this.barcodeBuffer = "";
            }
        }
    }
};
</script>

<style>
.el-dialog {
    border-radius: 10px;
    overflow: hidden;
}

/* Ajuste responsive del ancho del dialog */
.responsive-dialog .el-dialog {
    width: 65% !important;
}

@media (max-width: 1300px) {
    .responsive-dialog .el-dialog {
        width: 85% !important;
    }
}

@media (max-width: 768px) {
    .responsive-dialog .el-dialog {
        width: 95% !important;
    }

    /* Ocultar contenido del formulario en móvil */
    .desktop-only-content {
        display: none !important;
    }

    /* Mostrar mensaje solo en móvil */
    .mobile-only-message {
        display: flex !important;
    }
}

/* Ocultar mensaje en desktop */
.mobile-only-message {
    display: none;
    justify-content: center;
    align-items: center;
    min-height: 300px;
    padding: 40px 20px;
}

.mobile-alert {
    text-align: center;
    color: #073f68;
    max-width: 400px;
}

.mobile-alert i {
    color: #0a5a8f;
    opacity: 0.7;
}

.mobile-alert h4 {
    font-size: 20px;
    font-weight: 600;
    margin-bottom: 15px;
    color: #073f68;
}

.mobile-alert p {
    font-size: 14px;
    color: #666;
    line-height: 1.6;
}

.products-grid-container {
    max-height: 400px;
    overflow-y: auto;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.products-grid-table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    font-size: 13px;
}

.products-grid-table thead {
    background: linear-gradient(135deg, #073f68 0%, #0a5a8f 100%);
    position: sticky;
    top: 0;
    z-index: 10;
}

.products-grid-table thead th {
    color: white;
    padding: 10px 8px;
    font-weight: 600;
    text-align: left;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 2px solid #062f4f;
}

.products-grid-table tbody tr {
    border-bottom: 1px solid #e9ecef;
    transition: background-color 0.2s ease;
}

.products-grid-table tbody tr:hover {
    background-color: #f8f9fa;
}

.products-grid-table tbody tr:last-child {
    border-bottom: none;
}

.products-grid-table td {
    padding: 10px 8px;
    vertical-align: middle;
}

.product-name {
    font-weight: 600;
    color: #2c3e50;
    display: flex;
    align-items: center;
    margin-bottom: 2px;
}

.product-name i {
    color: #073f68;
    font-size: 14px;
}

.product-extra {
    display: flex;
    gap: 6px;
    margin-top: 4px;
    flex-wrap: wrap;
}

.badge-lote,
.badge-fecha {
    font-size: 10px;
    padding: 2px 6px;
    border-radius: 10px;
    background: #e3f2fd;
    color: #1976d2;
    display: inline-flex;
    align-items: center;
    gap: 3px;
}

.badge-fecha {
    background: #fff3e0;
    color: #f57c00;
}

.badge {
    padding: 4px 10px;
    border-radius: 12px;
    font-weight: 600;
    font-size: 12px;
    display: inline-block;
    min-width: 45px;
}

.badge-stock-anterior {
    background: #e3f2fd;
    color: #1565c0;
}

.badge-ingreso {
    background: #e8f5e9;
    color: #2e7d32;
}

.badge-salida {
    background: #fff3e0;
    color: #ef6c00;
}

.badge-stock-actual {
    background: #f3e5f5;
    color: #6a1b9a;
    font-weight: 700;
}

.text-center {
    text-align: center !important;
}

.products-grid-container::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}

.products-grid-container::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.products-grid-container::-webkit-scrollbar-thumb {
    background: #073f68;
    border-radius: 10px;
}

.products-grid-container::-webkit-scrollbar-thumb:hover {
    background: #0a5a8f;
}

/* Responsive para tablets y móviles */
@media (max-width: 768px) {
    .products-grid-table {
        font-size: 11px;
    }

    .products-grid-table thead th {
        padding: 8px 4px;
        font-size: 10px;
    }

    .products-grid-table td {
        padding: 8px 4px;
    }

    .badge {
        padding: 3px 6px;
        font-size: 10px;
        min-width: 35px;
    }
}
</style>
