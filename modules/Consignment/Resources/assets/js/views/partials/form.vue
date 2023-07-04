<template>
    <el-dialog
        @open="open"
        @close="close"
        title="Creando consignación"
        :visible="showDialog"
        width="70%"
    >
        <div class="row m-2">
            <div class="col-md-4 col-12">
                <label for="person_id"
                    >Cliente

                    <a href="#" @click="clickNewPerson">
                        [ + Nuevo ]
                    </a>
                </label>
                <el-select
                    v-model="form.person_id"
                    filterable
                    remote
                    class="border-left rounded-left border-info"
                    popper-class="el-select-customers"
                    dusk="customer_id"
                    placeholder="Escriba el nombre o número de documento del cliente"
                    :remote-method="searchRemoteCustomers"
                    :loading="loading_search"
                >
                    <el-option
                        v-for="option in customers"
                        :key="option.id"
                        :value="option.id"
                        :label="option.name"
                    ></el-option>
                </el-select>
            </div>
            <div class="col-md-2 col-12">
                <label for="date_of_issue">Fecha de consignación</label>
                <el-date-picker
                    class="w-100"
                    v-model="form.date_of_issue"
                    type="date"
                    placeholder="Seleccione una fecha"
                >
                </el-date-picker>
            </div>
            <div class="col-md-2 col-12">
                <label for="date_of_end">Fecha de liquidación</label>
                <el-date-picker
                    class="w-100"
                    v-model="form.date_of_end"
                    type="date"
                    placeholder="Seleccione una fecha"
                >
                </el-date-picker>
            </div>
            <div class="col-md-4 col-12">
                <label for="date_of_end"
                    >Penalización
                    <a href="#" @click="clickNewPenalty">
                        [ + Nuevo ]
                    </a>
                </label>
                <el-select
                    v-model="form.penalty_id"
                    placeholder="Seleccione una penalización"
                    class="w-100"
                    dusk="penalty_id"
                >
                    <el-option
                        v-for="option in penalties"
                        :key="option.id"
                        :value="option.id"
                        :label="option.description"
                    ></el-option>
                </el-select>
            </div>
        </div>
        <el-divider></el-divider>
        <div class="row m-2">
            <div class="col-md-4 col-12">
                <label for="item">Producto</label>
                <el-select
                    class="w-100"
                    v-model="formItem.id"
                    filterable
                    remote
                    popper-class="el-select-customers"
                    clearable
                    @change="getStock"
                    placeholder="Nombre o código interno"
                    :remote-method="searchRemoteItems"
                    :loading="loading_search_item"
                >
                    <el-option
                        v-for="option in items"
                        :key="option.id"
                        :value="option.id"
                        :label="option.description"
                    ></el-option>
                </el-select>
            </div>
            <div class="col-md-3 col-12">
                <label for="establishment">Establecimiento</label>
                <el-select
                    @change="getStock"
                    v-model="formItem.establishment_id"
                    placeholder="Seleccione un establecimiento"
                    class="w-100"
                    dusk="establishment_id"
                >
                    <el-option
                        v-for="option in establishments"
                        :key="option.id"
                        :value="option.id"
                        :label="option.description"
                    ></el-option>
                </el-select>
            </div>
            <div class="col-md-3 col-12">
                <label for="stock">Stock actual</label>
                <el-input v-model="formItem.stock" readonly> </el-input>
            </div>
            <div class="col-md-2 col-12">
                <label for="stock">Cantidad</label>
                <el-input
                :disabled="notHasStock"
                    :readonly="formItem.has_lots"
                    type="number"
                    @input="updateTotal"
                    v-model="formItem.quantity"
                >
                </el-input>
                <small v-if="formItem.has_lots">
                    <a href="#" @click="openLotItems">
                        [ Seleccione las series ]
                    </a>
                </small>
            </div>
            <div class="col-md-3 col-12">
                <label for="stock">Precio actual</label>
                <el-input v-model="formItem.sale_unit_price" readonly>
                </el-input>
            </div>
            <div class="col-md-3 col-12">
                <label for="stock">Precio</label>
                <el-input
                    type="number"
                   @input="updateTotal"

                    v-model="formItem.price"
                >
                </el-input>
            </div>
            <div class="col-md-3 col-12">
                <label for="stock">Total</label>
                <el-input readonly type="number" v-model="formItem.total">
                </el-input>
            </div>
            <div class="col-md-3 col-12">
                <br />
                <el-button type="primary" @click="addItem">
                    [+]Agregar
                </el-button>
            </div>
        </div>
        <!-- <div class="m-2 d-flex justify-content-end">
          
        </div> -->

        <div class="row" v-if="itemsSelected.length != 0">
            <table class="table table-responsive">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Producto</th>
                        <th>Almacén</th>
                        <th>Cantidad</th>
                        <th>Precio unitario</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, idx) in itemsSelected" :key="idx">
                        <td>{{ idx + 1 }}</td>
                        <td>
                            {{ item.description }}
                            <template v-if="item.has_lots"> 
                                <br>
                                <small>
                                    <a href="#" @click="showLotItemsDialog(item.lots)">
                                        [ Ver series ]
                                    </a>
                                </small>
                            </template>
                        </td>
                        <td>{{ item.establishment_description }}</td>
                        <td>{{ item.quantity }}</td>
                        <td>{{ item.price.toFixed(2) }}</td>
                        <td>
                            <el-button
                                type="danger"
                                size="mini"
                                @click="itemsSelected.splice(idx, 1)"
                            >
                                <i class="fas fa-trash"></i>
                            </el-button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div slot="footer" class="dialog-footer">
            <el-button @click="close">Cancelar</el-button>
            <el-button
                v-if="itemsSelected.length != 0"
                type="primary"
                @click="submit"
                >Guardar</el-button
            >
        </div>

        <person-form :showDialog.sync="showPersonDialog" :external="true">
        </person-form>
        <penalty-form :showDialog.sync="showPenaltyDialog"></penalty-form>
        <lot-item
            :showDialog.sync="showLotItemDialog"
            :limitQty="formItem.stock"
            :item_id="formItem.id"
            :seriesSelected.sync="formItem.lots"
            :establishment_id="formItem.establishment_id"
            @updateSeries="updateSeries"
        >
        </lot-item>

        <el-dialog
        :visible.sync="showLotItems"
        append-to-body
        @close="showLotItems = false"
        title="Lista de series"
        width="300px"
        >
 <table width="100%">
                        <thead>
                            <tr width="100%">
                                <th v-if="lots.length>0">SERIE</th>
                                <th v-if="lots.length>0">FECHA</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(row, index) in lots" :key="index" width="100%" >
                                <td>
                                        <span>{{row.series}}</span>
                                </td>
                               
                                <td>
                                        <span>{{row.date}}</span>
                                </td>
                         
                            </tr>
                        </tbody>
                    </table>
        </el-dialog>
    </el-dialog>
</template>

<script>
const LotItem = () => import("./lot_item.vue");
const PenaltyForm = () => import("./penalty_form.vue");
const PersonForm = () =>
    import("../../../../../../../resources/js/views/persons/form.vue");
export default {
    props: ["showDialog"],
    components: {
        PersonForm,
        PenaltyForm,
        LotItem
    },
    data() {
        return {
            notHasStock:false,
            showLotItems:false,
            showLotItemDialog: false,
            formItem: {},
            resource: "consignment",
            showPersonDialog: false,
            showPenaltyDialog: false,
            form: {},
            loading_search: false,
            loading_search_item: false,
            customers: [],
            penalties: [],
            establishments: [],
            search: {
                value: null
            },
            items: [],
            itemsSelected: [],
            lots:[],
        };
    },
    created() {
        this.getTables();
    },
    methods: {
        updateTotal(){
            this.formItem.total = this.formItem.quantity * this.formItem.price
        },
        updateSeries(_, series) {
            this.formItem.lots = series;
            this.formItem.quantity = series.length;
            this.updateTotal();
            // console.log(series);
        },
        showLotItemsDialog(lots){
            this.lots = lots;
            this.showLotItems = true;
        },
        openLotItems() {
            this.showLotItemDialog = true;
        },
       async submit() {
        this.form.items = this.itemsSelected.map((item)=>({
            ...item,
            lots: item.lots.map((lot)=>({
                id: lot.id ? lot.id : null,
                series: lot.series ? lot.series : null,
                date: lot.date ? lot.date : null
            }))
        }));
        const response = await this.$http.post(`/consignment`,this.form);

        },
        initFormItem() {
            this.formItem = {
                id: null,
                establishment_id: 1,
                quantity: 0,
                lots: [],
                price: 0,
                description: null,
                establishment_description: null,
                stock: 0,
                sale_unit_price: 0,
                total: 0,
                has_lots: false
            };
        },
        validateItem() {
            let success = true;
            let { id, establishment_id, quantity, price } = this.formItem;
            if (quantity == 0) {
                this.$toast.error(
                     "La cantidad debe ser mayor a 0"
                );
                success = false;
            }
            if (price == 0) {
                this.$toast.error(
                   "El precio debe ser mayor a 0"
                );
                success = false;
            }
            if (!id) {
                this.$toast.error(
                   "Debe seleccionar un producto"
                );
                success = false;
            }
            if (!establishment_id) {
                this.$toast.error(
                   "Debe seleccionar un establecimiento"
                );
                success = false;
            }
            return success;
        },
        addItem() {
            if (!this.validateItem()) {
                return;
            }
            let item = this.items.find(item => item.id == this.formItem.id);

            this.formItem.description = item.description;
            this.formItem.establishment_description = this.establishments.find(
                establishment =>
                    establishment.id == this.formItem.establishment_id
            ).description;
            this.itemsSelected.push(this.formItem);
            this.formItem.price = Number(this.formItem.price);
            this.initFormItem();
        },
        getStock() {
            this.notHasStock = false;
            let { establishment_id, id } = this.formItem;
            if (establishment_id && id) {
                this.$http
                    .get(
                        `/${this.resource}/stock?establishment_id=${establishment_id}&item_id=${id}`
                    )
                    .then(response => {
                        let { stock } = response.data;
                        
                        
                        let item = this.items.find(item => item.id == id);
                        this.formItem.stock = stock;
                        this.formItem.sale_unit_price = item.sale_unit_price;
                        this.formItem.price = item.sale_unit_price;
                        this.formItem.has_lots = item.series_enabled == 1;
                        // if (!success) {
                        //     this.$toast.error(
                             
                        //         message
                        //     );
                        // } else {
                        //     this.$toast.success(
                        //         message
                        //     );
                        // }

                        if(stock <= 0){
                            this.notHasStock = true;
                            this.$toast.error(
                                 "No hay stock disponible"
                            );
                            return;
                        }
                    })
                    .catch(e => {
                        console.log(e);
                    });
            }
        },
        searchRemoteItems(input) {
            if (input.length > 0) {
                this.loading_search_item = true;
                let parameters = `input=${input}`;

                this.$http
                    .get(`/documents/data-table/items?${parameters}`)
                    .then(response => {
                        // console.log(response.data)
                        this.items = response.data;
                        this.loading_search_item = false;
                    })
                    .catch(e => {
                        this.loading_search_item = false;

                        console.log(e);
                    });
            }
        },
        async getTables() {
            try {
                const response = await this.$http(`/${this.resource}/tables`);
                if (response.status === 200) {
                    this.customers = response.data.customers;
                    this.penalties = response.data.penalties;
                    this.items = response.data.items;
                    this.establishments = response.data.establishments;
                }
            } catch (e) {
                console.log(e);
            }
        },
        searchRemoteCustomers(input) {
            if (input.length > 0) {
                this.loading_search = true;
                let parameters = `input=${input}`;

                this.$http
                    .get(`/documents/search/customers?${parameters}`)
                    .then(response => {
                        this.customers = response.data.customers;
                        this.loading_search = false;
                    });
            }
        },
        initForm() {
            this.form = {
                person_id: null,
                date_of_issue: null,
                date_of_end: null,
                penalty_id: null,
                items: []
            };
        },
        clickNewPerson() {
            this.showPersonDialog = true;
        },
        clickNewPenalty() {
            this.showPenaltyDialog = true;
        },
        open() {
            this.initFormItem();
            console.log("open");
        },
        close() {
            this.$emit("update:showDialog", false);
        }
    }
};
</script>
