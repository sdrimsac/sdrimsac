<template>
    <el-dialog
        @open="open"
        @close="close"
        title="Creando consignación"
        :visible="showDialog"
        width="70%"
    >
        <div class="row m-2">
            <div class="col-md-4">
                <label for="person_id"
                    >Cliente

                    <a href="#" @click="clickNewPerson">
                        [ + Nuevo ]
                    </a>
                </label>
                <el-select
                    v-model="search.value"
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
            <div class="col-md-2">
                <label for="date_of_issue">Fecha de consignación</label>
                <el-date-picker
                    class="w-100"
                    v-model="form.date_of_issue"
                    type="date"
                    placeholder="Seleccione una fecha"
                >
                </el-date-picker>
            </div>
            <div class="col-md-2">
                <label for="date_of_end">Fecha de liquidación</label>
                <el-date-picker
                    class="w-100"
                    v-model="form.date_of_end"
                    type="date"
                    placeholder="Seleccione una fecha"
                >
                </el-date-picker>
            </div>
            <div class="col-md-4">
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
            <div class="col-md-4">
                <label for="item">Producto</label>
                <el-select
                    class="w-100"
                    v-model="formItem.id"
                    filterable
                    remote
                    popper-class="el-select-customers"
                    clearable
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
            <div class="col-md-3">
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
            <div class="col-md-3">
                <label for="stock">Stock actual</label>
                <el-input v-model="formItem.stock" readonly> </el-input>
            </div>
            <div class="col-md-2">
                <label for="stock">Cantidad</label>
                <el-input type="number" v-model="formItem.quantity"> </el-input>
            </div>
        </div>
        <div class="row m-2">
            
        </div>
        <person-form :showDialog.sync="showPersonDialog" :external="true">
        </person-form>
        <penalty-form :showDialog.sync="showPenaltyDialog"></penalty-form>
    </el-dialog>
</template>

<script>
const PenaltyForm = () => import("./penalty_form.vue");
const PersonForm = () =>
    import("../../../../../../../resources/js/views/persons/form.vue");
export default {
    props: ["showDialog"],
    components: {
        PersonForm,
        PenaltyForm
    },
    data() {
        return {
            formItem: {
                id: null,
                establishment_id: null,
                quantity: 0,
                lots: [],
                description: null,
                stock:0,
            },
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
            items: []
        };
    },
    created() {
        this.getTables();
    },
    methods: {
        getStock() {
            let { establishment_id, id } = this.formItem;
            if (establishment_id && id) {
                this.$http
                    .get(
                        `/${this.resource}/stock?establishment_id=${establishment_id}&item_id=${id}`
                    )
                    .then(response => {
                        let { stock, success, message } = response.data;

                        this.formItem.stock = stock;
                        if (!success) {
                            this.$message({
                                type: "error",
                                message
                            });
                        } else {
                            this.$message({
                                type: "success",
                                message
                            });
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
            console.log("open");
        },
        close() {
            this.$emit("update:showDialog", false);
        }
    }
};
</script>
