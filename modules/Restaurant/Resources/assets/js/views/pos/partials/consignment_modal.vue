<template>
    <el-dialog
        v-loading="loading"
        :visible="showDialog"
        @open="open"
        @close="close"
        title="Consignación"
    >
        <div class="row m-2">
            <div class="col-md-6 col-12">
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
            <div class="col-md-3 col-12">
                <label for="date_of_issue">Fecha de consignación</label>
                <el-date-picker
                    class="w-100"
                    v-model="form.date_of_issue"
                    type="date"
                    placeholder="Seleccione una fecha"
                >
                </el-date-picker>
            </div>
            <div class="col-md-3 col-12">
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
            <person-form
                :showDialog.sync="showDialogNewPerson"
                type="customers"
                :external="true"
            >
            </person-form>
            <penalty-form
                @reloadPenalties="reloadPenalties"
                :showDialog.sync="showDialogNewPenalty"
            ></penalty-form>
        </div>
        <div slot="footer" class="dialog-footer">
            <el-button @click="close">Cancelar</el-button>
            <el-button type="primary" @click="submit">Guardar</el-button>
        </div>
    </el-dialog>
</template>

<script>
const PersonForm = () =>
    import("../../../../../../../../resources/js/views/persons/form.vue");
const PenaltyForm = () =>
    import(
        "../../../../../../../Consignment/Resources/assets/js/views/partials/penalty_form.vue"
    );
export default {
    props: ["showDialog", "items", "all_customers", "establishments"],
    components: {
        PersonForm,
        PenaltyForm
    },

    data() {
        return {
            loading: false,
            showDialogNewPenalty: false,
            showDialogNewPerson: false,
            form: {},
            customers: [],
            penalties: [],
            loading_search: false
        };
    },
    created() {
        this.getPenalties();
    },
    methods: {
        initForm() {
            this.form = {
                person_id: null,
                date_of_issue: null,
                date_of_end: null,
                penalty_id: null
            };
        },
        async getPenalties() {
            const response = await this.$http("/consignment/penalty/records");

            this.penalties = response.data;
        },
        formatedItems() {
            let formatted = [];
            for (let i = 0; i < this.items.length; i++) {
                let item = this.items[i];
                let newItem = {};
                newItem.establishment_id = this.establishments.id;
                newItem.id = item.food.item.id;
                newItem.quantity = item.quantity;
                newItem.price = item.price;
                newItem.has_lots = item.series.length > 0;
                newItem.lots = item.series.map(s => ({
                    series: s.series,
                    date: s.date,
                    id: s.id
                }));
                formatted.push(newItem);
            }
            return formatted;
        },
        validate() {
            let hasError = false;
            let { person_id, date_of_issue, date_of_end } = this.form;
            if (!person_id) {
                this.$toast.error("Debe seleccionar un cliente/vendedor");
                hasError = true;
            }
            if (!date_of_issue) {
                this.$toast.error(
                    "Debe seleccionar una fecha de consignación"
                );
                hasError = true;
            }
            if (!date_of_end) {
                this.$toast.error(
                    "Debe seleccionar una fecha de liquidación"
                );
                hasError = true;
            }
            return hasError;
        },
        async submit() {
            if (this.validate()) {
                return;
            }
            try {
                this.loading = true;
                let items = this.formatedItems();
                this.form.items = items;

                const response = await this.$http.post(
                    `/consignment`,
                    this.form
                );
                if (response.status == 200) {
                    let { success, message } = response.data;
                    if (success) {
                        this.$toast.success(message);
                        this.$emit("update:showDialog", false);
                    } else {
                        this.$toast.error(message);
                    }
                }
                console.log(response);
            } catch (e) {
                this.$message.error("Ocurrió un error al crear la consignación");
                console.log(e);
            } finally {
                this.loading = false;
            }
        },
        clickNewPenalty() {
            this.showDialogNewPenalty = true;
        },
        clickNewPerson() {
            this.showDialogNewPerson = true;
            // this.$emit('clickNewPerson');
        },
        async reloadPenalties(id) {
            await this.getPenalties();
            this.form.penalty_id = id;
        },
        open() {
            this.customers = this.all_customers;
            this.initForm();
        },
        close() {
            this.$emit("update:showDialog", false);
        },
        searchRemoteCustomers(input) {
            if (input.length > 0) {
                this.loading_search = true;
                let parameters = `input=${input}`;

                this.$http
                    .get(`/quotations/search/customers?${parameters}`)
                    .then(response => {
                        this.customers = response.data.customers;
                        this.loading_search = false;
                        if (this.customers.length == 0) {
                            this.customers = this.all_customers;
                        }
                    });
            } else {
                this.customers = this.all_customers;
            }
        }
    }
};
</script>
