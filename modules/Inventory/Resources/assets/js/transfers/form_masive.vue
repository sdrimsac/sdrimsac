<template>
    <div class="card mb-0 pt-2 pt-md-0">
        <div class="card-header bg-primary">
            <h6 class="my-0 text-white">Nuevo Traslado {{isDirect ? ' (Traslado directo)':''}}</h6>
        </div>
        <div class="tab-content p-3">
            <form
                v-loading="loading_item"
                autocomplete="off"
                @submit.prevent="submit"
            >
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label"
                                    >Almacén Inicial</label
                                >
                                <el-select
                                    v-model="form.warehouse_id"
                                    @change="changeWarehouseInit"
                                >
                                    <el-option
                                        v-for="option in warehouses"
                                        :key="option.id"
                                        :value="option.id"
                                        :label="option.description"
                                    ></el-option>
                                </el-select>
                                <small
                                    class="form-control-feedback"
                                    v-if="errors.warehouse_id"
                                    v-text="errors.warehouse_id[0]"
                                ></small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div
                                class="form-group"
                                :class="{
                                    'has-danger':
                                        errors.warehouse_destination_id
                                }"
                            >
                                <label class="control-label"
                                    >Almacén Final</label
                                >
                                <el-select
                                    v-model="form.warehouse_destination_id"
                                >
                                    <el-option
                                        :disabled="
                                            option.id == form.warehouse_id
                                        "
                                        v-for="option in warehouses"
                                        :key="option.id"
                                        :value="option.id"
                                        :label="option.description"
                                    ></el-option>
                                </el-select>
                                <small
                                    class="form-control-feedback"
                                    v-if="errors.warehouse_destination_id"
                                    v-text="errors.warehouse_destination_id[0]"
                                ></small>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div
                                class="form-group"
                                :class="{ 'has-danger': errors.description }"
                            >
                                <label class="control-label"
                                    >Motivo de Traslado</label
                                >
                                <el-input
                                    type="textarea"
                                    :rows="3"
                                    v-model="form.description"
                                >
                                    <i
                                        slot="prefix"
                                        class="el-icon-edit-outline"
                                    ></i
                                ></el-input>
                                <small
                                    class="form-control-feedback"
                                    v-if="errors.description"
                                    v-text="errors.description[0]"
                                ></small>
                            </div>
                        </div>
                    </div>
                    <br />
                    <div class="d-flex align-items-end justify-content-between">
                            <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Buscar por</label>
                                <el-select v-model="searchType">
                                    <el-option
                                        label="Descripción"
                                        value="description"
                                    ></el-option>
                                    <el-option
                                        value="serie"
                                        label="Serie"
                                    ></el-option>
                                    <el-option
                                        value="lote"
                                        label="Lote"
                                    ></el-option>
                                </el-select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Producto</label>
                                <!-- <el-input v-model="form.item_description" :readonly="true"> <i slot="prefix" class="el-icon-edit-outline"></i></el-input> -->
                                <el-select
                                    :disabled="!form.warehouse_id"
                                    @change="changeItem"
                                    v-model="form_add.item_id"
                                    :remote-method="searchItem"
                                    filterable
                                    remote
                                    :loading="loading_item"
                                    popper-class="el-select-document_type"
                                    class="border-left rounded-left border-info"
                                >
                                    <el-option
                                        v-for="option in items"
                                        :key="option.id"
                                        :value="option.id"
                                        :label="option.full_description"
                                    ></el-option>
                                </el-select>

                                <a
                                    v-if="
                                        form_add.item_id &&
                                            form_add.series_enabled
                                    "
                                    href="#"
                                    class="text-center font-weight-bold text-info"
                                    @click.prevent="clickLotcodeOutput"
                                    >[&#10004; Seleccionar series]</a
                                >
                                <a
                                    v-if="
                                        form_add.item_id &&
                                            form_add.lots_enabled
                                    "
                                    href="#"
                                    class="text-center font-weight-bold text-info"
                                    @click.prevent="clickLotescodeOutput"
                                    >[&#10004; Seleccionar cantidad en lotes]</a
                                >
                            </div>
                        </div>
                    
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label"
                                    >Cantidad Actual
                                    <template v-if="currentItem && currentItem.max_quantity">
                                        <el-tooltip
                                            v-if="currentItem.max_quantity"
                                            :content="
                                                ` ${
                                                    currentItem.unds
                                                        ? 'Mostrando unidades'
                                                        : 'En base a la cantidad máx. ${currentItem.max_quantity}'
                                                }`
                                            "
                                        >
                                            <i class="fa fa-info-circle"></i>
                                        </el-tooltip>

                                        <el-checkbox
                                            @change="showUnits"
                                            style="margin-left:10px;"
                                            v-model="currentItem.unds"
                                        >
                                            Unidades
                                        </el-checkbox>
                                    </template>
                                </label>
                                <el-input
                                    v-model="form_add.stock"
                                    :readonly="true"
                                >
                                    <i
                                        slot="prefix"
                                        class="el-icon-edit-outline"
                                    ></i
                                ></el-input>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label"
                                    >Cantidad a Trasladar
                                    <template v-if="currentItem">
                                        <el-tooltip
                                            v-if="currentItem.max_quantity"
                                            :content="
                                                `Ingrese cantidad en base a ${currentItem.max_quantity}`
                                            "
                                        >
                                            <i class="fa fa-info-circle"></i>
                                        </el-tooltip>
                                    </template>
                                </label>
                                <el-input
                                    :disabled="hasLots"
                                    type="number"
                                    v-model="form_add.quantity"
                                >
                                    <i
                                        slot="prefix"
                                        class="el-icon-edit-outline"
                                    ></i
                                ></el-input>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <el-button
                                    :disabled="form_add.item_id == null"
                                    style="margin-top:10%;"
                                    @click.prevent="clickAddItem"
                                    type="primary"
                                    >Agregar Producto</el-button
                                >
                            </div>
                        </div>
                    </div>

                    <br />
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <table class="table" width="100%">
                                <thead>
                                    <tr width="100%">
                                        <th>#</th>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(row, index) in form.items"
                                        :key="index"
                                        width="100%"
                                    >
                                        <td>{{ index + 1 }}</td>
                                        <td>{{ row.description }}</td>
                                        <td>
                                            <template v-if="row.max_quantity">
                                                {{ row.max_quantity.input }}
                                                <el-tooltip
                                                    :content="
                                                        `Cantidad real ${row.quantity}`
                                                    "
                                                >
                                                    <i
                                                        class="fa fa-info-circle"
                                                    ></i>
                                                </el-tooltip>
                                            </template>
                                            <template v-else>
                                                {{ row.quantity }}
                                            </template>
                                        </td>
                                        <td
                                            class="series-table-actions text-center"
                                        >
                                            <button
                                                type="button"
                                                class="btn waves-effect waves-light btn-sm btn-danger"
                                                @click.prevent="
                                                    clickCancel(index)
                                                "
                                            >
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div
                    class="form-actions d-flex justify-content-end align-items-end pt-2 pb-2"
                >
                    <div class="col-md-4" style="margin-right:10px;">
                        <span> Impresora: </span><br />
                        <el-select v-model="form.printer">
                            <el-option
                                v-for="establishment in establishments"
                                :key="establishment.id"
                                :value="establishment.id"
                                :label="
                                    `${establishment.description} - ${establishment.printer}`
                                "
                            >
                            </el-option>
                        </el-select>
                    </div>
                    <el-button @click.prevent="close()">Cancelar</el-button>
                    <el-button
                        type="primary"
                        native-type="submit"
                        :loading="loading_submit"
                        >Guardar</el-button
                    >
                </div>
            </form>
        </div>

        <output-lots-form
            :showDialog.sync="showDialogLotsOutput"
            :lots="form_add.lots"
            @addRowOutputLot="addRowOutputLot"
        ></output-lots-form>
        <output-lotes-form
            :lotes="form_add.lotes"
            @sumLotes="sumLotes"
            :showDialog.sync="showDialogLotesOutput"
            @addRowOutputLote="addRowOutputLote"
        ></output-lotes-form>
    </div>
</template>

<script>
import OutputLotsForm from "./partials/lots.vue";
import OutputLotesForm from "./partials/lotes.vue";

export default {
    props: ["establishment_id", "establishments","configuration"],
    components: { OutputLotsForm, OutputLotesForm },
    data() {
        return {
            sameEstablishment: false,
            hasLots: false,
            loading_item: false,
            isDirect:false,
            loading_submit: false,
            titleDialog: null,
            showDialogLotsOutput: false,
            showDialogLotesOutput: false,
            resource: "transfers",
            errors: {},
            searchType: "description",
            form: {},
            warehouses: [],
            items: [],
            form_add: {},
            time: null,
            currentItem: null
        };
    },
    async created() {
        this.isDirect = this.configuration.translate_direct;
        await this.$http.get(`/${this.resource}/tables`).then(response => {
            this.warehouses = response.data.warehouses;
            this.items = response.data.items;
        });

        await this.initForm();
        this.initFormAdd();

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

    methods: {
        async printTransfer(url, printer) {
            let paperConfig = {
                scaleContent: false
            };
            let config = qz.configs.create(printer, paperConfig);

            if (!qz.websocket.isActive()) {
                await qz.websocket.connect(config);
            }

            let data = [
                {
                    type: "pdf",
                    format: "file",
                    data: url
                }
            ];
            try {
                await qz.print(config, data);
            } catch (e) {
                this.$toast.error(e);
            }
        },
        sumLotes(qty) {
            this.form_add.quantity = qty;
        },
        searchItem(input) {
            if (input.length > 2) {
                if (this.time) {
                    clearTimeout(this.time);
                }
                this.time = setTimeout(async () => {
                    let query = `?description=${input}&type=${this.searchType}`;

                    await this.searchItems(query);
                }, 500);
            }
        },

        async searchItems(query) {
            try {
                this.loading_item = true;
                const response = await this.$http.get(
                    `/${this.resource}/items/${this.form.warehouse_id}${query}`
                );
                if (response.status == 200) {
                    this.items = response.data.items;
                }
            } catch (e) {
                console.log(e);
            } finally {
                this.loading_item = false;
            }
        },
        async changeWarehouseInit(query = "", search = false) {
            this.form.warehouse_destination_id = null;
            this.form.items = [];
            let warehouse = this.warehouses.find(
                w => w.id == this.form.warehouse_id
            );
            this.sameEstablishment =
                warehouse.establishment_id == this.establishment_id;
            // try {
            //     this.loading_item = true;
            //     let response;
            //     if (search) {
            //         response = await this.$http.get(
            //             `/${this.resource}/items/${this.form.warehouse_id}${query}`
            //         );
            //     } else {
            //         response = await this.$http.get(
            //             `/${this.resource}/items/${this.form.warehouse_id}`
            //         );
            //     }

            //     if (response.status == 200) {
            //         this.items = response.data.items;
            //     }
            // } catch (e) {
            //     console.log(e);
            // } finally {
            //     this.loading_item = false;
            // }
        },
        addRowOutputLot(lots) {
            let row = this.items.find(x => x.id == this.form_add.item_id);

            row.lots = lots.filter(l => l.has_sale);
            this.form_add.quantity = row.lots.length;
        },
        addRowOutputLote(lotes) {
            let row = this.items.find(x => x.id == this.form_add.item_id);
            row.lotes = lotes;
        },
        clickCancel(index) {
            this.form.items.splice(index, 1);
        },
        async changeItem() {
            this.currentItem = this.items.find(
                i => i.id == this.form_add.item_id
            );

            this.loading_item = true;
            const response = await this.$http.get(
                `/${this.resource}/stock/${this.form_add.item_id}/${this.form.warehouse_id}`
            );

            this.form_add.stock = response.data.stock;
            if (this.currentItem) {
                if (this.currentItem.max_quantity) {
                    this.form_add.stock =
                        this.form_add.stock / this.currentItem.max_quantity;
                }
            }
            this.loading_item = false;

            let row = this.items.find(x => x.id == this.form_add.item_id);
            let lots = row.lots;
            if (typeof lots === "object" && !Array.isArray(lots)) {
                lots = Object.values(lots);
            }
            this.form_add.lots = lots;
            this.form_add.lotes = row.lotes;
            this.form_add.lots_enabled = row.lots_enabled;
            this.form_add.series_enabled = row.series_enabled;

            this.hasLots =
                this.form_add.lots_enabled || this.form_add.series_enabled;
        },
        showUnits() {
            if (this.currentItem.unds) {
                this.form_add.stock =
                    this.form_add.stock * this.currentItem.max_quantity;
            } else {
                this.form_add.stock =
                    this.form_add.stock / this.currentItem.max_quantity;
            }
        },
        initFormAdd() {
            this.form_add = {
                item_id: null,
                stock: 0,
                quantity: 0,
                lots: [],
                lotes: [],
                lots_enabled: false,
                series_enabled: false
            };
        },
        clickAddItem() {
            /* if (!this.form_add.item_id) {
        return;
      }*/

            if (parseFloat(this.form_add.stock) < 1) {
                return;
            }

            if (this.form_add.quantity < 1) {
                return;
            }

            if (parseFloat(this.form_add.stock) < this.form_add.quantity) {
                return;
            }

            if (this.form_add.lots.length > 0) {
                let selected_lots = this.form_add.lots.filter(
                    x => x.has_sale == true
                ).length;

                if (this.form_add.quantity != selected_lots) {
                    return;
                }
            }

            let dup = this.form.items.find(x => x.id == this.form_add.item_id);
            if (dup) {
                return;
            }

            let row = this.items.find(x => x.id == this.form_add.item_id);
            let quantity = this.form_add.quantity;
            let max_quantity = null;
            if (this.currentItem) {
                if (this.currentItem.max_quantity && !this.currentItem.unds) {
                    max_quantity = {
                        input: quantity,
                        factor: this.currentItem.max_quantity
                    };
                    quantity = quantity * max_quantity.factor;
                }
            }
            this.form.items.push({
                id: row.id,
                description: row.description,
                quantity,
                lots: this.form_add.lots.filter(x => x.has_sale),
                max_quantity,
                lotes: this.form_add.lotes
                    .filter(f => f.selectedQuantity && f.selectedQuantity > 0)
                    .map(m => ({ ...m, quantity: m.selectedQuantity }))
            });

            this.initFormAdd();
            this.currentItem = null;
        },
        clickLotescodeOutput() {
            this.showDialogLotesOutput = true;
        },
        clickLotcodeOutput() {
            this.showDialogLotsOutput = true;
        },
        initForm() {
            this.errors = {};
            this.form = {
                warehouse_id: null,
                warehouse_destination_id: null,
                description: null,
                items: []
            };
        },
        async submit() {
            if (!this.form.printer && !this.isDirect) {
                return this.$toast.warning(
                    "Recuerde Seleccionar una impresora."
                );
            }
            if (!this.form.description) {
                return this.$toast.error("Debe agregar el motivo de traslado.");
            }
            if (this.form.items.length == 0) {
                return this.$toast.error("Debe agregar productos.");
            }

            this.loading_submit = true;
            await this.$http
                .post(`/${this.resource}/place`, this.form)
                .then(async response => {
                    if (response.data.success) {
                        this.$toast.success(response.data.message);
                        let { code } = response.data;
                        let { printer } = response.data;
                        if(this.form.printer){
                            await this.printTransfer(code, printer);
                        }
                        this.close();
                    } else {
                        this.$toast.error(response.data.message);
                    }
                })
                .catch(error => {
                    if (error.response) {
                        if (error.response.status === 422) {
                            this.errors = error.response.data;
                        } else {
                            console.log(error);
                        }
                    } else {
                        this.close();
                        console.log(error);
                    }
                })
                .then(() => {
                    this.loading_submit = false;
                });
        },
        close() {
            location.href = "/transfers";
        }
    }
};
</script>
